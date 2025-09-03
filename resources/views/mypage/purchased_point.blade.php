@extends('layouts.mypage')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12">

                <div class="card">
                    <div class="card-header">ポイント購入履歴</div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center th-header">{{ __('PurchasedPointDate') }}</th>
                                    <th scope="col" class="text-center th-header">{{ __('PurchasedPointPoint') }}</th>
                                    <th scope="col" class="text-center th-header">{{ __('PurchasedPointMethod') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(count($orderPoints) > 0)
                                    @foreach($orderPoints as $orderPoint)
                                        <tr>
                                            <td>{{ date('Y年m月d日　H:i:s', strtotime($orderPoint->created_at)) }}</td>
                                            <td class="text-center">{{ number_format($orderPoint->point) }}PT</td>
                                            <td class="text-center">
                                                {{ $orderPoint->payment_text }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <th colspan="3" class="text-center">情報がありません。</th>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            {{ $orderPoints->links('vendor.pagination.custom') }}

                        </div>



                    </div>
                </div>

        </div>

    </div>
@endsection
