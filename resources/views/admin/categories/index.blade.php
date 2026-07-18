@extends('layouts.admin')

@section('title', 'Categories Management')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-tags me-2" style="color: var(--primary);"></i>Categories</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add New Category
    </a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Parent</th>
                        <th>Status</th>
                        <th>Tours Count</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories ?? [] as $cat)
                        <tr>
                            <td>{{ $cat->id }}</td>
                            <td>
                                @if($cat->image)
                                    <img src="{{ storage_url($cat->image) }}" alt="{{ $cat->name }}" class="rounded" width="40" height="40" style="object-fit: cover;">
                                @else
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:40px;height:40px;"><i class="bi bi-image text-muted"></i></div>
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $cat->name }}</td>
                            <td>{{ $cat->slug }}</td>
                            <td>{{ $cat->parent->name ?? 'None' }}</td>
                            <td>
                                <span class="badge bg-{{ $cat->status ? 'success' : 'secondary' }}">
                                    {{ $cat->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $cat->tours_count ?? $cat->tours->count() ?? 0 }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mt-2 mb-0">No categories found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">{{ $categories->links() ?? '' }}</div>
    </div>
</div>
@endsection