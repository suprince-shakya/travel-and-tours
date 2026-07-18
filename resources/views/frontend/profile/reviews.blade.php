@extends('layouts.customer')

@section('title', 'My Reviews - Travels & Tours')

@section('page-title', 'My Reviews')
@section('page-subtitle', 'Reviews you\'ve written for completed tours')

@section('customer-content')
@if($reviews->count() > 0)
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            @foreach($reviews as $review)
                <div style="border-bottom: 1px solid #e9ecef; padding: 1.25rem 0;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="fw-bold mb-1">{{ $review->tour?->title ?? 'N/A' }}</h6>
                            <div style="color: #f8b84a;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                    </div>
                    @if($review->title)
                        <h6 class="fw-semibold mb-1">{{ $review->title }}</h6>
                    @endif
                    <p style="color: #495057;">{{ $review->review }}</p>
                    <div class="d-flex align-items-center gap-3">
                        @if($review->verified)
                            <span class="badge bg-success">Verified</span>
                        @endif
                        @if($review->helpful_votes > 0)
                            <small class="text-muted"><i class="bi bi-hand-thumbs-up me-1"></i>{{ $review->helpful_votes }} found helpful</small>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mt-4 d-flex justify-content-center">
        {{ $reviews->links('components.pagination', ['paginator' => $reviews]) }}
    </div>
@else
    <div class="text-center py-5">
        <i class="bi bi-star fs-1 text-muted mb-3 d-block"></i>
        <h5 class="fw-bold">No Reviews Yet</h5>
        <p class="text-muted mb-3">You haven't written any reviews. Share your experience after a completed tour!</p>
        <a href="{{ route('customer.bookings') }}" class="btn btn-primary rounded-pill px-4">View My Bookings</a>
    </div>
@endif
@endsection
