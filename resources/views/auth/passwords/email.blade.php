@extends('layouts.app')

@section('content')
    <div class="container signup-container">
        <div class="row justify-content-center" style="margin: 0">
            <div class="col-md-8 marginbottom-2rem">

                <div class="login-title">{{ __('Reset Password') }}</div>

                <div class="card login-card">
                    {{-- <div class="card-header">{{ __('Reset Password') }}</div> --}}

                    <div class="card-body login-card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control login-input @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required {{-- autocomplete="email"  --}} autofocus
                                        placeholder="abcde@co.jp">

                                    @error('email')
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
                                        {{ __('Send Password Reset Link') }}
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
