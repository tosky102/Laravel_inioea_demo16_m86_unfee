@extends('layouts.mypage')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12 mypage_index_row">

            @if (!isset($data['mode']) || (isset($data['mode']) && $data['mode'] == 'main'))
                <form method="POST" action="{{ route('mypage.item') }}">
                    @csrf
                    <div class="card">
                        <div class="card-header">案件情報</div>
                        <div class="card-body">

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

                            <div class="form-group row">
                                <label for="title"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                                <div class="col-md-6">
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
                                <label for="images"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemImage') }}</label>

                                <div class="col-md-6">
                                    @error('images.0.url')
                                        <span class="invalid-feedback" role="alert" style="display: block;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <image-upload-component type="item" :max_size="{{ $uploadImageSize }}"></image-upload-component>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="public_flag"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemStatus') }}</label>

                                <div class="col-md-6">
                                    <div class="@error('public_flag') is-invalid @enderror">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                name="public_flag" id="isPublicYes"
                                                value="1" @if (old('public_flag', isset($data['public_flag']) ? $data['public_flag'] : '') == 1) checked @endif>
                                            <label class="form-check-label" for="isPublicYes">
                                                公開
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                name="public_flag" id="isPublicNo"
                                                value="0" @if (old('public_flag', isset($data['public_flag']) ? $data['public_flag'] : '') == 0) checked @endif>
                                            <label class="form-check-label" for="isPublicNo">
                                                非公開
                                            </label>
                                        </div>
                                    </div>
                                    @error('public_flag')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="genre"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemCategory') }}</label>

                                <div class="col-md-6">
                                    <select name="genre" id="genre"
                                        class="form-control login-input @error('genre') is-invalid @enderror">
                                        @foreach ($arrItemCategory as $key => $category)
                                            <option value="{{ $key }}"
                                                {{ old('genre', isset($data['genre']) ? $data['genre'] : '') === $key ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('genre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row" id="genre_other" style="display: none;">
                                <label for="genre_other"
                                    class="col-md-4 col-form-label text-md-right">{{ __('その他の仕事ジャンル') }}</label>

                                <div class="col-md-6">
                                    <input type="text" name="genre_other" id="genre_other"
                                        class="form-control login-input @error('genre_other') is-invalid @enderror"
                                        value="{{ old('genre_other', isset($data['genre_other']) ? $data['genre_other'] : '') }}"
                                        placeholder="カテゴリ名を入力してください">

                                    @error('genre_other')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="is_offering"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemOffering') }}</label>

                                <div class="col-md-6">
                                    <div class="@error('is_offering') is-invalid @enderror">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                name="is_offering" id="isOfferingYes"
                                                value="1" @if (old('is_offering', isset($data['is_offering']) ? $data['is_offering'] : '') == 1) checked @endif>
                                            <label class="form-check-label" for="isOfferingYes">
                                                有り
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                name="is_offering" id="isOfferingNo"
                                                value="0" @if (old('is_offering', isset($data['is_offering']) ? $data['is_offering'] : '') == 0) checked @endif>
                                            <label class="form-check-label" for="isOfferingNo">
                                                無し
                                            </label>
                                        </div>
                                    </div>
                                    @error('is_offering')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemPrice') }}</label>

                                <div class="col-md-6">
                                    <input type="number" id="price" name="price"
                                        value="{{ old('price', isset($data['price']) ? $data['price'] : '') }}"
                                        class="form-control login-input @error('price') is-invalid @enderror" />

                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemDescription') }}</label>

                                <div class="col-md-6">
                                    <textarea rows="3" id="description"
                                        class="form-control login-input @error('description') is-invalid @enderror" name="description"
                                        autocomplete="description" autofocus>{{ old('description', isset($data['description']) ? $data['description'] : '') }}</textarea>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="website"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemURL') }}</label>

                                <div class="col-md-6">
                                    <input type="url" id="website" name="website"
                                        value="{{ old('website', isset($data['website']) ? $data['website'] : '') }}"
                                        class="form-control login-input @error('website') is-invalid @enderror"
                                        autocomplete="website" />

                                    @error('website')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="station"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemStation') }}</label>

                                <div class="col-md-6">
                                    <input type="text" id="station" name="station"
                                        value="{{ old('station', isset($data['station']) ? $data['station'] : '') }}"
                                        class="form-control login-input @error('station') is-invalid @enderror"
                                        autocomplete="station" />

                                    @error('station')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemAddress') }}</label>

                                <div class="col-md-6">
                                    <textarea rows="3" id="address"
                                        class="form-control login-input @error('address') is-invalid @enderror" name="address"
                                        autocomplete="address" autofocus>{{ old('address', isset($data['address']) ? $data['address'] : '') }}</textarea>

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            希望PR投稿
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="post_sns"
                                    class="col-md-4 col-form-label text-md-right">{{ __('') }}</label>

                                <div class="col-md-6">
                                    <select name="post_sns" id="post_sns"
                                        class="form-control login-input @error('post_sns') is-invalid @enderror">
                                        @foreach ($arrPostSNS as $key => $sns)
                                            <option value="{{ $key }}"
                                                {{ old('post_sns', isset($data['post_sns']) ? $data['post_sns'] : '') === $key ? 'selected' : '' }}>
                                                {{ $sns }}</option>
                                        @endforeach
                                    </select>

                                    @error('post_sns')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="post_type"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemPostType') }}</label>

                                <div class="col-md-6">
                                    <input type="text" id="post_type" name="post_type"
                                        value="{{ old('post_type', isset($data['post_type']) ? $data['post_type'] : '') }}"
                                        class="form-control login-input @error('post_type') is-invalid @enderror"
                                        autocomplete="post_type" />

                                    @error('post_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="hash_tag"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemHashTag') }}</label>

                                <div class="col-md-6">
                                    <input type="text" id="hash_tag" name="hash_tag"
                                        value="{{ old('hash_tag', isset($data['hash_tag']) ? $data['hash_tag'] : '') }}"
                                        class="form-control login-input @error('hash_tag') is-invalid @enderror"
                                        autocomplete="hash_tag" />

                                    @error('hash_tag')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pr_account"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemPRAccount') }}</label>

                                <div class="col-md-6">
                                    <input type="text" id="pr_account" name="pr_account"
                                        value="{{ old('pr_account', isset($data['pr_account']) ? $data['pr_account'] : '') }}"
                                        class="form-control login-input @error('pr_account') is-invalid @enderror"
                                        autocomplete="pr_account" />

                                    @error('pr_account')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pr_flow"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemPRFlow') }}</label>

                                <div class="col-md-6">
                                    <textarea rows="3" id="pr_flow"
                                        class="form-control login-input @error('pr_flow') is-invalid @enderror" name="pr_flow"
                                        autocomplete="pr_flow">{{ old('pr_flow', isset($data['pr_flow']) ? $data['pr_flow'] : '') }}</textarea>

                                    @error('pr_flow')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pr_rule"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemPRRule') }}</label>

                                <div class="col-md-6">
                                    <textarea rows="3" id="pr_rule"
                                        class="form-control login-input @error('pr_rule') is-invalid @enderror" name="pr_rule"
                                        autocomplete="pr_rule">{{ old('pr_rule', isset($data['pr_rule']) ? $data['pr_rule'] : '') }}</textarea>

                                    @error('pr_rule')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">使用条件</div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="condition"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemCondition') }}</label>

                                <div class="col-md-6">
                                    <textarea rows="3" id="condition"
                                        class="form-control login-input @error('condition') is-invalid @enderror" name="condition"
                                        autocomplete="condition">{{ old('condition', isset($data['condition']) ? $data['condition'] : '') }}</textarea>

                                    @error('condition')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            応募条件
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="entry_sns"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemEntrySNS') }}</label>

                                <div class="col-md-6">
                                    <select name="entry_sns" id="entry_sns"
                                        class="form-control login-input @error('entry_sns') is-invalid @enderror">
                                        @foreach ($arrPostSNS as $key => $entry_sns)
                                            <option value="{{ $key }}"
                                                {{ old('entry_sns', isset($data['entry_sns']) ? $data['entry_sns'] : '') === $key ? 'selected' : '' }}>
                                                {{ $entry_sns }}</option>
                                        @endforeach
                                    </select>

                                    @error('entry_sns')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="entry_follower"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemEntryCount') }}</label>

                                <div class="col-md-6">
                                    <input type="number" id="entry_follower" name="entry_follower"
                                        value="{{ old('entry_follower', isset($data['entry_follower']) ? $data['entry_follower'] : '') }}"
                                        class="form-control login-input @error('entry_follower') is-invalid @enderror"
                                        autocomplete="entry_follower" />

                                    @error('entry_follower')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="gender"
                                    class="col-md-4 col-form-label text-md-right">{{ __('User Gender') }}</label>

                                <div class="col-md-6">
                                    <div class="pt-2 @error('gender') is-invalid @enderror">
                                        @foreach ($arrGenders as $key => $gender)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender"
                                                    id="gender_{{ $key }}" value="{{ $key }}"
                                                    {{ old('gender', $data['gender'] ?? null) == $key ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="gender_{{ $key }}">{{ $gender }}</label>
                                            </div>
                                        @endforeach
                                    </div>

                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="entry_method"
                                    class="col-md-4 col-form-label text-md-right">{{ __('ItemEntryMethod') }}</label>

                                <div class="col-md-6">
                                    <textarea rows="3" id="entry_method"
                                        class="form-control login-input @error('entry_method') is-invalid @enderror" name="entry_method"
                                        autocomplete="entry_method">{{ old('entry_method', isset($data['entry_method']) ? $data['entry_method'] : '') }}</textarea>

                                    @error('entry_method')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4 col-form-label text-md-right"></div>

                                <div class="col-md-6">
                                    <label for="is_emergency">
                                        <input id="is_emergency" name="is_emergency"
                                            type="checkbox"
                                            {{ old('is_emergency', $data['is_emergency'] ?? 0) ? 'checked' : '' }}>
                                        <span class="ml-1">{{ __('ItemIsEmergency') }}</span>
                                    </label>

                                    @error('is_emergency')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-4">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
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
                        </div>
                    </div>

                    <div class="form-group row mb-0 mx-auto">
                        <div style="margin:auto;">
                            <button type="submit" class="btn btn-primary register-button"
                                style="min-width: 200px; margin-right: 0.2rem; margin:0.5rem;">
                                {{ __('ItemSave') }}
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // カテゴリ選択時の処理
    $('#genre').on('change', function() {
        const selectedValue = $(this).val();
        const otherGroup = $('#genre_other');
        
        if (selectedValue === 'その他') {
            otherGroup.show();
            $('#genre_other').prop('required', true);
        } else {
            otherGroup.hide();
            $('#genre_other').prop('required', false);
        }
    });
    
    // ページ読み込み時の初期状態設定
    const initialCategory = $('#genre').val();
    if (initialCategory === 'その他') {
        $('#genre_other').show();
        $('#genre_other').prop('required', true);
    }
});
</script>
@endsection