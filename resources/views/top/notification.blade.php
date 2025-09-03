@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="l-main">
                    <h2 class="tos-title">運営からお知らせ</h2>
                    <div class="l-tos-container">
                        @if(count($notifications) > 0)
                        @foreach($notifications as $notification)
                            <h4>
                                {{ $notification->title }}
                                <span class="date">{{ date('Y-m-d', strtotime($notification->created_at)) }}</span>
                            </h4>
                            <p><?php echo nl2br($notification->comment) ?></p>
                        @endforeach
                        @else
                            <h4>情報がありません。</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
