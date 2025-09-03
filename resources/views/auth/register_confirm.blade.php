@extends('layouts.app')

@section('content')
    <div class="container signup-container">
        <div class="row justify-content-center" style="margin: 0">

            <div class="col-md-8 marginbottom-2rem">

                <div class="login-title">{{ __('Confirm Register') }}</div>

                <div class="card login-card">

                    <div class="card-body login-card-body">
                        <form method="POST" action="{{ route('register_confirm') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ $data['email'] }}
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6 pt-2">
                                    ********
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="password_hint"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password Hint') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ $data['password_hint'] }}
                                </div>
                            </div>

                            @if ($data['role'] == 'influencer')
                            <div class="form-group row">
                                <label for="instagram_account"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Instagram Account') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ $data['instagram_account'] }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tiktok_account"
                                    class="col-md-4 col-form-label text-md-right">{{ __('TikTok Account') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ $data['tiktok_account'] }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="x_account"
                                    class="col-md-4 col-form-label text-md-right">{{ __('X Account') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ $data['x_account'] }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="youtube_account"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Youtube Account') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ $data['youtube_account'] }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="facebook_account"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Facebook Account') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ $data['facebook_account'] }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="other_account"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Other Account') }}</label>

                                <div class="col-md-6 pt-2">
                                    {{ $data['other_account'] }}
                                </div>
                            </div>
                            @endif


                            <div class="form-group row mb-0">
                                <div style="margin: auto;">
                                    <a href="{{ route('register') }}" class="btn btn-secondary outline-button"
                                        style="margin: 0.5rem 0px; width: 100%; padding:10px;">
                                        {{ __('Back') }}
                                    </a>

                                    <button type="submit" class="btn btn-primary register-button"
                                        style="margin: 0.5rem 0px; width: 100%; padding:10px;">
                                        {{ __('Register') }}
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
