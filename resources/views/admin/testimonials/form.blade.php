@extends('layouts.admin')

@section('title', isset($testimonial) ? 'Edit Testimonial' : 'Create Testimonial')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-chat-quote me-2" style="color: var(--primary);"></i>{{ isset($testimonial) ? 'Edit Testimonial' : 'Create Testimonial' }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.testimonials.index') }}">Testimonials</a></li><li class="breadcrumb-item active">{{ isset($testimonial) ? 'Edit' : 'Create' }}</li></ol>
        </nav>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<form action="{{ isset($testimonial) ? route('admin.testimonials.update', $testimonial->id) : route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($testimonial)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Testimonial Details</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name', $testimonial->name ?? '') }}" required></div>
                        <div class="col-md-6"><label class="form-label">Designation</label><input type="text" name="designation" class="form-control" value="{{ old('designation', $testimonial->designation ?? '') }}"></div>
                        <div class="col-md-6"><label class="form-label">Company</label><input type="text" name="company" class="form-control" value="{{ old('company', $testimonial->company ?? '') }}"></div>
                        <div class="col-md-6"><label class="form-label">Rating</label><select name="rating" class="form-select"><option value="5" {{ old('rating', $testimonial->rating ?? '5') == '5' ? 'selected' : '' }}>5 Stars</option><option value="4" {{ old('rating', $testimonial->rating ?? '') == '4' ? 'selected' : '' }}>4 Stars</option><option value="3" {{ old('rating', $testimonial->rating ?? '') == '3' ? 'selected' : '' }}>3 Stars</option><option value="2" {{ old('rating', $testimonial->rating ?? '') == '2' ? 'selected' : '' }}>2 Stars</option><option value="1" {{ old('rating', $testimonial->rating ?? '') == '1' ? 'selected' : '' }}>1 Star</option></select></div>
                        <div class="col-12"><label class="form-label">Content <span class="text-danger">*</span></label><textarea name="content" class="form-control" rows="4" required>{{ old('content', $testimonial->content ?? '') }}</textarea></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Photo & Status</div>
                <div class="card-body">
                    <div class="mb-3"><label class="form-label">Photo</label>@if(isset($testimonial) && $testimonial->photo)<div class="mb-2"><img src="{{ storage_url($testimonial->photo) }}" alt="" class="rounded-circle" width="80" height="80" style="object-fit:cover;"></div>@endif<input type="file" name="photo" class="form-control" accept="image/*"></div>
                    <div class="mb-3"><div class="form-check form-switch"><input type="checkbox" name="status" class="form-check-input" value="1" id="status" {{ old('status', $testimonial->status ?? true) ? 'checked' : '' }}><label class="form-check-label" for="status">Active</label></div></div>
                </div>
            </div>
            <div class="card"><div class="card-body"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> {{ isset($testimonial) ? 'Update' : 'Create' }} Testimonial</button><a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a></div></div>
        </div>
    </div>
</form>
@endsection