@extends('layouts.app')

@section('content')
    <div class="container signup-container">
        <div class="row justify-content-center" style="margin: 0">

            <div class="col-md-8 marginbottom-2rem">

                <div class="login-title">新規会員登録</div>
                
                <div class="login-other-link">
                    <a href="{{ route('register') }}">{{ __('Register Influencer') }}</a>
                </div>

                <div class="card login-card">

                    {{-- <div class="card-header">{{ __('Register') }}</div> --}}

                    <div class="card-body login-card-body">

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <input type="hidden" name="role" value="company">

                            {{-- <div class="form-group row">
                                <label for="type"
                                    class="col-md-4 col-form-label text-md-right">{{ __('User Type') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control login-input" name="type" id="">
                                        <option value="0">店舗運営者</option>
                                        <option value="1">求職者</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" placeholder="abcde@co.jp"
                                        class="form-control login-input @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email', isset($data['email']) ? $data['email'] : '') }}" autofocus
                                        autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email_confirmation"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Confirm E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email_confirmation" type="email" class="form-control login-input"
                                        placeholder="abcde@co.jp" name="email_confirmation"
                                        value="{{ old('email_confirmation', isset($data['email_confirmation']) ? $data['email_confirmation'] : '') }}"
                                        {{-- autocomplete="email_confirmation" --}}>

                                    @error('email_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control login-input @error('password') is-invalid @enderror"
                                        name="password" autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control login-input"
                                        name="password_confirmation" autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password_hint"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password Hint') }}</label>

                                <div class="col-md-6">
                                    <input id="password_hint" type="text"
                                        class="form-control login-input @error('password_hint') is-invalid @enderror"
                                        name="password_hint"
                                        value="{{ old('password_hint', isset($data['password_hint']) ? $data['password_hint'] : '') }}"
                                        autocomplete="password_hint">

                                    @error('password_hint')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div style="margin: 0.5rem auto;width: 80%;">
                                    <button type="submit" class="btn btn-primary register-button"
                                        style="margin: 0.5rem 0px; width: 100%; padding:1rem;">
                                        {{ __('Confirm Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
