@extends('layouts.mypage')

@section('content')
    <div class="row mypage_row">
        <div class="col-md-12">

            @if (!isset($data['mode']) || (isset($data['mode']) && $data['mode'] == 'main'))
                <div class="login-title" style="padding-top:0;">メール通知設定</div>

                <div class="card login-card" style="margin:0;">

                    {{-- <div class="card-header">メール通知設定</div> --}}
                    <div class="card-body">
                        <form method="POST" action="{{ route('mypage.notice_mail') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="notification_to_seller_flag"
                                    class="col-md-6 col-form-label text-md-right">{{ __('noticeMailFavorite') }}</label>

                                <div class="col-md-6 pt-2">
                                    <div class="@error('notification_to_seller_flag') is-invalid @enderror">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                name="notification_to_seller_flag" id="notificationToSellerFlagYes"
                                                value="1" @if (old('notification_to_seller_flag', $user->notification_to_seller_flag) == 1) checked @endif>
                                            <label class="form-check-label" for="notificationToSellerFlagYes">
                                                ON
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                name="notification_to_seller_flag" id="notificationToSellerFlagNo"
                                                value="0" @if (old('notification_to_seller_flag', $user->notification_to_seller_flag) == 0) checked @endif>
                                            <label class="form-check-label" for="notificationToSellerFlagNo">
                                                OFF
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="purchased_to_seller_flag"
                                    class="col-md-6 col-form-label text-md-right">{{ __('noticeMailPurchase') }}</label>

                                <div class="col-md-6 pt-2">
                                    <div class="@error('purchased_to_seller_flag') is-invalid @enderror">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="purchased_to_seller_flag"
                                                id="purchasedToSellerFlagYes" value="1"
                                                @if (old('purchased_to_seller_flag', $user->purchased_to_seller_flag) == 1) checked @endif>
                                            <label class="form-check-label" for="purchasedToSellerFlagYes">
                                                ON
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="purchased_to_seller_flag"
                                                id="purchasedToSellerFlagNo" value="0"
                                                @if (old('purchased_to_seller_flag', $user->purchased_to_seller_flag) == 0) checked @endif>
                                            <label class="form-check-label" for="purchasedToSellerFlagNo">
                                                OFF
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary register-button"
                                        style="min-width: 200px; margin-right: 0.2rem; margin:0.5rem;">
                                        {{ __('noticeMailButton') }}
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
