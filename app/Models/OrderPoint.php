<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPoint extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        'status_text',
        'payment_text',
        'created_at_date',

    ];

    public function getStatusTextAttribute()
    {
        $arrPaymentStatus = config('constants.arrPaymentStatus');
        return isset($arrPaymentStatus[$this->status]) ? $arrPaymentStatus[$this->status] : '';
    }

    public function getPaymentTextAttribute()
    {
        $arrPaymentMethod = config('constants.arrPaymentMethod');
        return isset($arrPaymentMethod[$this->payment]) ? $arrPaymentMethod[$this->payment] : '';
    }

    public function getCreatedAtDateAttribute()
    {
        return date('Y-m-d H:i:s', strtotime($this->created_at));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
