<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'visit_user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function visitedUser()
    {
        return $this->belongsTo(User::class, 'visit_user_id');
    }
}
