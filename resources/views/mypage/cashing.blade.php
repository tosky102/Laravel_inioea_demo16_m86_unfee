@extends('layouts.mypage')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12">

            @if(!isset($data['mode']) || (isset($data['mode']) && $data['mode'] == 'main'))
                <div class="card">
                    <div class="card-header">換金申請</div>
                    <div class="card-body">
                        @if($user->point < $minChangeMoney)
                        <div class="alert alert-danger" role="alert">換金申請できません。</div>
                        @endif
                        <form method="POST" action="{{ route('mypage.cashing') }}">
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
                                </div>To Confirm
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('CashingChargingMoney') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ number_format($totalMoney) . '（換金申請手数料：' . number_format($totalFee) .'）' }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="money" class="col-md-4 col-form-label text-md-right">{{ __('CashingRequestMoney') }}</label>

                                <div class="col-md-6">
                                    <input id="money" type="number" class="form-control @error('money') is-invalid @enderror" name="money" value="{{ old('money', isset($data['money']) ? $data['money'] : '') }}" autocomplete="money" autofocus>

                                    @error('money')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    @if($user->has_bank_info)
                                        <button type="submit" class="btn btn-primary" @if($user->point < $minChangeMoney) disabled @endif>
                                            {{ __('To Confirm') }}
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-primary" onclick="alert('振込み先の銀行口座が登録されていません');">
                                            {{ __('To Confirm') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        </div>

    </div>

@endsection
