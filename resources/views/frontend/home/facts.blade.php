@extends('frontend.layouts.app')
@section('head')
<x-meta current-page-id="home" />
@endsection
@section('content')
@php
$fact = \App\Pharmalys\BlockQuery::init('home')->typeOf('facts');
@endphp

@if($fact)
<div class=" bg-blue pt-90 pb-70">
    <div class="container-fluid pb-70">
        <div class="row">
            <div class="col-12">
                <h3 class="v-heading text-white ps-lg-3">{{ $fact->getTitle() }}</h3>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row v-nav facts-slider-active">

            @foreach($fact->getContents() as $content)
            <div class="col-md-6">
                <div @class([
                    'v-count-box',
                    'v-count-box-before' => !$loop->first && !$loop->last,
                    'v-count-box-after-none pt-md-4' => $loop->last,
                ])>
                    <h6>{{ get_content_field($content, 'title') }}</h6>
                    <h3>{{ get_content_field($content, 'count') }}</h3>
                    <p class="text-white v-body">{{ get_content_field($content, 'details') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection