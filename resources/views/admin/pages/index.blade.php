@extends('layouts.admin')

@section('title', 'Pages Management')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-file-text me-2" style="color: var(--primary);"></i>Pages</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Pages</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Page</a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead><tr><th>#</th><th>Title</th><th>Slug</th><th>Status</th><th>Updated</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($pages ?? [] as $page)
                        <tr>
                            <td>{{ $page->id }}</td>
                            <td class="fw-semibold">{{ $page->title }}</td>
                            <td>{{ $page->slug }}</td>
                            <td><span class="badge bg-{{ $page->status ? 'success' : 'secondary' }}">{{ $page->status ? 'Published' : 'Draft' }}</span></td>
                            <td>{{ $page->updated_at ? $page->updated_at->format('M d, Y H:i') : 'N/A' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No pages found</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">{{ $pages->links() ?? '' }}</div>
    </div>
</div>
@endsection