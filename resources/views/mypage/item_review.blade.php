@extends('layouts.mypage')

@section('content')

    <div class="row mypage_row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">レビュー一覧</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mypage-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('ItemReviewComment') }}</th>
                                <th scope="col">{{ __('ItemReviewRating') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(count($reviews) > 0)
                                @foreach($reviews as $review)
                                <tr>
                                    <td>{{ $review->comment }}</th>
                                    <td>{{ $review->rating }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <th colspan="2" class="text-center">情報がありません。</th>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
