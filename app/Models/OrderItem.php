<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE_ITEM = 1;
    const TYPE_MESSAGE = 2;

    const STATUS_VOTED = -2;
    const STATUS_ACCEPTED = -1;
    const STATUS_CONFIRMED = 0;
    const STATUS_REQUESTED = 1;
    const STATUS_SHOPPING = 2;
    const STATUS_POSTED = 3;
    const STATUS_COMPLETED = 4;
    const STATUS_REJECTED = 5;

    // Allow mass assignment of 'status' attribute
    protected $fillable = [
        'status',
        'matched_at',
    ];

    protected $appends = [
        'seller_id',
        'seller_nickname',
        'type_text',
        'status_text',
        'started_at_date',
        'requested_at_date',
        'completed_at_date',
    ];

    protected $casts = [
        'suggested_at' => 'datetime',
        'created_at' => 'datetime',
        'started_at' => 'datetime',
        'requested_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // BelongsTo
    public function item()
    {
        return $this->belongsTo(Item::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function room()
    {
        return $this->hasOne(Room::class);
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->orderBy('created_at', 'desc');
    }

    public function getSellerIdAttribute()
    {
        if ($this->item) {
            return $this->item->user->id;
        } else {
            return $this->to_user_id;
        }
    }

    public function getSellerNicknameAttribute()
    {
        if ($this->item) {
            return $this->item->user->nickname;
        } else {
            return $this->toUser->nickname;
        }
    }

    public function getTypeTextAttribute()
    {
        return $this->type == 1 ? '応募' : '個別メッセージ';
    }

    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case '-3':
                return '相談中';
                break;
            case '-2':
                return '案件起票';
                break;
            case '-1':
                return '応募確認';
                break;
            case '0':
                return '応募';
                break;
            case '1':
                return '依頼';
                break;
            case '2':
                return '来店確認';
                break;
            case '3':
                return '総合評価';
            case '4':
                return '完了';
            case '5':
                return '依頼しない';
            default:
                break;
        }
        return '';
    }

    public function getStartedAtDateAttribute()
    {
        if (!$this->started_at) return '未実施';
        return $this->started_at->format('Y.m.d H:i');
    }
    public function getRequestedAtDateAttribute()
    {
        if (!$this->requested_at) return '未実施';
        return $this->requested_at->format('Y.m.d H:i');
    }
    public function getCompletedAtDateAttribute()
    {
        if (!$this->completed_at) return '未実施';
        return $this->completed_at->format('Y.m.d H:i');
    }
}
