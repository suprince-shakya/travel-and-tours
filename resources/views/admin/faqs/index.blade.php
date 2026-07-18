@extends('layouts.admin')

@section('title', 'FAQs')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-question-circle me-2" style="color: var(--primary);"></i>FAQs</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item active">FAQs</li></ol></nav>
    </div>
    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New FAQ</a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead><tr><th>#</th><th>Question</th><th>Category</th><th>Order</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($faqs ?? [] as $faq)
                        <tr>
                            <td>{{ $faq->id }}</td>
                            <td class="fw-semibold">{{ Str::limit($faq->question, 60) }}</td>
                            <td>{{ $faq->category ?? 'General' }}</td>
                            <td>{{ $faq->order ?? 0 }}</td>
                            <td><span class="badge bg-{{ $faq->status ? 'success' : 'secondary' }}">{{ $faq->status ? 'Active' : 'Inactive' }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No FAQs found</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">{{ $faqs->links() ?? '' }}</div>
    </div>
</div>
@endsection