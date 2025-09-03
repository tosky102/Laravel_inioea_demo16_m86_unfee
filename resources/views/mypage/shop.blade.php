@extends('layouts.mypage')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12 mypage_index_row">

            @if (!isset($data['mode']) || (isset($data['mode']) && $data['mode'] == 'main'))
                <form method="POST" action="{{ route('mypage.item') }}">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf

                    <div class="login-title">店舗情報</div>

                    <div class="card login-card">
                        {{-- <div class="card-header">個人情報</div> --}}
                        <div class="card-body" style="padding: 1.5rem;">

                            <input type="hidden" name="id" value="{{ $id }}" />

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

                            {{-- <div class="form-group row">
                                <label for="status"
                                    class="col-md-3 col-form-label text-md-right">{{ __('ItemStatus') }}</label>

                                <div class="col-md-9">
                                    <select id="status" class="form-control login-input @error('status') is-invalid @enderror"
                                        name="status" autocomplete="status" autofocus>
                                        @foreach ($arrSelling as $status => $text)
                                            <option value="{{ $status }}"
                                                @if (old('status', isset($data['status']) ? $data['status'] : -1) == $status) selected @endif>{{ $text }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label for="title"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Shop Title') }}</label>

                                <div class="col-md-9">
                                    <input id="title" type="text"
                                        class="form-control login-input @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title', isset($data['title']) ? $data['title'] : '') }}"
                                        autocomplete="title" autofocus>

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="business_name"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Shop Business Name') }}</label>

                                <div class="col-md-9">
                                    <input id="business_name" type="text"
                                        class="form-control login-input @error('business_name') is-invalid @enderror"
                                        name="business_name"
                                        value="{{ old('business_name', isset($data['business_name']) ? $data['business_name'] : '') }}"
                                        autocomplete="business_name" autofocus>

                                    @error('business_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="business_address"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Shop Business Address') }}</label>

                                <div class="col-md-9">
                                    <input type="text" id="business_address"
                                        value="{{ old('business_address', isset($data['business_address']) ? $data['business_address'] : '') }}"
                                        class="form-control login-input @error('business_address') is-invalid @enderror"
                                        name="business_address" autocomplete="business_address" autofocus />


                                    @error('business_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone"
                                    class="col-md-3 col-form-label text-md-right">{{ __('User Phone') }}</label>

                                <div class="col-md-9">
                                    <input id="phone" type="phone"
                                        class="form-control login-input @error('phone') is-invalid @enderror"
                                        name="phone"
                                        value="{{ old('phone', isset($data['phone']) ? $data['phone'] : '') }}"
                                        autocomplete="phone" autofocus>

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status"
                                    class="col-md-3 col-form-label text-md-right">{{ __('ItemImage') }}</label>

                                <div class="col-md-9">
                                    @error('images.0.url')
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <image-upload-component type="item" :max_size="{{ $uploadImageSize }}"></image-upload-component>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="manager_name"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Manager Name') }}</label>

                                <div class="col-md-9">
                                    <input type="text" id="manager_name"
                                        value="{{ old('manager_name', isset($data['manager_name']) ? $data['manager_name'] : '') }}"
                                        class="form-control login-input @error('manager_name') is-invalid @enderror"
                                        name="manager_name" autocomplete="manager_name" autofocus />

                                    @error('manager_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address1"
                                    class="col-md-3 col-form-label text-md-right">{{ __('User Prefecture') }}</label>

                                <div class="col-md-9">
                                    <select name="address1" id="address1"
                                        class="form-control login-input @error('address1') is-invalid @enderror">
                                        @foreach ($prefs as $pref)
                                            <option value="{{ $pref['id'] }}"
                                                {{ old('address1', isset($data['address1']) ? $data['address1'] : -1) == $pref['id'] ? 'selected' : '' }}>
                                                {{ $pref['name'] }}</option>
                                        @endforeach
                                    </select>

                                    @error('address1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address2"
                                    class="col-md-3 col-form-label text-md-right">{{ __('User City') }}</label>

                                <div class="col-md-9">
                                    <select name="address2" id="address2"
                                        class="form-control login-input @error('address2') is-invalid @enderror">
                                        @php $address2 = old('address1', isset($data['address1']) ? $data['address1'] : -1); @endphp
                                        @if ($address2 > -1)
                                            @foreach ($prefs[$address2]['city'] as $city)
                                                <option value="{{ $city['city'] }}"
                                                    {{ old('address2', isset($data['address2']) ? $data['address2'] : '') == $city['city'] ? 'selected' : '' }}>
                                                    {{ $city['city'] }}</option>
                                            @endforeach
                                        @else
                                            @foreach ($prefs['01']['city'] as $city)
                                                <option value="{{ $city['city'] }}"
                                                    {{ old('address2', isset($data['address2']) ? $data['address2'] : '') == $city['city'] ? 'selected' : '' }}>
                                                    {{ $city['city'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <input type="hidden" id="prefs" value="{{ json_encode($prefs) }}">
                                    @error('address2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address3"
                                    class="col-md-3 col-form-label text-md-right">{{ __('User Address') }}</label>

                                <div class="col-md-9">
                                    <input type="text" id="station"
                                        value="{{ old('address3', isset($data['address3']) ? $data['address3'] : '') }}"
                                        class="form-control login-input @error('address3') is-invalid @enderror"
                                        name="address3" autocomplete="address3" autofocus />

                                    @error('address3')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="station"
                                    class="col-md-3 col-form-label text-md-right">{{ __('User Station') }}</label>

                                <div class="col-md-9">
                                    <input type="text" id="station"
                                        value="{{ old('station', isset($data['station']) ? $data['station'] : '') }}"
                                        class="form-control login-input @error('station') is-invalid @enderror"
                                        name="station" autocomplete="station" autofocus />

                                    @error('station')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="login-title">採用条件</div>

                    <div class="card login-card">
                        {{-- <div class="card-header">
                            採用条件
                        </div> --}}
                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="form-group row">
                                <label for="wage"
                                    class="col-md-3 col-form-label text-md-right">{{ __('User Wage') }}</label>

                                <div class="col-md-9">
                                    <label for=""
                                        class="form-label d-flex align-items-center @error('wage') is-invalid @enderror">
                                        <select class="form-control login-input d-inline-flex" name="wage"
                                            id="">
                                            <option value=""></option>
                                            @for ($i = 1000; $i < 3100; $i += 100)
                                                <option value="{{ $i }}"
                                                    {{ old('wage', isset($data['wage']) ? $data['wage'] : '') == $i ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                        <div class="w-100 ml-2">円以上</div>
                                    </label>
                                    @error('wage')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="employment"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Shop Employment') }}</label>

                                <div class="col-md-9">
                                    <div class="employments_wrapper @error('employment') is-invalid @enderror">
                                        @foreach ($arrEmployments as $employment)
                                            <label for="employment{{ $employment }}" class="mr-2">
                                                <input name="employment[]" id="employment{{ $employment }}"
                                                    type="checkbox" value="{{ $employment }}"
                                                    {{ in_array($employment, old('employment', isset($data['employment']) ? $data['employment'] : [])) ? 'checked' : '' }}>{{ $employment }}
                                            </label>
                                        @endforeach
                                    </div>

                                    @error('employment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="employment2"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Shop Other Employment') }}</label>

                                <div class="col-md-9">
                                    <textarea rows="7" id="employment2" class="form-control login-input @error('employment2') is-invalid @enderror"
                                        name="employment2" autocomplete="employment2" autofocus>{{ old('employment2', isset($data['employment2']) ? $data['employment2'] : '') }}</textarea>

                                    @error('employment2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="career"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Shop Career') }}</label>

                                <div class="col-md-9">
                                    <div class="career-wrapper @error('career') is-invalid @enderror">
                                        @foreach ($arrCareers as $career)
                                            <label for="career{{ $career }}" class="form-label mr-2">
                                                <input name="career[]" id="career{{ $career }}"
                                                    class="form-checkbox" type="checkbox" value="{{ $career }}"
                                                    {{ in_array($career, old('career', isset($data['career']) ? $data['career'] : [])) ? 'checked' : '' }}>{{ $career }}
                                            </label>
                                        @endforeach
                                    </div>

                                    @error('career')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="career2"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Shop Other Career') }}</label>

                                <div class="col-md-9">
                                    <textarea rows="7" id="career2" class="form-control login-input @error('career2') is-invalid @enderror"
                                        name="career2" autocomplete="career2" autofocus>{{ old('career2', isset($data['career2']) ? $data['career2'] : '') }}</textarea>

                                    @error('career2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="message"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Shop Message') }}</label>

                                <div class="col-md-9">
                                    <textarea rows="7" id="message" class="form-control login-input @error('message') is-invalid @enderror"
                                        name="message" autocomplete="message" autofocus>{{ old('message', isset($data['message']) ? $data['message'] : '') }}</textarea>

                                    @error('message')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="content"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Shop Content') }}</label>

                                <div class="col-md-9">
                                    <textarea rows="7" id="content" class="form-control login-input @error('content') is-invalid @enderror"
                                        name="content" autocomplete="content" autofocus>{{ old('content', isset($data['content']) ? $data['content'] : '') }}</textarea>

                                    @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Shop Image') }}</label>

                                <div class="col-md-9">
                                    <textarea rows="7" id="image" class="form-control login-input @error('image') is-invalid @enderror"
                                        name="image" autocomplete="image" autofocus>{{ old('image', isset($data['image']) ? $data['image'] : '') }}</textarea>

                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="feature"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Shop Feature') }}</label>

                                <div class="col-md-9">
                                    <textarea rows="7" id="feature" class="form-control login-input @error('feature') is-invalid @enderror"
                                        name="feature" autocomplete="feature" autofocus>{{ old('feature', isset($data['feature']) ? $data['feature'] : '') }}</textarea>

                                    @error('feature')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="appeal_point"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Shop AppealPoint') }}</label>

                                <div class="col-md-9">
                                    <textarea rows="7" id="appeal_point"
                                        class="form-control login-input @error('appeal_point') is-invalid @enderror" name="appeal_point"
                                        autocomplete="appeal_point" autofocus>{{ old('appeal_point', isset($data['appeal_point']) ? $data['appeal_point'] : '') }}</textarea>

                                    @error('appeal_point')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="youtube"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Shop Youtube') }}</label>

                                <div class="col-md-9">
                                    <input type="url" rows="3" id="youtube"
                                        class="form-control login-input @error('youtube') is-invalid @enderror"
                                        name="youtube"
                                        value="{{ old('youtube', isset($data['youtube']) ? $data['youtube'] : '') }}"
                                        autocomplete="youtube" autofocus />

                                    @error('youtube')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="website"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Shop WEBsite') }}</label>

                                <div class="col-md-9">
                                    <input type="text" id="website"
                                        class="form-control login-input @error('website') is-invalid @enderror"
                                        name="website"
                                        value="{{ old('website', isset($data['website']) ? $data['website'] : '') }}"
                                        autocomplete="website" autofocus />

                                    @error('website')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="sns1"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Shop Other SNS') }}</label>

                                <div class="col-md-9">
                                    <input type="url" rows="3" id="sns1"
                                        class="form-control login-input @error('sns1') is-invalid @enderror"
                                        name="sns1"
                                        value="{{ old('sns1', isset($data['sns1']) ? $data['sns1'] : '') }}"
                                        autocomplete="sns1" autofocus />

                                    @error('sns1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sns2"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Shop Other SNS') }}</label>

                                <div class="col-md-9">
                                    <input type="url" rows="3" id="sns2"
                                        class="form-control login-input @error('sns2') is-invalid @enderror"
                                        name="sns2"
                                        value="{{ old('sns2', isset($data['sns2']) ? $data['sns2'] : '') }}"
                                        autocomplete="sns2" autofocus />

                                    @error('sns2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="form-group row mt-4">
                                <div class="col-md-2"></div>
                                <div class="col-md-9">
                                    <h4>契約事項確認</h4>
                                    <ul>
                                        <li>第三者の所有権・著作権・プライバシー・肖像権などを侵害するコンテンツ</li>
                                        <li>児童ポルノや無修正ポルノ</li>
                                        <li>暴力行為・犯罪行為など社会道徳・公序良俗に反するコンテンツ</li>
                                        <li>「禁止事項」に反するコンテンツ</li>
                                    </ul>
                                    <p style="color: red">※契約事項に違反するコンテンツの投稿を確認した場合、事前の警告なく即時アカウントの停止をおこないます。<br>
                                        また、法的な処罰の対象となる場合がございますのでご注意ください。 </p>
                                    {{-- <p>
                                        <input type="checkbox" name="agree" value="1">
                                        <label>投稿コンテンツが上記に該当しないことを誓約します。</label>

                                        @error('agree')
                                            <span class="invalid-feedback" role="alert" style="display: block">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p> --}}

                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="form-group row mb-0">
                                <div style="margin:auto;">
                                    <button type="submit" class="btn btn-primary register-button"
                                        style="min-width: 200px; margin-right: 0.2rem; margin:0.5rem;">
                                        {{ __('ItemSave') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif

        </div>

    </div>

@endsection
