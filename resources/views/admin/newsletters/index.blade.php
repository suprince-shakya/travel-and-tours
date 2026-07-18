@extends('layouts.admin')

@section('title', 'Newsletter Subscribers')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-megaphone me-2" style="color: var(--primary);"></i>Newsletter Subscribers</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item active">Newsletter</li></ol></nav></div>
    <a href="{{ route('admin.newsletters.export') }}" class="btn btn-outline-success"><i class="bi bi-download"></i> Export CSV</a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead><tr><th>#</th><th>Email</th><th>Subscribed</th><th>Date</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($subscribers ?? [] as $sub)
                        <tr>
                            <td>{{ $sub->id }}</td>
                            <td class="fw-semibold">{{ $sub->email }}</td>
                            <td>@if($sub->subscribed ?? true)<span class="badge bg-success">Subscribed</span>@else<span class="badge bg-secondary">Unsubscribed</span>@endif</td>
                            <td>{{ $sub->created_at ? $sub->created_at->format('M d, Y') : 'N/A' }}</td>
                            <td class="text-end">
                                <form action="{{ route('admin.newsletters.destroy', $sub->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No subscribers yet</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">{{ $subscribers->links() ?? '' }}</div>
    </div>
</div>
@endsection