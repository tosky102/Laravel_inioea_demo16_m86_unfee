<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        'rating_text',
        'created_date'
    ];

    public function getRatingTextAttribute()
    {
        $arrRating = config('constants.arrRatingScore');
        return isset($arrRating[$this->rating]) ? $arrRating[$this->rating] : '';
    }

    public function getCreatedDateAttribute()
    {
        return date('Y-m-d H:i:s', strtotime($this->created_at));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
