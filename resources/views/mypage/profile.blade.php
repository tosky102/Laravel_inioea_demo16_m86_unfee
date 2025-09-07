@extends('layouts.mypage')

@section('content')
    <div class="row mypage_row">
        <div class="col-md-12">
            <form method="POST" action="{{ route('mypage.profile') }}">
                @if ($data['role'] == 'company')
                    <div class="card" style="margin:0">
                        <div class="card-header">企業情報</div>

                        <div class="card-body">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">
                                    {{ __('E-Mail Address') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control login-input @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email', isset($data['email']) ? $data['email'] : '') }}"
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
                                    class="col-md-4 col-form-label text-md-right">
                                    {{ __('Confirm E-Mail Address') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="email_confirmation" type="email" class="form-control login-input"
                                        name="email_confirmation"
                                        value="{{ old('email_confirmation', isset($data['email']) ? $data['email'] : '') }}"
                                        autocomplete="email_confirmation">

                                    @error('email_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">
                                    {{ __('Password') }}
                                </label>

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
                                    class="col-md-4 col-form-label text-md-right">
                                    {{ __('Confirm Password') }}
                                </label>

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

                            {{-- 会社名または屋号名 --}}
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Company') }} <span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control login-input @error('name') is-invalid @enderror"
                                        name="name"
                                        value="{{ old('name', isset($data['name']) ? $data['name'] : '') }}"
                                       >
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
        
                            {{-- 施設名 --}}
                            <div class="form-group row">
                                <label for="facility_name" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Facility Name') }} <span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <input id="facility_name" type="text"
                                        class="form-control login-input @error('facility_name') is-invalid @enderror"
                                        name="facility_name"
                                        value="{{ old('facility_name', isset($data['facility_name']) ? $data['facility_name'] : '') }}"
                                       >
                                    @error('facility_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            {{-- 郵便番号 --}}
                            <div class="form-group row">
                                <label for="postcode" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Postcode') }} <span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <input id="postcode" type="text"
                                        class="form-control login-input @error('postcode') is-invalid @enderror"
                                        name="postcode"
                                        value="{{ old('postcode', isset($data['postcode']) ? $data['postcode'] : '') }}"
                                       >
                                    @error('postcode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            {{-- 都道府県 --}}
                            <div class="form-group row">
                                <input type="hidden" id="prefs" value="{{ json_encode($prefs) }}">
                                <label for="pref" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Pref') }} <span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <select name="pref" id="pref"
                                        class="form-control login-input @error('pref') is-invalid @enderror">
                                        <option value="">選択してください</option>
                                        @foreach ($prefs as $pref)
                                            <option value="{{ $pref['id'] }}"
                                                {{ old('pref', isset($data['pref']) ? $data['pref'] : '') == $pref['id'] ? 'selected' : '' }}>
                                                {{ $pref['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('pref')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            {{-- 市区町村 --}}
                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-right">
                                    {{ __('市区町村') }} <span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <select name="city" id="city"
                                        class="form-control login-input @error('city') is-invalid @enderror">
                                        <option value="">選択してください</option>
                                        @php $city = old('pref', isset($data['pref']) ? $data['pref'] : ''); @endphp
                                        @if ($city)
                                            @foreach ($prefs[$city]['city'] as $city)
                                                <option value="{{ $city['city'] }}"
                                                    {{ old('city', isset($data['city']) ? $data['city'] : '') == $city['city'] ? 'selected' : '' }}>
                                                    {{ $city['city'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            {{-- 所在地 --}}
                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Address') }}
                                </label>
                                <div class="col-md-6">
                                    <input type="text" id="address"
                                        class="form-control login-input @error('address') is-invalid @enderror"
                                        name="address"
                                        value="{{ old('address', isset($data['address']) ? $data['address'] : '') }}">
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            {{-- 業種 --}}
                            <div class="form-group row">
                                <label for="main_category" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Company Category') }} <span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <select name="main_category" id="main_category"
                                        class="form-control login-input @error('main_category') is-invalid @enderror">
                                        <option value="">選択してください</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category['id'] }}"
                                                {{ old('main_category', isset($data['main_category']) ? $data['main_category'] : '') == $category['id'] ? 'selected' : '' }}>
                                                {{ $category['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('main_category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            {{-- 担当者名 --}}
                            <div class="form-group row">
                                <label for="manager_name" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Manager Name') }} <span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" id="manager_name"
                                        class="form-control login-input @error('manager_name') is-invalid @enderror"
                                        name="manager_name"
                                        value="{{ old('manager_name', isset($data['manager_name']) ? $data['manager_name'] : '') }}">
                                    @error('manager_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            {{-- 担当者役職 --}}
                            <div class="form-group row">
                                <label for="manager_position" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Manager Position') }} <span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" id="manager_position"
                                        class="form-control login-input @error('manager_position') is-invalid @enderror"
                                        name="manager_position"
                                        value="{{ old('manager_position', isset($data['manager_position']) ? $data['manager_position'] : '') }}">
                                    @error('manager_position')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            {{-- 担当者電話番号 --}}
                            <div class="form-group row">
                                <label for="manager_phone" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Manager Phone') }} <span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" id="manager_phone"
                                        class="form-control login-input @error('manager_phone') is-invalid @enderror"
                                        name="manager_phone"
                                        value="{{ old('manager_phone', isset($data['manager_phone']) ? $data['manager_phone'] : '') }}">
                                    @error('manager_phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-4" style="margin: 0;">
                        <div class="card-header">その他</div>

                        <div class="card-body">
                            <input type="hidden" id="images_0_url" name="images[0][url]"
                            value="{{ old('images.0.url', isset($data['images'][0]['url']) ? $data['images'][0]['url'] : '') }}" />
                            <input type="hidden" id="images_0_path" name="images[0][path]"
                                value="{{ old('images.0.path', isset($data['images'][0]['path']) ? $data['images'][0]['path'] : '') }}" />
                            <input type="hidden" id="images_1_url" name="images[1][url]"
                                value="{{ old('images.1.url', isset($data['images'][1]['url']) ? $data['images'][1]['url'] : '') }}" />
                            <input type="hidden" id="images_1_path" name="images[1][path]"
                                value="{{ old('images.1.path', isset($data['images'][1]['path']) ? $data['images'][1]['path'] : '') }}" />
                            <input type="hidden" id="images_2_url" name="images[2][url]"
                                value="{{ old('images.2.url', isset($data['images'][2]['url']) ? $data['images'][2]['url'] : '') }}" />
                            <input type="hidden" id="images_2_path" name="images[2][path]"
                                value="{{ old('images.2.path', isset($data['images'][2]['path']) ? $data['images'][2]['path'] : '') }}" />
                            <input type="hidden" id="images_3_url" name="images[3][url]"
                                value="{{ old('images.3.url', isset($data['images'][3]['url']) ? $data['images'][3]['url'] : '') }}" />
                            <input type="hidden" id="images_3_path" name="images[3][path]"
                                value="{{ old('images.3.path', isset($data['images'][3]['path']) ? $data['images'][3]['path'] : '') }}" />
                            <input type="hidden" id="images_4_url" name="images[4][url]"
                                value="{{ old('images.4.url', isset($data['images'][4]['url']) ? $data['images'][4]['url'] : '') }}" />
                            <input type="hidden" id="images_4_path" name="images[4][path]"
                                value="{{ old('images.4.path', isset($data['images'][4]['path']) ? $data['images'][4]['path'] : '') }}" />
    
                            <input type="hidden" id="file_name" name="file[name]"
                                value="{{ old('file.name', isset($data['file']['name']) ? $data['file']['name'] : '') }}" />
                            <input type="hidden" id="file_path" name="file[path]"
                                value="{{ old('file.path', isset($data['file']['path']) ? $data['file']['path'] : '') }}" />
                            <input type="hidden" id="file_type" name="file[type]"
                                value="{{ old('file.type', isset($data['file']['type']) ? $data['file']['type'] : '') }}" />
                            <input type="hidden" id="file_extension" name="file[extension]"
                                value="{{ old('file.extension', isset($data['file']['extension']) ? $data['file']['extension'] : '') }}" />
                            <input type="hidden" id="file_size" name="file[size]"
                              value="{{ old('file.size', isset($data['file']['size']) ? $data['file']['size'] : '') }}" />
                        
                            {{-- 従業員数 --}}
                            <div class="form-group row">
                                <label for="employee_count" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Employee Number') }} <span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <select name="employee_count" id="employee_count"
                                        class="form-control login-input @error('employee_count') is-invalid @enderror">
                                        <option value="">選択してください</option>
                                        @foreach ($employeeCounts as $key => $employeeCount)
                                            <option value="{{ $key }}"
                                                {{ old('employee_count', isset($data['employee_count']) ? $data['employee_count'] : '') == $key ? 'selected' : '' }}>
                                                {{ $employeeCount }}</option>
                                        @endforeach
                                    </select>

                                    @error('employee_count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
        
                            {{-- 年商 --}}
                            <div class="form-group row">
                                <label for="earning" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Earning') }} <span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <select name="earning" id="earning"
                                        class="form-control login-input @error('earning') is-invalid @enderror">
                                        <option value="">選択してください</option>
                                        @foreach ($earnings as $key => $earning)
                                            <option value="{{ $key }}"
                                                {{ old('earning', isset($data['earning']) ? $data['earning'] : '') == $key ? 'selected' : '' }}>
                                                {{ $earning }}</option>
                                        @endforeach
                                    </select>

                                    @error('earning')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="images"
                                    class="col-md-4 col-form-label text-md-right">
                                    {{ __('Profile Image') }} <span class="text-danger">（必須）</span>
                                </label>

                                <div class="col-md-6">
                                    <image-upload-component type="profile" :max_-size="{{ $uploadImageSize }}"></image-upload-component>

                                    @error('images.0.url')
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- 自己紹介 --}}
                            <div class="form-group row">
                                <label for="comment" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Profile Comment') }} <span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <textarea id="comment"
                                        class="form-control login-input @error('comment') is-invalid @enderror"
                                        name="comment"
                                        rows="3"
                                       >{{ old('comment', isset($data['comment']) ? $data['comment'] : '') }}</textarea>
                                    @error('comment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            {{-- 経歴・実績 --}}
                            <div class="form-group row">
                                <label for="career" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Career History') }} <span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <textarea name="career" id="career"
                                        class="form-control login-input @error('career') is-invalid @enderror"
                                        rows="3"
                                       >{{ old('career', isset($data['career']) ? $data['career'] : '') }}</textarea>
                                    
                                    @error('career')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- 保有資格 --}}
                            <div class="form-group row">
                                <label for="company_qualification" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Company Qualification') }} <span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" id="company_qualification"
                                        class="form-control login-input @error('company_qualification') is-invalid @enderror"
                                        name="company_qualification"
                                        value="{{ old('company_qualification', isset($data['company_qualification']) ? $data['company_qualification'] : '') }}">
                                    @error('company_qualification')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            {{-- 得意分野 --}}
                            <div class="form-group row">
                                <label for="specialty" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Company Specialty') }} <span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" id="specialty"
                                        class="form-control login-input @error('specialty') is-invalid @enderror"
                                        name="specialty"
                                        value="{{ old('specialty', isset($data['specialty']) ? $data['specialty'] : '') }}">
                                    @error('specialty')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card" style="margin:0">
                        <div class="card-header">インフルエンサー情報</div>

                        <div class="card-body">
                            @csrf

                            <input type="hidden" id="images_0_url" name="images[0][url]"
                                value="{{ old('images.0.url', isset($data['images'][0]['url']) ? $data['images'][0]['url'] : '') }}" />
                            <input type="hidden" id="images_0_path" name="images[0][path]"
                                value="{{ old('images.0.path', isset($data['images'][0]['path']) ? $data['images'][0]['path'] : '') }}" />
                            <input type="hidden" id="images_1_url" name="images[1][url]"
                                value="{{ old('images.1.url', isset($data['images'][1]['url']) ? $data['images'][1]['url'] : '') }}" />
                            <input type="hidden" id="images_1_path" name="images[1][path]"
                                value="{{ old('images.1.path', isset($data['images'][1]['path']) ? $data['images'][1]['path'] : '') }}" />
                            <input type="hidden" id="images_2_url" name="images[2][url]"
                                value="{{ old('images.2.url', isset($data['images'][2]['url']) ? $data['images'][2]['url'] : '') }}" />
                            <input type="hidden" id="images_2_path" name="images[2][path]"
                                value="{{ old('images.2.path', isset($data['images'][2]['path']) ? $data['images'][2]['path'] : '') }}" />
                            <input type="hidden" id="images_3_url" name="images[3][url]"
                                value="{{ old('images.3.url', isset($data['images'][3]['url']) ? $data['images'][3]['url'] : '') }}" />
                            <input type="hidden" id="images_3_path" name="images[3][path]"
                                value="{{ old('images.3.path', isset($data['images'][3]['path']) ? $data['images'][3]['path'] : '') }}" />
                            <input type="hidden" id="images_4_url" name="images[4][url]"
                                value="{{ old('images.4.url', isset($data['images'][4]['url']) ? $data['images'][4]['url'] : '') }}" />
                            <input type="hidden" id="images_4_path" name="images[4][path]"
                                value="{{ old('images.4.path', isset($data['images'][4]['path']) ? $data['images'][4]['path'] : '') }}" />

                            <input type="hidden" id="file_name" name="file[name]"
                                value="{{ old('file.name', isset($data['file']['name']) ? $data['file']['name'] : '') }}" />
                            <input type="hidden" id="file_path" name="file[path]"
                                value="{{ old('file.path', isset($data['file']['path']) ? $data['file']['path'] : '') }}" />
                            <input type="hidden" id="file_type" name="file[type]"
                                value="{{ old('file.type', isset($data['file']['type']) ? $data['file']['type'] : '') }}" />
                            <input type="hidden" id="file_extension" name="file[extension]"
                                value="{{ old('file.extension', isset($data['file']['extension']) ? $data['file']['extension'] : '') }}" />
                            <input type="hidden" id="file_size" name="file[size]"
                            value="{{ old('file.size', isset($data['file']['size']) ? $data['file']['size'] : '') }}" />

                            <div class="form-group row mt-4">
                                <label for="" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Profile Image') }}<span class="text-danger">（必須）</span>
                                </label>

                                <div class="col-md-6">
                                    <image-upload-component type="profile" :max_size="{{ $uploadImageSize }}"></image-upload-component>
                                    @error('images.0.url')
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">
                                    {{ __('E-Mail Address') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control login-input @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email', isset($data['email']) ? $data['email'] : '') }}"
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
                                    class="col-md-4 col-form-label text-md-right">
                                    {{ __('Confirm E-Mail Address') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="email_confirmation" type="email" class="form-control login-input"
                                        name="email_confirmation"
                                        value="{{ old('email_confirmation', isset($data['email']) ? $data['email'] : '') }}"
                                        autocomplete="email_confirmation">

                                    @error('email_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">
                                    {{ __('Password') }}
                                </label>

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
                                    class="col-md-4 col-form-label text-md-right">
                                    {{ __('Confirm Password') }}
                                </label>

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

                            {{-- 氏名 --}}
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">
                                    {{ __('氏名') }}<span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control login-input @error('name') is-invalid @enderror"
                                        name="name"
                                        value="{{ old('name', isset($data['name']) ? $data['name'] : '') }}"
                                       >
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- ニックネーム --}}
                            <div class="form-group row">
                                <label for="nickname" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Influencer Name') }}<span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <input id="nickname" type="text"
                                        class="form-control login-input @error('nickname') is-invalid @enderror"
                                        name="nickname"
                                        value="{{ old('nickname', isset($data['nickname']) ? $data['nickname'] : '') }}"
                                       >
                                    @error('nickname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- 性別 --}}
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">
                                    {{ __('Gender') }}<span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="gender_male">
                                        <input class="form-check-input" type="radio" name="gender" id="gender_male" value="1"
                                            {{ old('gender', isset($data['gender']) ? $data['gender'] : '') == '1' ? 'checked' : '' }}>
                                        {{ __('Male') }}
                                    </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="gender_female">
                                        <input class="form-check-input" type="radio" name="gender" id="gender_female" value="2"
                                            {{ old('gender', isset($data['gender']) ? $data['gender'] : '') == '2' ? 'checked' : '' }}>
                                        {{ __('Female') }}
                                    </label>
                                    </div>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- カテゴリー --}}
                            <div class="form-group row">
                                <input type="hidden" id="categories" value="{{ json_encode($categories) }}">
                                <label for="main_category" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Category') }}<span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <select name="main_category" id="main_category"
                                        class="form-control login-input @error('main_category') is-invalid @enderror">
                                        <option value="">選択してください</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category['id'] }}"
                                                {{ old('main_category', isset($data['main_category']) ? $data['main_category'] : '') == $category['id'] ? 'selected' : '' }}>
                                                {{ $category['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('main_category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- サブカテゴリー --}}
                            {{-- <div class="form-group row">
                                <label for="sub_category" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Sub Category') }}<span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <select name="sub_category" id="sub_category"
                                        class="form-control login-input @error('sub_category') is-invalid @enderror">
                                        <option value="">選択してください</option>
                                        @php $sub_category = old('main_category', isset($data['main_category']) ? $data['main_category'] : ''); @endphp
                                        @if ($sub_category)
                                            @foreach ($categories[$sub_category]['sub_categories'] as $category)
                                                <option value="{{ $category['id'] }}"
                                                    {{ old('sub_category', isset($data['sub_category']) ? $data['sub_category'] : '') == $category['id'] ? 'selected' : '' }}>
                                                    {{ $category['name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('sub_category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}

                            {{-- 出身地 --}}
                            <div class="form-group row">
                                <label for="birthplace" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Birthplace') }}
                                </label>
                                <div class="col-md-6">
                                    <input type="text" id="birthplace"
                                        class="form-control login-input @error('birthplace') is-invalid @enderror"
                                        name="birthplace"
                                        value="{{ old('birthplace', isset($data['birthplace']) ? $data['birthplace'] : '') }}">
                                    @error('birthplace')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- 居住地 --}}
                            <div class="form-group row">
                                <label for="residence" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Residence') }}
                                </label>
                                <div class="col-md-6">
                                    <input type="text" id="residence"
                                        class="form-control login-input @error('residence') is-invalid @enderror"
                                        name="residence"
                                        value="{{ old('residence', isset($data['residence']) ? $data['residence'] : '') }}">
                                    @error('residence')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- 活動エリア --}}
                            <div class="form-group row">
                                <label for="area" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Activity Area') }}<span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <select name="area" id="area"
                                        class="form-control login-input @error('area') is-invalid @enderror">
                                        <option value="">選択してください</option>
                                        @foreach ($areas as $key => $area)
                                            <option value="{{ $key }}"
                                                {{ old('area', isset($data['area']) ? $data['area'] : '') == $key ? 'selected' : '' }}>
                                                {{ $area }}</option>
                                        @endforeach
                                    </select>
                                    @error('area')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- 活動エリアが海外の場合の自由記述 --}}
                            <div class="form-group row" id="other-area-container" style="display: none;">
                                <label for="other_area" class="col-md-4 col-form-label text-md-right">
                                    海外の活動エリア<span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" id="other_area" name="other_area"
                                        class="form-control login-input @error('other_area') is-invalid @enderror"
                                        value="{{ old('other_area', isset($data['other_area']) ? $data['other_area'] : '') }}"
                                        placeholder="海外の活動エリアを入力してください">
                                    @error('other_area')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- 特技 --}}
                            <div class="form-group row">
                                <label for="specialty" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Specialty') }}
                                </label>
                                <div class="col-md-6">
                                    <textarea id="specialty"
                                        rows="5"
                                        maxlength="1000"
                                        class="form-control login-input @error('specialty') is-invalid @enderror"
                                        name="specialty"
                                       >{{ old('specialty', isset($data['specialty']) ? $data['specialty'] : '') }}</textarea>
                                    @error('specialty')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- 趣味 --}}
                            <div class="form-group row">
                                <label for="hobby" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Hobby') }}
                                </label>
                                <div class="col-md-6">
                                    <textarea id="hobby"
                                        rows="5"
                                        maxlength="1000"
                                        class="form-control login-input @error('hobby') is-invalid @enderror"
                                        name="hobby"
                                       >{{ old('hobby', isset($data['hobby']) ? $data['hobby'] : '') }}</textarea>
                                    @error('hobby')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- 資格 / 免許 --}}
                            <div class="form-group row">
                                <label for="qualification" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Qualification') }}
                                </label>
                                <div class="col-md-6">
                                    <textarea id="qualification"
                                        rows="5"
                                        maxlength="1000"
                                        class="form-control login-input @error('qualification') is-invalid @enderror"
                                        name="qualification"
                                       >{{ old('qualification', isset($data['qualification']) ? $data['qualification'] : '') }}</textarea>
                                    @error('qualification')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- 話せる言語 --}}
                            <div class="form-group row">
                                <label for="language" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Languages') }}<span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <select name="language" id="language"
                                        class="form-control login-input @error('language') is-invalid @enderror">
                                        <option value="">選択してください</option>
                                        @foreach ($languages as $key => $language)
                                            <option value="{{ $key }}"
                                                {{ old('language', isset($data['language']) ? $data['language'] : '') == $key ? 'selected' : '' }}>
                                                {{ $language }}</option>
                                        @endforeach
                                    </select>
                                    @error('language')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- その他の言語（自由記述） --}}
                            <div class="form-group row" id="other-language-container" style="display: none;">
                                <label for="other_language" class="col-md-4 col-form-label text-md-right">
                                    その他の言語<span class="text-danger">（必須）</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" id="other_language" name="other_language"
                                        class="form-control login-input @error('other_language') is-invalid @enderror"
                                        value="{{ old('other_language', isset($data['other_language']) ? $data['other_language'] : '') }}"
                                        placeholder="言語名を入力してください">
                                    @error('other_language')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- 自己PR --}}
                            <div class="form-group row">
                                <label for="comment" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Overview') }}
                                </label>
                                <div class="col-md-6">
                                    <textarea id="comment"
                                        rows="5"
                                        maxlength="1000"
                                        class="form-control login-input @error('comment') is-invalid @enderror"
                                        name="comment"
                                       >{{ old('comment', isset($data['comment']) ? $data['comment'] : '') }}</textarea>
                                    @error('comment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- 活動SNS --}}
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">
                                    {{ __('SNS Group') }}
                                </label>
                            </div>

                            {{-- Instagram --}}
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
                                <label for="instagram_fan_count" class="col-md-4 col-form-label text-md-right">
                                    Instagram フォロワー数
                                </label>
                                <div class="col-md-6">
                                    <input type="number" id="instagram_fan_count"
                                        class="form-control login-input @error('instagram_fan_count') is-invalid @enderror"
                                        name="instagram_fan_count"
                                        value="{{ old('instagram_fan_count', isset($data['instagram_fan_count']) ? $data['instagram_fan_count'] : '') }}">
                                    @error('instagram_fan_count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- TikTok --}}
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
                                <label for="tiktok_fan_count" class="col-md-4 col-form-label text-md-right">
                                    TikTok フォロワー数
                                </label>
                                <div class="col-md-6">
                                    <input type="number" id="tiktok_fan_count"
                                        class="form-control login-input @error('tiktok_fan_count') is-invalid @enderror"
                                        name="tiktok_fan_count"
                                        value="{{ old('tiktok_fan_count', isset($data['tiktok_fan_count']) ? $data['tiktok_fan_count'] : '') }}">
                                    @error('tiktok_fan_count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- X --}}
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
                                <label for="x_fan_count" class="col-md-4 col-form-label text-md-right">
                                    X フォロワー数
                                </label>
                                <div class="col-md-6">
                                    <input type="number" id="x_fan_count"
                                        class="form-control login-input @error('x_fan_count') is-invalid @enderror"
                                        name="x_fan_count"
                                        value="{{ old('x_fan_count', isset($data['x_fan_count']) ? $data['x_fan_count'] : '') }}">
                                    @error('x_fan_count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- YouTube --}}
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
                                <label for="youtube_fan_count" class="col-md-4 col-form-label text-md-right">
                                    YouTube フォロワー数
                                </label>
                                <div class="col-md-6">
                                    <input type="number" id="youtube_fan_count"
                                        class="form-control login-input @error('youtube_fan_count') is-invalid @enderror"
                                        name="youtube_fan_count"
                                        value="{{ old('youtube_fan_count', isset($data['youtube_fan_count']) ? $data['youtube_fan_count'] : '') }}">
                                    @error('youtube_fan_count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Facebook --}}
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
                                <label for="facebook_fan_count" class="col-md-4 col-form-label text-md-right">
                                    Facebook フォロワー数
                                </label>
                                <div class="col-md-6">
                                    <input type="number" id="facebook_fan_count"
                                        class="form-control login-input @error('facebook_fan_count') is-invalid @enderror"
                                        name="facebook_fan_count"
                                        value="{{ old('facebook_fan_count', isset($data['facebook_fan_count']) ? $data['facebook_fan_count'] : '') }}">
                                    @error('facebook_fan_count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- そのほか --}}
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
                            <div class="form-group row">
                                <label for="other_fan_count" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Other Account') }}URL フォロワー数
                                </label>
                                <div class="col-md-6">
                                    <input type="number" id="other_fan_count"
                                        class="form-control login-input @error('other_fan_count') is-invalid @enderror"
                                        name="other_fan_count"
                                        value="{{ old('other_fan_count', isset($data['other_fan_count']) ? $data['other_fan_count'] : '') }}">
                                    @error('other_fan_count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- 実績履歴 --}}
                            <div class="form-group row">
                                <label for="other_fan_count" class="col-md-4 col-form-label text-md-right">
                                    {{ __('これまでの実績履歴') }}
                                </label>
                            </div>

                            <div class="form-group row">
                                <label for="career_url_1" class="col-md-4 col-form-label text-md-right">
                                    {{ __('URL') }}
                                </label>
                                <div class="col-md-6">
                                    <input type="url" id="career_url_1"
                                        class="form-control login-input @error('career_url_1') is-invalid @enderror"
                                        name="career_url_1"
                                        value="{{ old('career_url_1', isset($data['career_url_1']) ? $data['career_url_1'] : '') }}">
                                    @error('career_url_1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <label for="career_1" class="col-md-4 col-form-label text-md-right mt-2">
                                    {{ __('実績内容') }}
                                </label>
                                <div class="col-md-6 mt-2">
                                    <textarea id="career_1"
                                        rows="5"
                                        maxlength="1000"
                                        class="form-control login-input @error('career_1') is-invalid @enderror"
                                        name="career_1"
                                       >{{ old('career_1', isset($data['career_1']) ? $data['career_1'] : '') }}</textarea>
                                    @error('career_1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <label for="career_url_2" class="col-md-4 col-form-label text-md-right mt-2">
                                    {{ __('URL') }}
                                </label>
                                <div class="col-md-6 mt-2">
                                    <input type="url" id="career_url_2"
                                        class="form-control login-input @error('career_url_2') is-invalid @enderror"
                                        name="career_url_2"
                                        value="{{ old('career_url_2', isset($data['career_url_2']) ? $data['career_url_2'] : '') }}">
                                    @error('career_url_2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <label for="career_2" class="col-md-4 col-form-label text-md-right mt-2">
                                    {{ __('実績内容') }}
                                </label>
                                <div class="col-md-6 mt-2">
                                    <textarea id="career_2"
                                        rows="5"
                                        maxlength="1000"
                                        class="form-control login-input @error('career_2') is-invalid @enderror"
                                        name="career_2"
                                       >{{ old('career_2', isset($data['career_2']) ? $data['career_2'] : '') }}</textarea>
                                    @error('career_2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <label for="career_url_3" class="col-md-4 col-form-label text-md-right mt-2">
                                    {{ __('URL') }}
                                </label>
                                <div class="col-md-6 mt-2">
                                    <input type="url" id="career_url_3"
                                        class="form-control login-input @error('career_url_3') is-invalid @enderror"
                                        name="career_url_3"
                                        value="{{ old('career_url_3', isset($data['career_url_3']) ? $data['career_url_3'] : '') }}">
                                    @error('career_url_3')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <label for="career_3" class="col-md-4 col-form-label text-md-right mt-2">
                                    {{ __('実績内容') }}
                                </label>
                                <div class="col-md-6 mt-2">
                                    <textarea id="career_3"
                                        rows="5"
                                        maxlength="1000"
                                        class="form-control login-input @error('career_3') is-invalid @enderror"
                                        name="career_3"
                                       >{{ old('career_3', isset($data['career_3']) ? $data['career_3'] : '') }}</textarea>
                                    @error('career_3')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="form-group row mb-0">
                    <div style="margin:1rem auto 0;">
                        <button type="submit" class="btn btn-primary register-button"
                            style="min-width: 200px; margin-left: 0.2rem; margin:0.5rem; ">
                            {{ __('To Confirm') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // 言語選択の制御
        var $languageSelect = $('#language');
        var $otherLanguageContainer = $('#other-language-container');
        var $otherLanguageInput = $('#other_language');
        
        // 初期状態で「その他」が選択されている場合の処理
        if ($languageSelect.length && $languageSelect.val() === 'その他') {
            $otherLanguageContainer.show();
        }
        
        // 言語選択の変更イベント
        if ($languageSelect.length) {
            $languageSelect.on('change', function() {
                if ($(this).val() === 'その他') {
                    $otherLanguageContainer.show();
                    $otherLanguageInput.focus();
                } else {
                    $otherLanguageContainer.hide();
                    $otherLanguageInput.val('');
                }
            });
        }

        // 活動エリアの制御
        var $areaSelect = $('#area');
        var $otherAreaContainer = $('#other-area-container');
        var $otherAreaInput = $('#other_area');

        // 初期状態で「海外」が選択されている場合の処理
        if ($areaSelect.length && $areaSelect.val() === '海外') {
            $otherAreaContainer.show();
        }

        // 活動エリアの変更イベント
        if ($areaSelect.length) {
            $areaSelect.on('change', function() {
                if ($(this).val() === '海外') {
                    $otherAreaContainer.show();
                    $otherAreaInput.focus();
                } else {
                    $otherAreaContainer.hide();
                    $otherAreaInput.val('');
                }
            });
        }
    });
</script>
@endsection
