@extends('layouts.admin')

@section('title', 'Guides')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-person-badge me-2" style="color: var(--primary);"></i>Guides</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item active">Guides</li></ol></nav>
    </div>
    <a href="{{ route('admin.guides.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Guide</a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead><tr><th>Photo</th><th>Name</th><th>Email</th><th>Phone</th><th>Experience</th><th>Languages</th><th>Rating</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($guides ?? [] as $g)
                        <tr>
                            <td>@if($g->photo)<img src="{{ storage_url($g->photo) }}" alt="" class="rounded-circle" width="36" height="36" style="object-fit:cover;">@else<div class="avatar-xs" style="background:var(--primary);">{{ strtoupper(substr($g->name,0,1)) }}</div>@endif</td>
                            <td class="fw-semibold">{{ $g->name }}</td>
                            <td>{{ $g->email }}</td>
                            <td>{{ $g->phone ?? 'N/A' }}</td>
                            <td>{{ $g->experience ?? 0 }} years</td>
                            <td>{{ $g->languages ?? 'N/A' }}</td>
                            <td><span class="stars">@for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=($g->rating ?? 0) ? '-fill' : '' }}"></i>@endfor</span></td>
                            <td><span class="badge bg-{{ $g->status ? 'success' : 'secondary' }}">{{ $g->status ? 'Active' : 'Inactive' }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.guides.edit', $g->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.guides.destroy', $g->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No guides found</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">{{ $guides->links() ?? '' }}</div>
    </div>
</div>
@endsection