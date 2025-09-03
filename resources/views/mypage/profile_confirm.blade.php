@extends('layouts.mypage')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12">
            @if(!isset($data['mode']) || (isset($data['mode']) && $data['mode'] == 'email'))
            <div class="card">
                <div class="card-header">メールアドレス変更</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('mypage.profile_confirm') }}">
                        @csrf
                        <input type="hidden" name="mode" value="email" />

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', isset($data['email']) ? $data['email'] : '') }}" autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirm E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email_confirmation" type="email" class="form-control" name="email_confirmation" value="{{ old('email_confirmation', isset($data['email_confirmation']) ? $data['email_confirmation'] : '') }}" autocomplete="email_confirmation">

                                @error('email_confirmation')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            @if(!isset($data['mode']) || (isset($data['mode']) && $data['mode'] == 'password'))
            <div class="card">
                <div class="card-header">パスワード変更</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('mypage.profile_confirm') }}">
                        @csrf
                        <input type="hidden" name="mode" value="password" />

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_hint" class="col-md-4 col-form-label text-md-right">{{ __('Password Hint') }}</label>

                            <div class="col-md-6">
                                <input id="password_hint" type="text" class="form-control @error('password_hint') is-invalid @enderror" name="password_hint" value="{{ old('password_hint', isset($data['password_hint']) ? $data['password_hint'] : '') }}" autocomplete="password_hint" autofocus>

                                @error('password_hint')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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
