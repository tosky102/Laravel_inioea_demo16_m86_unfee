@extends('layouts.mypage')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12">

            @if(!isset($data['mode']) || (isset($data['mode']) && $data['mode'] == 'main'))
                <div class="card">
                    <div class="card-header">換金申請（確認）</div>
                    <div class="card-body">
                        @if($user->point < $minChangeMoney)
                        <div class="alert alert-danger" role="alert">換金申請できません。</div>
                        @endif
                        <form method="POST" action="{{ route('mypage.cashing_confirm') }}">
                            @csrf

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('CashingPoint') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ number_format($user->point) . 'PT' }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('CashingMinChangeMoney') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ number_format($minChangeMoney) }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('CashingChargingMoney') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ number_format($totalMoney) . '（換金申請手数料：' . number_format($totalFee) .'）' }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('CashingConfirmMoney') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ number_format($money) }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('CashingConfirmFee') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ number_format($fee) }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Bank Name') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ $user->bank_name }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Branch Name') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ $user->branch_name }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Branch Code') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ $user->branch_code }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Account No') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ $user->account_no }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Deposit Name') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ $user->deposit_name }}
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('CashingConfirmButton') }}
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
