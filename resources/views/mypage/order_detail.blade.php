@extends('layouts.mypage')

@section('content')
    <?php
    function displayTextWithLinks($s)
    {
        return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
    }
    ?>
    <div class="row mypage_row message-body">
        <div class="col-md-12">

            <h4 class="text-left">
                <a href="{{ route('item.show', $orderItem->item->id) }}" style="text-decoration: none; opacity: 0.7;">{{ $orderItem->item->title }}</a>
            </h4>

            <order-detail
                :order-item="{{ json_encode($orderItem) }}"
                :statuses="{{ json_encode($statuses) }}"
                :user-type="'{{ Auth::user()->role }}'"
                :messages="{{ json_encode($messages) }}"
                :partner="{{ json_encode($partner) }}"
                :user-id="{{ $user_id }}"
                :template="{{ json_encode($template) }}"
                :cancel-template="{{ json_encode($cancelTemplate) }}"
                :arr-rating="{{ json_encode(config('constants.arrRatingScore')) }}"
            ></order-detail>

        </div>

    </div>
@endsection
