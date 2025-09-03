<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', isset($data['name']) ? $data['name'] : '') }}" autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name_kana" class="col-md-4 col-form-label text-md-right">{{ __('NameKana') }}</label>

                                <div class="col-md-6">
                                    <input id="name_kana" type="text" class="form-control @error('name_kana') is-invalid @enderror" name="name_kana" value="{{ old('name_kana', isset($data['name_kana']) ? $data['name_kana'] : '') }}" autocomplete="name_kana" autofocus>

                                    @error('name_kana')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="company" class="col-md-4 col-form-label text-md-right">{{ __('Company') }}</label>

                                <div class="col-md-6">
                                    <input id="company" type="text" class="form-control @error('company') is-invalid @enderror" name="company" value="{{ old('company', isset($data['company']) ? $data['company'] : '') }}" autocomplete="company" autofocus>

                                    @error('company')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="postcode" class="col-md-4 col-form-label text-md-right">{{ __('Postcode') }}</label>

                                <div class="col-md-6">
                                    <input id="postcode" type="text" class="form-control @error('postcode') is-invalid @enderror" name="postcode" value="{{ old('postcode', isset($data['postcode']) ? $data['postcode'] : '') }}" autocomplete="postcode" autofocus>

                                    @error('postcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', isset($data['address']) ? $data['address'] : '') }}" autocomplete="address" autofocus>

                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', isset($data['phone']) ? $data['phone'] : '') }}" autocomplete="phone" autofocus>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

                                <div class="col-md-6 pt-2">
                                    <div class="@error('gender') is-invalid @enderror">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male" @if(old('gender', isset($data['gender']) ? $data['gender'] : '') == 'male') checked @endif>
                                            <label class="form-check-label" for="genderMale">
                                                {{ __('Male') }}
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="female" @if(old('gender', isset($data['gender']) ? $data['gender'] : '') == 'female') checked @endif>
                                            <label class="form-check-label" for="genderFemale">
                                                {{ __('Female') }}
                                            </label>
                                        </div>
                                    </div>

                                    @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="birthday" class="col-md-4 col-form-label text-md-right">{{ __('Birthday') }}</label>


                                <div class="col-md-6">
                                    <input type="hidden" id="registerBirthday" value="{{ old('birthday', isset($data['birthday']) ? $data['birthday'] : '') }}" />
                                    <vuejs-datepicker :language="ja" :format="date_format" name="birthday" class="@error('birthday') is-invalid @enderror" :value="registerBirthday"></vuejs-datepicker>

                                    @error('birthday')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nickname" class="col-md-4 col-form-label text-md-right">{{ __('Nickname') }}</label>

                                <div class="col-md-6">
                                    <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname" value="{{ old('nickname', isset($data['nickname']) ? $data['nickname'] : '') }}" autocomplete="nickname" autofocus>

                                    @error('nickname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="comment" class="col-md-4 col-form-label text-md-right">{{ __('ProfileComment') }}</label>

                                <div class="col-md-6">
                                    <textarea rows="3" id="comment" class="form-control @error('comment') is-invalid @enderror" name="comment" autocomplete="comment" autofocus>{{ old('comment', isset($data['comment']) ? $data['comment'] : '') }}</textarea>

                                    @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>



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
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    export default {
        // ...
        components: {
            Datepicker
        }
        // ...
    }
</script>