@extends('layouts.admin')

@section('title', 'Regions')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-geo me-2" style="color: var(--primary);"></i>Regions</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item active">Regions</li></ol></nav></div>
    <a href="{{ route('admin.regions.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Region</a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead><tr><th>#</th><th>Name</th><th>Country</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($regions ?? [] as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td class="fw-semibold">{{ $r->name }}</td>
                            <td>{{ $r->country->name ?? 'N/A' }}</td>
                            <td><span class="badge bg-{{ $r->status ? 'success' : 'secondary' }}">{{ $r->status ? 'Active' : 'Inactive' }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.regions.edit', $r->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.regions.destroy', $r->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No regions found</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">{{ $regions->links() ?? '' }}</div>
    </div>
</div>
@endsection