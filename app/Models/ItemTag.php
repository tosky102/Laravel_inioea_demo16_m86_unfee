<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemTag extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
