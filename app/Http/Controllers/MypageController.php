<?php

namespace App\Http\Controllers;

use App\Components\ExifComponent;
use App\Jobs\SendMailJob;
use App\Models\CashingData;
use App\Models\Config;
use App\Models\Contact;
use App\Models\CreditTransaction;
use App\Models\Favorite;
use App\Models\Follower;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\ItemTag;
use App\Models\Message;
use App\Models\OrderItem;
use App\Models\OrderPoint;
use App\Models\Room;
use App\Models\User;
use App\Models\UserImage;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class MypageController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth','verified'])->except(['contact', 'contactPost']);
    }

    public function index()
    {
        $uploadImageSize = Config::where('code', 'upload_user_image_size')->first() ? ceil(Config::where('code', 'upload_user_image_size')->first()->number) : 0;

        $pageTitle = 'マイページ';
        $title = 'マイページ';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => '#', 'text' => 'マイページ'],
        ];

        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        if ($user->status == 1) {
            return redirect()->route('mypage.basic_register');
        }
        if ($user->image_file_name) {
            $user->image_file_url = asset('storage/' . $user->image_file_name);
        } else {
            $user->image_file_url = asset('images/users/mallento.png');
        }

        return view('mypage.index')->with(compact('uploadImageSize','title', 'breadcrumbs', 'pageTitle', 'user'));
    }

    // AJAX REQUEST TRAIT
    // public function userImagePost(Request $request)
    // {
    //     $user_id = $request->user_id;
    //     $image = $request->image_file_name;
    //     $binary = ExifComponent::rotateFromBinary(file_get_contents($image));

    //     $file = Image::make($binary);
    //     $width = 360; $height = 360;
    //     $file->height() > $file->width() ? $width=null : $height=null;
    //     $file->resize($width, $height, function ($constraint) {
    //         $constraint->aspectRatio();
    //     })->stream('jpg', 100);

    //     $filename = time() . uniqid(rand()) . '.jpg';

    //     Storage::disk('public')->put('users/' . $user_id . '/' . $filename, $file);

    //     $user = User::find($user_id);
    //     $user->image_file_name = 'users/' . $user_id . '/' . $filename;
    //     $user->save();

    //     return redirect()->route('mypage');
    // }

    public function userImageDeletePost(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::find($user_id);

        $path = storage_path('app/public/' . $user->image_file_name);
        @unlink($path);

        $user->image_file_name = '';
        $user->save();

        return redirect()->route('mypage');

    }

    public function profile()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $user_id = Auth::user()->id;
        $auth_user = User::find($user_id);

        $pageTitle = $auth_user->role == 'influencer' ? 'インフルエンサー' : '企業情報';
        $title = $auth_user->role == 'influencer' ? 'インフルエンサー' : '企業情報';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => $auth_user->role == 'influencer' ? 'インフルエンサー' : '企業情報'],
        ];

        $data = session('sessProfile');
        if (empty($data)) {
            $data = $auth_user->toArray();
        }
        $userImages = $auth_user->images()->get();
        $images = [];
        foreach ($userImages as $i_id => $userImage) {
            $url = asset('storage/' . $userImage->name);
            $path = storage_path('app/public/' . $userImage->name);

            $images[$i_id] = compact('url', 'path');
        }
        $data['images'] = $images;

        $categories = get_category_list();
        $prefs = json_decode(File::get(public_path('pref.json')), true);
        $areas = config('constants.arrArea');
        $languages = config('constants.arrLanguage');
        $employeeCounts = config('constants.arrEmployeeCount');
        $earnings = config('constants.arrEarning');
        $uploadImageSize = Config::where('code', 'upload_item_image_size')->first() ? ceil(Config::where('code', 'upload_item_image_size')->first()->number) : 0;

        return view('mypage.profile')->with(compact('title', 'breadcrumbs', 'pageTitle', 'data', 'categories', 'prefs', 'areas', 'employeeCounts', 'earnings', 'languages', 'uploadImageSize'));
    }

    public function profilePost(Request $request)
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }
        if (!$this->multiSubmitCheck($request)) abort(409);

        $data = $request->except('_token');
        $this->validator_profile($data);

        $user = $this->createOrUpdateProfile($data);

        return redirect(route('mypage.profile_complete'));
    }

    public function profileConfirm()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $pageTitle = '登録情報変更の確認';
        $title = '登録情報変更の確認';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => '登録情報変更の確認'],
        ];

        $data = session('sessProfile');
        return view('mypage.profile_confirm')->with(compact('title', 'pageTitle', 'breadcrumbs', 'data'));
    }

    public function profileConfirmPost(Request $request)
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }
        if (!$this->multiSubmitCheck($request)) abort(409);

        $data = session('sessProfile');

        if ($user = $this->updateUser($data)) {
            return redirect(route('mypage.profile_complete'));
        } else {
            return redirect(route('mypage.profile'));
        }
    }

    public function profileComplete()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $pageTitle = '登録情報変更完了';
        $title = '登録情報変更完了';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => '登録情報変更完了'],
        ];

        return view('mypage.profile_complete')->with(compact('title', 'pageTitle', 'breadcrumbs'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_profile(array $data)
    {
        $user = Auth::user();
        // インフルエンサーの場合
        if ($user->role == 'influencer') {
            $rules = [
                'email' => [
                    'nullable', 'string', 'email', 'max:100',
                    Rule::unique('users')->where(function ($query) use ($data, $user) {
                        return $query->where('email', $data['email'])->whereIn('status', [0, 1,2])->where('id', '<>', $user->id)->where('deleted_at', NULL);
                    }),
                    'confirmed'
                ],
                'password' => ['nullable', 'string', 'min:8', 'max:100', 'confirmed'],
                'name' => ['required', 'string', 'max:32'],
                'nickname' => ['required', 'string', 'max:32'],
                'gender' => ['required', 'string', 'max:1'],
                'main_category' => ['required', 'string', 'max:100'],
                'birthplace' => ['nullable', 'string', 'max:100'],
                'residence' => ['nullable', 'string', 'max:100'],
                'area' => ['required', 'string', 'max:100'],
                'specialty' => ['nullable', 'string', 'max:1000'],
                'hobby' => ['nullable', 'string', 'max:1000'],
                'qualification' => ['nullable', 'string', 'max:1000'],
                'language' => ['required', 'string', 'max:100'],
                'other_language' => ['nullable', 'string', 'max:100'],
                'profile_comment' => ['nullable', 'string', 'max:1000'],
                'instagram_fan_count' => ['nullable', 'numeric'],
                'tiktok_fan_count' => ['nullable', 'numeric'],
                'x_fan_count' => ['nullable', 'numeric'],
                'youtube_fan_count' => ['nullable', 'numeric'],
                'facebook_fan_count' => ['nullable', 'numeric'],
                'other_fan_count' => ['nullable', 'numeric'],
                'career_url_1' => ['nullable', 'url'],
                'career_1' => ['nullable', 'string', 'max:1000'],
                'career_url_2' => ['nullable', 'url'],
                'career_2' => ['nullable', 'string', 'max:1000'],
                'career_url_3' => ['nullable', 'url'],
                'career_3' => ['nullable', 'string', 'max:1000'],
                'images.0.url' => ['required'],
            ];

            // 「その他」が選択された場合、other_languageを必須にする
            if (isset($data['language']) && $data['language'] === 'その他') {
                $rules['other_language'] = ['required', 'string', 'max:100'];
            }

            // 「海外」が選択された場合、other_areaを必須にする
            if (isset($data['area']) && $data['area'] === '海外') {
                $rules['other_area'] = ['required', 'string', 'max:100'];
            }

            return Validator::make($data, $rules)->validate();
        } else {
            return Validator::make($data, [
                'email' => [
                    'nullable', 'string', 'email', 'max:100',
                    Rule::unique('users')->where(function ($query) use ($data, $user) {
                        return $query->where('email', $data['email'])->whereIn('status', [0, 1,2])->where('id', '<>', $user->id)->where('deleted_at', NULL);
                    }),
                    'confirmed'
                ],
                'password' => ['nullable', 'string', 'min:8', 'max:100', 'confirmed'],
                'name' => ['required', 'string', 'max:100'],
                'facility_name' => ['required', 'string', 'max:100'],
                'postcode' => ['required', 'string', 'regex:/^\d{7}$/'],
                'pref' => ['required', 'string', 'max:100'],
                'city' => ['required', 'string', 'max:100'],
                'address' => ['nullable', 'string', 'max:100'],
                'main_category' => ['required', 'string', 'max:100'],
                'manager_name' => ['required', 'string', 'max:100'],
                'manager_position' => ['required', 'string', 'max:100'],
                'manager_phone' => ['required', 'string', 'regex:/^0\d{9,10}$/'],
                'images.0.url' => ['required'],
                'comment' => ['required', 'string'],
                'employee_count' => ['required'],
                'earning' => ['required', 'string'],
                'career' => ['required', 'string'],
                'specialty' => ['required', 'string'],
                'company_qualification' => ['required', 'string'],
            ])->validate();
        }
    }

    protected function validator_profile_main(array $data)
    {
        return Validator::make($data, [
            'type' => ['nullable', 'string', 'max:100'],
        ])->validate();
    }

    protected function validator_profile_email(array $data)
    {
        $user_id = Auth::user()->id;
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:100',
                Rule::unique('users')->where(function ($query) use ($data, $user_id) {
                    return $query->where('email', $data['email'])->whereIn('status', [0, 1,2])->where('id', '<>', $user_id)->where('deleted_at', NULL);
                }),
//                'unique:users,email,' . $user_id, 'id,deleted_at,NULL',
                'confirmed'],
        ])->validate();
    }

    protected function validator_profile_password(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
        ])->validate();
    }

    protected function updateUser(array $data)
    {

        $save_data = $data;
        if (isset($data['password'])) {
            $save_data['password'] = Hash::make($data['password']);
        }
        unset($save_data['mode']);
        unset($save_data['email_confirmation']);
        unset($save_data['password_confirmation']);

        $user_id = Auth::user()->id;
        User::where('id', $user_id)->update($save_data);
        return User::find($user_id);
    }

    protected function createOrUpdateProfile(array $data)
    {
        $user_id = Auth::user()->id;
        if ($data['email'] == null) {
            unset($data['email']);
        }
        if ($data['password'] == null) {
            unset($data['password']);
            unset($data['password_confirmation']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        $user = User::updateOrCreate(['id' => $user_id], $data);

        if (isset($data['images']) && is_array($data['images'])) {
            $old_images = UserImage::where('user_id', $user_id)->get();

            $old_paths = [];
            foreach($old_images as $old_image) {
                $old_paths[] = storage_path('app/public/' . $old_image->name);
            }
            UserImage::where('user_id', $user_id)->delete();

            foreach ($data['images'] as $image) {
                $url = $image['url'];
                $path = $image['path'];
                if ($url && $path) {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $filename = time().'_'.$this->getGenesCode(8).'.'.$ext;

                    $dir = storage_path('app/public/users/' . $user_id);
                    if (!is_dir($dir)) {
                        umask(0);
                        @mkdir($dir, 0777);
                    }

                    $new_path = storage_path('app/public/users/' . $user_id . '/' . $filename);

                    if ($path <> $new_path) {
                        @rename($path, $new_path);
                        @unlink($path);
                    }

                    $userImage = new UserImage();
                    $userImage->user_id = $user_id;
                    $userImage->name = 'users/' . $user_id . '/' . $filename;
                    $userImage->save();
                }
            }

            foreach ($old_paths as $old_path) {
                @unlink($old_path);
            }
        }

        return $user;
    }

    public function item($id = null)
    {
        $uploadFileSize = Config::where('code', 'upload_file_size')->first() ? ceil(Config::where('code', 'upload_file_size')->first()->number) : 0;
        $uploadImageSize = Config::where('code', 'upload_item_image_size')->first() ? ceil(Config::where('code', 'upload_item_image_size')->first()->number) : 0;

        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $data = array();
        if (!empty($id)) {
            $item = Item::find($id);

            if ($item->user_id != Auth::user()->id) return redirect()->route('mypage');

            $data = $item->toArray();

            $data['tags'] = $item->tags()->pluck('name');
            if (isset($data['employment']) && !empty($data['employment'])) {
                $data['employment'] = json_decode($data['employment'], true);
            }
            if (isset($data['career']) && !empty($data['career'])) {
                $data['career'] = json_decode($data['career'], true);
            }
            if (isset($data['duration']) && !empty($data['duration'])) {
                $data['duration'] = json_decode($data['duration'], true);
            }

            $objImages = $item->images()->get();
            $images = [];
            foreach ($objImages as $i_id => $objImage) {
            //                $url = asset('storage/items/' .$id . '/' . $i_id . '/' . $objImage->name);
            //                $path = storage_path('app/public/items/' . $id . '/' . $i_id . '/' . $objImage->name);

                $url = asset('storage/' . $objImage->name);
                $path = storage_path('app/public/' . $objImage->name);

                $images[$i_id] = compact('url', 'path');
            }
            $data['images'] = $images;

            $file_name = $data['file_name'];

            if (!empty($file_name)) {
                setlocale(LC_ALL, 'ja_JP.UTF-8');

                $path_parts = pathinfo($file_name);
                $file_path = storage_path('app/public/' . $file_name);

                $file = array(
                    'name' => isset($path_parts['basename']) ? $path_parts['basename'] : '',
                    'path' => $file_path,
                    'type' => @mime_content_type($file_path),
                    'extension' => isset($path_parts['extension']) ? $path_parts['extension'] : '',
                    'size' => @filesize($file_path),
                );
            } else {
                $file = array(
                    'name' => '',
                    'path' => '',
                    'type' => '',
                    'extension' => '',
                    'size' => '',
                );
            }

            $data['file'] = $file;
        }

        $prefs = json_decode(File::get(public_path('pref.json')), true);
        $arrItemCategory = config('constants.arrItemCategory');

        $arrPostSNS = config('constants.arrPostSNS');
        $arrGenders = config('constants.arrItemGender');
        $user = Auth::user();
        $pageTitle = $id ? $item->title : '新規案件登録';
        $title = $id ? $item->title : '新規案件登録';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
        ];
        if ($id) {
            $breadcrumbs[] = ['url' => route('mypage.item_mine'), 'text' => '自社案件一覧'];
            $breadcrumbs[] = ['url' => '#', 'text' => $pageTitle];
        } else {
            $breadcrumbs[] = ['url' => '#', 'text' => $pageTitle];
        }

        return view('mypage.item')->with(compact('uploadFileSize', 'uploadImageSize', 'title', 'pageTitle', 'breadcrumbs', 'arrItemCategory', 'arrPostSNS', 'id', 'data','prefs', 'arrGenders'));   
    }

    public function download($id)
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }
        if (Auth::user()->admin_flag == 0) { return redirect()->route('mypage'); }

        $item = Item::find($id);

        if (!empty($item) && !empty($item->file_name)) {
            $user = User::find(Auth::user()->id);

            $possible = $user->id == $item->user_id;
            if (!$possible) {
                return redirect()->route('mypage');
            }

            try {
                $file_path = storage_path('app/public/' . $item->file_name);
                if (is_file($file_path) && file_exists($file_path)) {
                    return Response::download($file_path);
                }

            } catch (\Exception $e) {

            }
        }

        return redirect()->route('mypage');
    }

    public function itemPost(Request $request)
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }
        if (!$this->multiSubmitCheck($request)) abort(409);

        $this->validator_item($request->all());

        $data = $request->except('_token');
        $data['is_emergency'] = $request->boolean('is_emergency');

        if ($item_id = $this->createOrUpdateItem($data)) {
            if ($item_id) {
                return redirect()->back()->withSuccess('情報を保存しました。');
            }
        }

        return redirect()->back()->withError('情報保存が失敗しました。');
    }

    // AJAX REQUEST TRAIT
    public function itemImagePost(Request $request)
    {
        $image = $request->file;
        $binary = ExifComponent::rotateFromBinary(file_get_contents($image));

        $file = Image::make($binary);

        $width = 800; $height = 800;
        $file->height() > $file->width() ? $width=null : $height=null;
        $file->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        })->stream('jpg', 100);

        $filename = time() . uniqid(rand()) . '.jpg';

        Storage::disk('public')->put('tmp/' . $filename, $file);

        $ret['file_path'] = storage_path('app/public/tmp/' . $filename);
        $ret['file_url'] = asset('storage/tmp/' . $filename);

        return response()->json($ret);

    }

    public function itemFilePost(Request $request)
    {
        $filename = $_FILES['file']['name'];
        $filetype = $_FILES['file']['type'];
        $filesize = $_FILES['file']['size'];

        $tmp_name = $_FILES['file']['tmp_name'];
        // File extension
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $new_filename = time() . uniqid(rand()) . '.' . $extension;


        $tmp_name = $_FILES['file']['tmp_name'];
        $filepath = storage_path('app/public/tmp/' . $new_filename);
        @move_uploaded_file($tmp_name, $filepath);

        $ret['file_path'] = $filepath;
        $ret['file_url'] = asset('storage/tmp/' . $new_filename);
        $ret['file_extension'] = $extension;
        $ret['file_name'] = $filename;
        $ret['file_type'] = $filetype;
        $ret['file_size'] = $filesize;

        return response()->json($ret);
    }

    private function removeImageDirectory($target)
    {

        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK );
            foreach( $files as $file ){
                unlink($file);
            }
            @rmdir( $target );
        } elseif(is_file($target)) {
            @unlink( $target );
        }
    }

    public function itemList()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $user = Auth::user();
        if ($user && $user->role == 'company' && $user->items->count() == 0) {
            return redirect()->route('mypage.item');
        }

        $pageTitle = $user->role == 'company' ? '自社案件一覧' : '応募した案件一覧';
        $title = $user->role == 'company' ? '自社案件一覧' : '応募した案件一覧';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => $pageTitle],
        ];

        $user_id = Auth::user()->id;
        if ($user->role == 'company') {
            $query = Item::where('user_id', $user_id)->with('order_items');
        } else {
            $query = OrderItem::where('user_id', $user_id)->whereHas('item');
        }
        $items = $query->orderBy('created_at', 'desc')->paginate($this->page_num)->appends(request()->except('page'));
        
        return view('mypage.item_mine')->with(compact('title', 'pageTitle', 'breadcrumbs', 'items'));
    }

    public function itemReview($id)
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $user_id = Auth::user()->id;
        $item = Item::find($id);
        if ($item && $item->user_id == $user_id) {
            $pageTitle = $item->title . 'のレビュー一覧';
            $title = mb_strimwidth($item->title, 0, 35, "…") . 'のレビュー一覧';
            $breadcrumbs = [
                ['url' => route('top'), 'text' => 'トップページ'],
                ['url' => route('mypage'), 'text' => 'マイページ'],
                ['url' => route('mypage.item_list'), 'text' => '求人リスト'],
                ['url' => '#', 'text' => $title],
            ];

            $reviews = $item->reviews()->get();
            return view('mypage.item_review')->with(compact('title', 'pageTitle', 'breadcrumbs', 'reviews'));
        } else {
            return redirect()->route('mypage.item_list')->withError('自分の求人のみレビューを見ることができます。');
        }
    }

    public function itemAllDel(Request $request)
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }
        if (!$this->multiSubmitCheck($request)) abort(409);
        $user_id = Auth::user()->id;

        $data = $request->all();
        $ids = isset($data['ids']) ? $data['ids'] : array();
        if (count($ids) > 0) {
            foreach ($ids as $id) {
                $item = Item::find($id);
                if ($item && $item->user_id == $user_id) {
                    ItemTag::where('item_id', $item->id)->delete();
                    ItemImage::where('item_id', $item->id)->delete();

                    $item->delete();

                }
            }
        }

        return redirect()->route('mypage.item_list')->withSuccess('求人を削除しました。');
    }

    public function itemDel($id)
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $user_id = Auth::user()->id;
        $item = Item::find($id);
        if ($item && $item->user_id == $user_id) {
            $item->delete();
            return redirect()->route('mypage.item_list')->withSuccess('求人を削除しました。');
        } else {
            return redirect()->route('mypage.item_list')->withError('自分の求人のみ削除できます。');
        }
    }

    public function cashing()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $pageTitle = '換金申請';
        $title = '換金申請';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => '換金申請'],
        ];

        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $totalMoney = $user->cashingDatas()->where('status', '<>', 1)->sum('money');
        $totalFee = $user->cashingDatas()->where('status', '<>', 1)->sum('fee');

        $minChangeMoney = Config::where('code', 'min_change_money')->first() ? Config::where('code', 'min_change_money')->first()->number : 0;

        return view('mypage.cashing')->with(compact('title', 'pageTitle', 'breadcrumbs', 'totalMoney', 'totalFee', 'minChangeMoney', 'user'));
    }

    public function cashingPost(Request $request)
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        if (!$this->multiSubmitCheck($request)) abort(409);

        $minChangeMoney = Config::where('code', 'min_change_money')->first() ? floor(Config::where('code', 'min_change_money')->first()->number) : 0;
        $maxPossibleMoney = Auth::user()->point;

        $data = $request->except('_token');
        $this->validator_cashing($data, $minChangeMoney, $maxPossibleMoney);

        $request->session()->start();
        $request->session()->put('sessCashing', $data);
        $request->session()->save();

        return redirect(route('mypage.cashing_confirm'));
    }

    public function cashingConfirm()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $pageTitle = '換金申請（確認）';
        $title = '換金申請（確認）';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => '換金申請（確認）'],
        ];

        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $totalMoney = $user->cashingDatas()->where('status', '<>', 1)->sum('money');
        $totalFee = $user->cashingDatas()->where('status', '<>', 1)->sum('fee');

        $minChangeMoney = Config::where('code', 'min_change_money')->first() ? Config::where('code', 'min_change_money')->first()->number : 0;

        $data = session('sessCashing');
        $money = isset($data['money']) ? $data['money'] : 0;
        $cashingRate = Config::where('code', 'cashing_rate')->first() ? Config::where('code', 'cashing_rate')->first()->number : 0;
        $fee = $money * $cashingRate / 100;
        return view('mypage.cashing_confirm')->with(compact('title', 'pageTitle', 'breadcrumbs', 'totalMoney', 'totalFee', 'minChangeMoney', 'money', 'fee', 'user'));
    }

    public function cashingConfirmPost(Request $request)
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }
        if (!$this->multiSubmitCheck($request)) abort(409);

        $data = session('sessCashing');

        if ($user = $this->createCashing($data)) {
            return redirect(route('mypage.cashing_complete'));
        } else {
            return redirect(route('mypage.cashing'));
        }
    }

    public function cashingComplete()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $pageTitle = '換金申請（申請完了）';
        $title = '換金申請（申請完了）';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => '換金申請（申請完了）'],
        ];

        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $totalMoney = $user->cashingDatas()->where('status', '<>', 1)->sum('money');
        $totalFee = $user->cashingDatas()->where('status', '<>', 1)->sum('fee');

        $data = session('sessCashing');
        if (empty($data)) return redirect(route('mypage.cashing'));
        $money = isset($data['money']) ? $data['money'] : 0 ;

        session(['sessCashing' => null]);
        return view('mypage.cashing_complete')->with(compact('title', 'pageTitle', 'breadcrumbs', 'totalMoney', 'totalFee', 'money', 'user'));
    }

    protected function createCashing(array $data)
    {
        $objCashingData = new CashingData();
        $user_id = Auth::user()->id;
        $objCashingData->user_id = $user_id;

        $money = $data['money'];
        $cashingRate = Config::where('code', 'cashing_rate')->first() ? Config::where('code', 'cashing_rate')->first()->number : 0;
        $fee = $money * $cashingRate / 100;
        $objCashingData->money = $money;
        $objCashingData->fee = $fee;

        $user = User::find($user_id);
        $user->point = $user->point - $money;
        $user->save();
        $objCashingData->balance = $user->point;

        $objCashingData->bank_name = $user->bank_name;
        $objCashingData->branch_name = $user->branch_name;
        $objCashingData->branch_code = $user->branch_code;
        $objCashingData->account_no = $user->account_no;
        $objCashingData->deposit_name = $user->deposit_name;

        $objCashingData->save();
        return $objCashingData;
    }

    protected function validator_cashing(array $data, $minVal, $maxVal)
    {
        return Validator::make($data, [
            'money' => 'required|numeric|between:' . $minVal . ',' . $maxVal
        ])->validate();
    }

    public function salesReport()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $pageTitle = '売上レポート';
        $title = '売上レポート';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => '売上レポート'],
        ];

        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $result = $user->sellingOrderItems()->groupBy('order_items.sale_ym')->orderBy('order_items.sale_ym', 'desc')->selectRaw('sum(order_items.total) as total, sum(order_items.sale_fee) as sale_fee, sum(order_items.quantity) as qty, sale_ym')->get();

        return view('mypage.sales_report')->with(compact('title', 'pageTitle', 'breadcrumbs', 'result'));
    }

    public function saleYm($ym)
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $yearMonth = substr($ym, 0, 4) . '年' . substr($ym, 4, 2) . '月';
        $pageTitle = $yearMonth . ' 売上レポート';
        $title = $yearMonth . ' 売上レポート';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => route('mypage.sales_report'), 'text' => '売上レポート'],
            ['url' => '#', 'text' => $pageTitle],
        ];

        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $result = $user->sellingOrderItems()->where('sale_ym', $ym)
            ->groupBy('item_id')->orderBy('order_items.created_at', 'desc')
            ->selectRaw('sum(order_items.total) as total, sum(order_items.sale_fee) as sale_fee,  sum(order_items.quantity) as qty, order_items.item_id, order_items.title as title')->get();
        return view('mypage.sale_ym')->with(compact('title', 'pageTitle', 'breadcrumbs', 'result'));
    }

    public function buyPoint()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $pageTitle = 'ポイント購入';
        $title = 'ポイント購入';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => 'ポイント購入'],
        ];

        $arrPointRateList = config('constants.arrPointRateList');
        $arrPaymentMethod = config('constants.arrPaymentMethod');

        $check_code = $this->getGenesCode();
        $data['check_code'] = $check_code;
        session(['sessBuyPoint' => $data]);

        $identity = config('constants.univapay_application_token');

        return view('mypage.buy_point')->with(compact('title', 'pageTitle','breadcrumbs','arrPointRateList', 'arrPaymentMethod', 'check_code', 'identity'));
    }

    public function buyPointPost(Request $request)
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }
        if (!$this->multiSubmitCheck($request)) abort(409);

        $data = $request->except('_token');
        $point = $data['point'];
        $arrPointRateList = config('constants.arrPointRateList');

        $price = 0;
        foreach ($arrPointRateList as $iPrice => $arrPoint) {
            if ($arrPoint['point'] == $point) {
                $price = $iPrice;
                break;
            }
        }

        $payment_method = $data['payment_method'];

        if ($payment_method == 'bank_transfer') {
            $objOrderPoint = new OrderPoint();
            $objOrderPoint->user_id = Auth::user()->id;
            $objOrderPoint->status = 0;
            $objOrderPoint->payment = 'bank_transfer';
            $objOrderPoint->point = $point;
            $objOrderPoint->save();

            $user = User::find(Auth::user()->id);
            $user->point = $user->point + $point;
            $user->save();

            $options = config('constants.mail')['pointPurchaseBankComplete'];
            $data = ['purchasePoint' => $point, 'paymentAmount' => $price];
            $to = $user->email;

            dispatch(new SendMailJob($to, $options, $data));

            $data = compact('price', 'point');

            session(['sessBuyPointBank' => $data]);
        }
        return redirect()->route('mypage.buy_point_bank');
    }

    public function buyPointBank()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $data = session('sessBuyPointBank');
        if (empty($data)) return redirect()->route('mypage');

        session(['sessBuyPointBank' => null]);

        $pageTitle = '銀行振込申請完了';
        $title = '銀行振込申請完了';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => '銀行振込申請完了'],
        ];

        return view('mypage.buy_point_bank')->with(compact('title', 'pageTitle', 'breadcrumbs', 'data'));
    }

    public function buyPointComplete()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $pageTitle = 'ポイント購入（完了）';
        $title = 'ポイント購入（完了）';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => 'ポイント購入（完了）'],
        ];

        return view('mypage.buy_point_complete')->with(compact('title', 'pageTitle', 'breadcrumbs'));
    }

    public function addPoint()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $data = session('sessBuyPoint');

        $price = $_GET['price'] ? $_GET['price'] : 0;
        $response_id = $_GET['response_id'] ? $_GET['response_id'] : 0;
        $check_code = $_GET['checkcode'] ? $_GET['checkcode'] : '';

        $sess_check_code = isset($data['check_code']) ? $data['check_code'] : '';
        session(['sessBuyPoint' => null]);

        if ($check_code != $sess_check_code) {
            return redirect()->route('mypage.buy_point')->withError('決済処理に失敗しました。入力内容をご確認の上、再度お試しください。');
        }

        $arrPointRateList = config('constants.arrPointRateList');
        $point = isset($arrPointRateList[$price]['point']) ? $arrPointRateList[$price]['point'] : 0;

        $objCreditTransaction = new CreditTransaction();
        $objCreditTransaction->user_id = Auth::user()->id;
        $objCreditTransaction->api_type = 'univapay';
        $objCreditTransaction->token = 'widget';
        $objCreditTransaction->response_id = $response_id;
        $objCreditTransaction->money = $price;
        $objCreditTransaction->test_flag = 1;
        $objCreditTransaction->status = $point && $response_id ? 2 : 3;
        $objCreditTransaction->transaction_time = date('Y-m-d H:i:s');
        $objCreditTransaction->save();

        if ($point && $response_id) {
            $objOrderPoint = new OrderPoint();
            $objOrderPoint->user_id = Auth::user()->id;
            $objOrderPoint->status = 1;
            $objOrderPoint->payment = 'credit_card';
            $objOrderPoint->point = $point;
            $objOrderPoint->save();

            $user = User::find(Auth::user()->id);
            $user->point = $user->point + $point;
            $user->save();

            $options = config('constants.mail')['pointPurchaseComplete'];
            $data = ['purchasePoint' => $point, 'paymentAmount' => $price];
            $to = $user->email;
            dispatch(new SendMailJob($to, $options, $data));

            return redirect()->route('mypage.buy_point_complete');
        } else {
            return redirect()->route('mypage.buy_point')->withError('決済処理に失敗しました。入力内容をご確認の上、再度お試しください。');
        }
    }

    public function purchasedPoint()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $pageTitle = 'ポイント購入履歴';
        $title = 'ポイント購入履歴';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => 'ポイント購入履歴'],
        ];

        $user = User::find(Auth::user()->id);
        $orderPoints = $user->orderPoints()->paginate($this->page_num)->appends(request()->except('page'));

        return view('mypage.purchased_point')->with(compact('title', 'pageTitle', 'breadcrumbs', 'orderPoints'));
    }

    public function purchasedItem()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $pageTitle = '購入済み求人';
        $title = '購入済み求人';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => '購入済み求人'],
        ];
        $user = User::find(Auth::user()->id);
        $orderItems = $user->buyingOrderItems()->paginate($this->page_num)->appends(request()->except('page'));
        return view('mypage.purchased_item')->with(compact('title', 'pageTitle', 'breadcrumbs', 'orderItems'));
    }

    public function favorite()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $type = isset($_GET['type']) ? $_GET['type'] : '';

        $pageTitle = $type == 'item' ? '案件' : '' .  'お気に入り';
        $title = $type == 'item' ? '案件' : '' . 'お気に入り';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => $pageTitle],
        ];

        $user = User::find(Auth::user()->id);
        $favoriteItems = $user->favoriteItems()->paginate($this->page_num)->appends(request()->except('page'));
        $favorites = $this->convertItemsToArray($favoriteItems);
        return view('mypage.favorite')->with(compact('title', 'pageTitle', 'breadcrumbs', 'favorites'));
    }

    public function favoriteDelete($id)
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $user_id = Auth::user()->id;

        Favorite::where('user_id', $user_id)->where('item_id', $id)->delete();
        return redirect()->route('mypage.favorite');
    }

    public function noticeMail()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $pageTitle = 'メール通知設定';
        $title = 'メール通知設定';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => 'メール通知設定'],
        ];

        $user = User::find(Auth::user()->id);
        return view('mypage.notice_mail')->with(compact('title', 'pageTitle', 'breadcrumbs', 'user'));
    }

    public function noticeMailPost(Request $request)
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }
        if (!$this->multiSubmitCheck($request)) abort(409);

        $data = $request->except('_token');
        $user = User::find(Auth::user()->id);
        if (isset($data['notification_to_seller_flag'])) {
            $user->notification_to_seller_flag = $data['notification_to_seller_flag'];
        }

        if (isset($data['purchased_to_seller_flag'])) {
            $user->purchased_to_seller_flag = $data['purchased_to_seller_flag'];
        }
        $user->save();

        return redirect()->route('mypage.notice_mail')->withSuccess('メール通知設定を変更しました');
    }

    public function follow()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $pageTitle = 'フォロー一覧';
        $title = 'フォロー一覧';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => 'フォロー一覧'],
        ];

        $user = User::find(Auth::user()->id);
        $follows = $user->followUsers()->paginate($this->page_num)->appends(request()->except('page'));
        return view('mypage.follow')->with(compact('title','pageTitle', 'breadcrumbs', 'follows'));
    }

    public function followDelete($id)
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $user_id = Auth::user()->id;

        Follower::where('user_id', $user_id)->where('follow_user_id', $id)->delete();
        return redirect()->route('mypage.follow');
    }


    public function follower()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $pageTitle = 'フォロワー一覧';
        $title = 'フォロワー一覧';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => 'フォロワー一覧'],
        ];

        $user = User::find(Auth::user()->id);
        $followers = $user->followerUsers()->paginate($this->page_num)->appends(request()->except('page'));
        return view('mypage.follower')->with(compact('title', 'pageTitle', 'breadcrumbs', 'followers'));
    }

    public function withdrawal()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $pageTitle = '退会する';
        $title = '退会する';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => '退会する'],
        ];
        return view('mypage.withdrawal')->with(compact('title', 'pageTitle', 'breadcrumbs'));
    }

    public function withdrawalPost(Request $request)
    {
//        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }
        if (!$this->multiSubmitCheck($request)) abort(409);
        $user = User::find(Auth::user()->id);
        $user->status = 3;
        $user->save();

        Auth::logout();
        return redirect()->route('mypage');

//        return redirect()->route('mypage.withdrawal_complete');
    }

    public function withdrawalComplete()
    {
        if (Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5) { return redirect()->route('mypage'); }

        $pageTitle = '退会する（確認）';
        $title = '退会する（確認）';
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('mypage'), 'text' => 'マイページ'],
            ['url' => '#', 'text' => '退会する（確認）'],
        ];
        return view('mypage.withdrawal_complete')->with(compact('title', 'pageTitle', 'breadcrumbs'));
    }


    public function contact()
    {
        $title = 'お問い合わせ';
        return view('mypage.contact')->with(compact('title'));
    }

    public function contactPost(Request $request)
    {
        if (!$this->multiSubmitCheck($request)) abort(409);
        $data = $request->except('_token');
        $this->validator_contact($data);

        $auth_user_id = Auth::user() ? Auth::user()->id : 0;
        $contact = new Contact();
        $contact->user_id = $auth_user_id;
        $contact->title = $data['title'];
        $contact->content = $data['content'];
        $contact->save();
        $user = User::find($auth_user_id);

        $options = config('constants.mail')['contactToAdmin'];
        $data = ['name' => $user ? $user->name : '', 'title' => $data['title'], 'content' => $data['content']];
        $to = env('MAIL_FROM_ADDRESS');

        dispatch(new SendMailJob($to, $options, $data));

        if ($user) {
        $options = config('constants.mail')['contactToUser'];
        $data = [];
        $to = $user->email;

            dispatch(new SendMailJob($to, $options, $data));
        }

        return redirect()->route('contact')->withSuccess('お問い合わせしました');

    }

    protected function validator_contact(array $data)
    {
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string'],
        ])->validate();
    }

    public function basicRegister()
    {
        if (Auth::user()->status != 1) { return redirect()->route('mypage'); }

        $title = '新規会員登録';

        $user = Auth::user();
        $categories = get_category_list();
        $prefs = json_decode(File::get(public_path('pref.json')), true);
        $areas = config('constants.arrArea');
        $languages = config('constants.arrLanguage');
        $uploadImageSize = Config::where('code', 'upload_item_image_size')->first() ? ceil(Config::where('code', 'upload_item_image_size')->first()->number) : 0;

        return view('mypage.basic_register')->with(compact('title', 'user', 'categories', 'prefs', 'areas', 'languages', 'uploadImageSize'));
    }

    public function userImagePost(Request $request)
    {
        $image = $request->file;
        $binary = ExifComponent::rotateFromBinary(file_get_contents($image));

        $file = Image::make($binary);

        $width = 800; $height = 800;
        $file->height() > $file->width() ? $width=null : $height=null;
        $file->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        })->stream('jpg', 100);

        $filename = time() . uniqid(rand()) . '.jpg';

        Storage::disk('public')->put('tmp/' . $filename, $file);

        $ret['file_path'] = storage_path('app/public/tmp/' . $filename);
        $ret['file_url'] = asset('storage/tmp/' . $filename);

        return response()->json($ret);
    }

    protected function validator_basic_register(array $data)
    {
        $user = Auth::user();
        // インフルエンサーの場合
        if ($user->role == 'influencer') {
            $rules = [
                'name' => ['required', 'string', 'max:32'],
                'nickname' => ['required', 'string', 'max:32'],
                'gender' => ['required', 'string', 'max:1'],
                'main_category' => ['required', 'string', 'max:100'],
                'birthplace' => ['nullable', 'string', 'max:100'],
                'residence' => ['nullable', 'string', 'max:100'],
                'area' => ['required', 'string', 'max:100'],
                'specialty' => ['nullable', 'string', 'max:1000'],
                'hobby' => ['nullable', 'string', 'max:1000'],
                'qualification' => ['nullable', 'string', 'max:1000'],
                'language' => ['required', 'string', 'max:100'],
                'other_language' => ['nullable', 'string', 'max:100'],
                'comment' => ['nullable', 'string', 'max:1000'],
                'instagram_fan_count' => ['nullable', 'numeric'],
                'tiktok_fan_count' => ['nullable', 'numeric'],
                'x_fan_count' => ['nullable', 'numeric'],
                'youtube_fan_count' => ['nullable', 'numeric'],
                'facebook_fan_count' => ['nullable', 'numeric'],
                'other_fan_count' => ['nullable', 'numeric'],
                'career_url_1' => ['nullable', 'url'],
                'career_1' => ['nullable', 'string', 'max:1000'],
                'career_url_2' => ['nullable', 'url'],
                'career_2' => ['nullable', 'string', 'max:1000'],
                'career_url_3' => ['nullable', 'url'],
                'career_3' => ['nullable', 'string', 'max:1000'],
                'images.0.url' => ['required'],
            ];

            // 「その他」が選択された場合、other_languageを必須にする
            if (isset($data['language']) && $data['language'] === 'その他') {
                $rules['other_language'] = ['required', 'string', 'max:100'];
            }

            // 「海外」が選択された場合、other_areaを必須にする
            if (isset($data['area']) && $data['area'] === '海外') {
                $rules['other_area'] = ['required', 'string', 'max:100'];
            }

            return Validator::make($data, $rules)->validate();
        } else {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:100'],
                'facility_name' => ['required', 'string', 'max:100'],
                'postcode' => ['required', 'string', 'regex:/^\d{7}$/'],
                'pref' => ['required', 'string', 'max:100'],
                'city' => ['required', 'string', 'max:100'],
                'address' => ['nullable', 'string', 'max:100'],
                'main_category' => ['required', 'string', 'max:100'],
                'manager_name' => ['required', 'string', 'max:100'],
                'manager_position' => ['required', 'string', 'max:100'],
                'manager_phone' => ['required', 'string', 'regex:/^0\d{9,10}$/'],
            ])->validate();
        }
    }

    public function basicRegisterPost(Request $request)
    {
        if (!$this->multiSubmitCheck($request)) abort(409);
        $data = $request->except('_token');
        $this->validator_basic_register($data);

        try {
            DB::beginTransaction();

            $user = User::find(Auth::user()->id);
            $data['status'] = 2;
            $user->update($data);

            if (isset($data['images']) && is_array($data['images'])) {
                $old_images = UserImage::where('user_id', $user->id)->get();
    
                $old_paths = [];
                foreach($old_images as $image_id => $old_image) {
                    $old_paths[] = storage_path('app/public/' . $old_image->name);
                }
                UserImage::where('user_id', $user->id)->delete();
    
                $non_empty_image_id = -1;
                foreach ($data['images'] as $image) {
                    $url = $image['url'];
                    $path = $image['path'];
                    if ($url && $path) {
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $filename = time().'_'.$this->getGenesCode(8).'.'.$ext;
    
                        $dir = storage_path('app/public/users/' . $user->id);
                        if (!is_dir($dir)) {
                            umask(0);
                            @mkdir($dir, 0777);
                        }
    
                        $new_path = storage_path('app/public/users/' . $user->id . '/' . $filename);
    
                        if ($path <> $new_path) {
                            @rename($path, $new_path);
                            @unlink($path);
                        }
    
                        $userImage = new UserImage();
                        $userImage->user_id = $user->id;
                        $userImage->name = 'users/' . $user->id . '/' . $filename;
                        $userImage->save();
                    }
                }
    
                foreach ($old_paths as $old_path) {
                    @unlink($old_path);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('mypage.basic_register')->withError('登録に失敗しました。');
        }

        $to = $user->email;
        $options = config('constants.mail')['basicRegisterComplete'];
        $data = ['user' => $user];
        dispatch(new SendMailJob($to, $options, $data));

        return redirect()->route('mypage');
    }

    public function orders($id)
    {
        $pageTitle = '応募一覧';
        $title = '応募一覧';
        $item = Item::find($id);
        $breadcrumbs = [
            ['url' => route('top'), 'text' => 'トップページ'],
            ['url' => route('item.show', ['id' => $id]), 'text' => $item->title],
            ['url' => '#', 'text' => '応募一覧'],
        ];
        $orders = OrderItem::where('item_id', $id)->addSelect([
            'last_message_created_at' => Message::selectRaw('MAX(created_at)')
                ->whereColumn('order_item_id', 'order_items.id')
        ])->orderBy('last_message_created_at', 'desc')->with('lastMessage')->paginate($this->page_num)->appends(request()->except('page'));
        return view('mypage.order')->with(compact('title', 'pageTitle', 'breadcrumbs', 'orders'));
    }

    public function entry(Request $request, $id)
    {
        if (!$this->multiSubmitCheck($request)) abort(409);

        $auth_user = User::find(Auth::user()->id);
        $item = Item::find($id);

        $order = new OrderItem();
        $order->item_id = $id;
        $order->user_id = $auth_user->id;
        $order->to_user_id = $item->user_id;
        $order->started_at = date('Y-m-d H:i:s');
        $order->suggested_at = date('Y-m-d H:i:s');
        $order->matched_at = date('Y-m-d H:i:s');
        $order->save();

        $message = new Message();
        $message->order_item_id = $order->id;
        $message->user_id = $auth_user->id;
        $message->to_user_id = $item->user_id;
        $message->comment = "【{$item->title}】から応募がありました。";
        $message->save();

        return redirect()->route('order.show', ['id' => $order->id]);
    }
}