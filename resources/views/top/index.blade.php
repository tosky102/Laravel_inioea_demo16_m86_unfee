@extends('layouts.app')

@section('content')
    <div id="page-container">
        {{-- <div id="side">
            <side-bar auth="{{ Auth::user() }}"></side-bar>
        </div> --}}

        <div id="main">
            <div class="top-page-container">
                <div class="top-slider">
                    <slider settings="{{ json_encode($topSlider['settings']) }}"
                        contents="{{ json_encode($topSlider['contents']) }}" type="top_slider"></slider>
                </div>

                {{-- <div style="padding: 40px 60px;">
                    <a href="{{ route('guide.buy') }}">
                        <img style="width: 100%;" src="/images/sliders/FOODSTEPの使い方.png" alt="">
                    </a>
                </div> --}}

                {{-- <div style="text-align: center; text-align: center; margin: 15px; margin-top:15px;">
                    <a href="/guide/buy">
                        <img class="top-slider-img" src="/images/sliders/FOODStepの使い方.png"
                            style="height: 100px;border-radius:15px;">
                    </a>
                </div> --}}

                @guest
                    {{-- <div class="top-nav-buttons-container">
                        <a class="top-nav-button top-btn-my-page" href="{{ route('login') }}">
                            {{ __('Login') }}
                        </a>
                        <a class="top-nav-button top-btn-job-seekers" href="{{ route('register_terms') }}">
                            {{ __('Full Register') }}
                        </a>
                    </div> --}}
                @else
                    {{-- <div class="top-nav-buttons-container">
                        <a class="top-nav-button top-btn-job-seekers" href="{{ route('item') . '?order=new&type=1' }}">
                            発注案件一覧はこちら
                        </a>
                        <a class="top-nav-button top-btn-my-page" href="{{ route('mypage') }}">
                            {{ __('My Page') }}
                        </a>
                    </div> --}}
                    {{-- @if (Auth::user() && Auth::user()->role == 'influencer')
                    @else
                        <div class="top-nav-buttons-container">
                            <a class="top-nav-button top-btn-job-seekers" href="{{ route('item') . '?order=new&type=0' }}">
                                店舗一覧はこちら
                            </a>
                            <a class="top-nav-button top-btn-my-page" href="{{ route('mypage') }}">
                                {{ __('My Page') }}
                            </a>
                        </div>
                    @endif --}}
                @endguest

                <div class="section-item slider-item">
                    <h2 class="text-left">発注案件一覧
                        <span class="section-item-link">
                            <a href="{{ route('item') . '?order=new' }}">すべての案件を見る</a>
                        </span>
                    </h2>
                    <div class="list-page-wrapper">
                        <div class="list-page-content">
                            <div class="product-items-container">
                                @foreach ($newProductSlider['contents'] as $item)
                                    <product-item :item="{{ json_encode($item) }}"></product-item>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- <product-list breadcrumbs="{{ json_encode($breadcrumbs) }}" title="{{ $title }}"
                            contents="{{ json_encode($products) }}" configs="{{ json_encode($configs) }}" type="item"></product-list>
            
                            {{ $objItems->links('vendor.pagination.front') }} --}}
                </div>
                {{-- @if (Auth::user() && Auth::user()->role == 'influencer')
                    <div class="section-item slider-item">
                        <h2>おすすめ求職者一覧<span class="section-item-link"><a
                                    href="{{ route('item') . '?order=new&type=1' }}">もっと見る</a></span></h2>
                        <slider settings="{{ json_encode($newUsersSlider['settings']) }}"
                            contents="{{ json_encode($newUsersSlider['contents']) }}" type="product_slider"></slider>
                    </div>
                @else
                @endif --}}

                <to-top></to-top>
            </div>

        </div>

    </div>
@endsection
