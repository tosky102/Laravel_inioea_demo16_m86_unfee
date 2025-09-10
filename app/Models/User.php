<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyNotification;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, CanResetPasswordContract
{
    use Notifiable, HasApiTokens, HasFactory, Notifiable, SoftDeletes, CanResetPassword;

    protected $guarded = ['mode', 'email_confirmation', 'updated_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
//    protected $fillable = [
//        'name', 'name_kana', 'company', 'postcode', 'address', 'phone', 'gender', 'birthday', 'nickname', 'email', 'password', 'password_hint', 'mailmag_flag', 'comment', 'admin_message',
//        'point', 'image_file_name', 'user_rank', 'role', 'status', 'admin_level', 'sale_count'
//    ];

    public function hasVerifiedEmail()
    {
        return $this->status > 0;
    }


    public function markEmailAsVerified()
    {
        // TODO: Implement markEmailAsVerified() method.
        $this->update([
            'status' => 1,
        ]);
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'level' => 'array',
    ];

    protected $appends = [
        'contact_name',
        'full_name',
        'gender_name',
        'mailmag_flag_text',
        'notification_to_seller_flag_text',
        'purchased_to_seller_flag_text',
        'status_text',
        'image_url',
        'has_bank_info',
        'type_text',
        'sns',
        'main_category_label',
        'pref_label',
        'admin_pickup_category_label',
    ];

    function getTypeTextAttribute() {
        return $this->type == 0 ? 'インフルエンサー' : '企業(宿泊施設)';
    }

    // HasMany
//    public function rooms() {
//        return $this->hasMany(Room::class);
//    }

    public function fromRooms() {
        return $this->hasMany(Room::class, 'from_user_id', 'id');
    }

    public function toRooms() {
        return $this->hasMany(Room::class, 'to_user_id', 'id');
    }

    public function cashingDatas()
    {
        return $this->hasMany(CashingData::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function creditTransactions()
    {
        return $this->hasMany(CreditTransaction::class);
    }

    public function mainCategory()
    {
        return $this->belongsTo(Category::class, 'main_category', 'id');
    }
    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category', 'id');
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'to_user_id', 'id')->orderBy('created_at', 'desc');
    }

    public function sellingReviews()
    {
        return $this->hasManyThrough(Review::class, Item::class, 'user_id', 'item_id', 'id', 'id');
    }

    public function buyingOrderItems()
    {
        return $this->hasMany(OrderItem::class)->orderBy('order_items.created_at', 'desc');
    }

    public function sellingOrderItems()
    {
        return $this->hasManyThrough(OrderItem::class, Item::class, 'user_id', 'item_id', 'id', 'id')->orderBy('order_items.created_at', 'desc');
    }

    public function orderPoints()
    {
        return $this->hasMany(OrderPoint::class)->orderBy('order_points.created_at', 'desc');
    }

    public function sendMessages() {
        return $this->hasMany(Message::class, 'user_id', 'id');
    }

    public function receiveMessages() {
        return $this->hasMany(Message::class, 'to_user_id', 'id');
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function follows() {
        return $this->hasMany(Follower::class);
    }

    public function followers() {
        return $this->hasMany(Follower::class, 'follow_user_id', 'id');
    }

    public function browses() {
        return $this->hasMany(Browse::class);
    }

    public function visits() {
        return $this->hasMany(Visit::class);
    }

    public function visit_users() {
        return $this->hasMany(Visit::class, 'visit_user_id', 'id');
    }

    // Belongs To Many
    public function browseItems() {
        return $this->belongsToMany(Item::class, 'browses', 'user_id', 'item_id');
    }

    public function favoriteItems() {
        return $this->belongsToMany(Item::class, 'favorites', 'user_id', 'item_id')->orderBy('favorites.created_at', 'desc')->whereNull('favorites.deleted_at');
    }

    public function reviewItems() {
        return $this->belongsToMany(Item::class, 'reviews', 'user_id', 'item_id')->whereNull('reviews.deleted_at');
    }

    public function followUsers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follow_user_id')->whereNull('followers.deleted_at')->orderBy('followers.created_at', 'desc');
    }

    public function followerUsers()
    {
        return $this->belongsToMany(User::class, 'followers', 'follow_user_id', 'user_id')->whereNull('followers.deleted_at')->orderBy('followers.created_at', 'desc');
    }

    public function receiveNotifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_sents', 'user_id', 'notification_id');
    }

    public function images()
    {
        return $this->hasMany(UserImage::class);
    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyNotification);
    }

    public function getFullNameAttribute()
    {
        return $this->name . '（' .  $this->name_kana . '）';
    }

    public function getGenderNameAttribute()
    {
        return $this->gender == 'male' ? __('Male') : __('Female');
    }

    public function getMailmagFlagTextAttribute()
    {
        return $this->mailmag_flag == 1 ? __('Mail Magazine Yes') : __('Mail Magazine No');
    }

    public function getNotificationToSellerFlagTextAttribute()
    {
        return $this->notification_to_seller_flag == 1 ? 'ON' : 'OFF';
    }

    public function getPurchasedToSellerFlagTextAttribute()
    {
        return $this->purchased_to_seller_flag == 1 ? 'ON' : 'OFF';
    }

    public function getImageUrlAttribute()
    {
        $images = $this->images;
        if ($images->count() > 0) {
            $file_name = $images->first()->name;
            return $file_name ? asset('storage/' . $file_name) : asset('images/users/mallento.png');
        }
        return asset('images/users/mallento.png');
    }

    public function getStatusTextAttribute()
    {
        if ($this->status == 1) {
            return '有効';
        } elseif ($this->status == 4) {
            return '退会';
        } else {
            return '';
        }
    }

    public function getHasBankInfoAttribute()
    {
        return ($this->bank_name != '') && ($this->branch_name != '') && ($this->branch_code != '') && ($this->account_no != '') && ($this->deposit_name != '');
    }

    public function getSnsAttribute() {
        $sns = [];
        if ($this->instagram_account) {
            $sns[] = [
                'url' => 'https://www.instagram.com/' . $this->instagram_account,
                'icon' => asset('images/sns/sns_instagram.svg'),
                'name' => 'Instagram',
                'account' => $this->instagram_account,
                'followers' => $this->instagram_fan_count,
            ];
        }
        if ($this->tiktok_account) {
            $sns[] = [
                'url' => 'https://www.tiktok.com/@' . $this->tiktok_account,
                'icon' => asset('images/sns/sns_tiktok.svg'),
                'name' => 'TikTok',
                'account' => $this->tiktok_account,
                'followers' => $this->tiktok_fan_count,
            ];
        }
        if ($this->x_account) {
            $sns[] = [
                'url' => 'https://x.com/' . $this->x_account,
                'icon' => asset('images/sns/sns_x.svg'),
                'name' => 'X',
                'account' => $this->x_account,
                'followers' => $this->x_fan_count,
            ];
        }
        if ($this->youtube_account) {
            $sns[] = [
                'url' => 'https://www.youtube.com/' . $this->youtube_account,
                'icon' => asset('images/sns/sns_youtube.svg'),
                'name' => 'YouTube',
                'account' => $this->youtube_account,
                'followers' => $this->youtube_fan_count,
            ];
        }
        if ($this->facebook_account) {
            $sns[] = [
                'url' => 'https://www.facebook.com/' . $this->facebook_account,
                'icon' => asset('images/sns/sns_facebook.svg'),
                'name' => 'Facebook',
                'account' => $this->facebook_account,
                'followers' => $this->facebook_fan_count,
            ];
        }
        if ($this->other_account) {
            $sns[] = [
                'url' => $this->other_account,
                'icon' => asset('images/sns/sns_other.svg'),
                'name' => '他',
                'account' => $this->orther_account,
                'followers' => $this->orther_fan_count,
            ];
        }
        return $sns;
    }

    public function getMainCategoryLabelAttribute()
    {
        $category = Category::find($this->main_category);

        if ($category) return $category->name;
        return '';
    }

    public function getPrefLabelAttribute()
    {
        if (!$this->pref) return '';
        $prefs = json_decode(File::get(public_path('pref.json')), true);
        return $prefs[$this->pref]['name'];
    }

    public function getAdminPickupCategoryLabelAttribute()
    {
        $category = Category::find($this->admin_pickup_category);
        if ($category) return $category->name;
        return '';
    }

    public function getContactNameAttribute()
    {
        if ($this->user_role == 'influencer') {
            return $this->nickname;
        } else {
            return $this->name;
        }
    }

    public static function boot()
    {
        parent::boot();

        // Delete Relationship
        static::deleting(function ($user) {
//            $user->rooms()->delete();
            $user->cashingDatas()->delete();
            $user->creditTransactions()->delete();
            foreach($user->items as $item) {
                $item->delete();
            }
            $user->reviews()->delete();
            $user->buyingOrderItems()->delete();
            $user->orderPoints()->delete();

            $user->fromRooms()->delete();
            $user->toRooms()->delete();
            $user->sendMessages()->delete();
            $user->receiveMessages()->delete();

            $user->contacts()->delete();

            $user->favorites()->delete();

            $user->follows()->delete();
            $user->followers()->delete();

            $user->browses()->delete();
        });
    }

    public function item()
    {
        return $this->hasOne(Item::class);
    }
}
