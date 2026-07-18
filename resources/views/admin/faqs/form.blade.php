@extends('layouts.admin')

@section('title', isset($faq) ? 'Edit FAQ' : 'Create FAQ')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-question-circle me-2" style="color: var(--primary);"></i>{{ isset($faq) ? 'Edit FAQ' : 'Create FAQ' }}</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.faqs.index') }}">FAQs</a></li><li class="breadcrumb-item active">{{ isset($faq) ? 'Edit' : 'Create' }}</li></ol></nav>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<form action="{{ isset($faq) ? route('admin.faqs.update', $faq->id) : route('admin.faqs.store') }}" method="POST">
    @csrf
    @if(isset($faq)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">FAQ Details</div>
                <div class="card-body">
                    <div class="mb-3"><label class="form-label">Category</label><input type="text" name="category" class="form-control" value="{{ old('category', $faq->category ?? 'General') }}"></div>
                    <div class="mb-3"><label class="form-label">Question <span class="text-danger">*</span></label><textarea name="question" class="form-control" rows="2" required>{{ old('question', $faq->question ?? '') }}</textarea></div>
                    <div class="mb-3"><label class="form-label">Answer <span class="text-danger">*</span></label><textarea name="answer" class="form-control" rows="5" required>{{ old('answer', $faq->answer ?? '') }}</textarea></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Settings</div>
                <div class="card-body">
                    <div class="mb-3"><label class="form-label">Order</label><input type="number" name="order" class="form-control" value="{{ old('order', $faq->order ?? 0) }}"></div>
                    <div class="mb-3"><div class="form-check form-switch"><input type="checkbox" name="status" class="form-check-input" value="1" id="status" {{ old('status', $faq->status ?? true) ? 'checked' : '' }}><label class="form-check-label" for="status">Active</label></div></div>
                </div>
            </div>
            <div class="card"><div class="card-body"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> {{ isset($faq) ? 'Update' : 'Create' }} FAQ</button><a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a></div></div>
        </div>
    </div>
</form>
@endsection