@extends('layouts.admin')

@section('title', 'Countries Management')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-globe me-2" style="color: var(--primary);"></i>Countries</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Countries</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.countries.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Country</a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr><th>#</th><th>Flag</th><th>Code</th><th>Name</th><th>Currency</th><th>Status</th><th>Featured</th><th>Tours</th><th class="text-end">Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($countries ?? [] as $c)
                        <tr>
                            <td>{{ $c->id }}</td>
                            <td>
                                @if($c->flag)<img src="{{ storage_url($c->flag) }}" alt="{{ $c->name }}" width="28" height="20" style="object-fit: cover;" class="rounded border">@endif
                            </td>
                            <td class="fw-semibold">{{ $c->code }}</td>
                            <td>{{ $c->name }}</td>
                            <td>{{ $c->currency }} ({{ $c->currency_symbol }})</td>
                            <td><span class="badge bg-{{ $c->status ? 'success' : 'secondary' }}">{{ $c->status ? 'Active' : 'Inactive' }}</span></td>
                            <td>@if($c->featured)<span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i></span>@else<span class="badge bg-light text-muted">No</span>@endif</td>
                            <td>{{ $c->tours_count ?? $c->tours->count() ?? 0 }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.countries.edit', $c->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.countries.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No countries found</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">{{ $countries->links() ?? '' }}</div>
    </div>
</div>
@endsection