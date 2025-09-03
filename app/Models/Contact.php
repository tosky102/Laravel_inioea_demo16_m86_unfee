<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;


    protected $appends = [
        'user_nickname'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUserNicknameAttribute()
    {
        if ($this->user) {
            return $this->user->nickname;
        } else {
            return '匿名';
        }


    }
}
