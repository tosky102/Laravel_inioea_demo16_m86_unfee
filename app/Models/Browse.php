<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Browse extends Model
{
    use HasFactory, SoftDeletes;

    public function item()
    {
        return $this->belongsTo(Item::class)->where('deleted_at', null);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->where('deleted_at', null);
    }
}
