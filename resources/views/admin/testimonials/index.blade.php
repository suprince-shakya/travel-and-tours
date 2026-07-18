@extends('layouts.admin')

@section('title', 'Testimonials')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-chat-quote me-2" style="color: var(--primary);"></i>Testimonials</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item active">Testimonials</li></ol>
        </nav>
    </div>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Testimonial</a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead><tr><th>#</th><th>Photo</th><th>Name</th><th>Designation</th><th>Rating</th><th>Content</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($testimonials ?? [] as $t)
                        <tr>
                            <td>{{ $t->id }}</td>
                            <td>@if($t->photo)<img src="{{ storage_url($t->photo) }}" alt="" class="rounded-circle" width="36" height="36" style="object-fit:cover;">@else<div class="avatar-xs" style="background:var(--primary);">{{ strtoupper(substr($t->name,0,1)) }}</div>@endif</td>
                            <td class="fw-semibold">{{ $t->name }}</td>
                            <td>{{ $t->designation ?? 'N/A' }}</td>
                            <td><span class="stars">@for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=$t->rating ? '-fill' : '' }}"></i>@endfor</span></td>
                            <td><div class="review-excerpt">{{ $t->content ?? '' }}</div></td>
                            <td><span class="badge bg-{{ $t->status ? 'success' : 'secondary' }}">{{ $t->status ? 'Active' : 'Inactive' }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.testimonials.edit', $t->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.testimonials.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No testimonials found</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">{{ $testimonials->links() ?? '' }}</div>
    </div>
</div>
@endsection