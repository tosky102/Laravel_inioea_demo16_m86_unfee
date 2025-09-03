@extends('layouts.app')

@section('content')
    <div class="container signup-container">
        <div class="row justify-content-center" style="margin: 0">

            <div class="col-md-8 marginbottom-2rem">

                <div class="login-title">新規会員登録</div>
                
                <div class="login-other-link">
                    <a href="{{ route('register.company') }}">{{ __('Register Company') }}</a>
                </div>

                <div class="card login-card">

                    <div class="card-body login-card-body">

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <input type="hidden" name="role" value="influencer">

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
                                        autocomplete="password_hint" autofocus>

                                    @error('password_hint')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="instagram_account"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Instagram Account') }}</label>

                                <div class="col-md-6">
                                    <input id="instagram_account" type="text"
                                        class="form-control login-input @error('instagram_account') is-invalid @enderror"
                                        name="instagram_account"
                                        value="{{ old('instagram_account', isset($data['instagram_account']) ? $data['instagram_account'] : '') }}"
                                        autocomplete="instagram_account" autofocus>

                                    @error('instagram_account')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tiktok_account"
                                    class="col-md-4 col-form-label text-md-right">{{ __('TikTok Account') }}</label>

                                <div class="col-md-6">
                                    <input id="tiktok_account" type="text"
                                        class="form-control login-input @error('tiktok_account') is-invalid @enderror"
                                        name="tiktok_account"
                                        value="{{ old('tiktok_account', isset($data['tiktok_account']) ? $data['tiktok_account'] : '') }}"
                                        autocomplete="tiktok_account" autofocus>

                                    @error('tiktok_account')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="x_account"
                                    class="col-md-4 col-form-label text-md-right">{{ __('X Account') }}</label>

                                <div class="col-md-6">
                                    <input id="x_account" type="text"
                                        class="form-control login-input @error('x_account') is-invalid @enderror"
                                        name="x_account"
                                        value="{{ old('x_account', isset($data['x_account']) ? $data['x_account'] : '') }}"
                                        autocomplete="x_account" autofocus>

                                    @error('x_account')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="youtube_account"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Youtube Account') }}</label>

                                <div class="col-md-6">
                                    <input id="youtube_account" type="text"
                                        class="form-control login-input @error('youtube_account') is-invalid @enderror"
                                        name="youtube_account"
                                        value="{{ old('youtube_account', isset($data['youtube_account']) ? $data['youtube_account'] : '') }}"
                                        autocomplete="youtube_account" autofocus>

                                    @error('youtube_account')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="facebook_account"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Facebook Account') }}</label>

                                <div class="col-md-6">
                                    <input id="facebook_account" type="text"
                                        class="form-control login-input @error('facebook_account') is-invalid @enderror"
                                        name="facebook_account"
                                        value="{{ old('facebook_account', isset($data['facebook_account']) ? $data['facebook_account'] : '') }}"
                                        autocomplete="facebook_account" autofocus>

                                    @error('facebook_account')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="other_account"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Other Account') }}</label>

                                <div class="col-md-6">
                                    <input id="other_account" type="text"
                                        class="form-control login-input @error('other_account') is-invalid @enderror"
                                        name="other_account"
                                        value="{{ old('other_account', isset($data['other_account']) ? $data['other_account'] : '') }}"
                                        autocomplete="other_account" autofocus>

                                    @error('other_account')
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
