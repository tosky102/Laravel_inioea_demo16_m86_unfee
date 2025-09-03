<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    public function sentUsers()
    {
        return $this->belongsToMany(User::class, 'notification_sents', 'notification_id', 'user_id');
    }
}
