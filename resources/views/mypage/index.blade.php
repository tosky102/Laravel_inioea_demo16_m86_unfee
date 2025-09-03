@extends('layouts.mypage')

@section('content')
    <div class="row mypage_row">
        <div class="col-md-12 mypage_index_row">
            @if (Auth::user()->status == 3)
                <div class="card" style="border-radius: 15px;padding: 1rem;">
                    {{-- <div class="card-header">{{ __('Account') }}</div> --}}
                    <div class="card-body">
                        <div class="row">
                            <div style="width: 80%; margin: auto;">
                                <div class="col-md-12">
                                    <div class="mypage_row-account-image">
                                        <img src="{{ $user->image_url }}"/>
                                        {{-- <form method="post" action="{{ route('mypage.user_image') }}"
                                            id="userImageFileForm" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                            <input type="hidden" name="max_size" id="user_image_max_size"
                                                value="{{ $uploadImageSize }}" />
                                            <input type="file" name="image_file_name" accept="image/*"
                                                id="user_image_file_name" style="display: none" />
                                        </form>

                                        <form method="post" action="{{ route('mypage.user_image_del') }}"
                                            id="userImageDelForm">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                        </form> --}}
                                        {{-- <p class="mt-3"><a href="javascript:void(0)" onclick="uploadUserImage();">＋画像を編集する</a></p>
                                    <p><a href="javascript:void(0)" onclick="deleteUserImage();">＋画像削除</a></p> --}}
                                    </div>
                                </div>

                                <div class="row" style="margin: 1rem 0">
                                    <div class="col-md-6" style="text-align: center;">
                                        <div class="mypage_row-account-container">
                                            <h3 class="mypage_row-account-title">
                                                {{ $user->role == 'company' ? '企業名' : 'インフルエンサー名' }}
                                            </h3>
                                            <p class="mypage_row-account-content">
                                                {{ $user->name }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" style="text-align: center;">
                                <p>
                                    <a class="btn btn-primary register-button"
                                        style="margin: 0.5rem 0px; width: 80%; padding:0.8rem; color: white !important;text-decoration: none;"
                                        href="{{ route('item') }}">案件一覧へ</a>
                                </p>
                            </div>


                            <div class="col-md-6" style="text-align: center;">
                                <p>
                                    <a class="btn btn-primary register-button"
                                        style="margin: 0.5rem 0px; width: 80%; padding:0.8rem; color: white !important;text-decoration: none;"
                                        href="{{ route('message') }}">メッセージBOX</a>
                                </p>
                            </div>

                            <div class="col-md-6" style="text-align: center;">
                                <p>
                                    <a class="btn btn-primary register-button"
                                        style="margin: 0.5rem 0px; width: 80%; padding:0.8rem; color: white !important;text-decoration: none;"
                                        href="{{ route('mypage.favorite') }}">お気に入り一覧</a>
                                </p>
                            </div>

                            {{-- <div class="col-md-6" style="text-align: center;">
                                <p>
                                    <a class="btn btn-primary register-button"
                                        style="margin: 0.5rem 0px; width: 80%; padding:0.8rem; color: white !important;text-decoration: none;"
                                        href="{{ route('mypage.item') }}">{{ $user->role == 'company' ? '企業' : 'インフルエンサー' }}情報編集</a>
                                </p>
                            </div> --}}


                            <div class="col-md-6" style="text-align: center;">
                                <p>
                                    <a class="btn btn-primary outline-button"
                                        style="min-width: 200px; margin-left: 0.2rem; width: 80%; padding: 0.8rem;"
                                        href="{{ route('mypage.profile') }}">登録情報を変更する</a>
                                </p>
                            </div>


                            <div class="col-md-6" style="text-align: center;">
                                <p>
                                    <a class="btn btn-primary outline-button"
                                        style="min-width: 200px; margin-left: 0.2rem; width: 80%; padding: 0.8rem;"
                                        href="{{ route('logout') }}">ログアウト</a>
                                </p>
                            </div>

                            {{-- <div class="col-md-6" style="text-align: center;">
                                <p>
                                    <a class="btn btn-primary outline-button"
                                        style="min-width: 200px; margin-left: 0.2rem; width: 80%; padding: 0.8rem;"
                                        href="{{ route('message') }}">メール通知設定</a>
                                </p>
                            </div> --}}


                            {{-- <div class="col-md-6" style="text-align: center;">
                                <p>
                                    <a class="btn btn-primary outline-button"
                                        style="min-width: 200px; margin-left: 0.2rem; width: 80%; padding: 0.8rem;"
                                        href="{{ route('mypage.withdrawal') }}">退会する</a>
                                </p>

                            </div> --}}

                        </div>
                    </div>
                </div>
                {{-- 
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body mypage-status">
                        <div class="row">
                            @if (Auth::user()->type == 0)
                                <div class="col-md-4">
                                    <table>
                                        <tr>
                                            <td colspan="2" class="mypage_row-dashboard-title">サマリー</td>
                                        </tr>
                                        <tr>
                                            <td>掲載中</td>
                                            <td>{{ number_format($user->items()->where('status', 1)->count()) }}件</td>
                                        </tr>
                                        <tr>
                                            <td>一時停止</td>
                                            <td>{{ number_format($user->items()->where('status', 0)->count()) }}件</td>
                                        </tr>
                                        <tr>
                                            <td>掲載終了</td>
                                            <td>{{ number_format($user->items()->where('status', 2)->count()) }}件</td>
                                        </tr>
                                    </table>

                                </div>
                            @endif
                            <div class="col-md-4">
                                <table>
                                    <tr>
                                        <td colspan="2" class="mypage_row-dashboard-title">フォロー・フォロワー</td>
                                    </tr>
                                    <tr>
                                        <td>フォロー数</td>
                                        <td>{{ number_format($user->followUsers()->count()) }}人</td>
                                    </tr>
                                    <tr>
                                        <td>フォロワー数</td>
                                        <td>{{ number_format($user->followerUsers()->count()) }}人</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table>
                                    <tr>
                                        <td colspan="2" class="mypage_row-dashboard-title">メッセージ</td>
                                    </tr>
                                    <tr>
                                        <td>受　信</td>
                                        <td>{{ number_format($user->receiveMessages()->count()) }}件</td>
                                    </tr>
                                    <tr>
                                        <td>未開封</td>
                                        <td>{{ number_format($user->receiveMessages()->where('read_flag', 0)->count()) }}件
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>
                </div> --}}

                {{-- <div class="card">
                    <div class="card-header">{{ __('Pages') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="mypage_row-pages-table">
                                    <tr>
                                        <td colspan="2" class="mypage_row-pages-title">
                                            {{ Auth::user()->type == 0 ? '店舗' : '購入者' }}用</td>
                                    </tr>
                                    <tr>
                                        <td class="mypage_row-pages-link">
                                            <p><a href="{{ route('mypage.favorite') }}">お気に入り一覧</a></p>
                                            <p><a
                                                    href="{{ route('mypage.item') }}">{{ Auth::user() && Auth::user()->type == 0 ? '店舗情報' : '求職者情報' }}編集</a>
                                            </p>
                                            <p><a href="{{ route('message') }}">メッセージ一覧</a></p>
                                        </td>
                                    </tr>

                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="mypage_row-pages-table w-100">
                                    <tr>
                                        <td colspan="1" class="mypage_row-pages-title">登録情報</td>
                                    </tr>
                                    <tr>
                                        <td class="mypage_row-pages-link">
                                            <p><a href="{{ route('mypage.profile') }}">登録情報を変更する</a></p>
                                            <p><a href="{{ route('mypage.notice_mail') }}">メール通知設定</a></p>
                                            <p><a href="{{ route('mypage.follow') }}">フォロー一覧</a></p>
                                            <p><a href="{{ route('mypage.follower') }}">フォロワー一覧</a></p>
                                            <p><a href="{{ route('mypage.withdrawal') }}">退会する</a></p>
                                            <p><a href="{{ route('logout') }}">ログアウト</a></p>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> --}}
            @elseif(Auth::user()->status == 2)
                <div class="card">
                    <div class="card-header">{{ __('My Page') }}</div>
                    <div class="card-body">
                        <p>基本情報登録が完了されました。管理者からの承認をお待ちしてください。</p>
                    </div>
                </div>
            @elseif(Auth::user()->status == 4)
                <div class="card">
                    <div class="card-header">{{ __('My Page') }}</div>
                    <div class="card-body">
                        <p>ログイン制限されました。再びサービスを利用するためには管理者にお問い合わせください。</p>

                        <p>
                            管理者からのお知らせ：<br>
                            <?php echo nl2br($user->admin_message); ?>
                        </p>
                    </div>
                </div>
            @elseif(Auth::user()->status == 4)
                <div class="card">
                    <div class="card-header">{{ __('My Page') }}</div>
                    <div class="card-body">
                        <p>強制退会済みのユーザーです。<br>
                            ご利用いただけません。</p>

                    </div>
                </div>
            @endif

        </div>

    </div>
@endsection
