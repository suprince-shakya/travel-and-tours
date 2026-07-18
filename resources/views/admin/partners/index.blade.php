@extends('layouts.admin')

@section('title', 'Partners')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-handshake me-2" style="color: var(--primary);"></i>Partners</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item active">Partners</li></ol>
        </nav>
    </div>
    <a href="{{ route('admin.partners.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Partner</a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead><tr><th>#</th><th>Logo</th><th>Name</th><th>Website</th><th>Order</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($partners ?? [] as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>@if($p->logo)<img src="{{ storage_url($p->logo) }}" alt="{{ $p->name }}" height="30" class="rounded">@else<span class="text-muted">-</span>@endif</td>
                            <td class="fw-semibold">{{ $p->name }}</td>
                            <td><a href="{{ $p->website }}" target="_blank" class="text-decoration-none">{{ Str::limit($p->website, 30) }}</a></td>
                            <td>{{ $p->order ?? 0 }}</td>
                            <td><span class="badge bg-{{ $p->status ? 'success' : 'secondary' }}">{{ $p->status ? 'Active' : 'Inactive' }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.partners.edit', $p->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.partners.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No partners found</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">{{ $partners->links() ?? '' }}</div>
    </div>
</div>
@endsection