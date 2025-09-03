<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Jobs\SendMailJob;
use App\Models\Browse;
use App\Models\Config;
use App\Models\Item;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
//        $this->middleware('auth');
        $this->middleware(['auth','verified']);
    }

    public function index($mode = 'index')
    {
        if (Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        if ($mode == 'index') {
            $title = 'カート';
        } else if ($mode == 'confirm') {
            $title = 'カート（決済確認）';
        } else if ($mode == 'complete') {
            $title = 'カート（決済完了）';
        } else {
            return redirect()->route('item');
        }

        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => '#', 'text' => $title],
        ];

        $cartItems = Cart::getContent();

        if (($mode == 'confirm' || $mode == 'complete') && count($cartItems) == 0) {
            return redirect()->route('item');
        }

        $categories = [];
        $objItems = [];

        $cartTotal = 0;
        $cartCount = 0;
        foreach ($cartItems as $cartItem) {
            $id = $cartItem['id'];
            $objItem = Item::find($id);
            $categories[] = $objItem->category;
            $objItems[] = $objItem;
            $cartTotal += $objItem->price;
            $cartCount++;
        }


        $user = User::find(Auth::user()->id);

        $cartVars = array(
            'count' => number_format($cartCount),
            'total' => number_format($cartTotal),
            'point' => number_format($user->point),
            'possible' => $user->point >= $cartTotal,
            'items_url' => route('item'),
            'index_url' => route('cart'),
            'confirm_url' => route('cart', ['mode' => 'confirm']),
            'complete_url' => route('cart', ['mode' => 'complete']),
            'buy_point_url' => route('mypage.buy_point'),
            'purchased_item_url' => route('mypage.purchased_item'),
            'user_id' => $user->id,
            'productUrl1' => route('item'),
            'productUrl2' => route('item') . '?order=sale',
            'productUrl3' => route('item'),
        );

        $items = $this->convertItemsToArray($objItems, 'cart');


        $objRelationProducts = Item::whereHas('User', function($q) { $q->whereIn('users.status', [0,1,2]); })->whereIn('items.status', [0,1])->whereIn('category', $categories)->take(7)->get();
        $relationProducts = $this->convertItemsToArray($objRelationProducts);

        $objSellerProducts = Item::whereHas('User', function($q) { $q->whereIn('users.status', [0,1,2]); })->whereIn('items.status', [0,1])->orderBy('sale_count', 'DESC')->take(7)->get();
        $sellerProducts = $this->convertItemsToArray($objSellerProducts);

        $objLastBrowses = Browse::whereHas('user')->latest()->take(100)->get();

        $objLastBrowseProducts = [];
        $last_browse_product_ids = [];
        foreach ($objLastBrowses as $objLastBrowse) {
            if (!in_array($objLastBrowse->item_id, $last_browse_product_ids) && $objLastBrowse->item) {
                if ($objLastBrowse->item->status == 1) {
                    $last_browse_product_ids[] = $objLastBrowse->item_id;
                    $objLastBrowseProducts[] = $objLastBrowse->item;
                }
            }

            if (count($last_browse_product_ids) >= 7) break;
        }
        $lastBrowseProducts = $this->convertItemsToArray($objLastBrowseProducts);

        if ($mode == 'complete') {
            Cart::clear();
        }
        return view('cart.index')->with(compact('title', 'breadcrumbs', 'mode', 'items', 'relationProducts', 'sellerProducts', 'lastBrowseProducts', 'cartVars'));
    }

    public function completePost(Request $request)
    {
        if (!$this->multiSubmitCheck($request)) abort(409);

        $cartItems = Cart::getContent();

        $user_id = $request->user_id;
        $objUser = User::find($user_id);

        $mailData = [];

        foreach ($cartItems as $cartItem) {
            $item_id = $cartItem['id'];
            $objItem = Item::find($item_id);

            $orderItem = new OrderItem();
            $orderItem->user_id = $user_id;
            $orderItem->name = $objUser->name;
            $orderItem->name_kana = $objUser->name_kana;
            $orderItem->company = $objUser->company;
            $orderItem->email = $objUser->email;
            $orderItem->postcode = $objUser->postcode;
            $orderItem->pref = $objUser->pref;
            $orderItem->address = $objUser->address;
            $orderItem->phone = $objUser->phone;

            $orderItem->item_id = $item_id;
            $orderItem->title = $objItem->title;
            $orderItem->price = $objItem->price;
            $orderItem->quantity = 1;
            $orderItem->total = $objItem->price;
            $orderItem->matched_at = date('Y-m');

            $sale_fee_rate = Config::where('code', 'sale_fee_rate')->first() ? floor(Config::where('code', 'sale_fee_rate')->first()->number) : 0;
            if ($sale_fee_rate < 100) {
                $sale_fee = floor($objItem->price * $sale_fee_rate / 100);
            } else {
                $sale_fee = 0;
            }

            $orderItem->sale_fee = $sale_fee;


            $orderItem->sale_ym = date('Ym');
            $orderItem->save();

            $objUser->point = $objUser->point - $objItem->price;
            $objUser->save();

            $objSeller = User::find($objItem->user_id);
            $objSeller->point = $objSeller->point + ($objItem->price - $objItem->sale_fee);
            $objSeller->save();

            $objItem->sale_count = $objItem->sale_count + 1;
            $objItem->save();

            $options = config('constants.mail')['purchasedToSeller'];
            $data = ['id' => $objItem->id, 'title' => $objItem->title];
            $to = $objItem->user->email;
            dispatch(new SendMailJob($to, $options, $data));

            $mailRet = array(
                'item_id' => $objItem->id,
                'item_name' => $objItem->title,
                'nickname' => $objItem->user->nickname,
                'total' => $objItem->price
            );

            $mailData[] = $mailRet;
        }


        $options = config('constants.mail')['purchaseComplete'];
        $data = ['items' => $mailData];
        $to = $objUser->email;
        dispatch(new SendMailJob($to, $options, $data));

        return redirect()->route('cart', ['mode' => 'complete']);
    }

    public function addItem($id)
    {
//        $user_id = Auth::user()->id;
        $item = Item::find($id);
        if (empty($item)) {
            return redirect()->route('cart');
        }

        $cartItems = Cart::getContent();

        $isContain = 0;
        foreach ($cartItems as $cartItem) {
            if ($cartItem->id == $id) {
                $isContain = 1;
//                $quantity = $cartItem->quantity;
//                Cart::update($cartItem->id, [
//                    'quantity' => [
//                        'relative' => false, 'value' => $quantity + 1
//                    ]
//                ]);
            }
        }

        if ($isContain == 0) {
            Cart::add([
                'id' => $item->id,
                'name' => $item->title,
                'price' => $item->price,
                'quantity' => 1,
                'attributes' => [
                    'image' => $item->main_image_url,
                ]
            ]);
        }

        return redirect()->route('cart');
    }

    public function removeItem($id)
    {
        $user_id = Auth::user()->id;
        Cart::remove($id);
        return redirect()->route('cart');
    }
}