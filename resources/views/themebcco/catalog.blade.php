@extends('themes::themebcco.layout')

@php
    $years = Cache::remember('all_years', \Backpack\Settings\app\Models\Setting::get('site_cache_ttl', 5 * 60), function () {
        return \Ophim\Core\Models\Movie::select('publish_year')
            ->distinct()
            ->pluck('publish_year')
            ->sortDesc();
    });
@endphp

@push('header')
    <link href="{{ asset('/themes/bcco/css/catalog.css') }}" rel="stylesheet">
@endpush

@section('breadcrumb')
@endsection

@section('content')
    @include('themes::themebcco.inc.catalog_filter')
    <div class="playlist-wrapper playlist-list border-container mt-3 mb-5 p0">
        <div class="row title-wrapper">
            <div class="col-sm-12">
                <h1 class="title">{{ $section_name }}</h1>
            </div>
        </div>
        <div id="all-items" class="row">
            @foreach ($data as $movie)
                @include('themes::themebcco.inc.movie_card')
            @endforeach
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $data->appends(request()->all())->links('themes::themebcco.inc.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection
