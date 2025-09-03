<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function getImageUrlAttribute()
    {
        $file_name = $this->name;
        return $file_name ? asset('storage/' . $file_name) : asset('images/users/mallento.png');
    }
}
