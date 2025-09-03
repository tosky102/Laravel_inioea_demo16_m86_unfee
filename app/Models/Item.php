<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'user_id',
        'price',
        'is_offering',
        'category_id',
        'genre',
        'genre_other',
        'description',
        'message',
        'phone',
        'address',
        'post_sns',
        'post_type',
        'hash_tag',
        'pr_account',
        'pr_flow',
        'pr_rule',
        'condition',
        'entry_sns',
        'entry_follower',
        'entry_method',
        'is_emergency',
        'related_user_id',
        'expired_at',
        'public_flag',
        'is_recommended',
        'gender',
        'address1',
        'address2',
        'address3',
        'wage',
        'image',
        'feature',
        'appeal_point',
        'website',
        'youtube',
        'birthday',
        'station',
        'employment',
        'content',
        'business_name',
        'employment2',
        'career',
        'career2',
        'manager_name',
    ];

    protected $appends = [
        'company_name',
        'status_text',
        'main_image_url',
        'file_exist',
        'email',
        'view_count',
        'genre_text'
    ];

    // BelongsTo
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // HasMany
    public function mainImage() {
        return $this->hasMany(ItemImage::class)->first();
    }

    public function images() {
        return $this->hasMany(ItemImage::class)->take(5);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function rooms() {
        return $this->hasMany(Room::class);
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function tags()
    {
        return $this->hasMany(ItemTag::class)->take(5);
    }

//    public function files()
//    {
//        return $this->hasMany(ItemFile::class);
//    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function browses()
    {
        return $this->hasMany(Browse::class);
    }

    // Belongs To Many
    public function browseUsers() {
        return $this->belongsToMany(User::class, 'browses', 'item_id', 'user_id');
    }

    public function favoriteUsers() {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id');
    }

    public function reviewUsers() {
        return $this->belongsToMany(User::class, 'reviews', 'item_id', 'user_id');
    }

    function getCompanyNameAttribute() {
        return $this->user ? $this->user->name : '';
    }

    function getEmailAttribute() {
        return $this->user ? $this->user->email : '';
    }

    public function getGenreTextAttribute()
    {
        if ($this->genre === 'その他') {
            return $this->genre_other;
        } else {
            return $this->genre;
        }
    }

    public function getStatusTextAttribute()
    {
        $arrSelling = config('constants.arrPublicStatus');
        return isset($arrSelling[$this->public_flag]) ? $arrSelling[$this->public_flag] : '';
    }

    public function getMainImageUrlAttribute()
    {
        $file_name = $this->images()->first()? $this->images()->first()->name : '';
        return $file_name ? asset('storage/' . $file_name) : asset('images/users/mallento.png');
    }

    public function getFileExistAttribute()
    {
        $file_path = storage_path('app/public/' . $this->file_name);
        if (is_file($file_path) && file_exists($file_path)) {
            return true;
        } else {
            return false;
        }
    }

    public function getViewCountAttribute()
    {
        return $this->browses()->count();
    }

    public function scopePublic($query)
    {
        $auth_user = Auth::user();
        $query = $query->where('public_flag', 1);
        if ($auth_user) {
            if ($auth_user->role == 'influencer') {
                $query->orWhere('related_user_id', $auth_user->id);
            } else {
                $query->orWhere('user_id', $auth_user->id);
            }
        }
        return $query;
    }

    public static function boot()
    {
        parent::boot();

        // Delete Relationship
        static::deleting(function ($item) {
            foreach ($item->rooms as $room) {
                $room->delete();
            }
            $item->favorites()->delete();
            $item->images()->delete();
            $item->tags()->delete();
            $item->reviews()->delete();
            $item->order_items()->delete();
        });
    }

}
