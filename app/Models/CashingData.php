<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashingData extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        'status_text',
        'created_datetime',
        'transfer_money'
    ];

    public function getStatusTextAttribute()
    {
        $arrCashingStatus = config('constants.arrCashingStatus');
        return isset($arrCashingStatus[$this->status]) ? $arrCashingStatus[$this->status] : '';
    }

    public function getCreatedDatetimeAttribute()
    {
        return date('Y-m-d H:i:s', strtotime($this->created_at));
    }

    public function getTransferMoneyAttribute()
    {
        return $this->money - $this->fee;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
