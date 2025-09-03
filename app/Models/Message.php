<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id', 'id');
    }
}
