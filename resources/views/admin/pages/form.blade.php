@extends('layouts.admin')

@section('title', isset($page) ? 'Edit Page' : 'Create Page')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-file-text me-2" style="color: var(--primary);"></i>{{ isset($page) ? 'Edit Page' : 'Create Page' }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">Pages</a></li>
                <li class="breadcrumb-item active">{{ isset($page) ? 'Edit' : 'Create' }}</li>
            </ol>
        </nav>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<form action="{{ isset($page) ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($page)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Page Content</div>
                <div class="card-body">
                    <div class="mb-3"><label class="form-label">Title <span class="text-danger">*</span></label><input type="text" name="title" class="form-control" value="{{ old('title', $page->title ?? '') }}" required></div>
                    <div class="mb-3"><label class="form-label">Slug</label><input type="text" name="slug" class="form-control" value="{{ old('slug', $page->slug ?? '') }}" placeholder="Auto-generated"></div>
                    <div class="mb-3"><label class="form-label">Excerpt</label><textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $page->excerpt ?? '') }}</textarea></div>
                    <div class="mb-3"><label class="form-label">Content <span class="text-danger">*</span></label><textarea name="content" class="form-control" rows="12" required>{{ old('content', $page->content ?? '') }}</textarea></div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">SEO</div>
                <div class="card-body">
                    <div class="mb-3"><label class="form-label">Meta Title</label><input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $page->meta_title ?? '') }}"></div>
                    <div class="mb-3"><label class="form-label">Meta Description</label><textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $page->meta_description ?? '') }}</textarea></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Settings</div>
                <div class="card-body">
                    <div class="mb-3"><label class="form-label">Featured Image</label>@if(isset($page) && $page->featured_image)<div class="mb-2"><img src="{{ storage_url($page->featured_image) }}" alt="" class="rounded" width="100%"></div>@endif<input type="file" name="featured_image" class="form-control" accept="image/*"></div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="status" class="form-check-input" value="published" id="status" {{ old('status', $page->status ?? 'draft') == 'published' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Published</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card"><div class="card-body"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> {{ isset($page) ? 'Update Page' : 'Create Page' }}</button><a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a></div></div>
        </div>
    </div>
</form>
@endsection