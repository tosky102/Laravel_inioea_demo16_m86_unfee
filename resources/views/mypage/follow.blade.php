@extends('layouts.mypage')

@section('content')
    <div class="row mypage_row">
        <div class="col-md-12">
            <!--<div class="login-title">お気に入り一覧</div>-->

            <div class="favorite-list-container">
                <div class="list-page-content">
                    <div class="product-items-container">
                        @foreach ($follows as $follow)
                            <user-item :user="{{ json_encode($follow) }}" type="favorite"></user-item>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-12">

                <div class="card">
                    <div class="card-header">フォロー一覧</div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center th-header">{{ __('FollowId') }}</th>
                                    <th scope="col" class="text-center th-header">{{ __('FollowName') }}</th>
                                    <th scope="col" class="text-center th-header">{{ __('FollowImage') }}</th>
                                    <th scope="col" class="text-center th-header">{{ __('FollowDelete') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(count($follows) > 0)
                                    @foreach($follows as $follow)
                                        <tr>
                                            <td class="text-center">{{ $follow->id }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('user.show', ['id' => $follow->id]) }}">
                                                    {{ $follow->nickname }}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <img src="{{ $follow->image_url }}" />
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('mypage.follow_del', ['id' => $follow->id]) }}">削除</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <th colspan="4" class="text-center">情報がありません。</th>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            {{ $follows->links('vendor.pagination.custom') }}

                        </div>



                    </div>
                </div>

        </div> --}}
    </div>
@endsection