@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center" style="margin: 0">
            <div class="col-md-8 marginbottom-2rem">

                <div class="login-title">マイページログイン</div>

                <div class="card login-card" style="margin:0">

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" style="width: 80%; margin: auto;">
                            @csrf
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="email"
                                        class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <input id="email" type="email"
                                        class="form-control login-input @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required {{-- autocomplete="email" --}} autofocus
                                        placeholder="abcde@co.jp">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>

                                    <input id="password" type="password"
                                        class="form-control login-input @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="current-password" placeholder="password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div style="width: 100%;">
                                    <div class="form-check login-check" style="padding: 0; text-align: center;">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div style="text-align: center;">
                                    <button type="submit" class="btn btn-primary register-button"
                                        style="min-width: 200px; margin-right: 0.2rem; margin:0.5rem;">
                                        {{ __('Login') }}
                                    </button>

                                    <a href="{{ route('register_terms') }}" class="btn btn-primary outline-button"
                                        style="min-width: 200px; margin-left: 0.2rem; margin:0.5rem;">
                                        新規会員登録（無料）
                                    </a>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
