@extends('layouts.frontend')

@section('title', 'Travel Blog - Travels & Tours')
@section('meta_description', 'Read our latest travel stories, tips, and guides.')
@section('meta_keywords', 'travel blog, travel stories, travel tips, travel guides')

@section('content')

<section class="blog-hero">
    <div class="container">
        <h1 class="display-5 fw-bold text-white mb-2">Travel Blog</h1>
        <p class="lead text-white-50 mb-0">Stories, tips, and guides from our travel experts</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-9">
                @if($blogs->count() > 0)
                    <div class="row g-4">
                        @foreach($blogs as $blog)
                            <div class="col-md-6">
                                @component('components.blog-card', ['blog' => $blog])
                                @endcomponent
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $blogs->links('components.pagination', ['paginator' => $blogs]) }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-journal-text fs-1 text-muted mb-3 d-block"></i>
                        <h5 class="fw-bold">No Blog Posts Yet</h5>
                        <p class="text-muted">Check back soon for new travel stories and guides.</p>
                    </div>
                @endif
            </div>

            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-header bg-white py-3 fw-semibold rounded-4 rounded-bottom-0">
                        <i class="bi bi-filter me-2"></i>Categories
                    </div>
                    <div class="card-body p-3">
                        @php $categories = \App\Models\BlogCategory::where('status', true)->get(); @endphp
                        @if($categories->count() > 0)
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('blog.index') }}" class="category-badge {{ !request('category') ? 'active' : '' }}">All</a>
                                @foreach($categories as $cat)
                                    <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                                       class="category-badge {{ request('category') == $cat->slug ? 'active' : '' }}"
                                       style="{{ request('category') == $cat->slug ? '' : 'background: #e9ecef; color: #495057;' }}">
                                        {{ $cat->name }}
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted small mb-0">No categories available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
