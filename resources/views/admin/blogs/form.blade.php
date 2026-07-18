@extends('layouts.admin')

@section('title', isset($post) ? 'Edit Post' : 'Create Post')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-newspaper me-2" style="color: var(--primary);"></i>{{ isset($post) ? 'Edit Post' : 'Create Post' }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blog</a></li>
                <li class="breadcrumb-item active">{{ isset($post) ? 'Edit' : 'Create' }}</li>
            </ol>
        </nav>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<form action="{{ isset($post) ? route('admin.blogs.update', $post->id) : route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($post)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Content</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $post->title ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug ?? '') }}" placeholder="Auto-generated">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">Uncategorized</option>
                            @foreach($categories ?? [] as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Excerpt</label>
                        <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control" rows="12" required>{{ old('content', $post->content ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tags</label>
                        <input type="text" name="tags" class="form-control" value="{{ old('tags', is_array($post->tags ?? '') ? implode(', ', $post->tags) : ($post->tags ?? '')) }}" placeholder="Comma separated">
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">SEO</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $post->meta_title ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Settings</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Featured Image</label>
                        @if(isset($post) && $post->featured_image)
                            <div class="mb-2"><img src="{{ storage_url($post->featured_image) }}" alt="" class="rounded" width="100%"></div>
                        @endif
                        <input type="file" name="featured_image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Publish Date</label>
                        <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="status" class="form-check-input" value="1" id="status" {{ old('status', $post->status ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Published</label>
                        </div>
                        <div class="form-check form-switch mt-2">
                            <input type="checkbox" name="featured" class="form-check-input" value="1" id="featured" {{ old('featured', $post->featured ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">Featured</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> {{ isset($post) ? 'Update Post' : 'Create Post' }}</button>
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection