@extends('layouts.mypage')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12">

            @if(!isset($data['mode']) || (isset($data['mode']) && $data['mode'] == 'main'))
                <div class="card">
                    <div class="card-header">換金申請（申請完了）</div>
                    <div class="card-body">

                            <div class="alert alert-info" role="alert">換金申請が完了いたしました。支払について後日ご連絡が行きますので少々お待ちください。</div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('CashingPoint') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ number_format($user->point) . 'PT' }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('CashingRequestMoney') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ number_format($money) }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('CashingChargingMoney') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ number_format($totalMoney) . '（換金申請手数料：' . number_format($totalFee) .'）' }}
                                </div>
                            </div>

                    </div>
                </div>
            @endif

        </div>

    </div>

@endsection
