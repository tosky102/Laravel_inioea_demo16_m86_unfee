@extends('layouts.mypage')

@section('content')
    <div class="row mypage_row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $title }}</div>
                <div class="card-body">
                    <div class="table-responsive message-table">
                        <table class="table mypage-table order-table">
                            <tbody>
                                @if(count($orders) > 0)
                                @foreach($orders as $order)
                                <tr>
                                    <td style="width: calc(80px + 1.5rem); vertical-align: middle;">
                                        <a href="{{ route('user.show', ['id' => $order->user_id]) }}">
                                            <img src="{{ $order->user->image_url }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;" /></td>
                                        </a>
                                    <td>
                                        <a href="{{ $order->type == 1 ? route('order.show', ['id' => $order->id]) : route('message.show', ['id' => $order->id]) }}">
                                            <div class="order-status order-status-{{ $order->type }}">{{ $order->type_text }}</div>
                                            <h4 class="order-nickname">{{ $order->user->nickname }}</h4>
                                            <p class="order-message">{{ $order->lastMessage->comment }}</p>
                                        </a>
                                    </td>
                                    <td style="width: 110px; vertical-align: middle;">{{ $order->created_at->format('Y-m-d') }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <th colspan="9" class="text-center">情報がありません。</th>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                        {{ $orders->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
