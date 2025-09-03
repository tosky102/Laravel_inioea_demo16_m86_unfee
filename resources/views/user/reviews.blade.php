@extends('layouts.app')

@section('content')
    <div style="padding-bottom: 40px">
        <user-reviews breadcrumbs="{{ json_encode($breadcrumbs) }}" user="{{ json_encode($user) }}" reviews="{{ json_encode($reviews) }}"></user-reviews>

        {{ $objReviews->links('vendor.pagination.front') }}
    </div>
@endsection