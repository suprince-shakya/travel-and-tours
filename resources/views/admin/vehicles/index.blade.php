@extends('layouts.admin')

@section('title', 'Vehicles')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-truck me-2" style="color: var(--primary);"></i>Vehicles</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item active">Vehicles</li></ol></nav></div>
    <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Vehicle</a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead><tr><th>#</th><th>Image</th><th>Name</th><th>Type</th><th>Capacity</th><th>Price/Day</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($vehicles ?? [] as $v)
                        <tr>
                            <td>{{ $v->id }}</td>
                            <td>@if($v->image)<img src="{{ storage_url($v->image) }}" alt="" width="50" height="35" style="object-fit:cover;" class="rounded">@else<div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:50px;height:35px;"><i class="bi bi-image text-muted"></i></div>@endif</td>
                            <td class="fw-semibold">{{ $v->name }}</td>
                            <td>{{ ucfirst($v->type) }}</td>
                            <td>{{ $v->capacity }}</td>
                            <td>${{ number_format($v->price_per_day ?? 0, 2) }}</td>
                            <td><span class="badge bg-{{ $v->status ? 'success' : 'secondary' }}">{{ $v->status ? 'Active' : 'Inactive' }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.vehicles.edit', $v->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.vehicles.destroy', $v->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No vehicles found</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">{{ $vehicles->links() ?? '' }}</div>
    </div>
</div>
@endsection