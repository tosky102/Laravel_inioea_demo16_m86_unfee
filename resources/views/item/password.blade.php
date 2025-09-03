@extends('layouts.app')

@section('content')
    <product-password breadcrumbs="{{ json_encode($breadcrumbs) }}" product="{{ json_encode($product) }}" relationproducts="{{ json_encode($relationProducts) }}" sellerproducts="{{ json_encode($sellerProducts) }}" lastbrowseproducts="{{ json_encode($lastBrowseProducts) }}"></product-password>
@endsection
