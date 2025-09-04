<?php

namespace App\Http\Controllers;

use App\Models\HtmlPart;
use App\Models\ItemTag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;
use App\Http\Traits\RequestTrait;
use App\Models\Favorite;
use App\Models\Follower;
use App\Models\Item;
use App\Models\ItemImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, RequestTrait;

    public $page_num = 20;
    public $mypage_page_num = 20;
    public $list_page_num = 25;

    public function __construct()
    {
        $arrCategories = config('constants.arrCategory');
        $dspMainCategories = [];
        $dspCategories = [];
        $id = 1;
        foreach ($arrCategories as $k1 => $arrCategory) {
            $dspMainCategories[$k1] = $k1;
            $ret = [];
            $ret['id'] = $id;
            $ret['active'] = $id == 1 ? true : false;
            $ret['title'] = $k1;
            $ret['url'] = route('item') . '?category=' . $k1;

            $details = [];
            foreach ($arrCategory as $k2 => $v2) {
                $details[] = array(
                    'text' => trim(mb_convert_kana($v2, 's', 'UTF-8')),
                    'url' => route('item') . '?category=' . $k2,
                    'value' => $k2
                );
            }
            $ret['details'] = $details;

            $dspCategories[] = $ret;
            $id++;
        }

        $tags = ItemTag::whereHas('Item', function($q) { $q->where('public_flag', 1)->where('deleted_at', null); })->where('deleted_at', null)->groupBy('name')->orderByRaw('COUNT(*) DESC')->limit(10)->get();
//        $tags = ItemTag::where('deleted_at', null)->groupBy('name')->orderByRaw('COUNT(*) DESC')->limit(10)->get();
        $dspKeywords = [];
        foreach ($tags as $tag) {
            $dspKeywords[] = array(
                'text' => mb_strimwidth($tag->name, 0, 15, "…"),
                'title' => mb_strimwidth($tag->name, 0, 15, "…"),
                'url' => route('item') . '?tag=' . $tag->name
            );
        }

        $objHtmlPart = HtmlPart::where('title', 'logo')->first();
        $logoHtml = $objHtmlPart ? $objHtmlPart->desc : '';

        $objHtmlPart = HtmlPart::where('title', 'sns')->first();
        $snsHtml = $objHtmlPart ? $objHtmlPart->desc : '';

        View::share(compact('dspCategories', 'dspMainCategories', 'dspKeywords', 'logoHtml', 'snsHtml'));
    }

    public function convertItemsToArray($items, $mode = '', $start_index = 0)
    {
        $ret = [];
        if (Auth::user()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = 0;
        }
        $prefs = json_decode(File::get(public_path('pref.json')), true);
        foreach ($items as $ind => $item) {
            $iRet = array(
                'id' => $item->id,
                'title' => mb_strimwidth($item->title, 0, 35, "…"),
                'image' => $item->image,
                'user' => $item->user,
                'user_id' => $user_id,
                'is_emergency' => $item->is_emergency,
                'station' => $item->station,
                'entry_follower' => $item->entry_follower,
                'url' => route('item.show', ['id' => $item->id]),
                'user_url' => route('user.show', ['id' => $item->user_id]),
                'order_status' => $item->status_text,
                'newMessageUrl' => Auth::user() ? ($item->user->type != Auth::user()->type ? 
                    route('message.new_message', ['id' => $item->id]) : null) : route('login'),
            );
            if ($item->images()->count() > 0) {
                $iRet['img'] = $item->images()->first()->name ? asset('storage/' . $item->images()->first()->name) : asset('storage/mallento.png');
            } else {
                $iRet['img'] = asset('storage/mallento.png');
            }
            if ($mode == 'new') {
                $iRet['status_text'] = '新着';
                $iRet['status_class'] = 'new-item-status';
            }

            $favoriteItem = Favorite::where('item_id', $item->id)->where('user_id', $user_id)->first();
            if ($favoriteItem) {
                $iRet['favorited'] = true;
            } else {
                $iRet['favorited'] = false;
            }

            if ($mode == 'ranking') {
                $index = $start_index + $ind + 1;
                $iRet['status_text'] = $index;
                if ($index == 1) {
                    $iRet['status_class'] = 'sale-status-first';
                } else if ($index == 2) {
                    $iRet['status_class'] = 'sale-status-second';
                } else if ($index == 3) {
                    $iRet['status_class'] = 'sale-status-third';
                } else {
                    $iRet['status_class'] = 'sale-status-other';
                }
            }
            $ret[] = $iRet;
        }

        return $ret;
    }

    public function convertUsersToArray($users, $mode='', $start_index = 0, $categories)
    {
        $ret = [];
        if (Auth::user()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = 0;
        }
        foreach ($users as $ind => $user) {
            $iRet = array(
                'id' => $user->id,
                'img' => $user->image_url ? $user->image_url : asset('storage/mallento.png'),
                'name' => $user->nickname,
                'area' => $user->area,
                'url' => route('user.show', ['id' => $user->id]),
                'sns' => $user->sns,
                'admin_pickup_category' => $user->admin_pickup_category && isset($categories[$user->admin_pickup_category]) ? $categories[$user->admin_pickup_category]['name'] : '',
                'is_picked' => $user->is_picked,
                'newMessageUrl' => Auth::user() ? route('message.new_message', ['id' => $user->id]) : route('login'),
            );

            $followerUser = Follower::where('user_id', $user_id)->where('follow_user_id', $user->id)->first();
            if ($followerUser) {
                $iRet['followed'] = true;
            } else {
                $iRet['followed'] = false;
            }
            if ($mode == 'ranking') {
                $index = $start_index + $ind + 1;
                $iRet['status_text'] = $index;
                if ($index == 1) {
                    $iRet['status_class'] = 'sale-status-first';
                } else if ($index == 2) {
                    $iRet['status_class'] = 'sale-status-second';
                } else if ($index == 3) {
                    $iRet['status_class'] = 'sale-status-third';
                } else {
                    $iRet['status_class'] = 'sale-status-other';
                }

            }
            $ret[] = $iRet;
        }

        return $ret;
    }

    public function validator_item(array $data)
    {
        $rules = [
            'title' => ['required', 'string', 'max:100'],
            'public_flag' => ['required', 'numeric'],
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
            'images.0.url' => ['required'],
        ];

        // 「その他」が選択された場合、category_otherを必須にする
        if (isset($data['genre']) && $data['genre'] === 'その他') {
            $rules['genre_other'] = ['required', 'string', 'max:100'];
        }

        return Validator::make($data, $rules)->validate();
    }

    public function getGenesCode($nLengthRequired = 8) {
        $sCharList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_";
        mt_srand();
        $sRes = "";
        for($i = 0; $i < $nLengthRequired; $i++){
            $sRes .= $sCharList[mt_rand(0, strlen($sCharList) - 1)];
        }
        return $sRes;
    }

    public function createOrUpdateItem(array $data, $is_vote = false, $related_user_id = null)
    {
        $user_id = Auth::user()->id;
        $id = isset($data['id']) ? $data['id'] : 0;

        $data['user_id'] = $user_id;
        $data['is_emergency'] = $data['is_emergency'] ? 1 : 0;
        
        // 「その他」が選択された場合、category_otherフィールドを保存
        if (isset($data['genre']) && $data['genre'] === 'その他') {
            $data['genre_other'] = $data['genre_other'] ?? '';
        } else {
            $data['genre_other'] = null;
        }
        
        if ($is_vote) {
            $data['expired_at'] = Carbon::now()->addDays(7);
            $data['public_flag'] = 0;
            $data['status'] = 1;
            $data['related_user_id'] = $related_user_id;
        }

        try {
            $item = Item::updateOrCreate(['id' => $id], $data);
            $id = $item->id;
    
            if (isset($data['images']) && is_array($data['images'])) {
                $old_images = ItemImage::where('item_id', $id)->get();
    
                $old_paths = [];
                foreach($old_images as $image_id => $old_image) {
                    $old_paths[] = storage_path('app/public/' . $old_image->name);
                }
                ItemImage::where('item_id', $id)->delete();
    
                $non_empty_image_id = -1;
                foreach ($data['images'] as $image) {
                    $url = $image['url'];
                    $path = $image['path'];
                    if ($url && $path) {
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $filename = time().'_'.$this->getGenesCode(8).'.'.$ext;
    
                        $dir = storage_path('app/public/items/' . $id);
                        if (!is_dir($dir)) {
                            umask(0);
                            @mkdir($dir, 0777);
                        }
    
                        $new_path = storage_path('app/public/items/' . $id . '/' . $filename);
    
                        if ($path <> $new_path) {
                            @rename($path, $new_path);
                            @unlink($path);
                        }
    
                        $itemImage = new ItemImage();
                        $itemImage->item_id = $id;
                        $itemImage->name = 'items/' . $id . '/' . $filename;
                        $itemImage->save();
                    }
                }
    
                foreach ($old_paths as $old_path) {
                    @unlink($old_path);
                }
            }
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return 0;
        }

        return $id;
    }
}
