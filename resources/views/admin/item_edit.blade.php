<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">編集</h3>

        <div class="box-tools">
            <div class="btn-group pull-right" style="margin-right: 5px;">
                <a href="{{ route(config('admin.route.prefix') . '.admin.item.delete', $item->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i><span style="margin-left: 2px;">削除</span></a>
            </div>
            <div class="btn-group pull-right" style="margin-right: 5px;">
                <a href="{{ route(config('admin.route.prefix') . '.admin.item.index') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i><span style="margin-left: 2px;">一覧</span></a>
            </div>
        </div>
    </div>

    <div class="box-body item-edit-form">
        <form action="{{ route(config('admin.route.prefix') . '.admin.item.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- <input type="hidden" name="id" value="{{ $id }}" />

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
                value="{{ old('images.4.path', isset($data['images'][4]['path']) ? $data['images'][4]['path'] : '') }}" /> --}}

            <div class="form-group row @error('title') has-error @enderror">
                <label for="title" class="col-sm-2 control-label">タイトル</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $item->title) }}">
                    @error('title')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            {{-- <div class="form-group row">
                <label for="title" class="col-sm-2 control-label">案件画像</label>
                <div class="col-sm-8">
                    <image-upload-component type="item" :max_size="{{ $uploadImageSize }}"></image-upload-component>
                </div>
            </div> --}}

            <div class="form-group row @error('genre') has-error @enderror">
                <label for="genre" class="col-sm-2 control-label">お仕事ジャンル</label>
                <div class="col-sm-8">
                    <select name="genre" id="genre" class="form-control">
                    @foreach ($mainCategories as $id => $name)
                        <option value="{{ $id }}" {{ old('genre', $item->genre) == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('genre')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('public_flag') has-error @enderror">
                <label for="public_flag" class="col-sm-2 control-label">状況</label>
                <div class="col-sm-8">
                    <select name="public_flag" id="public_flag" class="form-control">
                    @foreach(config('constants.arrPublicStatus') as $key => $value)
                        <option value="{{ $key }}" {{ old('public_flag', $item->public_flag) == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('public_flag')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('genre_other') has-error @enderror" id="genre_other_group" style="display: none;">
                <label for="genre_other" class="col-sm-2 control-label">その他の仕事ジャンル</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="genre_other" name="genre_other" 
                           value="{{ old('genre_other', $item->genre_other) }}" 
                           placeholder="仕事ジャンル名を入力してください">
                    @error('genre_other')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('is_offering') has-error @enderror">
                <label for="is_offering" class="col-sm-2 control-label">同伴者への提供</label>
                <div class="col-sm-8">
                    <select name="is_offering" id="is_offering" class="form-control">
                    @foreach(config('constants.arrIsOffering') as $key => $value)
                        <option value="{{ $key }}" {{ old('is_offering', $item->is_offering) == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('is_offering')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('price') has-error @enderror">
                <label for="price" class="col-sm-2 control-label">本来の提供価格</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $item->price) }}">
                    @error('price')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('description') has-error @enderror">
                <label for="description" class="col-sm-2 control-label">提供商品の詳細</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $item->description) }}</textarea>
                    @error('description')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group row @error('website') has-error @enderror">
                <label for="website" class="col-sm-2 control-label">参考URL</label>
                <div class="col-sm-8">
                    <input type="url" class="form-control" id="website" name="website" value="{{ old('website', $item->website) }}">
                    @error('website')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('station') has-error @enderror">
                <label for="station" class="col-sm-2 control-label">都道府県 / 最寄り駅</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="station" name="station" value="{{ old('station', $item->station) }}">
                    @error('station')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('address') has-error @enderror">
                <label for="address" class="col-sm-2 control-label">住所</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $item->address) }}</textarea>
                    @error('address')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('post_sns') has-error @enderror">
                <label for="post_sns" class="col-sm-2 control-label">投稿SNS</label>
                <div class="col-sm-8">
                    <select name="post_sns" id="post_sns" class="form-control">
                    @foreach(config('constants.arrPostSNS') as $key => $value)
                        <option value="{{ $key }}" {{ old('post_sns', $item->post_sns) == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('post_sns')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('post_type') has-error @enderror">
                <label for="post_type" class="col-sm-2 control-label">投稿形式</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="post_type" name="post_type" value="{{ old('post_type', $item->post_type) }}">
                    @error('post_type')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('hash_tag') has-error @enderror">
                <label for="hash_tag" class="col-sm-2 control-label">ハッシュタグ</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="hash_tag" name="hash_tag" value="{{ old('hash_tag', $item->hash_tag) }}">
                    @error('hash_tag')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group row @error('pr_account') has-error @enderror">
                <label for="pr_account" class="col-sm-2 control-label">PR投稿に載せる指定アカウント</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="pr_account" name="pr_account" value="{{ old('pr_account', $item->pr_account) }}">
                    @error('pr_account')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('pr_flow') has-error @enderror">
                <label for="pr_flow" class="col-sm-2 control-label">PR投稿の流れ</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="pr_flow" name="pr_flow" rows="5">{{ old('pr_flow', $item->pr_flow) }}</textarea>
                    @error('pr_flow')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('pr_rule') has-error @enderror">
                <label for="pr_rule" class="col-sm-2 control-label">PR投稿ルール</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="pr_rule" name="pr_rule" rows="5">{{ old('pr_rule', $item->pr_rule) }}</textarea>
                    @error('pr_rule')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group row @error('condition') has-error @enderror">
                <label for="condition" class="col-sm-2 control-label">使用条件</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="condition" name="condition" rows="5">{{ old('condition', $item->condition) }}</textarea>
                    @error('condition')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('entry_sns') has-error @enderror">
                <label for="entry_sns" class="col-sm-2 control-label">SNS名</label>
                <div class="col-sm-8">
                    <select name="entry_sns" id="entry_sns" class="form-control">
                    @foreach(config('constants.arrPostSNS') as $key => $value)
                        <option value="{{ $key }}" {{ old('entry_sns', $item->entry_sns) == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                @error('entry_sns')
                    <span class="help-block">{{ $message }}</span>
                @enderror
                </div>
            </div>

            <div class="form-group row @error('entry_follower') has-error @enderror">
                <label for="entry_follower" class="col-sm-2 control-label">フォロワー数</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="entry_follower" name="entry_follower" value="{{ old('entry_follower', $item->entry_follower) }}">
                    @error('entry_follower')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('gender') has-error @enderror">
                <label for="gender" class="col-sm-2 control-label">性別</label>
                <div class="col-sm-8">
                    <select name="gender" id="gender" class="form-control">
                    @foreach(config('constants.arrItemGender') as $key => $value)
                        <option value="{{ $key }}" {{ old('gender', $item->gender) == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                    </select>
                    @error('gender')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('entry_method') has-error @enderror">
                <label for="entry_method" class="col-sm-2 control-label">応募方法</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="entry_method" name="entry_method" rows="5">{{ old('entry_method', $item->entry_method) }}</textarea>
                    @error('entry_method')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('is_emergency') has-error @enderror">
                <label for="is_emergency" class="col-sm-2 control-label">急募</label>
                <div class="col-sm-8">
                    <select name="is_emergency" id="is_emergency" class="form-control">
                      <option value="1" {{ old('is_emergency', $item->is_emergency) == 1 ? 'selected' : '' }}>はい</option>
                      <option value="0" {{ old('is_emergency', $item->is_emergency) == 0 ? 'selected' : '' }}>いいえ</option>
                    </select>
                    @error('is_emergency')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row @error('is_recommended') has-error @enderror">
                <label for="is_recommended" class="col-sm-2 control-label">おすすめ一覧へ掲載</label>
                <div class="col-sm-8">
                    <select name="is_recommended" id="is_recommended" class="form-control">
                    <option value="1" {{ old('is_recommended', $item->is_recommended) == 1 ? 'selected' : '' }}>はい</option>
                    <option value="0" {{ old('is_recommended', $item->is_recommended) == 0 ? 'selected' : '' }}>いいえ</option>
                </select>
                @error('is_recommended')
                    <span class="help-block">{{ $message }}</span>
                @enderror
                </div>
            </div>

            <div style="margin-bottom: 20px; margin-top: 30px; border-bottom: 1px solid #ccc;"></div>

            <div class="form-group row"> 
              <div class="col-sm-offset-2 col-sm-8">
                <h4>応募してきたインフルエンサー一覧</h4>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th style="width: 67.5px;">画像</th>
                      <th>名前</th>
                      <th>メールアドレス</th>
                      <th>応募日時</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($orderItems as $orderItem)
                      <tr>
                        <td>{{ $orderItem->user->id }}</td>
                        <td><img src="{{ $orderItem->user->image_url }}" alt="{{ $orderItem->user->name }}" style="width: 50px; height: 50px;"></td>
                        <td><a href="{{ route(config('admin.route.prefix') . '.admin.orderitem.detail', $orderItem->id) }}">{{ $orderItem->user->name }}</a></td>
                        <td>{{ $orderItem->user->email }}</td>
                        <td>{{ $orderItem->created_at }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

            <div class="box-footer">
              <div class="row">
                  <div class="col-sm-offset-2 col-sm-8">
                    <div style="display: flex; justify-content: space-between;">
                      <a href="{{ route(config('admin.route.prefix') . '.admin.item.edit', $item->id) }}" class="btn btn-warning">リセット</a>
                      <button type="submit" class="btn btn-primary">送信</button>
                    </div>
                  </div>
              </div>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // カテゴリ選択時の処理
    $('#genre').on('change', function() {
        const selectedValue = $(this).val();
        const otherGroup = $('#genre_other_group');
        
        if (selectedValue === 'その他') {
            otherGroup.show();
            $('#genre_other').prop('required', true);
        } else {
            otherGroup.hide();
            $('#genre_other').prop('required', false);
        }
    });
    
    // ページ読み込み時の初期状態設定
    const initialGenre = $('#genre').val();
    if (initialGenre === 'その他') {
        $('#genre_other_group').show();
        $('#genre_other').prop('required', true);
    }
});
</script> 