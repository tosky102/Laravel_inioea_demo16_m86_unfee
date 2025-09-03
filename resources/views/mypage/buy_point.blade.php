@extends('layouts.mypage')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12 mypage_index_row">

            @if(!isset($data['mode']) || (isset($data['mode']) && $data['mode'] == 'main'))
                <div class="card">
                    <div class="card-header">ポイント購入</div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('mypage.buy_point') }}" id="buyPointForm">
                            @csrf
                            <input type="hidden" id="check_code" value="{{ $check_code }}" />
                            <input type="hidden" id="app_id" value="{{ $identity }}" />

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center th-header">{{ __('BuyPointPrice') }}</th>
                                        <th scope="col" class="text-center th-header">{{ __('BuyPointPoint') }}</th>
                                        <th scope="col" class="text-center th-header"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($arrPointRateList as $price => $row)
                                            <tr>
                                                <th scope="row" class="text-center">{{ number_format($price) }}</th>
                                                <td class="text-center">{{ $row['text'] }}</td>
                                                <td class="text-center">
                                                    <input type="radio" name="point" value="{{ $row['point'] }}" class="point_selector" data-price="{{ $price }}"/>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive mt-4">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center th-header">{{ __('BuyPointPaymentMethod') }}</th>
                                        <th scope="col" class="text-center th-header"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($arrPaymentMethod as $key => $val)
                                        <tr>
                                            <th scope="row" class="text-center">{{ $val }}</th>
                                            <td class="text-center">
                                                <input type="radio" name="payment_method" value="{{ $key }}" class="payment_selector" />
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-primary" onclick="openWidgetOrGoBank()">
                                        {{ __('BuyPointButton') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        </div>

    </div>
@endsection
