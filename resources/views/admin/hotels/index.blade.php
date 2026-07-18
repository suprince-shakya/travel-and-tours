@extends('layouts.admin')

@section('title', 'Hotels')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-building me-2" style="color: var(--primary);"></i>Hotels</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item active">Hotels</li></ol></nav>
    </div>
    <a href="{{ route('admin.hotels.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Hotel</a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead><tr><th>#</th><th>Image</th><th>Name</th><th>Stars</th><th>Country</th><th>City</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($hotels ?? [] as $h)
                        <tr>
                            <td>{{ $h->id }}</td>
                            <td>@if($h->image)<img src="{{ storage_url($h->image) }}" alt="" width="50" height="35" style="object-fit:cover;" class="rounded">@else<div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:50px;height:35px;"><i class="bi bi-image text-muted"></i></div>@endif</td>
                            <td class="fw-semibold">{{ $h->name }}</td>
                            <td>@for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=$h->star_rating ? '-fill' : '' }}" style="color:#ffc107;font-size:0.8rem;"></i>@endfor</td>
                            <td>{{ $h->country->name ?? 'N/A' }}</td>
                            <td>{{ $h->city ?? 'N/A' }}</td>
                            <td><span class="badge bg-{{ $h->status ? 'success' : 'secondary' }}">{{ $h->status ? 'Active' : 'Inactive' }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.hotels.edit', $h->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.hotels.destroy', $h->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No hotels found</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">{{ $hotels->links() ?? '' }}</div>
    </div>
</div>
@endsection