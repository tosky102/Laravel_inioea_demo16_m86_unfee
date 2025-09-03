@extends('layouts.mypage')

@section('content')
    <div class="row mypage_row">
        <div class="col-md-12">
            <div>
                <table class="table">
                    <thead></thead>
                    <tbody>
                        <div class="favorite-list-container">
                            @if (count($items) > 0)
                                @foreach ($items as $item)
                                    <div class="job-card">
                                        <div class="job-image">
                                            <a href="{{ route('item.show', ['id' => Auth::user()->role == 'company' ? $item->id : $item->item_id]) }}">
                                                <img src="{{ Auth::user()->role == 'company' ? $item->main_image_url : $item->item->main_image_url }}" />
                                            </a>
                                        </div>
                                        <div class="job-content">
                                            <a href="{{ route('item.show', ['id' => Auth::user()->role == 'company' ? $item->id : $item->item_id]) }}"
                                                style="text-decoration: none;">
                                                <div class="job-title">{{ Auth::user()->role == 'company' ? $item->title : $item->item->title }}</div>
                                            </a>
                                            <div class="job-buttons">
                                                @if (Auth::user()->role == 'company')
                                                <a class="job-button job-button-edit" href="{{ route('mypage.item', ['id' => $item->id]) }}">編集</a>
                                                    @if ($item->public_flag == 1)
                                                    <a class="job-button job-button-entry" href="{{ route('mypage.item.orders', ['id' => $item->id]) }}">応募一覧</a>
                                                    @elseif ($item->order_items()->first())
                                                    <a class="job-button job-button-entry" href="{{ route('message.show', ['id' => $item->order_items()->first()->id]) }}">メッセージ</a>
                                                    @endif
                                                @else
                                                <a class="job-button job-button-entry" href="{{ route('order.show', ['id' => $item->id]) }}">メッセージ</a>
                                                @endif
                                            </div>
                                        </div>
                                        @if (Auth::user()->role == 'company')
                                        <span class="job-status job-status-{{ $item->public_flag }}">
                                            {{ $item->status_text }}
                                        </span>
                                        @else
                                        <span class="job-status job-status-{{ $item->item->public_flag }}">
                                            {{ $item->status_text }}
                                        </span>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center mx-auto">
                                    情報がありません。
                                </div>
                            @endif
                        </div>
                    </tbody>
                </table>

                {{ $items->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
@endsection
