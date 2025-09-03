@extends('layouts.app')

@section('content')
    <product-detail breadcrumbs="{{ json_encode($breadcrumbs) }}" user="{{ json_encode($user) }}" product="{{ json_encode($product) }}" relationproducts="{{ json_encode($relationProducts) }}" csrf="{{ csrf_token() }}"></product-detail>
@endsection
