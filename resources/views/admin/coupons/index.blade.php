@extends('layouts.admin')

@section('title', 'Coupons')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-ticket-perforated me-2" style="color: var(--primary);"></i>Coupons</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item active">Coupons</li></ol></nav></div>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Coupon</a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead><tr><th>#</th><th>Code</th><th>Type</th><th>Value</th><th>Min Order</th><th>Used</th><th>Start Date</th><th>Expiry</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($coupons ?? [] as $cp)
                        <tr>
                            <td>{{ $cp->id }}</td>
                            <td class="fw-semibold text-uppercase">{{ $cp->code }}</td>
                            <td><span class="badge bg-{{ $cp->type === 'percentage' ? 'info' : 'primary' }}">{{ ucfirst($cp->type) }}</span></td>
                            <td>{{ $cp->type === 'percentage' ? $cp->value.'%' : '$'.number_format($cp->value, 2) }}</td>
                            <td>${{ number_format($cp->min_order_amount ?? 0, 2) }}</td>
                            <td>{{ $cp->used_count ?? 0 }}{{ $cp->usage_limit ? ' / '.$cp->usage_limit : '' }}</td>
                            <td>{{ $cp->starts_at ? $cp->starts_at->format('M d, Y') : 'N/A' }}</td>
                            <td>{{ $cp->expires_at ? $cp->expires_at->format('M d, Y') : 'N/A' }}</td>
                            <td><span class="badge bg-{{ $cp->status ? 'success' : 'secondary' }}">{{ $cp->status ? 'Active' : 'Inactive' }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.coupons.edit', $cp->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.coupons.destroy', $cp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No coupons found</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">{{ $coupons->links() ?? '' }}</div>
    </div>
</div>
@endsection