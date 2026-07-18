@extends('layouts.admin')

@section('title', isset($coupon) ? 'Edit Coupon' : 'Create Coupon')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-ticket-perforated me-2" style="color: var(--primary);"></i>{{ isset($coupon) ? 'Edit Coupon' : 'Create Coupon' }}</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Coupons</a></li><li class="breadcrumb-item active">{{ isset($coupon) ? 'Edit' : 'Create' }}</li></ol></nav></div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<form action="{{ isset($coupon) ? route('admin.coupons.update', $coupon->id) : route('admin.coupons.store') }}" method="POST">
    @csrf
    @if(isset($coupon)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Coupon Details</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Code <span class="text-danger">*</span></label><input type="text" name="code" class="form-control text-uppercase" value="{{ old('code', $coupon->code ?? '') }}" required></div>
                        <div class="col-md-3"><label class="form-label">Type</label><select name="type" class="form-select"><option value="fixed" {{ old('type', $coupon->type ?? 'fixed') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option><option value="percentage" {{ old('type', $coupon->type ?? '') == 'percentage' ? 'selected' : '' }}>Percentage</option></select></div>
                        <div class="col-md-3"><label class="form-label">Value <span class="text-danger">*</span></label><input type="number" step="0.01" name="value" class="form-control" value="{{ old('value', $coupon->value ?? '') }}" required></div>
                        <div class="col-md-4"><label class="form-label">Min Order Amount</label><input type="number" step="0.01" name="min_order_amount" class="form-control" value="{{ old('min_order_amount', $coupon->min_order_amount ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Max Discount</label><input type="number" step="0.01" name="max_discount" class="form-control" value="{{ old('max_discount', $coupon->max_discount ?? '') }}"></div>
                        <div class="col-md-4"><label class="form-label">Usage Limit</label><input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}"></div>
                        <div class="col-md-6"><label class="form-label">Start Date</label><input type="date" name="starts_at" class="form-control" value="{{ old('starts_at', isset($coupon) && $coupon->starts_at ? $coupon->starts_at->format('Y-m-d') : '') }}"></div>
                        <div class="col-md-6"><label class="form-label">Expiry Date</label><input type="date" name="expires_at" class="form-control" value="{{ old('expires_at', isset($coupon) && $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : '') }}"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Status</div>
                <div class="card-body">
                    <div class="form-check form-switch"><input type="checkbox" name="status" class="form-check-input" value="1" id="status" {{ old('status', $coupon->status ?? true) ? 'checked' : '' }}><label class="form-check-label" for="status">Active</label></div>
                </div>
            </div>
            <div class="card"><div class="card-body"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> {{ isset($coupon) ? 'Update' : 'Create' }} Coupon</button><a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a></div></div>
        </div>
    </div>
</form>
@endsection