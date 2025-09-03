<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageTemplate;
use App\Models\Room;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function show($id)
    {
        if (Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        // OrderItem を取得
        $orderItem = OrderItem::find($id)->load('user.reviews');

        if (empty($orderItem)) {
            return redirect()->route('top');
        }

        // アクセス権限チェック
        $user_id = Auth::user()->id;
        if ($user_id != $orderItem->user_id && $user_id != $orderItem->to_user_id) {
            return redirect()->route('top');
        }

        // パートナー取得
        $partner = $orderItem->user_id == $user_id ? $orderItem->toUser : $orderItem->user;

        // メッセージ取得 & 既読処理
        Message::where('order_item_id', $orderItem->id)->update(['read_flag' => 1]);
        $messages = Message::where('order_item_id', $orderItem->id)->orderBy('created_at', 'ASC')->get()->map(function ($message) use ($partner) {
            $message->fromUser = $message->fromUser ?? $message->from_user;
            return $message;
        });

        // 画面表示用変数
        $pageTitle = 'メッセージ';
        $title = 'メッセージ';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
        ];
        
        if (Auth::user()->role == 'company') {
            $breadcrumbs[] = [
                'url' => route('item.show', ['id' => $orderItem->item->id]),
                'text' => $orderItem->item->title,
            ];
        } else {
            $breadcrumbs[] = [
                'url' => route('mypage'),
                'text' => 'マイページ',
            ];
        }
        
        $breadcrumbs[] = [
            'url' => Auth::user()->role == 'company'
                ? route('mypage.item.orders', ['id' => $orderItem->item->id])
                : route('mypage.item_mine'),
            'text' => Auth::user()->role == 'company'
                ? '応募一覧'
                : '応募した案件一覧',
        ];
        
        $breadcrumbs[] = [
            'url' => '#',
            'text' => $pageTitle,
        ];

        if (Auth::user()->role == 'influencer') {
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

        $template = [];
        if ($orderItem->status == 0) {
            $template = [
                'label' => Auth::user()->role == 'influencer' ? '応募返信定型文を挿入する' : '依頼定型文を挿入する',
                'value' => (MessageTemplate::where('type', Auth::user()->role == 'influencer' ? MessageTemplate::TEMPLATE_REPLY : MessageTemplate::TEMPLATE_REQUEST)->first() ? MessageTemplate::where('type', Auth::user()->role == 'influencer' ? MessageTemplate::TEMPLATE_REPLY : MessageTemplate::TEMPLATE_REQUEST)->first()->template : ''),
            ];
        } else if ($orderItem->status == 1) {
            $template = [
                'label' => Auth::user()->role == 'influencer' ? '採用お礼定型文を挿入する' : '来店お礼定型文を挿入する',
                'value' => (MessageTemplate::where('type', Auth::user()->role == 'influencer' ? MessageTemplate::TEMPLATE_EMPLOYMENT_THANK : MessageTemplate::TEMPLATE_VISIT_THANK)->first() ? MessageTemplate::where('type', Auth::user()->role == 'influencer' ? MessageTemplate::TEMPLATE_EMPLOYMENT_THANK : MessageTemplate::TEMPLATE_VISIT_THANK)->first()->template : ''),
            ];
        } else if ($orderItem->status == 2) {
            $template = [
                'label' => '投稿完了定型文を挿入する',
                'value' => (MessageTemplate::where('type', MessageTemplate::TEMPLATE_POST_THANK)->first() ? MessageTemplate::where('type', MessageTemplate::TEMPLATE_POST_THANK)->first()->template : ''),
            ];
        }
        if ($orderItem->status == 0) {
            $cancelTemplate = MessageTemplate::where('type', MessageTemplate::TEMPLATE_REJECT)->first()->template;
        } else {
            $cancelTemplate = '';
        }

        return view('mypage.order_detail')->with(compact('title', 'pageTitle', 'breadcrumbs', 'orderItem', 'user_id', 'partner', 'messages', 'statuses', 'template', 'cancelTemplate'));
    }

    public function update(Request $request, $id)
    {
        // if (!$this->multiSubmitCheck($request)) abort(409);

        $status = $request->status;
        $post_url = $request->post_url;
        $rating = $request->rating;
        $comment = $request->comment;
        $auth_user = Auth::user();
        $orderItem = OrderItem::find($id);

        try {
            DB::beginTransaction();
            if ($auth_user->role == 'company' && $status <= 2 || $status >= 3 || $status == -1) {
                $orderItem->status = $status;
                if ($status == -1) {
                } else if ($status == 0) {
                    $orderItem->matched_at = date('Y-m-d H:i:s');
                    $orderItem->started_at = date('Y-m-d H:i:s');
                } else if ($status == 1) {
                    $orderItem->requested_at = date('Y-m-d H:i:s');
                } else if ($status == 4) {
                    $orderItem->completed_at = date('Y-m-d H:i:s');
                }
                $orderItem->save();
            }

            if ($status == 1) {
                $message = new Message();
                $message->order_item_id = $orderItem->id;
                $message->user_id = $auth_user->id;
                $message->to_user_id = $orderItem->user_id;
                $message->comment = '依頼が正式に成立いたしました！';
                $message->role_type = 'all';
                $message->save();

                $message = new Message();
                $message->order_item_id = $orderItem->id;
                $message->user_id = $orderItem->user_id;
                $message->to_user_id = $auth_user->id;
                $message->comment = '企業とやり取りを行い、来店を実施してください。';
                $message->role_type = 'influencer';
                $message->save();
            } else if ($status == 2) {
                $message = new Message();
                $message->order_item_id = $orderItem->id;
                $message->user_id = $auth_user->id;
                $message->to_user_id = $orderItem->user_id;
                $message->comment = '来店完了報告を受け取りました。
SNSでの投稿をお願いいたします。';
                $message->role_type = 'influencer';
                $message->save();
            } else if ($status == 3 && $post_url != '') {
                $message = new Message();
                $message->order_item_id = $orderItem->id;
                $message->user_id = $auth_user->id;
                $message->to_user_id = $orderItem->item->user_id;
                $message->comment = '投稿完了のURL
' . $post_url;
                $message->role_type = 'all';
                $message->save();
            } else if ($status == 4) {
                $review = new Review();
                $review->user_id = $orderItem->item->user_id;
                $review->to_user_id = $orderItem->user_id;
                $review->item_id = $orderItem->item_id;
                $review->rating = $rating;
                $review->comment = $comment;
                $review->save();

                $message = new Message();
                $message->order_item_id = $orderItem->id;
                $message->user_id = $auth_user->id;
                $message->to_user_id = $orderItem->user_id;
                $message->comment = '依頼が完了され、レビューが登録されました。
この度はありがとうございました。';
                $message->role_type = 'influencer';
                $message->save();
            } else if ($status == 5) {
                $message = new Message();
                $message->order_item_id = $orderItem->id;
                $message->user_id = $auth_user->id;
                $message->to_user_id = $orderItem->user_id;
                $message->comment = (MessageTemplate::where('type', MessageTemplate::TEMPLATE_REJECT)->first() ? MessageTemplate::where('type', MessageTemplate::TEMPLATE_REJECT)->first()->template : '');
                $message->role_type = 'influencer';
                $message->save();

                $message = new Message();
                $message->order_item_id = $orderItem->id;
                $message->user_id = $orderItem->user_id;
                $message->to_user_id = $auth_user->id;
                $message->comment = '案件依頼をキャンセルしました。';
                $message->role_type = 'company';
                $message->save();
            } else if ($status == 0) {
                $message = new Message();
                $message->order_item_id = $orderItem->id;
                $message->user_id = $orderItem->user_id;
                $message->to_user_id = $orderItem->item->user_id;
                $message->comment = "【{$orderItem->item->title}】から応募がありました。";
                $message->save();
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json(['result' => 0, 'error' => $th->getMessage()]);
        }

        return response()->json(['result' => 1, 'status' => $status]);
    }

    public function sendMessage(Request $request)
    {
        if (!$this->multiSubmitCheck($request)) return response()->json(['result' => 0]);
        
        $data = $request->except('_token');
        $message = new Message();
        $message->order_item_id = $data['order_item_id'];
        $message->user_id = $data['user_id'];
        $message->to_user_id = $data['to_user_id'];
        $message->comment = $data['comment'];
        $message->save();
        return response()->json(['result' => 1]);
    }

    public function reject($id)
    {
        $orderItem = OrderItem::find($id);
        $orderItem->status = 2;
        $orderItem->save();
        return redirect()->route('mypage.item.orders', ['id' => $orderItem->item->id]);
    }

}
