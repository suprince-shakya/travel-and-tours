@extends('layouts.frontend')

@section('title', ($page->meta_title ?? $page->title) . ' - Travels & Tours')
@section('meta_description', $page->meta_description ?? $page->excerpt)
@section('meta_keywords', $page->meta_keywords ?? '')

@section('content')

<section class="page-hero">
    <div class="container">
        @component('components.breadcrumb', ['items' => [
            ['label' => $page->title]
        ]])
        @endcomponent
        <h1 class="display-5 fw-bold text-white mb-2">{{ $page->title }}</h1>
        @if($page->excerpt)
            <p class="lead text-white-50 mb-0">{{ $page->excerpt }}</p>
        @endif
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-content">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
