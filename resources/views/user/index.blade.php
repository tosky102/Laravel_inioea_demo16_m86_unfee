@extends('layouts.app')

@section('content')
    <div id="page-container">
        <div id="main">
            <div class="list-page-container">
                <user-list breadcrumbs="{{ json_encode($breadcrumbs) }}" title="{{ $title }}" contents="{{ json_encode($users) }}" configs="{{ json_encode($configs) }}"></user-list>

                {{ $objUsers->links('vendor.pagination.front') }}

                <to-top></to-top>
            </div>


        </div>

    </div>
@endsection
