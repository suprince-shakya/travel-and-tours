@extends('layouts.frontend')

@section('title', ($blog->meta_title ?? $blog->title) . ' - Travels & Tours Blog')
@section('meta_description', $blog->meta_description ?? $blog->excerpt)
@section('meta_keywords', $blog->meta_keywords ?? '')

@section('content')

<section class="py-5 bg-light border-bottom">
    <div class="container">
        @component('components.breadcrumb', ['items' => [
            ['label' => 'Blog', 'url' => route('blog.index')],
            ['label' => $blog->title]
        ]])
        @endcomponent
    </div>
</section>

@if($blog->featured_image_url)
<section>
    <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}"
         class="w-100" style="max-height: 60vh; object-fit: cover;">
</section>
@endif

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    @if($blog->category)
                        <span class="badge rounded-pill px-3 py-2" style="background: var(--primary-color);">{{ $blog->category->name }}</span>
                    @endif
                    <small class="text-muted"><i class="bi bi-person me-1"></i>{{ $blog->user?->name ?? 'Admin' }}</small>
                    <small class="text-muted"><i class="bi bi-calendar me-1"></i>{{ $blog->published_at?->format('M d, Y') ?? $blog->created_at->format('M d, Y') }}</small>
                    <small class="text-muted"><i class="bi bi-eye me-1"></i>{{ number_format($blog->views ?? 0) }} views</small>
                </div>

                <h1 class="fw-bold mb-4" style="color: var(--secondary-color);">{{ $blog->title }}</h1>

                @if($blog->excerpt)
                    <p class="lead fw-semibold text-muted mb-4">{{ $blog->excerpt }}</p>
                @endif

                <div class="blog-content">
                    {!! $blog->content !!}
                </div>

                @if($blog->tags && count($blog->tags) > 0)
                    <div class="mt-4 pt-4 border-top">
                        <h6 class="fw-bold mb-2">Tags:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($blog->tags as $tag)
                                <span class="tag-badge">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <hr class="my-5">

                <div id="commentsContainer">
                    @php $approvedComments = $blog->comments->where('status', true); @endphp
                    <h5 class="fw-bold mb-4" style="color: var(--secondary-color);">Comments (<span id="commentCount">{{ $approvedComments->count() }}</span>)</h5>
                    @forelse($approvedComments as $comment)
                        @include('frontend.blog._comment', ['comment' => $comment])
                    @empty
                        <p class="text-muted" id="noComments">No comments yet. Be the first to comment!</p>
                    @endforelse
                </div>

                <div class="mt-4 p-4 bg-light rounded-4">
                    <h6 class="fw-bold mb-3">Leave a Comment</h6>
                    <form id="commentForm" action="{{ route('blog.comments.store', $blog->id) }}" method="POST">
                        @csrf
                        @auth
                            <div class="mb-3">
                                <textarea name="comment" class="form-control rounded-4" rows="4" placeholder="Write your comment..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary rounded-pill px-4" id="submitBtn">Post Comment</button>
                        @else
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control rounded-pill" placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control rounded-pill" placeholder="Your Email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <textarea name="comment" class="form-control rounded-4" rows="4" placeholder="Write your comment..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary rounded-pill px-4" id="submitBtn">Post Comment</button>
                        @endauth
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@if($relatedPosts->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <h4 class="fw-bold mb-4" style="color: var(--secondary-color);">Related Posts</h4>
        <div class="row g-4">
            @foreach($relatedPosts as $related)
                <div class="col-lg-3 col-md-6">
                    @component('components.blog-card', ['blog' => $related])
                    @endcomponent
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
    <div id="commentToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                Your comment has been submitted.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    var commentForm = $('#commentForm');
    var submitBtn = $('#submitBtn');
    var commentsContainer = $('#commentsContainer');
    var toast = new bootstrap.Toast(document.getElementById('commentToast'));

    commentForm.on('submit', function (e) {
        e.preventDefault();
        submitBtn.prop('disabled', true).text('Posting...');

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (res) {
                commentForm[0].reset();
                $('#toastMessage').text(res.message);
                toast.show();

                if (res.auto_approved && res.comment) {
                    $('#noComments').remove();
                    commentsContainer.append(res.comment);
                    var count = parseInt($('#commentCount').text());
                    $('#commentCount').text(count + 1);
                }
            },
            error: function (xhr) {
                var msg = 'Something went wrong. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errs = xhr.responseJSON.errors;
                    msg = Object.values(errs).flat().join('<br>');
                }
                $('#toastMessage').html(msg);
                var errorToast = new bootstrap.Toast(document.getElementById('commentToast'));
                $('#commentToast').removeClass('text-bg-success').addClass('text-bg-danger');
                errorToast.show();
                setTimeout(function () {
                    $('#commentToast').removeClass('text-bg-danger').addClass('text-bg-success');
                }, 3000);
            },
            complete: function () {
                submitBtn.prop('disabled', false).text('Post Comment');
            }
        });
    });
});
</script>
@endpush
