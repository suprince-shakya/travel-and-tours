@extends('layouts.admin')

@section('title', 'Blog Categories')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-bookmark me-2" style="color: var(--primary);"></i>Blog Categories</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item active">Blog Categories</li></ol></nav></div>
    <a href="{{ route('admin.blog-categories.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Category</a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead><tr><th>#</th><th>Name</th><th>Slug</th><th>Posts</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($categories ?? [] as $cat)
                        <tr>
                            <td>{{ $cat->id }}</td>
                            <td class="fw-semibold">{{ $cat->name }}</td>
                            <td>{{ $cat->slug }}</td>
                            <td>{{ $cat->blogs_count ?? 0 }}</td>
                            <td><span class="badge bg-{{ $cat->status ? 'success' : 'secondary' }}">{{ $cat->status ? 'Active' : 'Inactive' }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.blog-categories.edit', $cat->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.blog-categories.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No categories found</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">{{ $categories->links() ?? '' }}</div>
    </div>
</div>
@endsection