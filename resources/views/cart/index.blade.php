@extends('layouts.app')

@section('content')
    <cart-list title="{{ $title }}" breadcrumbs="{{ json_encode($breadcrumbs) }}" mode="{{ $mode }}" relationproducts="{{ json_encode($relationProducts) }}" sellerproducts="{{ json_encode($sellerProducts) }}" lastbrowseproducts="{{ json_encode($lastBrowseProducts) }}" items="{{ json_encode($items) }}" cartVars="{{ json_encode($cartVars) }}"></cart-list>
@endsection
