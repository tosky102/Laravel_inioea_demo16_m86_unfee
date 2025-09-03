@extends('layouts.mypage')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12">

                <div class="card">
                    <div class="card-header">フォロワー一覧</div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center th-header">{{ __('FollowId') }}</th>
                                    <th scope="col" class="text-center th-header">{{ __('FollowName') }}</th>
                                    <th scope="col" class="text-center th-header">{{ __('FollowImage') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(count($followers) > 0)
                                    @foreach($followers as $follower)
                                        <tr>
                                            <td class="text-center">{{ $follower->id }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('user.show', ['id' => $follower->id]) }}">
                                                    {{ $follower->nickname }}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <img src="{{ $follower->image_url }}" />
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <th colspan="3" class="text-center">情報がありません。</th>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            {{ $followers->links('vendor.pagination.custom') }}

                        </div>



                    </div>
                </div>

        </div>

    </div>
@endsection
