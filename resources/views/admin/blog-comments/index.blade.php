@extends('layouts.admin')

@section('title', 'Blog Comments')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-chat-dots me-2" style="color: var(--primary);"></i>Blog Comments</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blog</a></li><li class="breadcrumb-item active">Comments</li></ol></nav></div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.blog-comments.index') }}">
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search comments..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="blog_id" class="form-select">
                        <option value="">All Posts</option>
                        @foreach($posts as $p)
                            <option value="{{ $p->id }}" {{ request('blog_id') == $p->id ? 'selected' : '' }}>{{ Str::limit($p->title, 30) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary me-1"><i class="bi bi-filter"></i> Filter</button>
                    <a href="{{ route('admin.blog-comments.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i></a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead><tr><th>#</th><th>Author</th><th>Email</th><th>Comment</th><th>Post</th><th>Status</th><th>Date</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($comments as $comment)
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td class="fw-semibold">{{ $comment->name ?? $comment->user?->name ?? 'Anonymous' }}</td>
                            <td>{{ $comment->email ?? $comment->user?->email ?? 'N/A' }}</td>
                            <td><div class="review-excerpt">{{ $comment->comment }}</div></td>
                            <td><a href="{{ route('admin.blogs.edit', $comment->blog_id) }}">{{ Str::limit($comment->blog?->title ?? 'N/A', 30) }}</a></td>
                            <td>
                                @if($comment->status)
                                    <span class="badge badge-soft-success">Approved</span>
                                @else
                                    <span class="badge badge-soft-warning">Pending</span>
                                @endif
                            </td>
                            <td>{{ $comment->created_at ? $comment->created_at->format('M d, Y') : 'N/A' }}</td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    @if(!$comment->status)
                                        <form action="{{ route('admin.blog-comments.approve', $comment->id) }}" method="POST" class="d-inline">@csrf @method('PUT')<button type="submit" class="btn btn-sm btn-outline-success" title="Approve"><i class="bi bi-check-lg"></i></button></form>
                                    @else
                                        <form action="{{ route('admin.blog-comments.reject', $comment->id) }}" method="POST" class="d-inline">@csrf @method('PUT')<button type="submit" class="btn btn-sm btn-outline-warning" title="Reject"><i class="bi bi-x-lg"></i></button></form>
                                    @endif
                                    <form action="{{ route('admin.blog-comments.destroy', $comment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this comment?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-5 text-muted"><i class="bi bi-inbox" style="font-size:2.5rem;"></i><p class="mt-2 mb-0">No comments found</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">{{ $comments->links() }}</div>
    </div>
</div>
@endsection