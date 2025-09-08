<?php


namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Models\Config;
use App\Models\Item;
use App\Models\Message;
use App\Models\MessageTemplate;
use App\Models\OrderItem;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MessageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth','verified']);
    }

    public function index()
    {
        if (Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }
        $pageTitle = 'メッセージ一覧';
        $title = 'メッセージ一覧';

        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => 'メッセージ一覧'],
        ];

        $user_id = Auth::user()->id;
        $auth_user = User::find($user_id);
        $query = OrderItem::query();
        // 各OrderItemの最新メッセージ作成日時を取得し、別名カラムで並び替える
        $query->addSelect([
            'last_message_created_at' => Message::selectRaw('MAX(created_at)')
                ->whereColumn('order_item_id', 'order_items.id')
        ]);
        if ($auth_user->role == 'influencer') {
            $query->where('user_id', $user_id);
        } else {
            $query->where('to_user_id', $user_id);
        }
        // 最新メッセージ日時の降順。NULLは末尾に並ぶ（DBの設定に依存）
        $query->orderByDesc('last_message_created_at');
        
        $orderItems = $query->paginate($this->page_num)->appends(request()->except('page'));

        return view('message.index')->with(compact('title', 'pageTitle', 'breadcrumbs', 'orderItems'));
    }

    public function show($id)
    {
        if (Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }
        
        $orderItem = OrderItem::find($id)->load('user.reviews', 'toUser');
        if (empty($orderItem)) {
            return redirect()->route('top');
        }

        $user_id = Auth::user()->id;
        if ($user_id != $orderItem->user_id && $user_id != $orderItem->to_user_id) {
            return redirect()->route('top');
        }
        $auth_user = User::find($user_id);

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
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => route('message'), 'text' => 'メッセージ一覧'],
            ['url' => '#', 'text' => 'メッセージ'],
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
        if ($orderItem) {
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
        }
        if ($orderItem) {
            if ($orderItem->status == 0) {
                $cancelTemplate = MessageTemplate::where('type', MessageTemplate::TEMPLATE_REJECT)->first() ? MessageTemplate::where('type', MessageTemplate::TEMPLATE_REJECT)->first()->template : '';
            } else {
                $cancelTemplate = '';
            }
        } else {
            $cancelTemplate = '';
        }

        $uploadFileSize = Config::where('code', 'upload_file_size')->first() ? ceil(Config::where('code', 'upload_file_size')->first()->number) : 0;
        $uploadImageSize = Config::where('code', 'upload_item_image_size')->first() ? ceil(Config::where('code', 'upload_item_image_size')->first()->number) : 0;
        $prefs = json_decode(File::get(public_path('pref.json')), true);
        $arrItemCategory = config('constants.arrItemCategory');

        $arrPostSNS = config('constants.arrPostSNS');
        $arrGenders = config('constants.arrGenders');

        return view('message.show')->with(compact('title', 'pageTitle', 'breadcrumbs', 'orderItem', 'user_id', 'partner', 'messages', 'statuses', 'template', 'cancelTemplate', 'uploadFileSize', 'uploadImageSize', 'prefs', 'arrItemCategory', 'arrPostSNS', 'arrGenders'));
    }

    public function send(Request $request)
    {
        if (!$this->multiSubmitCheck($request)) abort(409);

        $data = $request->except('_token');
        $message = new Message();
        $message->order_item_id = $data['order_item_id'];
        $message->user_id = $data['user_id'];
        $message->to_user_id = $data['to_user_id'];
        $message->comment = $data['comment'];
        $message->save();
        
        return redirect()->route('message.show', ['id' => $data['order_item_id']]);
    }

    public function newMessage($id)
    {
        $auth_user_id = Auth::user()->id;
        $auth_user = User::find($auth_user_id);

        $orderItem = new OrderItem();
        $orderItem->item_id = null;
        $orderItem->user_id = $auth_user->role == 'company' ? $id : $auth_user_id;
        $orderItem->to_user_id = $auth_user->role == 'company' ? $auth_user_id : $id;
        $orderItem->status = -3;
        $orderItem->type = OrderItem::TYPE_MESSAGE;
        $orderItem->save();

        return redirect()->route('message.show', ['id' => $orderItem->id]);
    }

    public function concern($id)
    {
        $user_id = Auth::user()->id;
        $item = Item::find($id);
        if (empty($item)) return redirect()->route('top');

        $room = Room::where('item_id', $id)->where('from_user_id', $user_id)->first();
        if (empty($room)) {
            $room = new Room();
            $room->item_id = $id; $room->from_user_id = $user_id; $room->to_user_id = $item->user_id;
            $room->save();
        }

        $user = User::find($user_id);

        $message = new Message();
        $message->user_id = $user_id;
        $message->room_id = $room->id;
        $message->to_user_id = $item->user_id;
        $message->comment = $user->nickname . '様が' . $item->title . 'について「気になる」通知をしました';
        $message->save();


        $options = config('constants.mail')['concern'];
        $data = ['item_id' => $item->id, 'item_name' => $item->title, 'nickname' => $user->nickname];
        $to = $item->user->email;
        dispatch(new SendMailJob($to, $options, $data));


        return redirect()->route('message.show', ['id' => $room->id]);
    }
}