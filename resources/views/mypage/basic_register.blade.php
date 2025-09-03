@extends('layouts.app')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12 mypage_index_row">
            <form action="{{ route('mypage.basic_register') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="login-title">{{ $title }}</div>

                <div class="card login-card" style="margin-bottom: 4rem;">
                    <div class="card-body" style="padding: 1.5rem;">
                    @if (Auth::user()->role == 'influencer')
                        <input type="hidden" id="images_0_url" name="images[0][url]"
                        value="{{ old('images.0.url', isset($user['images'][0]['url']) ? $user['images'][0]['url'] : '') }}" />
                        <input type="hidden" id="images_0_path" name="images[0][path]"
                            value="{{ old('images.0.path', isset($user['images'][0]['path']) ? $user['images'][0]['path'] : '') }}" />
                        <input type="hidden" id="images_1_url" name="images[1][url]"
                            value="{{ old('images.1.url', isset($user['images'][1]['url']) ? $user['images'][1]['url'] : '') }}" />
                        <input type="hidden" id="images_1_path" name="images[1][path]"
                            value="{{ old('images.1.path', isset($user['images'][1]['path']) ? $user['images'][1]['path'] : '') }}" />
                        <input type="hidden" id="images_2_url" name="images[2][url]"
                            value="{{ old('images.2.url', isset($user['images'][2]['url']) ? $user['images'][2]['url'] : '') }}" />
                        <input type="hidden" id="images_2_path" name="images[2][path]"
                            value="{{ old('images.2.path', isset($user['images'][2]['path']) ? $user['images'][2]['path'] : '') }}" />
                        <input type="hidden" id="images_3_url" name="images[3][url]"
                            value="{{ old('images.3.url', isset($user['images'][3]['url']) ? $user['images'][3]['url'] : '') }}" />
                        <input type="hidden" id="images_3_path" name="images[3][path]"
                            value="{{ old('images.3.path', isset($user['images'][3]['path']) ? $user['images'][3]['path'] : '') }}" />
                        <input type="hidden" id="images_4_url" name="images[4][url]"
                            value="{{ old('images.4.url', isset($user['images'][4]['url']) ? $user['images'][4]['url'] : '') }}" />
                        <input type="hidden" id="images_4_path" name="images[4][path]"
                            value="{{ old('images.4.path', isset($user['images'][4]['path']) ? $user['images'][4]['path'] : '') }}" />

                        <input type="hidden" id="file_name" name="file[name]"
                            value="{{ old('file.name', isset($user['file']['name']) ? $user['file']['name'] : '') }}" />
                        <input type="hidden" id="file_path" name="file[path]"
                            value="{{ old('file.path', isset($user['file']['path']) ? $user['file']['path'] : '') }}" />
                        <input type="hidden" id="file_type" name="file[type]"
                            value="{{ old('file.type', isset($user['file']['type']) ? $user['file']['type'] : '') }}" />
                        <input type="hidden" id="file_extension" name="file[extension]"
                            value="{{ old('file.extension', isset($user['file']['extension']) ? $user['file']['extension'] : '') }}" />
                        <input type="hidden" id="file_size" name="file[size]"
                          value="{{ old('file.size', isset($user['file']['size']) ? $user['file']['size'] : '') }}" />

                        <div class="form-group row mt-4">
                            <label for="" class="col-md-3 col-form-label text-md-right">
                                {{ __('Profile Image') }}<span class="text-danger">（必須）</span>
                            </label>

                            <div class="col-md-9">
                                <image-upload-component type="profile" :max_size="{{ $uploadImageSize }}"></image-upload-component>
                                @error('images.0.url')
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- 氏名 --}}
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right">
                                {{ __('氏名') }}<span class="text-danger">（必須）</span>
                            </label>
                            <div class="col-md-9">
                                <input id="name" type="text"
                                    class="form-control login-input @error('name') is-invalid @enderror"
                                    name="name"
                                    value="{{ old('name', isset($user['name']) ? $user['name'] : '') }}"
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
                            <label for="nickname" class="col-md-3 col-form-label text-md-right">
                                {{ __('Nickname') }}<span class="text-danger">（必須）</span>
                            </label>
                            <div class="col-md-9">
                                <input id="nickname" type="text"
                                    class="form-control login-input @error('nickname') is-invalid @enderror"
                                    name="nickname"
                                    value="{{ old('nickname', isset($user['nickname']) ? $user['nickname'] : '') }}"
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
                            <label class="col-md-3 col-form-label text-md-right">
                                {{ __('Gender') }}<span class="text-danger">（必須）</span>
                            </label>
                            <div class="col-md-9">
                                <div class="form-check form-check-inline">
                                <label class="form-check-label" for="gender_male">
                                    <input class="form-check-input" type="radio" name="gender" id="gender_male" value="1"
                                        {{ old('gender', isset($user['gender']) ? $user['gender'] : '') == '1' ? 'checked' : '' }} >
                                    {{ __('Male') }}
                                </label>
                                </div>
                                <div class="form-check form-check-inline">
                                <label class="form-check-label" for="gender_female">
                                    <input class="form-check-input" type="radio" name="gender" id="gender_female" value="2"
                                        {{ old('gender', isset($user['gender']) ? $user['gender'] : '') == '2' ? 'checked' : '' }} >
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
                            <label for="main_category" class="col-md-3 col-form-label text-md-right">
                                {{ __('Category') }}<span class="text-danger">（必須）</span>
                            </label>
                            <div class="col-md-9">
                                <select name="main_category" id="main_category"
                                    class="form-control login-input @error('main_category') is-invalid @enderror" >
                                    <option value="">選択してください</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category['id'] }}"
                                            {{ old('main_category', isset($user['main_category']) ? $user['main_category'] : '') == $category['id'] ? 'selected' : '' }}>
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
                            <label for="sub_category" class="col-md-3 col-form-label text-md-right">
                                {{ __('Sub Category') }}<span class="text-danger">（必須）</span>
                            </label>
                            <div class="col-md-9">
                                <select name="sub_category" id="sub_category"
                                    class="form-control login-input @error('sub_category') is-invalid @enderror" >
                                    <option value="">選択してください</option>
                                    @php $sub_category = old('main_category', isset($user['main_category']) ? $user['main_category'] : ''); @endphp
                                    @if ($sub_category)
                                        @foreach ($categories[$sub_category]['sub_categories'] as $category)
                                            <option value="{{ $category['id'] }}"
                                                {{ old('sub_category', isset($user['sub_category']) ? $user['sub_category'] : '') == $category['id'] ? 'selected' : '' }}>
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
                            <label for="birthplace" class="col-md-3 col-form-label text-md-right">
                                {{ __('Birthplace') }}
                            </label>
                            <div class="col-md-9">
                                <input type="text" id="birthplace"
                                    class="form-control login-input @error('birthplace') is-invalid @enderror"
                                    name="birthplace"
                                    value="{{ old('birthplace', isset($user['birthplace']) ? $user['birthplace'] : '') }}">
                                @error('birthplace')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- 居住地 --}}
                        <div class="form-group row">
                            <label for="residence" class="col-md-3 col-form-label text-md-right">
                                {{ __('Residence') }}
                            </label>
                            <div class="col-md-9">
                                <input type="text" id="residence"
                                    class="form-control login-input @error('residence') is-invalid @enderror"
                                    name="residence"
                                    value="{{ old('residence', isset($user['residence']) ? $user['residence'] : '') }}">
                                @error('residence')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- 活動エリア --}}
                        <div class="form-group row">
                            <label for="area" class="col-md-3 col-form-label text-md-right">
                                {{ __('Activity Area') }}<span class="text-danger">（必須）</span>
                            </label>
                            <div class="col-md-9">
                                <select name="area" id="area"
                                    class="form-control login-input @error('area') is-invalid @enderror" >
                                    <option value="">選択してください</option>
                                    @foreach ($areas as $key => $area)
                                        <option value="{{ $key }}"
                                            {{ old('area', isset($user['area']) ? $user['area'] : '') == $key ? 'selected' : '' }}>
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
                            <label for="other_area" class="col-md-3 col-form-label text-md-right">
                                海外の活動エリア<span class="text-danger">（必須）</span>
                            </label>
                            <div class="col-md-9">
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
                            <label for="specialty" class="col-md-3 col-form-label text-md-right">
                                {{ __('Specialty') }}
                            </label>
                            <div class="col-md-9">
                                <textarea id="specialty"
                                    rows="5"
                                    maxlength="1000"
                                    class="form-control login-input @error('specialty') is-invalid @enderror"
                                    name="specialty"
                                    >{{ old('specialty', isset($user['specialty']) ? $user['specialty'] : '') }}</textarea>
                                @error('specialty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- 趣味 --}}
                        <div class="form-group row">
                            <label for="hobby" class="col-md-3 col-form-label text-md-right">
                                {{ __('Hobby') }}
                            </label>
                            <div class="col-md-9">
                                <textarea id="hobby"
                                    rows="5"
                                    maxlength="1000"
                                    class="form-control login-input @error('hobby') is-invalid @enderror"
                                    name="hobby"
                                    >{{ old('hobby', isset($user['hobby']) ? $user['hobby'] : '') }}</textarea>
                                @error('hobby')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- 資格 / 免許 --}}
                        <div class="form-group row">
                            <label for="qualification" class="col-md-3 col-form-label text-md-right">
                                {{ __('Qualification') }}
                            </label>
                            <div class="col-md-9">
                                <textarea id="qualification"
                                    rows="5"
                                    maxlength="1000"
                                    class="form-control login-input @error('qualification') is-invalid @enderror"
                                    name="qualification"
                                    >{{ old('qualification', isset($user['qualification']) ? $user['qualification'] : '') }}</textarea>
                                @error('qualification')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- 話せる言語 --}}
                        <div class="form-group row">
                            <label for="language" class="col-md-3 col-form-label text-md-right">
                                {{ __('Languages') }}<span class="text-danger">（必須）</span>
                            </label>
                            <div class="col-md-9">
                                <select name="language" id="language"
                                    class="form-control login-input @error('language') is-invalid @enderror" >
                                    <option value="">選択してください</option>
                                    @foreach ($languages as $key => $language)
                                        <option value="{{ $key }}"
                                            {{ old('language', isset($user['language']) ? $user['language'] : '') == $key ? 'selected' : '' }}>
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
                            <label for="other_language" class="col-md-3 col-form-label text-md-right">
                                その他の言語<span class="text-danger">（必須）</span>
                            </label>
                            <div class="col-md-9">
                                <input type="text" id="other_language" name="other_language"
                                    class="form-control login-input @error('other_language') is-invalid @enderror"
                                    value="{{ old('other_language', isset($user['other_language']) ? $user['other_language'] : '') }}"
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
                            <label for="comment" class="col-md-3 col-form-label text-md-right">
                                {{ __('Overview') }}
                            </label>
                            <div class="col-md-9">
                                <textarea id="comment"
                                    rows="5"
                                    maxlength="1000"
                                    class="form-control login-input @error('comment') is-invalid @enderror"
                                    name="comment"
                                    >{{ old('comment', isset($user['comment']) ? $user['comment'] : '') }}</textarea>
                                @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- 活動SNS --}}
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">
                                {{ __('SNS Group') }}
                            </label>
                        </div>

                        {{-- Instagram --}}
                        @if ($user['instagram_account'])
                        <div class="form-group row">
                            <label for="instagram_fan_count" class="col-md-3 col-form-label text-md-right">
                                Instagram - {{ __('@') }}{{ $user['instagram_account'] }} フォロワー数
                            </label>
                            <div class="col-md-9">
                                <input type="number" id="instagram_fan_count"
                                    class="form-control login-input @error('instagram_fan_count') is-invalid @enderror"
                                    name="instagram_fan_count"
                                    value="{{ old('instagram_fan_count', isset($user['instagram_fan_count']) ? $user['instagram_fan_count'] : '') }}">
                                @error('instagram_fan_count')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        {{-- TikTok --}}
                        @if ($user['tiktok_account'])
                        <div class="form-group row">
                            <label for="tiktok_fan_count" class="col-md-3 col-form-label text-md-right">
                                TikTok - {{ __('@') }}{{ $user['tiktok_account'] }} フォロワー数
                            </label>
                            <div class="col-md-9">
                                <input type="number" id="tiktok_fan_count"
                                    class="form-control login-input @error('tiktok_fan_count') is-invalid @enderror"
                                    name="tiktok_fan_count"
                                    value="{{ old('tiktok_fan_count', isset($user['tiktok_fan_count']) ? $user['tiktok_fan_count'] : '') }}">
                                @error('tiktok_fan_count')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        {{-- X --}}
                        @if ($user['x_account'])
                        <div class="form-group row">
                            <label for="x_fan_count" class="col-md-3 col-form-label text-md-right">
                                X - {{ __('@') }}{{ $user['x_account'] }} フォロワー数
                            </label>
                            <div class="col-md-9">
                                <input type="number" id="x_fan_count"
                                    class="form-control login-input @error('x_fan_count') is-invalid @enderror"
                                    name="x_fan_count"
                                    value="{{ old('x_fan_count', isset($user['x_fan_count']) ? $user['x_fan_count'] : '') }}">
                                @error('x_fan_count')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        {{-- YouTube --}}
                        @if ($user['youtube_account'])
                        <div class="form-group row">
                            <label for="youtube_fan_count" class="col-md-3 col-form-label text-md-right">
                                YouTube - {{ __('@') }}{{ $user['youtube_account'] }} フォロワー数
                            </label>
                            <div class="col-md-9">
                                <input type="number" id="youtube_fan_count"
                                    class="form-control login-input @error('youtube_fan_count') is-invalid @enderror"
                                    name="youtube_fan_count"
                                    value="{{ old('youtube_fan_count', isset($user['youtube_fan_count']) ? $user['youtube_fan_count'] : '') }}">
                                @error('youtube_fan_count')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        {{-- Facebook --}}
                        @if ($user['facebook_account'])
                        <div class="form-group row">
                            <label for="facebook_fan_count" class="col-md-3 col-form-label text-md-right">
                                Facebook - {{ __('@') }}{{ $user['facebook_account'] }} フォロワー数
                            </label>
                            <div class="col-md-9">
                                <input type="number" id="facebook_fan_count"
                                    class="form-control login-input @error('facebook_fan_count') is-invalid @enderror"
                                    name="facebook_fan_count"
                                    value="{{ old('facebook_fan_count', isset($user['facebook_fan_count']) ? $user['facebook_fan_count'] : '') }}">
                                @error('facebook_fan_count')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        {{-- そのほか --}}
                        @if ($user['other_account'])
                        <div class="form-group row">
                            <label for="other_fan_count" class="col-md-3 col-form-label text-md-right">
                                {{ __('Other Account') }} - URL: {{ $user['other_account'] }} フォロワー数
                            </label>
                            <div class="col-md-9">
                                <input type="number" id="other_fan_count"
                                    class="form-control login-input @error('other_fan_count') is-invalid @enderror"
                                    name="other_fan_count"
                                    value="{{ old('other_fan_count', isset($user['other_fan_count']) ? $user['other_fan_count'] : '') }}">
                                @error('other_fan_count')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        {{-- 実績履歴 --}}
                        <div class="form-group row">
                            <label for="other_fan_count" class="col-md-3 col-form-label text-md-right">
                                {{ __('これまでの実績履歴') }}
                            </label>
                        </div>

                        <div class="form-group row">
                            <label for="career_url_1" class="col-md-3 col-form-label text-md-right">
                                {{ __('URL') }}
                            </label>
                            <div class="col-md-9">
                                <input type="url" id="career_url_1"
                                    class="form-control login-input @error('career_url_1') is-invalid @enderror"
                                    name="career_url_1"
                                    value="{{ old('career_url_1', isset($user['career_url_1']) ? $user['career_url_1'] : '') }}">
                                @error('career_url_1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label for="career_1" class="col-md-3 col-form-label text-md-right mt-2">
                                {{ __('実績内容') }}
                            </label>
                            <div class="col-md-9 mt-2">
                                <textarea id="career_1"
                                    rows="5"
                                    maxlength="1000"
                                    class="form-control login-input @error('career_1') is-invalid @enderror"
                                    name="career_1"
                                    >{{ old('career_1', isset($user['career_1']) ? $user['career_1'] : '') }}</textarea>
                                @error('career_1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label for="career_url_2" class="col-md-3 col-form-label text-md-right mt-2">
                                {{ __('URL') }}
                            </label>
                            <div class="col-md-9 mt-2">
                                <input type="url" id="career_url_2"
                                    class="form-control login-input @error('career_url_2') is-invalid @enderror"
                                    name="career_url_2"
                                    value="{{ old('career_url_2', isset($user['career_url_2']) ? $user['career_url_2'] : '') }}">
                                @error('career_url_2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label for="career_2" class="col-md-3 col-form-label text-md-right mt-2">
                                {{ __('実績内容') }}
                            </label>
                            <div class="col-md-9 mt-2">
                                <textarea id="career_2"
                                    rows="5"
                                    maxlength="1000"
                                    class="form-control login-input @error('career_2') is-invalid @enderror"
                                    name="career_2"
                                    >{{ old('career_2', isset($user['career_2']) ? $user['career_2'] : '') }}</textarea>
                                @error('career_2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label for="career_url_3" class="col-md-3 col-form-label text-md-right mt-2">
                                {{ __('URL') }}
                            </label>
                            <div class="col-md-9 mt-2">
                                <input type="url" id="career_url_3"
                                    class="form-control login-input @error('career_url_3') is-invalid @enderror"
                                    name="career_url_3"
                                    value="{{ old('career_url_3', isset($user['career_url_3']) ? $user['career_url_3'] : '') }}">
                                @error('career_url_3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label for="career_3" class="col-md-3 col-form-label text-md-right mt-2">
                                {{ __('実績内容') }}
                            </label>
                            <div class="col-md-9 mt-2">
                                <textarea id="career_3"
                                    rows="5"
                                    maxlength="1000"
                                    class="form-control login-input @error('career_3') is-invalid @enderror"
                                    name="career_3"
                                    >{{ old('career_3', isset($user['career_3']) ? $user['career_3'] : '') }}</textarea>
                                @error('career_3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @elseif (Auth::user()->role == 'company')
                        {{-- 会社名または屋号名 --}}
                        <div class="form-group row">
                        <label for="name" class="col-md-3 col-form-label text-md-right">
                            {{ __('Company') }} <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <input id="name" type="text"
                                class="form-control login-input @error('name') is-invalid @enderror"
                                name="name"
                                value="{{ old('name', isset($profile['name']) ? $profile['name'] : '') }}"
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
                            <label for="facility_name" class="col-md-3 col-form-label text-md-right">
                                {{ __('Facility Name') }} <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <input id="facility_name" type="text"
                                    class="form-control login-input @error('facility_name') is-invalid @enderror"
                                    name="facility_name"
                                    value="{{ old('facility_name', isset($profile['facility_name']) ? $profile['facility_name'] : '') }}"
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
                            <label for="postcode" class="col-md-3 col-form-label text-md-right">
                                {{ __('Postcode') }} <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <input id="postcode" type="text"
                                    class="form-control login-input @error('postcode') is-invalid @enderror"
                                    name="postcode"
                                    value="{{ old('postcode', isset($profile['postcode']) ? $profile['postcode'] : '') }}"
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
                            <label for="pref" class="col-md-3 col-form-label text-md-right">
                                {{ __('Pref') }} <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <select name="pref" id="pref"
                                    class="form-control login-input @error('pref') is-invalid @enderror" >
                                    <option value="">選択してください</option>
                                    @foreach ($prefs as $pref)
                                        <option value="{{ $pref['id'] }}"
                                            {{ old('pref', isset($profile['pref']) ? $profile['pref'] : '') == $pref['id'] ? 'selected' : '' }}>
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
                            <label for="city" class="col-md-3 col-form-label text-md-right">
                                {{ __('市区町村') }} <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <select name="city" id="city"
                                    class="form-control login-input @error('city') is-invalid @enderror" >
                                    <option value="">選択してください</option>
                                    @php $city = old('pref', isset($profile['pref']) ? $profile['pref'] : ''); @endphp
                                    @if ($city)
                                        @foreach ($prefs[$city]['city'] as $city)
                                            <option value="{{ $city['city'] }}"
                                                {{ old('city', isset($profile['city']) ? $profile['city'] : '') == $city['city'] ? 'selected' : '' }}>
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
                            <label for="address" class="col-md-3 col-form-label text-md-right">
                                {{ __('Address') }}
                            </label>
                            <div class="col-md-9">
                                <input type="text" id="address"
                                    class="form-control login-input @error('address') is-invalid @enderror"
                                    name="address"
                                    value="{{ old('address', isset($profile['address']) ? $profile['address'] : '') }}">
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- 業種 --}}
                        <div class="form-group row">
                            <label for="main_category" class="col-md-3 col-form-label text-md-right">
                                {{ __('Company Category') }} <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <select name="main_category" id="main_category"
                                    class="form-control login-input @error('main_category') is-invalid @enderror" >
                                    <option value="">選択してください</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category['id'] }}"
                                            {{ old('main_category', isset($user['main_category']) ? $user['main_category'] : '') == $category['id'] ? 'selected' : '' }}>
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
                            <label for="manager_name" class="col-md-3 col-form-label text-md-right">
                                {{ __('Manager Name') }} <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <input type="text" id="manager_name"
                                    class="form-control login-input @error('manager_name') is-invalid @enderror"
                                    name="manager_name"
                                    value="{{ old('manager_name', isset($profile['manager_name']) ? $profile['manager_name'] : '') }}">
                                @error('manager_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- 担当者役職 --}}
                        <div class="form-group row">
                            <label for="manager_position" class="col-md-3 col-form-label text-md-right">
                                {{ __('Manager Position') }} <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <input type="text" id="manager_position"
                                    class="form-control login-input @error('manager_position') is-invalid @enderror"
                                    name="manager_position"
                                    value="{{ old('manager_position', isset($profile['manager_position']) ? $profile['manager_position'] : '') }}">
                                @error('manager_position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- 担当者電話番号 --}}
                        <div class="form-group row">
                            <label for="manager_phone" class="col-md-3 col-form-label text-md-right">
                                {{ __('Manager Phone') }} <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <input type="text" id="manager_phone"
                                    class="form-control login-input @error('manager_phone') is-invalid @enderror"
                                    name="manager_phone"
                                    value="{{ old('manager_phone', isset($profile['manager_phone']) ? $profile['manager_phone'] : '') }}">
                                @error('manager_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @endif
                        <div class="form-group row mb-0">
                            <div style="margin:auto;">
                                <button type="submit" class="btn btn-primary register-button"
                                    style="min-width: 200px; margin-right: 0.2rem; margin:0.5rem;">
                                    {{ __('登録確認') }}
                                </button>
                            </div>
                        </div>
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
        if ($languageSelect.val() === 'その他') {
            $otherLanguageContainer.show();
        }
        
        // 言語選択の変更イベント
        $languageSelect.on('change', function() {
            if ($(this).val() === 'その他') {
                $otherLanguageContainer.show();
                $otherLanguageInput.focus();
            } else {
                $otherLanguageContainer.hide();
                $otherLanguageInput.val('');
            }
        });

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

    function previewImage(input) {
        var $container = $('#image-preview-container');
        var $fileLabel = $(input).next();
        
        if (input.files && input.files[0]) {
            var file = input.files[0];
            
            // ファイルサイズチェック（2MB）
            if (file.size > 2 * 1024 * 1024) {
                alert('ファイルサイズは2MB以内にしてください。');
                $(input).val('');
                $fileLabel.text('ファイルを選択');
                return;
            }
            
            // ファイルタイプチェック
            if (!['image/jpeg', 'image/png'].includes(file.type)) {
                alert('JPGまたはPNG形式の画像をアップロードしてください。');
                $(input).val('');
                $fileLabel.text('ファイルを選択');
                return;
            }
            
            var reader = new FileReader();
            reader.onload = function(e) {
                // 既存のプレビューを削除
                $container.empty();
                
                // 新しいプレビューを作成
                var $img = $('<img>', {
                    src: e.target.result,
                    class: 'img-thumbnail',
                    css: {
                        maxWidth: '200px',
                        maxHeight: '200px',
                        objectFit: 'cover'
                    },
                    alt: 'プロフィール画像'
                });
                
                $container.append($img);
                $fileLabel.text(file.name);
            }
            reader.readAsDataURL(file);
        } else {
            // ファイルが選択されていない場合
            $container.empty();
            $fileLabel.text('ファイルを選択');
        }
    }
</script>
@endsection