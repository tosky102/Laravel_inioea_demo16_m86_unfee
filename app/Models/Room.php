<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'item_id',
        'from_user_id',
        'to_user_id',
        'suggested_at',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'desc');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id', 'id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id', 'id');
    }

    public function orderItem()
    {
        return $this->hasOne(OrderItem::class);
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->orderBy('created_at', 'desc');
    }

    public static function boot()
    {
        parent::boot();

        // Delete Relationship
        static::deleting(function ($room) {
            $room->messages()->delete();
        });
    }
}
