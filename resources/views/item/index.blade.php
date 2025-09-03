@extends('layouts.app')

@section('content')
    <div id="page-container">
        {{-- <div id="side">
            <side-bar auth="{{Auth::user()}}"></side-bar>
        </div> --}}

        <div id="main">
            <div class="list-page-container">
                <product-list breadcrumbs="{{ json_encode($breadcrumbs) }}" title="{{ $title }}"
                    contents="{{ json_encode($products) }}" configs="{{ json_encode($configs) }}"></product-list>

                {{ $objItems->links('vendor.pagination.front') }}

                <to-top></to-top>
            </div>


        </div>

    </div>
@endsection
