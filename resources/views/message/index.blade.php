@extends('layouts.mypage')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12">

            {{-- <div class="login-title" style="padding-top:0;">メッセージ一覧</div> --}}

            <div class="card login-card" style="margin:0; border-radius:0; ">
                <div class="card-header">メッセージ一覧</div>
                <div class="card-body message-table">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            </thead>
                            <tbody>
                                @if (count($orderItems) > 0)
                                    @foreach ($orderItems as $orderItem)
                                        @php
                                            $partner = Auth::user()->role == 'company' ? $orderItem->user : $orderItem->toUser;
                                        @endphp
                                        <tr>
                                            <td style="width: calc(80px + 1.5rem); vertical-align: middle;">
                                                <a href="{{ Auth::user()->role == 'company' ? route('user.show', ['id' => $partner->id]) : route('user.show.partner', ['id' => $partner->id]) }}">
                                                    <img class="mypage-avatar" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;" src="{{ optional($partner)->image_url ?? asset('images/users/mallento.png') }}" />
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('message.show', ['id' => $orderItem->id]) }}">
                                                    <div class="mypage-message-group">
                                                        <div class="mypage-message-content">
                                                            <div class="mypage-message-badge message-badge-{{ $orderItem->status }}">{{ $orderItem->status_text }}</div>
                                                            <div class="mypage-message-header">
                                                                <div class="mypage-store-name">
                                                                    {{ optional($partner->item)->title ?? $partner->nickname }}
                                                                </div>
                                                            </div>
                                                            <div class="mypage-message-text">
                                                                <?php echo nl2br($orderItem->lastMessage ? $orderItem->lastMessage->comment : ''); ?>
                                                            </div>
                                                        </div>
                                                        <div class="mypage-date">
                                                            {{ date('Y-m-d', strtotime($orderItem->lastMessage ? $orderItem->lastMessage->created_at : $orderItem->created_at)) }}
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <th colspan="6" class="text-center">情報がありません。</th>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        {{ $orderItems->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
