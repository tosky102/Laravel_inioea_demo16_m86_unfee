<?php

namespace App\Observers;

use App\Models\Message;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;

class MessageObserver
{
    public function created(Message $message)
    {
        $orderItem = $message->orderItem;
        if ($orderItem->type == OrderItem::TYPE_ITEM && $orderItem->messages()->count() == 1) {
            $orderItem->suggested_at = $message->created_at;
        }
        if ($orderItem->type == OrderItem::TYPE_MESSAGE) {
            $count = $orderItem->messages()->where('user_id', $orderItem->user_id)->count();
            if ($count == 1) {
                $orderItem->suggested_at = $message->created_at;
            }
        }
        $orderItem->save();
    }
}
