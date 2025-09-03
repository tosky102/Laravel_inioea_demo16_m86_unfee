@extends('layouts.app')

@section('content')
    <partner-detail breadcrumbs="{{ json_encode($breadcrumbs) }}" user="{{ json_encode($user) }}" relationproducts="{{ json_encode($relationProducts) }}"></partner-detail>
@endsection
