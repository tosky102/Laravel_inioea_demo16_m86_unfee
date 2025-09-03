@extends('layouts.mypage')

@section('content')
    <div class="row mypage_row">
        <div class="col-md-12">
            <!--<div class="login-title">お気に入り一覧</div>--!>

            <div class="favorite-list-container">
                <div class="list-page-content">
                    <div class="product-items-container">
                        @foreach ($favorites as $favorite)
                            <product-item :item="{{ json_encode($favorite) }}" type="favorite"></product-item>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection