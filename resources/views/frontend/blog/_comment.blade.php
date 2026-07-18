<div class="comment-card">
    <div class="d-flex align-items-center mb-2">
        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white me-3"
             style="width: 40px; height: 40px; font-weight: 600; font-size: 0.85rem;">
            {{ strtoupper(substr($comment->name ?? $comment->user?->name ?? 'A', 0, 1)) }}
        </div>
        <div>
            <h6 class="fw-bold mb-0">{{ $comment->name ?? $comment->user?->name ?? 'Anonymous' }}</h6>
            <small class="text-muted">{{ $comment->created_at->format('M d, Y \a\t h:i A') }}</small>
        </div>
    </div>
    <p style="color: #495057;">{{ $comment->comment }}</p>
</div>