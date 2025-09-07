<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}{{ isset($title) ? '｜' . $title : '' }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1:wght@100..900&family=M+PLUS+1p&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body>
    <div id="app">

        <nav class="navbar-status">
            <div class="container-fluid">
                @guest
                    {{ __('Greetings Login Before') }}<a href="/login">ログイン</a>してください
                @else
                    <?php echo sprintf(__('Greetings Login After'), Auth::user() ? Auth::user()->name : ''); ?>
                @endguest

            </div>
        </nav>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <?php echo $logoHtml; ?>
                {{-- <a href="/" class="navbar-brand"><img src="/images/valiables/logo2024-08-05.png"></a> --}}

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto header-search-buttons">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link btn-header-login"
                                    style="border-radius: 10px;border: 1px solid #333333;color: #333333;text-align: center;"
                                    href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link btn-header-mypage"
                                    style="background: linear-gradient(90deg, #EF0505, #E38300); text-align: center; border-radius: 10px; border: none; width:150px; "
                                    href="{{ route('register_terms') }}">{{ __('Full Register') }}</a>
                            </li>
                        @endif
                    @else
                        @if (Auth::user() && Auth::user()->type == 0)
                            {{-- <li class="nav-item">
                                <a class="nav-link btn-header-login pc-only"
                                    style="background: linear-gradient(90deg, #EF0505, #E38300); text-align: center; border-radius: 10px; border: none; width:150px; "
                                    href="{{ route('mypage.item') }}">{{ __('Upload Product') }}</a>
                            </li> --}}
                            <li class="nav-item">
                                {{-- <a class="nav-link btn-header-login btn-header-login-mypage"
                                    style="border-radius: 10px;border: 1px solid #333333;color: #333333;text-align: center;"
                                    href="{{ route('logout') }}">ログアウト</a> --}}
                                <a class="nav-link btn-header-login pc-only" href="{{ route('mypage') }}">マイページ</a>
                            </li>
                        @else
                            <li class="nav-item">
                                {{-- <a class="nav-link btn-header-login pc-only" href="{{ route('message') }}">メッセージ一覧へ</a> --}}
                                <a class="nav-link btn-header-login pc-only" href="{{ route('mypage') }}">マイページ</a>

                            </li>
                        @endif
                        {{-- <li class="nav-item">
                            <a class="nav-link btn-header-login btn-header-login-mypage"
                                style="border-radius: 10px;border: 1px solid #333333;color: #333333;text-align: center;"
                                href="{{ route('mypage') }}">{{ __('My Page') }}</a>
                        </li> --}}



                        {{--                            <li class="nav-item dropdown"> --}}
                        {{--                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> --}}
                        {{--                                    {{ Auth::user()->name }} --}}
                        {{--                                </a> --}}

                        {{--                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"> --}}
                        {{--                                    <a class="dropdown-item" href="{{ route('logout') }}" --}}
                        {{--                                       onclick="event.preventDefault(); --}}
                        {{--                                                     document.getElementById('logout-form').submit();"> --}}
                        {{--                                        {{ __('Logout') }} --}}
                        {{--                                    </a> --}}

                        {{--                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> --}}
                        {{--                                        @csrf --}}
                        {{--                                    </form> --}}
                        {{--                                </div> --}}
                        {{--                            </li> --}}
                    @endguest

                    <button class="navbar-toggler collapsed" type="button" @click="openSideToggle();">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </ul>



            </div>
        </nav>


        <div class="navbar-sp-header">
            <div class="navbar-sp-status">
                @guest
                    {{ __('Greetings Login Before') }}
                @else
                    <?php echo sprintf(__('Greetings Login After'), Auth::user() ? Auth::user()->name : ''); ?>
                @endguest
            </div>
        </div>

        <div id="overlay" v-bind:style="show_toggle_bar ? 'display:block;' : 'display:none;'">
            <div id="sideToggleBar" v-click-outside="outsideSideToggle">

                <div class="batsu-parent">
                    <span class="batsu" @click="outsideSideToggle();"></span>
                </div>




                <div class="status-bar">
                    @guest
                        {{ __('Short Greetings Login Before') }}
                    @else
                        <?php echo sprintf(__('Short Greetings Login After'), Auth::user() ? Auth::user()->name : ''); ?>
                    @endguest
                </div>

                <div class="humberger-conteiner">

                    <div style="margin: 20px 0px;">
                        @guest
                            <div>
                                <a href="{{ route('register_terms') }}" class="btn-toggle-mypage"
                                    style="border-radius: 10px;border: 1px solid #333333;color: #333333;">{{ __('Full Register') }}</a>
                            </div>
                            <div>
                                <a href="{{ route('login') }}" class="btn-toggle-login">{{ __('Login') }}</a>
                            </div>
                        @else
                        @endguest
                    </div>

                    <div class="button-container2">
                        @if (Auth::user() && Auth::user()->type == 0)
                            <div style="margin: 20px 0px;">
                                <div style="color: #000; margin: 10px;">
                                    <a style=" text-align: left; padding: 0.5rem 0; font-size: 1rem; font-weight: normal;"
                                        class="btn" href="{{ route('message') }}"
                                        class="btn-toggle-upload">メッセージ一覧</a>
                                </div>

                                <div style="color: #000; margin: 10px;">
                                    <a style=" text-align: left; padding: 0.5rem 0; font-size: 1rem; font-weight: normal;"
                                        class="btn" href="{{ route('mypage.favorite') }}">お気に入り一覧</a>
                                </div>

                                <div style="color: #000; margin: 10px;">
                                    <a style=" text-align: left; padding: 0.5rem 0; font-size: 1rem; font-weight: normal;"
                                        class="btn" href="{{ route('contact') }}"
                                        class="footer-sp-btn footer-sp-contact-btn">お問い合わせ<span
                                            class="right-arrow-icon"></span></a>
                                </div>

                                <div style="color: #000; margin: 10px;">
                                    <a style=" text-align: left; padding: 0.5rem 0; font-size: 1rem; font-weight: normal;"
                                        class="btn" href="{{ route('logout') }}">ログアウト</a>
                                </div>
                            </div>

                            <div style="margin: 20px 0px;">
                                <div class="one-block">
                                    <a href="{{ route('mypage') }}" class="btn-toggle-login"
                                        style="border-radius: 10px;border: 1px solid #333333;color: #333333;text-align: center;
                                        padding: 12px 0px;
                                        ">{{ __('My Page') }}</a>
                                </div>
                            </div>

                            <div style="margin: 20px 0px;">
                                <div>
                                    <a href="{{ route('mypage.profile') }}"
                                        style="background: linear-gradient(90deg, #EF0505, #E38300);
                                text-align: center;
                                border-radius: 10px;
                                border: none;
                                color:#fff;
                                padding: 12px 0;
                                ">
                                        情報を編集する
                                        {{-- {{ __('Upload Product') }} --}}
                                    </a>
                                </div>
                            </div>
                        @else
                            {{-- <div><a href="{{ route('message') }}" class="btn-toggle-upload">メッセージ一覧へ</a></div>
                            <div><a href="{{ route('mypage') }}" class="btn-toggle-upload">マイページ</a></div> --}}

                            {{-- <div style="color: #000; margin: 10px;">
                                <a style=" text-align: left; padding: 0.5rem 0; font-size: 1rem; font-weight: normal;"
                                    class="btn" href="{{ route('mypage') }}" class="btn-toggle-upload">マイページ</a>
                            </div> --}}

                            <div style="color: #000; margin: 10px;">
                                <a style=" text-align: left; padding: 0.5rem 0; font-size: 1rem; font-weight: normal;"
                                    class="btn" href="{{ route('message') }}" class="btn-toggle-upload">メッセージ一覧</a>
                            </div>

                            <div style="color: #000; margin: 10px;">
                                <a style=" text-align: left; padding: 0.5rem 0; font-size: 1rem; font-weight: normal;"
                                    class="btn" href="{{ route('mypage.favorite') }}">お気に入り一覧</a>
                            </div>

                            <div style="color: #000; margin: 10px;">
                                <a style=" text-align: left; padding: 0.5rem 0; font-size: 1rem; font-weight: normal;"
                                    class="btn" href="{{ route('contact') }}"
                                    class="footer-sp-btn footer-sp-contact-btn">お問い合わせ<span
                                        class="right-arrow-icon"></span></a>
                            </div>

                            <div style="color: #000; margin: 10px;">
                                <a style=" text-align: left; padding: 0.5rem 0; font-size: 1rem; font-weight: normal;"
                                    class="btn" href="{{ route('logout') }}">ログアウト</a>
                            </div>

                            <div style="margin: 20px 0px;">
                                <div class="one-block">
                                    <a href="{{ route('mypage') }}" class="btn-toggle-login"
                                        style="border-radius: 10px;border: 1px solid #333333;color: #333333;text-align: center;
                                        padding: 12px 0px;
                                        ">{{ __('My Page') }}</a>
                                </div>
                            </div>

                            <div style="margin: 20px 0px;">
                                <div>
                                    <a href="{{ route('mypage.profile') }}"
                                        style="background: linear-gradient(90deg, #EF0505, #E38300);
                                text-align: center;
                                border-radius: 10px;
                                border: none;
                                color:#fff;
                                padding: 12px 0;
                                ">
                                        情報を編集する
                                        {{-- {{ __('Upload Product') }} --}}
                                    </a>
                                </div>
                            </div>
                        @endif
                        {{-- <div><a href="{{ route('mypage.buy_point') }}"
                                class="btn-toggle-point">{{ __('Purchase Point') }}</a></div> --}}
                    </div>

                    {{-- <div class="category-container">
                        <label><a href="{{ route('category') }}">{{ __('Category') }}</a></label>
                        <accordion contents="{{ json_encode($dspCategories) }}" multiple="multiple"></accordion>

                        <label><a href="{{ route('tag') }}">{{ __('Keyword') }}</a></label>
                        <accordion contents="{{ json_encode($dspKeywords) }}"></accordion>
                    </div> --}}
                </div>
            </div>
        </div>

        <main>
            <div class="container-lg mypage-container">
                <div class="">
                    @if (session('success'))
                        <div class="alert alert-info" role="alert">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                    @endif

                    <mypage-breadcrumb breadcrumbs="{{ json_encode($breadcrumbs) }}"></mypage-breadcrumb>

                    <h2 class="mypage-title">{{ $pageTitle }}</h2>
                </div>

                <div id="mypage-layout">
                    <div id="mypage-side">
                        <div class="mypage-sidebar">
                            @if (Auth::user()->status == 3)
                                @if (Auth::user() && Auth::user()->role == 'influencer')
                                <div class="mypage-sidebar-title">取引管理</div>
                                <div class="mypage-sidebar-container">
                                    <div class="mypage-sidebar-item">
                                        <a href="{{ route('item') }}">案件一覧</a>
                                    </div>
                                    <div class="mypage-sidebar-item">
                                        <a href="{{ route('mypage.favorite', ['type' => 'item']) }}">お気に入り</a>
                                    </div>
                                    <div class="mypage-sidebar-item">
                                        <a href="{{ route('mypage.item_mine') }}">応募した案件一覧</a>
                                    </div>
                                </div>
                                @else
                                <div class="mypage-sidebar-title">案件管理</div>
                                <div class="mypage-sidebar-container">
                                    <div class="mypage-sidebar-item">
                                        <a href="{{ route('mypage.item') }}">新規案件登録</a>
                                    </div>
                                    <div class="mypage-sidebar-item">
                                        <a href="{{ route('mypage.item_mine') }}">自社案件一覧</a>
                                    </div>
                                    <div class="mypage-sidebar-item">
                                        <a href="{{ route('item') }}">案件一覧</a>
                                    </div>
                                    <div class="mypage-sidebar-item">
                                        <a href="{{ route('mypage.favorite', ['type' => 'item']) }}">お気に入り</a>
                                    </div>
                                </div>
                                @endif
                                @if (Auth::user() && Auth::user()->role == 'influencer')
                                <div class="mypage-sidebar-title">その他</div>
                                @else
                                <div class="mypage-sidebar-title">人材&企業管理</div>
                                @endif
                                <div class="mypage-sidebar-container">
                                    <div class="mypage-sidebar-item">
                                        <a href="{{ route('user') }}">インフルエンサー一覧</a>
                                    </div>
                                    <div class="mypage-sidebar-item">
                                        <a href="{{ route('user.follow') }}">お気に入り一覧</a>
                                    </div>
                                </div>

                                <div class="mypage-sidebar-title">メッセージ</div>
                                <div class="mypage-sidebar-container">
                                    <div class="mypage-sidebar-item">
                                        <a href="{{ route('message') }}">メッセージ一覧</a>
                                    </div>
                                </div>

                                <div class="mypage-sidebar-title">登録情報</div>
                                <div class="mypage-sidebar-container">
                                    <div class="mypage-sidebar-item"><a
                                            href="{{ route('mypage.profile') }}">登録情報を変更</a></div>
                                    {{-- <div class="mypage-sidebar-item"><a
                                            href="{{ route('mypage.notice_mail') }}">メール通知設定</a></div> --}}
                                    {{-- <div class="mypage-sidebar-item"><a
                                            href="{{ route('mypage.follow') }}">フォロー一覧</a>
                                    </div> --}}
                                    {{-- <div class="mypage-sidebar-item"><a
                                            href="{{ route('mypage.follower') }}">フォロワー一覧</a></div> --}}
                                    <div class="mypage-sidebar-item"><a href="{{ route('logout') }}">ログアウト</a></div>
                                </div>
                                
                            @elseif(Auth::user()->status == 2 || Auth::user()->status == 4 || Auth::user()->status == 5)
                                <div class="mypage-sidebar-title">マイページ</div>
                                <div class="mypage-sidebar-container">
                                    <div class="mypage-sidebar-item"><a href="{{ route('mypage') }}">マイページ</a></div>
                                    <div class="mypage-sidebar-item"><a href="{{ route('logout') }}">ログアウト</a></div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div id="mypage-main">
                        @yield('content')
                    </div>
                </div>
            </div>

        </main>
        <footer>
            <div class="footer-pc">
                {{-- <div class="footer-seller-container">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="footer-seller-title">JOIN SELLER</h2>
                                <p class="footer-seller-introduction">{{ __('Footer Seller Introduction') }}</p>
                            </div>
                            <div class="col-md-6">
                                @if (Auth::user() && Auth::user()->type == 0)
                                    <a href="{{ route('mypage.item') }}"
                                        class="footer-seller-upload">{{ __('Upload Product') }}<span
                                            class="right-arrow-icon"></span></a>
                                @else
                                    <a href="{{ route('message') }}" class="footer-seller-upload">メッセージ一覧へ<span
                                            class="right-arrow-icon"></span></a>
                                @endif
                                <a href="{{ route('guide.sale') }}"
                                    class="footer-seller-guide">{{ __('See Seller Guide') }}</a>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="footer-service-container">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-12 footer-service-block">
                                <h2 class="footer-service-title">SERVICE GUIDE</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><a href="{{ route('guide.buy') }}">受注者/求職者向けガイド</a></p>
                                        <p><a href="{{ route('guide.sale') }}">企業向け（発注/採用）ガイド</a></p>
                                        <p><a href="{{ route('faq') }}">よくある質問</a></p>
                                        <p><a href="{{ route('notification') }}">運営からお知らせ</a></p>
                                    </div>

                                    <div class="col-md-6">
                                        <p><a href="{{ route('register') }}">新規会員登録</a></p>
                                        <p><a href="{{ route('login') }}">ログイン</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-4 col-sm-12  footer-service-block">
                                <h2 class="footer-service-title">{{ config('app.name', 'Laravel') }}</h2>
                                <p>運営会社：株式会社〇〇〇〇</p>
                                {{-- <p>〒153-0061 東京都目黒区中目黒１丁目９−２２</p> --}}
                                {{-- <?php echo $snsHtml; ?> --}}
                            </div>
                            <div class="col-xl-3 col-lg-12  footer-service-block footer-service-block-contact">
                                <h2 class="footer-service-title">CONTACT</h2>
                                <p>お気軽にお問い合わせください</p>
                                <a href="{{ route('contact') }}" class="footer-service-contact">お問い合わせフォーム<span
                                        class="right-arrow-icon"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-info-container">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="footer-info-links">
                                    {{-- <a href="{{ route('law') }}">特定商法取引に基づく表記</a> --}}
                                    <a href="{{ route('privacy') }}">個人情報保護について</a>
                                    <a href="{{ route('about') }}">運営会社</a>
                                    <a href="{{ route('contact') }}">お問い合わせ</a>
                                </div>
                                <div class="footer-info-desc">
                                    {{-- <a href="{{ route('top') }}" class="footer-info-logo"><img
                                            src="{{ asset('images/icons/logo_footer.svg') }}" /></a> --}}
                                    <span class="footer-info-introduction">Copyright (C) BizBASE All Rights
                                        Reserved.</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="footer-info-ssl">
                                    <img src="{{ url('/images/icons/ssl.svg') }}" />
                                    <span>当サイトはお客様の個人情報を守るためSSL暗号化通信を使用しています</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="footer-sp">
                {{-- <div class="footer-sp-seller-container">
                    <h2 class="footer-sp-title">ABOUT SELLER</h2>
                    <p class="footer-sp-info">出品されたい方はこちらからどうぞ</p>
                    @if (Auth::user() && Auth::user()->type == 0)
                        <a href="{{ route('mypage.item') }}"
                            class="footer-sp-btn footer-sp-seller-btn">{{ __('Upload Product') }}<span
                                class="right-arrow-icon"></span></a>
                    @else
                        <a href="{{ route('message') }}" class="footer-sp-btn footer-sp-seller-btn">メッセージ一覧へ<span
                                class="right-arrow-icon"></span></a>
                    @endif
                    <a href="{{ route('guide.sale') }}"
                        class="footer-sp-btn footer-sp-seller-btn">{{ __('See Seller Guide') }}<span
                            class="right-arrow-icon"></span></a>
                </div> --}}

                <div class="footer-sp-contact">
                    <h2 class="footer-sp-title">CONTACT</h2>
                    <p class="footer-sp-info">気軽にお問い合わせください。</p>
                    <a href="{{ route('contact') }}" class="footer-sp-btn footer-sp-contact-btn">お問い合わせ<span
                            class="right-arrow-icon"></span></a>
                </div>

                <div class="footer-sp-service">
                    <h3>SERVICE GUIDE</h3>
                    <a href="{{ route('notification') }}" class="footer-sp-link">運営からのお知らせ<span
                            class="right-arrow-icon"></span></a>
                    <a href="{{ route('guide.buy') }}" class="footer-sp-link">受注者/求職者向けガイド<span
                            class="right-arrow-icon"></span></a>
                    <a href="{{ route('guide.sale') }}" class="footer-sp-link">企業向け（発注/採用）ガイド<span
                            class="right-arrow-icon"></span></a>
                    <a href="{{ route('faq') }}" class="footer-sp-link">よくある質問<span
                            class="right-arrow-icon"></span></a>
                    {{-- <a href="{{ route('law') }}" class="footer-sp-link">特定商法取引に基づく表記<span
                            class="right-arrow-icon"></span></a> --}}
                    <a href="{{ route('privacy') }}" class="footer-sp-link">個人情報保護について<span
                            class="right-arrow-icon"></span></a>
                    <a href="{{ route('about') }}" class="footer-sp-link">運営会社<span
                            class="right-arrow-icon"></span></a>
                </div>

                <div class="footer-sp-ssl">
                    <div class="footer-sp-ssl-img-container">
                        <img src="{{ url('/images/icons/sp_ssl.svg') }}" />
                    </div>

                    <div class="footer-sp-ssl-text-container">
                        当サイトはEncryptにより認証されています。
                        情報送信は暗号化により保護されています。
                    </div>

                    <sp-to-top></sp-to-top>
                </div>

                <div class="footer-sp-logo">
                    {{-- <h2 class="footer-sp-logo-title"><img src="/images/icons/logo_footer.svg" /></h2> --}}
                    <p class="footer-sp-logo-info">Copyright (C) BizBASE All Rights Reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>

{{-- <script src="https://cdn.jsdelivr.net/npm/vue2-datepicker@1.9.7/dist/build.min.js"></script> --}}
{{-- <script src="https://momentjs.com/downloads/moment.js"></script> --}}

<script src="https://yubinbango.github.io/yubinbango-core/yubinbango-core.js" charset="UTF-8"></script>
<script src="https://unpkg.com/vue-upload-multiple-image@1.1.6/dist/vue-upload-multiple-image.js"></script>
<script src="https://widget.univapay.com/client/checkout.js"></script>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>

<script src="{{ asset('js/credit-widget.univapay.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

@yield('scripts')

</html>