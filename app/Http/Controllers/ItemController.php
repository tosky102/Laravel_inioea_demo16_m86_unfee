<?php


namespace App\Http\Controllers;

use App\Models\Browse;
use App\Models\Favorite;
use App\Models\Follower;
use App\Models\Item;
use App\Models\ItemTag;
use App\Models\Message;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{

    public $page_num = 25;
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $order = isset($_GET['order']) ? $_GET['order'] : '';
        $count = isset($_GET['count']) ? $_GET['count'] : $this->page_num;
        $genre = isset($_GET['genre']) ? $_GET['genre'] : '';
        $offer = isset($_GET['offer']) ? $_GET['offer'] : '';
        $sns = isset($_GET['sns']) ? $_GET['sns'] : '';
        $gender = isset($_GET['gender']) ? $_GET['gender'] : '';
        $entry_follower = isset($_GET['entry_follower']) ? $_GET['entry_follower'] : '';
        $isEmergency = isset($_GET['is_emergency']) ? 1 : null;

        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => '#', 'text' => '案件一覧'],
        ];
        $title = '案件一覧';

        $objItems = Item::onlyPublic();
        if ($isEmergency) {
            $objItems = $objItems->where('is_emergency', $isEmergency);
        }
        
        if ($keyword) {
            $tag_ids = ItemTag::where('name', 'LIKE', '%' . $keyword . '%')->pluck('item_id');

            $objItems = $objItems->where(function ($query) use($keyword, $tag_ids) {
                $query->where('title', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('category', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('description', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('address1', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('address2', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('address3', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('wage', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('image', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('feature', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('appeal_point', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('website', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('youtube', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('station', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('employment', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('work_times', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('duration', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('timetable', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('content', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('resuraunt_years', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('business_name', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('employment2', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('career2', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('career', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('business_address', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('manager_name', 'LIKE', '%'. $keyword . '%')
                    ->orwhere('qualification', 'LIKE', '%'. $keyword . '%')
                    ->orWhereIn('id', $tag_ids);
            });
        }

        if ($genre) {
            $objItems = $objItems->where('genre', $genre);
        }
        if ($offer) {
            $objItems = $objItems->where('is_offering', $offer);
        }
        if ($sns) {
            $objItems = $objItems->where('entry_sns', $sns);
        }
        if ($gender) {
            $objItems = $objItems->where('gender', $gender);
        }
        if ($entry_follower) {
            $objItems = $objItems->where('entry_follower', '>', $entry_follower);
        }
        if ($order == '') $order = 'new';
        if ($order == 'new') {
            $objItems = $objItems->orderBy('created_at', 'DESC');
        }
        if ($order == 'view') {
            $objItems = $objItems->leftJoin('browses', 'items.id', '=', 'browses.item_id')
                ->groupBy('items.id')
                ->orderByRaw('COUNT(browses.id) DESC')
                ->select('items.*');
        }
        $objItems = $objItems->paginate($count)->appends(request()->except('page'));

        $startIndex = $count * ($objItems->currentPage() - 1);
        $products = $this->convertItemsToArray($objItems, $order, $startIndex);

        $genres = config('constants.arrItemCategory');
        $offers = [
            '1' => '有り',
            '0' => '無し',
        ];
        $postSNS = config('constants.arrPostSNS');
        $genders = config('constants.arrItemGender');
        $configs = array(
            'total' => $objItems->total(),
            'count' => $count,
            'order' => $order,
            'keyword' => $keyword,
            'genre' => $genre,
            'offer' => $offer,
            'sns' => $sns,
            'gender' => $gender,
            'genres' => $genres,
            'offers' => $offers,
            'postSNS' => $postSNS,
            'genders' => $genders,
            'isEmergency' => $isEmergency,
            'entry_follower' => $entry_follower,
        );

        return view('item.index')->with(compact('breadcrumbs', 'title', 'products', 'configs', 'objItems'));
    }

    function decodeUnicodeString($str)
    {
        return preg_replace_callback('/./u', function ($match) {
            $char = current($match);
            $code = unpack('H*', mb_convert_encoding($char, 'UTF-16BE', 'UTF-8'));
            return '\\u' . $code[1];
        }, $str);
    }

    public function category()
    {
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => '#', 'text' => 'カテゴリー一覧'],
        ];

        $title = 'カテゴリー一覧';

        $arrCategory = config('constants.arrCategory');

        $contents = [];
        foreach ($arrCategory as $main_category=>$categories) {
            $objProducts = Item::whereHas('User', function($q) { $q->whereIn('users.status', [0,1,2]); })->whereIn('items.status', [0,1])->where('category', 'LIKE', '%' . $main_category . '%')->take(10)->get();
            if (count($objProducts)) {
                $sub_categories = [];
                foreach ($categories as $category=>$text) {
                    $sub_categories[] = array(
                        'url' => route('item') . '?category=' . $category,
                        'text' => trim(mb_convert_kana($text, 's', 'UTF-8'))
                    );
                }
                $contents[] = array(
                    'category' => $main_category,
                    'category_url' => route('item') . '?category=' . $main_category,
                    'sub_categories' => $sub_categories,
                    'products' => $this->convertItemsToArray($objProducts)
                );
            }

        }


        return view('item.category')->with(compact('breadcrumbs', 'title', 'contents'));
    }


    public function tag()
    {
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => '#', 'text' => 'タグ一覧'],
        ];

        $title = 'タグ一覧';
        $objTags = ItemTag::whereHas('Item', function($q) { $q->where('status', 1)->where('deleted_at', null); })->where('deleted_at', null)->groupBy('name')->orderByRaw('COUNT(*) DESC')->get();
        $tags = [];
        foreach ($objTags as $objTag) {
            $tags[] = array(
                'text' => $objTag->name,
                'url' => route('item') . '?tag=' . $objTag->name
            );
        }
        return view('item.tag')->with(compact('breadcrumbs', 'title', 'tags'));
    }

    public function show($id)
    {
        $item = Item::find($id);
        $user_id = Auth::user() ? Auth::user()->id : 0;
        if (empty($item)) return redirect()->route('top');
        if ($item->status > 1) return redirect()->route('top');
        if ($item->user->status == 4) return redirect()->route('top');
        if ($item->user_id != $user_id && $item->related_user_id != $user_id && $item->public_flag == 0) return redirect()->route('top');

        $user = User::find($user_id);
        $browse = new Browse();
        $browse->user_id = $user_id ? $user_id : null;
        $browse->item_id = $id;
        $browse->save();

        $title = mb_strimwidth($item->title, 0, 50, "…");
        $breadcrumbs[] = ['url' => route('top'), 'text' => 'トップページ'];
        $breadcrumbs[] = ['url' => route('item'), 'text' => '案件一覧'];
        $breadcrumbs[] = ['url' => '#', 'text' => mb_strimwidth($item->title, 0, 50, "…")];

        $item_images = $item->images;
        $subImages = [];
        foreach ($item_images as $item_image) {
            $subImages[] = $item_image->image_url;
        }

        $favorited = Favorite::where('user_id', $user_id)->where('item_id', $item->id)->count();

        $auth_user_id = Auth::user() ? Auth::user()->id : 0;
        $following = Follower::where('user_id', $auth_user_id)->where('follow_user_id', $item->user_id)->count();

        $orderItem = OrderItem::where('user_id', $auth_user_id)->where('item_id', $item->id)->first();
        $purchased = OrderItem::where('user_id', $auth_user_id)->where('item_id', $item->id)->count();
        $reviwed = Review::where('user_id', $auth_user_id)->where('item_id', $item->id)->count();

        $prefs = json_decode(File::get(public_path('pref.json')), true);
        $arrGenders = config('constants.arrGenders');
        $is_entried = $item->order_items()->where('user_id', $user_id)->count() > 0;

        $product = [
            'id' => $item->id,
            'type' => $item->user->type,
            'title' => $item->title,
            'is_offering' => $item->is_offering ? '有り': '無し',
            'genre' => $item->genre_text,
            'address' => nl2br($item->address),
            'post_sns' => $item->post_sns,
            'post_type' => $item->post_type,
            'hash_tag' => $item->hash_tag,
            'pr_account' => $item->pr_account,
            'pr_flow' => nl2br($item->pr_flow),
            'pr_rule' => nl2br($item->pr_rule),
            'condition' => nl2br($item->condition),
            'entry_sns' => $item->entry_sns,
            'entry_follower' => $item->entry_follower ? $item->entry_follower . '人' : '0人',
            'entry_method' => nl2br($item->entry_method),
            'is_emergency' => $item->is_emergency,
            'user_id' => $user_id,
            'user' => $item->user,
            'description' => nl2br($item->description),
            'image' => $item->image,
            'website' => $item->website,
            'gender' => $item->gender ? $arrGenders[$item->gender] : '男女問わず',
            'station' => $item->station,
            'mainImage' => $item->main_image_url,
            'subImages' => $subImages,
            'rating' => $item->reviews->avg('rating'),
            'ratesCount' => $item->reviews->count(),
            'status' => $item->status,
            'price' => '￥' . number_format($item->price),
            'sellerId' => $item->user_id,
            'sellerUrl' => route('user.show', ['id' => $item->user_id]),
            'sellerReviewsUrl' => route('user.reviews', ['id' => $item->user_id]),
            'sellerImg' => $item->user->image_file_name ? asset('storage/' . $item->user->image_file_name) : asset('images/users/mallento.png'),
            'sellerName' => $item->user->nickname,
            'sellerLevel' => $item->user->admin_level,
            'sellerRating' => $item->user->sellingReviews->avg('rating'),
            'sellerRatesCount' => $item->user->sellingReviews->count(),
            'sellerDescription' => nl2br($item->user->comment),
            'description' => nl2br($item->description),
            'buyPointUrl' => route('mypage.buy_point'),
            'cartUrl' => route('cart.add_item', ['id' => $item->id]),
            'favorited' => $favorited,
            'purchased' => ($purchased > 0) && ($reviwed == 0),
            'following' => $following,
            'is_entried' => $is_entried,
            'public_flag' => $item->public_flag,
            'twitterUrl' => 'http://twitter.com/intent/tweet?text=' . $item->title . '&url=' . route('item.show', ['id' => $item->id]),
            'twitterSetting' => 'width=550,height=480,left=100,top=50,scrollbars=1,resizable=1',
            'newOrderUrl' => Auth::user() ? (Auth::user()->role == 'influencer' ? route('cart') : null) : route('login'),
            'messageUrl' => Auth::user() ? (Auth::user()->role == 'influencer' ? route('message.new_message', ['id' => $item->user_id]) : null) : route('login'),
            'editItemUrl' => Auth::user() ? (Auth::user()->id == ($item ? $item->user_id : null) ? route('mypage.item', ['id' => $item->id]) : null) : route('login'),
            'concernUrl' => route('message.concern', ['id' => ($item ? $item->id : null)]),
            'sellerListUrl' => route('item') . '?seller=' . ($item ? $item->user_id : null),
            'reviewsUrl' => route('item.reviews', ['id' => ($item ? $item->id : null)]),
            'partnerUrl' => $item ? route('user.show.partner', [ 'id' => $item->user_id]) : null,
            'productUrl1' => route('item'),
            'productUrl2' => route('item') . '?seller=' . ($item ? $item->user->id : null),
            'productUrl3' => route('item') . '?order=new&type=1',
        ];

        // $objRelationProducts = Item::where('category', $category)->where('id', '<>', $item->id)->take(10);
        $objRelationProducts = Item::whereHas('User', function($q) {
            $q->whereIn('users.status', [0,1,2,3]);
        })->whereIn('items.status', [0,1])
        ->where('is_recommended', 1)
        // ->where('category', $category)
        ->take(7)->get();
        $relationProducts = $this->convertItemsToArray($objRelationProducts);

        $objSellerProducts = Item::whereHas('User', function($q) { $q->whereIn('users.status', [0,1,2,3]); })->whereIn('items.status', [0,1])->where('user_id', $item->user_id)->take(7)->get();
        $sellerProducts = $this->convertItemsToArray($objSellerProducts);

        $objLastBrowses = Browse::where('user_id', $user_id)->groupBy('item_id')->latest()->take(7)->get();

        $objLastBrowseProducts = [];
        $last_browse_product_ids = [];
        foreach ($objLastBrowses as $objLastBrowse) {
            $objLastBrowseProducts[] = $objLastBrowse->item;
            // if (!in_array($objLastBrowse->item_id, $last_browse_product_ids) && $objLastBrowse->item) {
            //     if ($objLastBrowse->item->status == 1) {
            //         $last_browse_product_ids[] = $objLastBrowse->item_id;
            //         $objLastBrowseProducts[] = $objLastBrowse->item;
            //     }

            // }

            // if (count($last_browse_product_ids) >= 7) break;
        }
        $lastBrowseProducts = $this->convertItemsToArray($objLastBrowseProducts);

        $item_ids = session('sessAuthItems') ? session('sessAuthItems') : [];
        if (empty($item->password) || in_array($id, $item_ids)) {
            return view('item.show')->with(compact('title', 'breadcrumbs', 'user', 'product', 'relationProducts', 'sellerProducts', 'lastBrowseProducts'));
        } else {
            return view('item.password')->with(compact('title', 'breadcrumbs', 'product', 'relationProducts', 'sellerProducts', 'lastBrowseProducts'));
        }
    }

    public function password(Request $request)
    {
        $id = $request->id;
        $item = Item::find($id);
        if (!empty($item)) {
            $password = $request->password;
            if ($item->password == $password) {
                $item_ids = session('sessAuthItems') ? session('sessAuthItems') : [];
                if (!in_array($id, $item_ids)) {
                    $item_ids[] = $id;
                }

                $request->session()->start();
                $request->session()->put('sessAuthItems', $item_ids);
                $request->session()->save();
            }
        }

        return redirect()->route('item.show', ['id' => $id]);
    }

    public function reviews($id)
    {
        $item = Item::find($id);
        if (empty($item)) return redirect()->route('top');

        $category = $item->category;
        $categories = explode('-', $category);

        $title = 'レビュー一覧';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('item') . '?category=' . $categories[0], 'text' => $categories[0]],
            ['url' => route('item') . '?category=' . $category, 'text' => $categories[1]],
            ['url' => route('item.show', ['id' => $id]), 'text' => mb_strimwidth($item->title, 0, 50, "…")],
            ['url' => '#', 'text' => 'レビュー一覧'],
        ];

        $product = [
            'id' => $item->id,
            'img' => $item->main_image_url,
            'title' => $item->title,
            'rating' => $item->reviews->avg('rating'),
            'ratesCount' => $item->reviews->count(),
        ];

        $objReviews = $item->reviews()->paginate($this->mypage_page_num)->appends(request()->except('page'));;
        $reviews = [];
        foreach ($objReviews as $objReview) {
            $review = array(
                'nickname' => $objReview->user->nickname,
                'title' => $objReview->item->title,
                'datetime' => date('Y-m-d H:i:s', strtotime($objReview->created_at)),
                'comment' => $objReview->comment,
                'rating' => $objReview->rating,
            );

            $reviews[] = $review;
        }


        return view('item.reviews')->with(compact('title', 'breadcrumbs', 'product', 'reviews', 'objReviews'));
    }

    public function download($id)
    {
        $item = Item::find($id);

        if (empty(Auth::user())) {
            return redirect()->route('top');
        }
        if (!empty($item)) {
            $user = User::find(Auth::user()->id);

            $oneWeekBefore = date("Y-m-d H:i:s",strtotime("-7 day"));

            $possible = $user->buyingOrderItems()->where('item_id', $id)->where('created_at', '>=', $oneWeekBefore)->count();
            if (!$possible) {
                return redirect()->route('top');
            }

            $file_path = storage_path('app/public/' . $item->file_name);
            if (is_file($file_path) && file_exists($file_path)) {
                return Response::download($file_path);
            }
        }

        return redirect()->route('top');
    }

    public function favorite(Request $request)
    {
        $item_id = $request->item_id;
        $user_id = $request->user_id;

        if ($user_id == 0) {
            $ret['status'] = -5; // Guest
        } else {
            if ($item_id && $user_id) {
                $user = User::find($user_id);
                $item = Item::find($item_id);
                if (!empty($user) && !empty($item)) {
                    if ($user_id <> $item->user_id) {
                        $existed = Favorite::where('user_id', $user_id)->where('item_id', $item_id)->count();
                        if ($existed == 0) {
                            $favorite = new Favorite();
                            $favorite->user_id = $user_id; $favorite->item_id = $item_id;
                            $favorite->save();
                            $ret['status'] = 0;
                        } else {
                            Favorite::where('user_id', $user_id)->where('item_id', $item_id)->delete();
                            $ret['status'] = -3; // Existed Favorite
                        }
                    } else {
                        $ret['status'] = -4; // Self
                    }

                } else {
                    $ret['status'] = -2; // No Existing Data
                }
            } else {
                $ret['status'] = -1; // Invalid Parameters
            }
        }

        return response()->json($ret);
    }

    public function follow(Request $request)
    {
        $user_id = $request->user_id;
        $follow_user_id = $request->follow_user_id;
        $ret = [];
        if ($user_id) {
            if ($user_id == $follow_user_id) {
                $ret['status'] = -1; // Self
            } else {
                $existed = Follower::where('user_id', $user_id)->where('follow_user_id', $follow_user_id)->count();
                if ($existed == 0) {
                    $follower = new Follower();
                    $follower->user_id = $user_id; $follower->follow_user_id = $follow_user_id;
                    $follower->save();
                    $ret['status'] = 0;
                } else {
                    Follower::where('user_id', $user_id)->where('follow_user_id', $follow_user_id)->delete();
                    $ret['status'] = -3; // Existed Followers
                }
            }
        } else {
            $ret['status'] = -2; // Invalid Parameters
        }

        return response()->json($ret);
    }

    public function review(Request $request)
    {
        if (!$this->multiSubmitCheck($request)) {
            return redirect()->route('item.show', ['id' => $request->item_id]);
        }

        $review = new Review();
        $review->user_id = $request->user_id;
        $review->item_id = $request->item_id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return redirect()->route('item.show', ['id' => $review->item_id]);
    }

    public function vote(Request $request)
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }
        
        if (!$this->multiSubmitCheck($request)) abort(409);

        // バリデーションは try の外で実行して、失敗時は自動でリダイレクト＆エラーをフラッシュさせる
        $this->validator_item($request->all());

        try {
            $order_item_id = $request->order_item_id;
            $partner_id = $request->partner_id;
            $data = $request->except(['_token', 'order_item_id', 'partner_id']);
            $data['is_emergency'] = $request->boolean('is_emergency');

            if ($item_id = $this->createOrUpdateItem($data, true, $partner_id)) {
                if (!$item_id) {
                    return redirect()->back()->withError('案件起票に失敗しました。')->withInput();
                }

                $orderItem = OrderItem::find($order_item_id);
                $orderItem->item_id = $item_id;
                $orderItem->status = -2; // 案件起票
                $orderItem->save();

                $message = new Message();
                $message->order_item_id = $order_item_id;
                $message->user_id = $orderItem->item->user_id;
                $message->to_user_id = $orderItem->user_id;
                $message->role_type = 'influencer';
                $message->comment = '案件起票がありました。';
                $message->save();
            }
        } catch (\Throwable $e) {
            // ValidationException はここに来ない想定
            Log::error($e->getMessage());
            return redirect()->back()->withError('案件起票に失敗しました。')->withInput();
        }

        return redirect()->route('message.show', ['id' => $order_item_id]);
    }
}