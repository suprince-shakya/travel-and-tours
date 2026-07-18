@extends('layouts.admin')

@section('title', 'Review Details')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-star me-2" style="color: var(--primary);"></i>Review Details</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Reviews</a></li>
                <li class="breadcrumb-item active">#{{ $review->id }}</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="row g-3">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Review by {{ $review->user->name ?? 'Anonymous' }}</span>
                <div>
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $i <= ($review->rating ?? 0) ? '-fill' : '' }}" style="color: #ffc107;"></i>
                    @endfor
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Tour:</strong> {{ $review->tour->title ?? 'N/A' }}
                    <span class="ms-3"><strong>Date:</strong> {{ $review->created_at->format('M d, Y') }}</span>
                </div>
                @if($review->booking)
                    <div class="mb-3"><strong>Booking:</strong> <a href="{{ route('admin.bookings.show', $review->booking->id) }}">#{{ $review->booking->booking_number }}</a></div>
                @endif
                <hr>
                <div style="white-space: pre-wrap;">{{ $review->comment ?? 'No comment provided.' }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header fw-semibold">Status</div>
            <div class="card-body">
                <div class="mb-3">
                    @if($review->status)
                        <span class="badge badge-soft-success fs-6">Approved</span>
                    @else
                        <span class="badge badge-soft-warning fs-6">Pending</span>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    @unless($review->status)
                        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST">
                            @csrf @method('PUT')
                            <button type="submit" class="btn btn-success"><i class="bi bi-check-lg"></i> Approve</button>
                        </form>
                    @endunless
                    @if($review->status)
                        <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST">
                            @csrf @method('PUT')
                            <button type="submit" class="btn btn-warning"><i class="bi bi-x-lg"></i> Reject</button>
                        </form>
                    @endif
                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header fw-semibold">Customer Info</div>
            <div class="card-body">
                <p class="mb-1"><strong>Name:</strong> {{ $review->user->name ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $review->user->email ?? 'N/A' }}</p>
                <p class="mb-0"><strong>Member since:</strong> {{ $review->user->created_at ? $review->user->created_at->format('M Y') : 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection