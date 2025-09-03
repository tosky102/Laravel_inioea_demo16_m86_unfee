@extends('layouts.app')

@section('content')
    <user-detail breadcrumbs="{{ json_encode($breadcrumbs) }}" user="{{ json_encode($user) }}" relationusers="{{ json_encode($relationUsers) }}"></user-detail>
@endsection
