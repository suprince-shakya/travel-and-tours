@props(['blog'])
<div class="card blog-card border-0 shadow-sm rounded-4 overflow-hidden h-100">
    <img src="{{ $blog->featured_image_url ?? 'https://placehold.co/600x400/3c453e/white?text=Blog' }}"
         class="card-img-top" alt="{{ $blog->title }}" style="height: 200px; object-fit: cover;">
    <div class="card-body">
        <small class="text-muted"><i class="bi bi-calendar"></i> {{ $blog->published_at?->format('M d, Y') ?? $blog->created_at->format('M d, Y') }}</small>
        <h6 class="fw-bold mt-2">{{ Str::limit($blog->title, 50) }}</h6>
        <p class="small text-muted">{{ Str::limit($blog->excerpt ?? strip_tags($blog->content), 100) }}</p>
        <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-link p-0 text-decoration-none">Read More <i class="bi bi-arrow-right"></i></a>
    </div>
</div>
