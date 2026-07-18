@extends('layouts.admin')

@section('title', isset($category) ? 'Edit Blog Category' : 'Create Blog Category')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-bookmark me-2" style="color: var(--primary);"></i>{{ isset($category) ? 'Edit Blog Category' : 'Create Blog Category' }}</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.blog-categories.index') }}">Blog Categories</a></li><li class="breadcrumb-item active">{{ isset($category) ? 'Edit' : 'Create' }}</li></ol></nav></div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<form action="{{ isset($category) ? route('admin.blog-categories.update', $category->id) : route('admin.blog-categories.store') }}" method="POST">
    @csrf
    @if(isset($category)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Category Details</div>
                <div class="card-body">
                    <div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required></div>
                    <div class="mb-3"><label class="form-label">Slug</label><input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug ?? '') }}" placeholder="Auto-generated"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Status</div>
                <div class="card-body">
                    <div class="form-check form-switch"><input type="checkbox" name="status" class="form-check-input" value="1" id="status" {{ old('status', $category->status ?? true) ? 'checked' : '' }}><label class="form-check-label" for="status">Active</label></div>
                </div>
            </div>
            <div class="card"><div class="card-body"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> {{ isset($category) ? 'Update' : 'Create' }} Category</button><a href="{{ route('admin.blog-categories.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a></div></div>
        </div>
    </div>
</form>
@endsection