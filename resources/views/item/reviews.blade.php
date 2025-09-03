@extends('layouts.app')

@section('content')
    <div style="padding-bottom: 40px">
        <product-reviews breadcrumbs="{{ json_encode($breadcrumbs) }}" product="{{ json_encode($product) }}" reviews="{{ json_encode($reviews) }}"></product-reviews>

        {{ $objReviews->links('vendor.pagination.front') }}
    </div>
@endsection