<?php


namespace App\Admin\Controllers;

use App\Admin\Actions\OrderitemDeleteAction;
use App\Admin\Actions\OrderitemDetailAction;
use App\Components\ExifComponent;
use App\Models\AdminConfirm;    
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Message;
use App\Models\MessageTemplate;
use App\Models\OrderItem;
use App\Models\Review;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class OrderitemController extends AdminController
{
    protected function title()
    {
        return trans('admin.orderitem');
    }

    protected function grid()
    {
        $uri = 'orderitem';
        AdminConfirm::updateOrCreate(['uri' => $uri], ['confirmed_at' => now()]);

        /** @var \App\Models\OrderItem $orderItemModel */
        $orderItemModel = config('admin.database.order_items_model');
        $grid = new Grid(new $orderItemModel());

        $grid->column('id', trans('ID'))->sortable();
        $grid->column('to_user_id', trans('admin.company_id'));
        $grid->column('toUser.name', trans('admin.company_name'));

        $grid->column('user_id', trans('admin.influencer_id'));
        $grid->column('user.name', trans('admin.influencer_name'));
        $grid->column('type', trans('admin.orderitem_type'))->display(function ($type) {
            return config('constants.arrOrderType')[$type];
        });
        $grid->column('status', trans('admin.orderitem_status'))->display(function ($status) {
            return config('constants.arrOrderStatus')[$status];
        });

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->add(new OrderitemDetailAction());
            $actions->add(new OrderitemDeleteAction());
            $actions->disableEdit();
            $actions->disableView();
            $actions->disableDelete();
        });
        $grid->model()->orderBy('created_at', 'desc');
        return $grid;
    }

    public function detail($id)
    {
        $viewType = request()->get('viewType', 'company');
        
        // OrderItem を取得
        $orderItem = OrderItem::find($id)->load('user.reviews');
        
        if (empty($orderItem)) {
            return redirect()->route('admin.orderitem.index');
        }

        $user_id = $viewType == 'company' ? $orderItem->to_user_id : $orderItem->user_id;

        // メッセージ取得 & 既読処理
        Message::where('order_item_id', $orderItem->id)->update(['read_flag' => 1]);
        $messages = Message::where('order_item_id', $orderItem->id)->orderBy('created_at', 'ASC')->get()->map(function ($message) {
            if ($message->user_id > 0) {
                $message->fromUser = $message->fromUser ?? $message->from_user;
            } else {
                $message->fromUser = null;
            }

            return $message;
        });

        // 画面表示用変数
        $pageTitle = 'メッセージ';
        $title = 'メッセージ';

        if ($viewType == 'influencer') {
            $statuses = [
                '応募完了',
                '依頼',
                '来店依頼',
                '投稿依頼',
                '完了',
            ];
        } else {
            $statuses = [
                '応募確認',
                '依頼',
                '来店確認',
                '総合評価',
                '完了',
            ];
        }

        $template = $this->getTemplate($viewType, $orderItem);
        $cancelTemplate = MessageTemplate::where('type', MessageTemplate::TEMPLATE_REJECT)->first()->template;
        $arrRating = config('constants.arrRatingScore');
        $review = $orderItem->user->reviews()->where('item_id', $orderItem->item_id)
                                             ->where('user_id', $orderItem->to_user_id)
                                             ->where('to_user_id', $orderItem->user_id)
                                             ->first();

        $arrItemCategory = config('constants.arrItemCategory');
        $arrPostSNS = config('constants.arrPostSNS');
        $arrGenders = config('constants.arrGenders');
        
        $content = new Content();
        $content->header('取引状況');
        $content->description('表示');
        $content->body(view('admin.orderitem', compact('orderItem', 'user_id', 'messages', 'statuses', 'template', 'cancelTemplate', 'arrRating', 'arrItemCategory', 'arrPostSNS', 'arrGenders', 'review')));
        return $content;
    }

    public function delete($id)
    {
        $orderItem = OrderItem::find($id);
        $orderItem->delete();
        return redirect()->route(config('admin.route.prefix') . '.admin.orderitem.index');
    }

    public function message(Request $request, $id)
    {
        $orderItem = OrderItem::find($id);
        $type = $request->get('type');
        // if ($type == 'company') {
        //     $user_id = $orderItem->to_user_id;
        //     $to_user_id = $orderItem->user_id;
        // } else {
        //     $user_id = $orderItem->user_id;
        //     $to_user_id = $orderItem->to_user_id;
        // }
        $message = new Message();
        $message->order_item_id = $orderItem->id;
        // $message->user_id = $user_id;
        // $message->to_user_id = $to_user_id;
        $message->user_id = null;
        $message->to_user_id = null;
        $message->comment = $request->get('comment');
        $message->save();

        return redirect()->route(config('admin.route.prefix') . '.admin.orderitem.detail', ['id' => $id, 'viewType' => $type]);
    }

    public function action(Request $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $action = $request->input('action');

        try {
            switch ($action) {
                case 'request':
                    $orderItem->status = 1;

                    $message = new Message();
                    $message->order_item_id = $orderItem->id;
                    $message->user_id = $orderItem->item->user_id;
                    $message->to_user_id = $orderItem->user_id;
                    $message->comment = '依頼が正式に成立いたしました！';
                    $message->role_type = 'all';
                    $message->save();

                    $message = new Message();
                    $message->order_item_id = $orderItem->id;
                    $message->user_id = $orderItem->item->user_id;
                    $message->to_user_id = $orderItem->user_id;
                    $message->comment = '企業とやり取りを行い、来店を実施してください。';
                    $message->role_type = 'influencer';
                    $message->save();
                    break;
                case 'reject':
                    $orderItem->status = 5;

                    $message = new Message();
                    $message->order_item_id = $orderItem->id;
                    $message->user_id = $orderItem->item->user_id;
                    $message->to_user_id = $orderItem->user_id;
                    $message->comment = '申し訳ございませんが、今回は見送り致しました。
 また、再度応募お願い致します。';
                    $message->role_type = 'influencer';
                    $message->save();

                    $message = new Message();
                    $message->order_item_id = $orderItem->id;
                    $message->user_id = $orderItem->user_id;
                    $message->to_user_id = $orderItem->item->user_id;
                    $message->comment = '案件依頼をキャンセルしました。';
                    $message->role_type = 'company';
                    $message->save();
                    break;
                case 'shopping':
                    $orderItem->status = 2;

                    $message = new Message();
                    $message->order_item_id = $orderItem->id;
                    $message->user_id = $orderItem->item->user_id;
                    $message->to_user_id = $orderItem->user_id;
                    $message->comment = '来店完了報告を受け取りました。
SNSでの投稿をお願いいたします。';
                    $message->role_type = 'influencer';
                    $message->save();
                    break;
                case 'post':
                    $orderItem->status = 3;

                    $message = new Message();
                    $message->order_item_id = $orderItem->id;
                    $message->user_id = $orderItem->user_id;
                    $message->to_user_id = $orderItem->item->user_id;
                    $message->comment = '投稿完了のURL
' . $request->input('post_url');
                    $message->role_type = 'all';
                    $message->save();
                    break;
                case 'complete':
                    $orderItem->status = 4;

                    $review = new Review();
                    $review->user_id = $orderItem->item->user_id;
                    $review->to_user_id = $orderItem->user_id;
                    $review->item_id = $orderItem->item_id;
                    $review->rating = $request->input('rating');
                    $review->comment = $request->input('review');
                    $review->save();

                    $message = new Message();
                    $message->order_item_id = $orderItem->id;
                    $message->user_id = $orderItem->item->user_id;
                    $message->to_user_id = $orderItem->user_id;
                    $message->comment = '依頼が完了され、レビューが登録されました。
この度はありがとうございました。';
                    $message->role_type = 'influencer';
                    $message->save();
                    break;
                case 'accept':
                    $orderItem->status = -1;
                    break;
                    
                case 'confirm':
                    $orderItem->status = 0;
                    $orderItem->matched_at = Carbon::now();

                    $message = new Message();
                    $message->order_item_id = $orderItem->id;
                    $message->user_id = $orderItem->user_id;
                    $message->to_user_id = $orderItem->item->user_id;
                    $message->comment = "【{$orderItem->item->title}】から応募がありました。";
                    $message->save();
                    break;
                case 'vote':
                    break;
                default:
                    return response()->json(['success' => false, 'message' => 'Invalid action.']);
            }
            $orderItem->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function getTemplate($viewType, $orderItem)
    {
        $template = [];
        if ($orderItem->status == 0) {
            $template = [
                'label' => $viewType == 'influencer' ? '応募返信定型文を挿入する' : '依頼定型文を挿入する',
                'value' => MessageTemplate::where('type', $viewType == 'influencer' ? MessageTemplate::TEMPLATE_REPLY : MessageTemplate::TEMPLATE_REQUEST)->first()->template ?? '',
            ];
        } else if ($orderItem->status == 1) {
            $template = [
                'label' => $viewType == 'influencer' ? '採用お礼定型文を挿入する' : '来店お礼定型文を挿入する',
                'value' => MessageTemplate::where('type', $viewType == 'influencer' ? MessageTemplate::TEMPLATE_EMPLOYMENT_THANK : MessageTemplate::TEMPLATE_VISIT_THANK)->first()->template ?? '',
            ];
        } else if ($orderItem->status == 2) {
            $template = [
                'label' => '投稿完了定型文を挿入する',
                'value' => MessageTemplate::where('type', MessageTemplate::TEMPLATE_POST_THANK)->first()->template ?? '',
            ];
        }
        return $template;
    }

    public function vote(Request $request, $id)
    {
        $data = $request->except('_token');
        $this->validate_item($data);

        $orderItem = OrderItem::findOrFail($id);

        $item_id = $this->createItem($data, $orderItem, $request->file('images'));
        if (!$item_id) {
            return back()->with(['error' => '案件起票に失敗しました。'])->withInput();
        }

        $orderItem->status = -2;
        $orderItem->item_id = $item_id;
        $orderItem->save();

        $message = new Message();
        $message->order_item_id = $orderItem->id;
        $message->user_id = $orderItem->user_id;
        $message->to_user_id = $orderItem->to_user_id;
        $message->comment = '案件が起票されました。';
        $message->role_type = 'influencer';
        $message->save();

        return redirect()->route(config('admin.route.prefix') . '.admin.orderitem.detail', ['id' => $orderItem->id, 'viewType' => 'company']);
    }

    protected function createItem(array $data, OrderItem $orderItem, $image = null)
    {
        $data['is_emergency'] = isset($data['is_emergency']) ? 1 : 0;
        $data['user_id'] = $orderItem->to_user_id;
        $data['expired_at'] = Carbon::now()->addDays(7);
        $data['public_flag'] = 0;
        $data['status'] = 1;
        $data['related_user_id'] = $orderItem->user_id;
        
        // 「その他」が選択された場合、category_otherフィールドを保存
        if (isset($data['genre']) && $data['genre'] === 'その他') {
            $data['genre_other'] = $data['genre_other'] ?? '';
        } else {
            $data['genre_other'] = null;
        }
        
        $item = Item::create($data);

        if ($image) {
            $binary = ExifComponent::rotateFromBinary(file_get_contents($image));
            $file = Image::make($binary);

            $width = 800; $height = 800;
            $file->height() > $file->width() ? $width=null : $height=null;
            $file->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })->stream('jpg', 100);
            $filename = time() . uniqid(rand()) . '.jpg';
            Storage::disk('public')->put('items/' . $item->id . '/' . $filename, $file);

            $old_images = ItemImage::where('item_id', $item->id)->get();
            foreach($old_images as $old_image) {
                @unlink(storage_path('app/public/' . $old_image->name));
            }
            ItemImage::where('item_id', $item->id)->delete();

            $itemImage = new ItemImage();
            $itemImage->item_id = $item->id;
            $itemImage->name = 'items/' . $item->id . '/' . $filename;
            $itemImage->save();
        }
        return $item->id;
    }

    protected function validate_item(array $data)
    {
        $rules = [
            'title' => ['required', 'string', 'max:100'],
            'genre' => ['required', 'string'],
            'is_offering' => ['required', 'numeric'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'website' => ['nullable', 'string', 'url'],
            'station' => ['required', 'string'],
            'address' => ['required', 'string'],
            'post_sns' => ['required', 'string'],
            'post_type' => ['required', 'string'],
            'hash_tag' => ['required', 'string'],
            'pr_account' => ['required', 'string'],
            'pr_flow' => ['required', 'string'],
            'pr_rule' => ['required', 'string'],
            'condition' => ['required', 'string'],
            'entry_sns' => ['required', 'string'],
            'entry_follower' => ['required', 'numeric', 'min:0'],
            'gender' => ['required', 'string'],
            'entry_method' => ['required', 'string'],
            'is_emergency' => ['nullable'],
            'images' => ['required', 'array'],
        ];

        // 「その他」が選択された場合、category_otherを必須にする
        if (isset($data['genre']) && $data['genre'] === 'その他') {
            $rules['genre_other'] = ['required', 'string', 'max:100'];
        }

        return Validator::make($data, $rules)->validate();
    }
}