@extends('layouts.app')

@section('content')
    <div class="container signup-container">
        <div class="row justify-content-center" style="margin: 0">
            <div class="col-md-8 marginbottom-2rem">

                <div class="login-title">{{ __('Confirm Password') }}</div>

                <div class="card login-card">
                    {{-- <div class="card-header">{{ __('Confirm Password') }}</div> --}}

                    <div class="card-body login-card-body">
                        {{ __('Please confirm your password before continuing.') }}

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control login-input @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div style="margin:1rem auto 0;">
                                    <button type="submit" class="btn btn-primary register-button"
                                        style="min-width: 200px; margin-left: 0.2rem; margin:0.5rem;">
                                        {{ __('Confirm Password') }}
                                    </button>

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
