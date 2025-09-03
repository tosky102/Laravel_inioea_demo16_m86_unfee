<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Follower extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'follow_user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function followUser()
    {
        return $this->belongsTo(User::class, 'follow_user_id', 'id');
    }
}
