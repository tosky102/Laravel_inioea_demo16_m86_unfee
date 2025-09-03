@extends('layouts.app')

@section('content')
    <div id="page-container">
        <div id="side">
            <side-bar categories="{{ json_encode($dspCategories) }}" keywords="{{ json_encode($dspKeywords) }}"></side-bar>
        </div>

        <div id="main">
            <div class="list-page-container">
                <category-list breadcrumbs="{{ json_encode($breadcrumbs) }}" title="{{ $title }}" contents="{{ json_encode($contents) }}"></category-list>

                <to-top></to-top>
            </div>

        </div>

    </div>
@endsection
