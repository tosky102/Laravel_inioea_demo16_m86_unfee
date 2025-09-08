<?php
    function displayTextWithLinks($s) {
    return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
    }
?>

<div class="row mypage_row message-body">
  <div class="col-md-12">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">
          {{-- {{ optional($orderItem->item)->title ?? '' }} --}}
        </h3>

        <div class="box-tools">
          <div class="btn-group pull-right" style="margin-right: 5px">
            <a href={{route(config('admin.route.prefix') . '.admin.orderitem.index')}} class="btn btn-sm btn-default" title="一覧">
              <i class="fa fa-list"></i>
              <span class="hidden-xs">一覧</span>
            </a>
          </div>
        </div>
      </div>

      <div class="box-body message-body">
        <div class="item-list">
          <div class="order-tab-container">
            <a class="order-tab-item" data-url="{{ route(config('admin.route.prefix') . '.admin.orderitem.detail', ['id' => $orderItem->id, 'viewType' => 'company']) }}">
              <span @if (request()->get('viewType') == 'company' || request()->get('viewType') == null) class="active" @endif>企業側</span>
            </a>
            <a class="order-tab-item" data-url="{{ route(config('admin.route.prefix') . '.admin.orderitem.detail', ['id' => $orderItem->id, 'viewType' => 'influencer']) }}">
              <span @if (request()->get('viewType') == 'influencer') class="active" @endif>インフルエンサー側</span>
            </a>
          </div>
          <div class="order-status-container">
            @if ($orderItem->status >= 0)
            @foreach($statuses as $i => $label)
              <div class="order-status-item {{ $i === $orderItem->status ? 'active' : ($i < $orderItem->status ? 'pass' : '') }}">
                <div class="order-status-item-label">{{ $label }}</div>
              </div>
              @if($i < count($statuses) - 1)
                <div class="order-status-symbol"></div>
              @endif
            @endforeach
            @endif
          </div>

          @php
              $userType = request()->get('viewType', 'company');
              $status = $orderItem->status;
          @endphp

          <div class="order-status-action-container" id="order-status-action-container" data-action-url="{{ route(config('admin.route.prefix') . '.admin.orderitem.action', ['id' => $orderItem->id]) }}">
              @if(!empty($orderItem->item))
                  {{-- Status 0: Applied --}}
                  @if($status === 0)
                      @if($userType === 'company')
                          <button type="button" class="btn btn-request" data-action="request">依頼する</button>
                          <button type="button" class="btn btn-reject" data-action="reject">依頼しない</button>
                      @endif
                  @endif
          
                  {{-- Status 1: Requested --}}
                  @if($status === 1)
                      @if($userType === 'company')
                          <button type="button" class="btn btn-request" data-action="shopping">来店完了</button>
                      @endif
                  @endif
          
                  {{-- Status 2: Visited --}}
                  @if($status === 2)
                    @if($userType === 'influencer')
                        <div class="order-status-post-url-container">
                              <button type="button" class="btn btn-post" id="post-button" data-action="post" disabled>投稿完了</button>
                              <div>
                                  <label for="post_url" style="display: block;">投稿完了のURL</label>
                                  <input type="text" class="form-control" name="post_url" id="post_url">
                              </div>
                        </div>
                    @endif
                  @endif
          
                  {{-- Status 3: Posted --}}
                  @if($status === 3)
                    @if($userType === 'company')
                        <div class="order-status-rating-container">
                              <div class="rating">
                                  <select name="rating" id="rating" class="form-control">
                                      <option value="" disabled selected>評価を選択してください</option>
                                      @foreach($arrRating as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="review">
                                  <label for="review">レビューと投稿確認をお願いします。</label>
                                  <textarea name="review" id="review" class="form-control"></textarea>
                                  <button type="button" class="btn btn-request mt-1" id="complete-button" data-action="complete" disabled>依頼を完了する</button>
                              </div>
                        </div>
                    @endif
                  @endif
          
                  {{-- Status 5: Cancelled --}}
                  @if($status === 5)
                      <div class="order-status-cancel-container">
                          @if($userType === 'influencer')
                              <p>応募がキャンセルされました。</p>
                          @else
                              <p>案件依頼をキャンセルしました。</p>
                          @endif
                      </div>
                  @endif
          
                  {{-- Status -2: Initial --}}
                  @if($status === -2)
                      <div class="order-status-vote-container">
                          <a href="{{ route(config('admin.route.prefix') . '.admin.item.edit', ['id' => $orderItem->item_id]) }}" target="_blank">
                              <div class="order-status-vote-item">
                                  <img src="{{ optional($orderItem->item)->image_url ?? '/images/users/mallento.png' }}" alt="案件画像">
                              </div>
                          </a>
                          @if($userType === 'company')
                              <p>案件起票完了しました。<br>
                              インフルエンサーからの案件受け取りをお待ちください。</p>
                          @else
                              <button type="button" class="btn btn-request" data-action="accept">案件を受ける</button>
                          @endif
                      </div>
                  @endif
          
                  {{-- Status -1: Applied by Influencer --}}
                  @if($status === -1)
                       <div class="order-status-vote-container">
                          @if($userType === 'company')
                            <button type="button" class="btn btn-request" data-action="confirm">応募確認する</button>
                          @else
                            <p>応募確認をお待ちしてください。</p>
                          @endif
                        </div>
                  @endif
              @else
                  <div class="order-status-action-container">
                      @if($userType === 'company')
                          <button type="button" class="btn btn-request" data-toggle="modal" data-target="#voteModal">案件を起票する</button>
                      @endif
                  </div>
              @endif
          </div>

          <div class="order-status-history-container">
            <div class="user-part">
              <div class="user-item">
                <div class="user-item-icon">
                  <img src="{{ $orderItem->toUser->image_url}}" alt="{{ $orderItem->toUser->name}}">
                </div>
                <div class="user-item-name">
                  <a href="{{ route(config('admin.route.prefix') . '.admin.user.show', ['user' => $orderItem->toUser->id]) }}">{{ $orderItem->toUser->name }}</a>
                </div>
              </div>
              <div class="user-item">
                <div class="user-item-icon">
                  <img src="{{ $orderItem->user->image_url }}" alt="{{ $orderItem->user->nickname }}">
                </div>
                <div class="user-item-name">
                  <a href="{{ route(config('admin.route.prefix') . '.admin.user.show', ['user' => $orderItem->user->id]) }}">{{ $orderItem->user->nickname }}</a>
                </div>
              </div>
            </div>
            <div class="history-part">
              <div class="history-item">
                <p class="history-label">応募開始</p>
                <p class="history-time">{{ $orderItem->started_at_date }}</p>
              </div>
              <div class="history-item">
                <p class="history-label">依頼完了</p>
                <p class="history-time">{{ $orderItem->requested_at_date }}</p>
              </div>
              <div class="history-item">
                <p class="history-label">案件完了</p>
                <p class="history-time">{{ $orderItem->completed_at_date }}</p>
              </div>
            </div>
          </div>
          
          @if ($review && isset($arrRating[$review->rating]) && $arrRating[$review->rating] != '')
            <div class="order-status-history-container">
                <div class="review-label">評価</div>
                <div class="review-rating">{{ $arrRating[$review->rating] ?? '' }}</div>
                <div class="review-value">{!! preg_replace('@(https?://([-\w\.]+[-\w])+(?:\:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', nl2br(e($review->comment ?? ''))) !!}</div>
            </div>
          @endif

          <div class="card login-card" style="margin:0">
            <div class="card-body">
              <div class="item-list show-scroller">
                @foreach($messages as $row)
                  @if($row->role_type)
                  @if($row->role_type == 'all' || $row->role_type == request()->get('viewType'))
                  <div class="template">
                    <div class="message-detail-text">
                      <h5 class="title-color display-table o-textNote__title f14">{{ date('Y.m.d', strtotime($row->created_at)) }}</h5>
                      <p class="f14 display-table o-textNote__description" style="margin-top: 4px; text-align: left">
                        {!! preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', nl2br(e($row->comment))) !!}
                      </p>
                    </div>
                  </div>
                  @endif
                  @elseif($row->fromUser == null)
                    <div class="partner">
                        <div class="o-gridNote__body padding-top-none">
                            <div class="message-admin">
                                <img src="{{ asset('images/users/mallento.png') }}" />
                                <span class="message-sender-name">{{ config('app.name') }}<br/>事務局</span>
                            </div>
                            <div class="message-detail-text">
                                <h5 class="title-color display-table o-textNote__title f14">{{ date('Y.m.d', strtotime($row->created_at)) }}</h5>
                                <p class="f14 display-table o-textNote__description" style="margin-top: 4px; text-align: left">
                                {!! preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', nl2br(e($row->comment))) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                  @elseif($row->fromUser)
                    <div class="{{ $row->user_id === $orderItem->user_id ? 'self' : 'partner' }}">
                      <div class="o-gridNote__body padding-top-none">
                        <img src="{{ $row->fromUser->image_url }}" />
                        <div class="message-detail-text">
                          <h5 class="title-color display-table o-textNote__title f14">{{ date('Y.m.d', strtotime($row->created_at)) }}</h5>
                          <p class="f14 display-table o-textNote__description" style="margin-top: 4px; text-align: left; line-break: anywhere;">
                            {!! preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', nl2br(e($row->comment))) !!}
                          </p>
                        </div>
                      </div>
                    </div>
                  @endif
                  <div class="clearfix" style="margin-bottom:8px"></div>
                @endforeach
              </div>
            </div>

            @if ($orderItem->status < 4 )
            <div class="item-list">
              <div class="message-input">
                <form action="{{ route(config('admin.route.prefix') . '.admin.orderitem.message', ['id' => $orderItem->id]) }}" method="POST" id="message-form">
                  @csrf
                  <input type="hidden" name="type" value="{{ request()->get('viewType', 'company') }}">
                  
                  <textarea
                    class="form-control"
                    name="comment"
                    style="background-color: rgb(243, 243, 243); color: rgb(0, 21, 29); min-height: 40px; width: 100%; margin-top: 30px;"
                    placeholder="テキストを入力"
                    rows="4"
                  ></textarea>
                  
                  @isset($template['label'])
                  {{-- <div style="margin-top: 10px; display: flex; justify-content: flex-start; gap: 20px;">
                    <label for="is_template" class="order-status-template-label">
                      <input type="checkbox" id="is_template" data-template-value="{{ e($template['value'] ?? '') }}">
                      <span>{{ $template['label'] }}</span>
                    </label>
                    @if ($orderItem->status == 0 && (request()->get('viewType') == 'company' || request()->get('viewType') == null))
                    <label for="is_cancel" class="order-status-template-label">
                      <input type="checkbox" id="is_cancel" data-template-value="{{ e($cancelTemplate ?? '') }}">
                      <span>お見送り定型文を挿入する</span>
                    </label>
                    @endif
                  </div> --}}
                  @endisset
                  
                  <div class="text-center" style="margin-top: 10px;">
                    <button
                      type="submit"
                      class="btn btn-primary register-button"
                      style="min-width: 200px; margin-right: 0.2rem; margin:0.5rem; padding:1rem;"
                    >送信する</button>
                  </div>
                </form>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>

      <div class="modal" id="voteModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{ route(config('admin.route.prefix') . '.admin.orderitem.vote', ['id' => $orderItem->id]) }}" id="voteForm" method="post">
                @csrf
                
                <div class="modal-header">
                    <h5 class="modal-title f-bold">案件を起票する</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="card">
                            <div class="card-header">案件情報</div>
                            <div class="card-body">
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
                                        @error('images')
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <input type="file" name="images[]" multiple>
                                        {{-- <image-upload-component type="item" :max_size="{{ $uploadImageSize }}"></image-upload-component> --}}
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
                                        <div class="d-flex items-start justify-start @error('is_offering') is-invalid @enderror">
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
            
                        <div class="card mt-4">
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
            
                        <div class="card mt-4">
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
            
                        <div class="card mt-4">
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
                                        <div class="d-flex items-start justify-start pt-2 @error('gender') is-invalid @enderror">
                                            @foreach ($arrGenders as $key => $gender)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="gender_{{ $key }}" value="{{ $key }}"
                                                        {{ old('gender', $data['gender'] ?? null) == $key ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="gender_{{ $key }}">{{ $gender }}</label>
                                                </div>
                                            @endforeach
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender"
                                                    id="gender_unspecified" value="0"
                                                    {{ old('gender', $data['gender'] ?? null) == '0' ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="gender_unspecified">{{ __('男女問わず') }}</label>
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
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                    <button type="submit" class="btn btn-primary">起票する</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function scrollToBottom() {
        var element = document.querySelector('.show-scroller');
        if (element) {
            element.scrollTop = element.scrollHeight;
        }
    }

    function setupEventListeners() {
        scrollToBottom();

        const tabContainer = document.querySelector('.order-tab-container');
        if (tabContainer && !tabContainer.dataset.listenerAttached) {
            tabContainer.addEventListener('click', function(e) {
                const button = e.target.closest('a.order-tab-item');
                if (button && button.dataset.url) {
                    window.location.href = button.dataset.url;
                }
            });
            tabContainer.dataset.listenerAttached = 'true';
        }

        const templateCheckbox = document.getElementById('is_template');
        const cancelTemplateCheckbox = document.getElementById('is_cancel');
        const commentTextarea = document.querySelector('textarea[name="comment"]');

        if (commentTextarea && (templateCheckbox || cancelTemplateCheckbox)) {
            // attach listener for template checkbox
            if (templateCheckbox && !templateCheckbox.dataset.listenerAttached) {
                templateCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        // uncheck cancel if checked
                        if (cancelTemplateCheckbox && cancelTemplateCheckbox.checked) {
                            cancelTemplateCheckbox.checked = false;
                        }
                        commentTextarea.value = this.dataset.templateValue || '';
                    } else {
                        // if cancel is checked, use cancel template, otherwise clear
                        if (cancelTemplateCheckbox && cancelTemplateCheckbox.checked) {
                            commentTextarea.value = cancelTemplateCheckbox.dataset.templateValue || '';
                        } else {
                            commentTextarea.value = '';
                        }
                    }
                });
                templateCheckbox.dataset.listenerAttached = 'true';
            }

            // attach listener for cancel checkbox
            if (cancelTemplateCheckbox && !cancelTemplateCheckbox.dataset.listenerAttached) {
                cancelTemplateCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        // uncheck template if checked
                        if (templateCheckbox && templateCheckbox.checked) {
                            templateCheckbox.checked = false;
                        }
                        commentTextarea.value = this.dataset.templateValue || '';
                    } else {
                        // if template is checked, use template, otherwise clear
                        if (templateCheckbox && templateCheckbox.checked) {
                            commentTextarea.value = templateCheckbox.dataset.templateValue || '';
                        } else {
                            commentTextarea.value = '';
                        }
                    }
                });
                cancelTemplateCheckbox.dataset.listenerAttached = 'true';
            }

            // initial state handling
            if (templateCheckbox && templateCheckbox.checked) {
                commentTextarea.value = templateCheckbox.dataset.templateValue || '';
                if (cancelTemplateCheckbox) cancelTemplateCheckbox.checked = false;
            } else if (cancelTemplateCheckbox && cancelTemplateCheckbox.checked) {
                commentTextarea.value = cancelTemplateCheckbox.dataset.templateValue || '';
                if (templateCheckbox) templateCheckbox.checked = false;
            }
        }

        const actionContainer = document.getElementById('order-status-action-container');
        if (actionContainer && !actionContainer.dataset.listenerAttached) {
            actionContainer.addEventListener('click', function(e) {
                if (e.target.matches('button[data-action]')) {
                    e.preventDefault(); 

                    const action = e.target.dataset.action;
                    console.log(action);
                    const url = actionContainer.dataset.actionUrl;
                    let data = { action };
                    
                    if (action === 'post') {
                        data.post_url = document.getElementById('post_url').value;
                    } else if (action === 'complete') {
                        data.rating = document.getElementById('rating').value;
                        data.review = document.getElementById('review').value;
                    }

                    axios.post(url, data)
                        .then(response => {
                            if (response.data.success) {
                                window.location.reload();
                            } else {
                                alert(response.data.message || 'エラーが発生しました。');
                            }
                        })
                        .catch(error => {
                            console.error('Axios Error:', error.response || error);
                            alert('エラーが発生しました。');
                        });
                }
            });
            actionContainer.dataset.listenerAttached = 'true';
        }
        
        // Handlers for status 2 (post)
        const postUrlInput = document.getElementById('post_url');
        const postButton = document.getElementById('post-button');
        if (postUrlInput && postButton) {
            postUrlInput.addEventListener('input', function() {
                postButton.disabled = this.value.trim() === '';
            });
        }

        // Handlers for status 3 (complete)
        const ratingSelect = document.getElementById('rating');
        const reviewTextarea = document.getElementById('review');
        const completeButton = document.getElementById('complete-button');
        if (ratingSelect && reviewTextarea && completeButton) {
            const checkCompletionState = () => {
                const rating = ratingSelect.value;
                const review = reviewTextarea.value;
                completeButton.disabled = rating.trim() === '' || review.trim() === '';
            };
            ratingSelect.addEventListener('input', checkCompletionState);
            reviewTextarea.addEventListener('input', checkCompletionState);
        }
    }

    $(document).ready(function() {
        setupEventListeners();
        
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