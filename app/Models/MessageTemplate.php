<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    use HasFactory;

    public $timestamps = false;

    public const TEMPLATE_REPLY = 1; // 応募返信定型文
    public const TEMPLATE_REQUEST = 2; // 依頼定型文
    public const TEMPLATE_REJECT = 3; // お見送りの文章
    public const TEMPLATE_EMPLOYMENT_THANK = 4; // 採用お礼定型文
    public const TEMPLATE_VISIT_THANK = 5; // 来店お礼定型文
    public const TEMPLATE_POST_THANK = 6; // 投稿完了定型文
}
