<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr><th>#</th><th>Image</th><th>Title</th><th>Author</th><th>Category</th><th>Status</th><th>Comments</th><th>Views</th><th class="text-end">Actions</th></tr>
        </thead>
        <tbody>
            @forelse($blogs as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>
                        @if($post->featured_image)<img src="{{ storage_url($post->featured_image) }}" alt="" width="50" height="35" style="object-fit:cover;" class="rounded">@else<div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:50px;height:35px;"><i class="bi bi-image text-muted"></i></div>@endif
                    </td>
                    <td class="fw-semibold">{{ Str::limit($post->title, 40) }}</td>
                    <td>{{ $post->user?->name ?? 'Admin' }}</td>
                    <td>{{ $post->category?->name ?? 'Uncategorized' }}</td>
                    <td>
                        @if($post->status)
                            <span class="badge badge-soft-success">Published</span>
                        @else
                            <span class="badge badge-soft-warning">Draft</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.blog-comments.index', ['blog_id' => $post->id]) }}" class="text-decoration-none">
                            <i class="bi bi-chat-dots me-1"></i>{{ $post->comments->count() }}
                        </a>
                    </td>
                    <td>{{ number_format($post->views ?? 0) }}</td>
                    <td class="text-end">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="{{ route('admin.blog-comments.index', ['blog_id' => $post->id]) }}" class="btn btn-sm btn-outline-info" title="Comments"><i class="bi bi-chat-dots"></i></a>
                            <a href="{{ route('admin.blogs.edit', $post->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.blogs.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this post?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center py-5 text-muted"><i class="bi bi-inbox" style="font-size:2.5rem;"></i><p class="mt-2 mb-0">No blog posts found</p></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center mt-3" id="blogsPagination">{{ $blogs->links() }}</div>
