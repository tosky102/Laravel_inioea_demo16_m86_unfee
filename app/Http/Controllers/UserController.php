<?php


namespace App\Http\Controllers;


use App\Models\Browse;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Favorite;
use App\Models\Follower;
use App\Models\Item;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public $page_num = 25;

    public function index()
    {
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $order = isset($_GET['order']) ? $_GET['order'] : '';
        $count = isset($_GET['count']) ? $_GET['count'] : $this->page_num;
        $category = isset($_GET['category']) ? $_GET['category'] : '';
        $area = isset($_GET['area']) ? $_GET['area'] : '';
        $gender = isset($_GET['gender']) ? $_GET['gender'] : '';
        $isEmergency = isset($_GET['is_picked']) ? 1 : null;

        $pageTitle = 'インフルエンサー一覧';
        $title = 'インフルエンサー一覧';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => '#', 'text' => $pageTitle],
        ];
        
        $auth_user = User::find(Auth::user()->id);
        $query = User::where('role', 'influencer')->where('status', 3);
        if ($isEmergency) {
            $query->where('is_picked', $isEmergency);
        }
        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('nickname', 'like', '%' . $keyword . '%')
                ->orWhere('comment', 'like', '%' . $keyword . '%');
        }
        if ($category) {
            $query->where('main_category', $category);
        }
        if ($area) {
            $query->where('area', $area);
        }
        if ($gender) {
            $query->where('gender', $gender);
        }
        if ($order == '') $order = 'new';
        if ($order == 'new') {
            $query->orderBy('created_at', 'DESC');
        }
        if ($order == 'view') {
            $query->leftJoin('visits', 'users.id', '=', 'visits.visit_user_id')
                ->groupBy('users.id')
                ->orderByRaw('COUNT(visits.id) DESC')
                ->select('users.*');
        }

        $arrCategories = Category::get()->pluck('name', 'id');
        $objUsers = $query->paginate($count)->appends(request()->except('page'));
        $startIndex = $count * ($objUsers->currentPage() - 1);
        $users = $this->convertUsersToArray($objUsers, '', $startIndex, $arrCategories);

        $arrAreas = config('constants.arrArea');
        $arrGenders = config('constants.arrGender');
        
        $configs = array(
            'total' => $objUsers->total(),
            'count' => $count,
            'order' => $order,
            'keyword' => $keyword,
            'category' => $category,
            'area' => $area,
            'gender' => $gender,
            'categories' => $arrCategories,
            'areas' => $arrAreas,
            'genders' => $arrGenders,
            'isPicked' => $isEmergency,
        );

        return view('user.index')->with(compact('breadcrumbs', 'title', 'users', 'configs', 'objUsers'));
    }

    public function show($id)
    {
        $user = User::find($id);
        if (empty($user)) return redirect()->route('top');
        if ($user->status == 4) {
            return redirect()->route('top');
        }

        $title = $user->nickname;
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('user'), 'text' => 'インフルエンサー一覧'],
            ['url' => '#', 'text' => $title],
        ];

        $auth_user_id = Auth::user() ? Auth::user()->id : 0;
        $following = Follower::where('user_id', $auth_user_id)->where('follow_user_id', $id)->count();

        Visit::create([
            'user_id' => $auth_user_id,
            'visit_user_id' => $id,
        ]);

        $user_images = $user->images;
        $subImages = [];
        foreach ($user_images as $user_image) {
            $subImages[] = $user_image->image_url;
        }

        $main_category = $user->mainCategory ? $user->mainCategory->name : '';
        $sub_category = $user->subCategory ? $user->subCategory->name : '';

        $user = array(
            'id' => $user->id,
            'mainImage' => $user->image_url,
            'subImages' => $subImages,
            'name' => $user->nickname,
            'role' => $auth_user_id ? Auth::user()->role : '',
            'sns' => $user->sns,
            'gender' => config('constants.arrGenders')[$user->gender],
            'main_category' => $main_category,
            'sub_category' => $sub_category,
            'birthplace' => $user->birthplace,
            'residence' => $user->residence,
            'area' => $user->area,
            'specialty' => nl2br($user->specialty),
            'hobby' => nl2br($user->hobby),
            'qualification' => $user->qualification,
            'language' => $user->language,
            'instagram_account' => $user->instagram_account,
            'tiktok_account' => $user->tiktok_account,
            'x_account' => $user->x_account,
            'youtube_account' => $user->youtube_account,
            'facebook_account' => $user->facebook_account,
            'other_sns_account' => $user->other_sns_account,
            'instagram_fan_count' => $user->instagram_fan_count,
            'tiktok_fan_count' => $user->tiktok_fan_count,
            'x_fan_count' => $user->x_fan_count,
            'youtube_fan_count' => $user->youtube_fan_count,
            'facebook_fan_count' => $user->facebook_fan_count,
            'other_fan_count' => $user->other_fan_count,
            'career_url_1' => $user->career_url_1,
            'career_1' => nl2br($user->career_1),
            'career_url_2' => $user->career_url_2,
            'career_2' => nl2br($user->career_2),
            'career_url_3' => $user->career_url_3,
            'career_3' => $user->career_3,
            'is_picked' => $user->is_picked,
            'admin_comment' => nl2br($user->admin_comment),
            'admin_pickup_category' => $user->admin_pickup_category,
            'level' => $user->level,
            'comment' => nl2br($user->comment),
            'rating' => $user->sellingReviews->avg('rating'),
            'ratesCount' => number_format($user->sellingReviews->count()),
            'followerCount' => number_format($user->followerUsers()->count()),
            'followCount' => number_format($user->followUsers()->count()),
            'followed' => Follower::where('user_id', $auth_user_id)->where('follow_user_id', $user->id)->count() > 0 ? true : false,
            'itemsCount' => number_format($user->items()->count()),
            'user_id' => $auth_user_id,
            'newMessageUrl' => Auth::user() ? route('message.new_message', ['id' => $user->id]) : route('login'),
            'reportUrl' => route('user.report', ['id' => $user->id]),
            'reviewsUrl' => route('user.reviews', ['id' => $user->id]),
            'productUrl1' => route('item') . '?seller=' . $user->id . '&order=new',
            'productUrl2' => route('item') . '?seller=' . $user->id . '&order=sale',
        );

        // $objRelationProducts = Item::whereHas('User', function($q) {
        //     $q->whereIn('users.status', [0,1,2,3]);
        // })->whereIn('items.status', [0,1])
        // ->where('is_recommended', 1)
        // ->where('category', $category)
        // ->take(7)->get();
        // $relationProducts = $this->convertItemsToArray($objRelationProducts);
        $categories = Category::all()->toArray();
        $relationUsers = User::where('is_recommended', 1)->whereIn('status', [0,1,2,3])->take(7)->get();
        $relationUsers = $this->convertUsersToArray($relationUsers, '', 0, $categories);

        // $objNewProducts = Item::whereHas('User', function($q) { $q->whereIn('users.status', [0,1,2]); })->whereIn('items.status', [0,1])->where('user_id', $id)->orderBy('created_at', 'DESC')->take(10)->get();
        // $newProducts = $this->convertItemsToArray($objNewProducts);

        // $objSellerProducts = Item::whereHas('User', function($q) { $q->whereIn('users.status', [0,1,2]); })->whereIn('items.status', [0,1])->where('user_id', $id)->orderBy('sale_count', 'DESC')->take(10)->get();
        // $sellerProducts = $this->convertItemsToArray($objSellerProducts);

        return view('user.show')->with(compact('title', 'breadcrumbs', 'user', 'relationUsers'));
    }

    public function showPartner($id) {
        $user = User::find($id);
        if (empty($user)) return redirect()->route('top');
        if ($user->status == 4) {
            return redirect()->route('top');
        }

        $title = $user->facility_name;
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('item'), 'text' => '案件一覧'],
            ['url' => '#', 'text' => $title],
        ];

        $auth_user_id = Auth::user() ? Auth::user()->id : 0;
        $following = Follower::where('user_id', $auth_user_id)->where('follow_user_id', $id)->count();

        Visit::create([
            'user_id' => $auth_user_id,
            'visit_user_id' => $id,
        ]);

        $user_images = $user->images;
        $subImages = [];
        foreach ($user_images as $user_image) {
            $subImages[] = $user_image->image_url;
        }

        $main_category = $user->mainCategory ? $user->mainCategory->name : '';
        $sub_category = $user->subCategory ? $user->subCategory->name : '';

        $user = array(
            'id' => $user->id,
            'mainImage' => $user->image_url,
            'subImages' => $subImages,
            'name' => $user->facility_name,
            'role' => $auth_user_id ? Auth::user()->role : '',
            'postcode' => $user->postcode,
            'pref' => $user->pref_label,
            'city' => $user->city,
            'address' => $user->address,
            'main_category' => $main_category,
            'manager_name' => $user->manager_name,
            'manager_position' => $user->manager_position,
            'manager_phone' => $user->manager_phone,
            'employee_count' => $user->employee_count,
            'earning' => $user->earning,
            'comment' => nl2br($user->comment),
            'career' => $user->career,
            'company_qualification' => $user->company_qualification,
            'specialty' => $user->specialty,
            
            // 'rating' => $user->sellingReviews->avg('rating'),
            // 'ratesCount' => number_format($user->sellingReviews->count()),
            // 'followerCount' => number_format($user->followerUsers()->count()),
            // 'followCount' => number_format($user->followUsers()->count()),
            // 'followed' => Follower::where('user_id', $auth_user_id)->where('follow_user_id', $user->id)->count() > 0 ? true : false,
            // 'itemsCount' => number_format($user->items()->count()),
            // 'user_id' => $auth_user_id,
            // 'newMessageUrl' => Auth::user() ? route('message.new_message', ['id' => $user->id]) : route('login'),
            // 'reportUrl' => route('user.report', ['id' => $user->id]),
            // 'reviewsUrl' => route('user.reviews', ['id' => $user->id]),
            // 'productUrl1' => route('item') . '?seller=' . $user->id . '&order=new',
            // 'productUrl2' => route('item') . '?seller=' . $user->id . '&order=sale',
        );

        $objRelationProducts = Item::whereHas('User', function($q) {
            $q->whereIn('users.status', [0,1,2,3]);
        })->whereIn('items.status', [0,1])
        ->where('is_recommended', 1)
        // ->where('category', $category)
        ->take(7)->get();
        $relationProducts = $this->convertItemsToArray($objRelationProducts);

        // $objNewProducts = Item::whereHas('User', function($q) { $q->whereIn('users.status', [0,1,2]); })->whereIn('items.status', [0,1])->where('user_id', $id)->orderBy('created_at', 'DESC')->take(10)->get();
        // $newProducts = $this->convertItemsToArray($objNewProducts);

        // $objSellerProducts = Item::whereHas('User', function($q) { $q->whereIn('users.status', [0,1,2]); })->whereIn('items.status', [0,1])->where('user_id', $id)->orderBy('sale_count', 'DESC')->take(10)->get();
        // $sellerProducts = $this->convertItemsToArray($objSellerProducts);
        return view('user.show_partner')->with(compact('title', 'breadcrumbs', 'user', 'relationProducts'));
    }

    public function report($id)
    {
        $title = '報告する';
        $user = User::find($id);
        if (empty($user)) return redirect()->route('top');

        $auth_user_id = Auth::user() ? Auth::user()->id : 0;

        return view('user.report')->with(compact('title', 'user', 'auth_user_id'));
    }

    public function reportPost(Request $request)
    {
        if (!$this->multiSubmitCheck($request)) abort(409);

        $data = $request->except('_token');
        $this->validator_report($data);

        $user_id = isset($data['user_id']) ? $data['user_id'] : 0;
        $contact = new Contact();
        $contact->user_id = $user_id;
        $contact->title = $data['title'];
        $contact->content = $data['content'];
        $contact->save();

        $id = $data['id'];
        return redirect()->route('user.report', ['id' => $id])->withSuccess('報告しました！');
    }

    protected function validator_report(array $data)
    {
        return Validator::make($data, [
            'content' => ['required', 'string'],
        ])->validate();
    }

    public function reviews($id)
    {
        $objUser = User::find($id);
        if (empty($objUser)) return redirect()->route('top');

        $title = 'レビュー一覧';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('user.show', ['id' => $objUser->id]), 'text' => $objUser->nickname],
            ['url' => '#', 'text' => 'レビュー一覧'],
        ];

        $user = array(
            'img' => $objUser->image_file_name ? asset('storage/' . $objUser->image_file_name) : asset('storage/mallento.png'),
            'user_id' => Auth::user() ? Auth::user()->id : 0,
            'id' => $objUser->id,
            'name' => $objUser->nickname,
            'comment' => nl2br($objUser->comment),
            'rating' => $objUser->sellingReviews->avg('rating'),
            'ratesCount' => number_format($objUser->sellingReviews->count()),
            'followerCount' => number_format($objUser->followerUsers()->count()),
            'followCount' => number_format($objUser->followUsers()->count()),
            'itemsCount' => number_format($objUser->items()->count()),
        );

        $count = 2;

        $objReviews = $objUser->sellingReviews()->paginate($this->page_num)->appends(request()->except('page'));;
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

        return view('user.reviews')->with(compact('title', 'breadcrumbs', 'user', 'reviews', 'objReviews'));
    }

    public function follow()
    {
        $pageTitle = 'お気に入り一覧';
        $title = 'お気に入り一覧';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => $pageTitle],
        ];

        $auth_user = User::find(Auth::user()->id);

        $arrCategories = get_category_list();
        $query = User::where('role', 'influencer')->whereHas('followers', function($q) use ($auth_user) {
            $q->where('user_id', $auth_user->id);
        })->get();
        $follows = $this->convertUsersToArray($query, '', 0, $arrCategories);

        return view('mypage.follow')->with(compact('title', 'pageTitle', 'breadcrumbs', 'follows'));
    }

    public function followPost(Request $request)
    {
        $follow_user_id = $request->follow_user_id;

        $auth_user_id = Auth::user() ? Auth::user()->id : 0;
        if ($auth_user_id == 0) {
            return response()->json(['status' => -1]); // Guest
        }

        $user = User::find($follow_user_id);
        if (empty($user)) {
            return response()->json(['status' => -2]); // No Existing Data
        }

        if ($follow_user_id == $auth_user_id) {
            return response()->json(['status' => -4]);
        }

        $follower = Follower::where('user_id', $auth_user_id)->where('follow_user_id', $follow_user_id)->first();
        if ($follower) {
            $follower->delete();
            return response()->json(['status' => -3]);
        }

        Follower::create([
            'user_id' => $auth_user_id,
            'follow_user_id' => $follow_user_id,
        ]);

        return response()->json(['status' => 0]);
    }
}