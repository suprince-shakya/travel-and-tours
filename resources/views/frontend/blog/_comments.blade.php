<h5 class="fw-bold mb-4" style="color: var(--secondary-color);">Comments (<span id="commentCount">{{ $comments->count() }}</span>)</h5>

@forelse($comments as $comment)
    @include('frontend.blog._comment', ['comment' => $comment])
@empty
    <p class="text-muted" id="noComments">No comments yet. Be the first to comment!</p>
@endforelse