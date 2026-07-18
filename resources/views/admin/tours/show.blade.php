@extends('layouts.admin')

@section('title', $tour->title ?? 'Tour Details')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-backpack me-2" style="color: var(--primary);"></i>{{ $tour->title ?? 'Tour Details' }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.tours.index') }}">Tours</a></li>
                <li class="breadcrumb-item active">{{ $tour->title ?? 'Tour' }}</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.tours.edit', $tour->id) }}" class="btn btn-primary"><i class="bi bi-pencil"></i> Edit</a>
        <form action="{{ route('admin.tours.destroy', $tour->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this tour?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
        </form>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="row g-3">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Tour Information</span>
                @php $s = $tour->status ? 'badge-soft-success' : ($tour->featured ? 'badge-soft-info' : 'badge-soft-secondary'); @endphp
                <span class="badge {{ $s }}">{{ $tour->status ? 'Active' : ($tour->featured ? 'Featured' : 'Inactive') }}</span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3 text-muted">Price</div>
                    <div class="col-md-9 fw-semibold">${{ number_format($tour->price ?? 0, 2) }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 text-muted">Duration</div>
                    <div class="col-md-9">{{ $tour->duration ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 text-muted">Category</div>
                    <div class="col-md-9">{{ $tour->category->name ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 text-muted">Location</div>
                    <div class="col-md-9">{{ $tour->country->name ?? '' }}{{ $tour->city ? ', ' . $tour->city->name : '' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 text-muted">Difficulty</div>
                    <div class="col-md-9">{{ ucfirst($tour->difficulty ?? 'N/A') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 text-muted">Guide</div>
                    <div class="col-md-9">{{ $tour->guide->name ?? 'N/A' }}</div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6>Description</h6>
                        <p style="white-space: pre-wrap;">{{ $tour->description ?? 'No description.' }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6>Overview</h6>
                        <p style="white-space: pre-wrap;">{{ $tour->overview ?? 'No overview.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($tour->itineraries->count() > 0)
        <div class="card mb-3">
            <div class="card-header fw-semibold">Itinerary</div>
            <div class="card-body">
                @foreach($tour->itineraries as $it)
                    <div class="mb-3">
                        <h6>Day {{ $it->day }}: {{ $it->title ?? '' }}</h6>
                        <p class="mb-0">{{ $it->description ?? '' }}</p>
                    </div>
                    @if(!$loop->last)<hr>@endif
                @endforeach
            </div>
        </div>
        @endif

        @if($tour->galleries->count() > 0)
        <div class="card mb-3">
            <div class="card-header fw-semibold">Gallery ({{ $tour->galleries->count() }})</div>
            <div class="card-body">
                <div class="row g-2">
                    @foreach($tour->galleries as $gallery)
                        <div class="col-4 col-md-3">
                            <img src="{{ $gallery->image_url ?? 'https://placehold.co/300x200' }}" class="img-fluid rounded" alt="{{ $gallery->caption ?? '' }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if($tour->dates->count() > 0)
        <div class="card mb-3">
            <div class="card-header fw-semibold">Available Dates ({{ $tour->dates->count() }})</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead><tr><th>Start</th><th>End</th><th>Price</th><th>Spots</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($tour->dates as $date)
                                <tr>
                                    <td>{{ $date->start_date->format('M d, Y') }}</td>
                                    <td>{{ $date->end_date->format('M d, Y') }}</td>
                                    <td>${{ number_format($date->price ?? $tour->price, 2) }}</td>
                                    <td>{{ $date->available_spots ?? 'N/A' }}</td>
                                    <td><span class="badge {{ $date->status ? 'badge-soft-success' : 'badge-soft-secondary' }}">{{ $date->status ? 'Open' : 'Closed' }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        @if($tour->reviews->count() > 0)
        <div class="card">
            <div class="card-header fw-semibold">Reviews ({{ $tour->reviews->count() }})</div>
            <div class="card-body">
                @foreach($tour->reviews as $review)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= ($review->rating ?? 0) ? '-fill' : '' }}" style="color: #ffc107; font-size: 0.8rem;"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="mb-0 small">{{ $review->comment ?? '' }}</p>
                        @if(!$loop->last)<hr>@endif
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        @if($tour->image_url)
        <div class="card mb-3">
            <img src="{{ $tour->image_url }}" class="card-img-top" alt="{{ $tour->title }}">
        </div>
        @endif

        <div class="card mb-3">
            <div class="card-header fw-semibold">Quick Stats</div>
            <div class="card-body">
                <p class="mb-1"><strong>Bookings:</strong> {{ $tour->bookings_count ?? 0 }}</p>
                <p class="mb-1"><strong>Reviews:</strong> {{ $tour->reviews_count ?? 0 }}</p>
                <p class="mb-0"><strong>Avg Rating:</strong> {{ number_format($tour->reviews_avg_rating ?? 0, 1) }} / 5</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header fw-semibold">Actions</div>
            <div class="card-body d-flex flex-column gap-2">
                <a href="{{ route('admin.tours.edit', $tour->id) }}" class="btn btn-primary w-100"><i class="bi bi-pencil"></i> Edit Tour</a>
                <a href="{{ route('tours.show', $tour->slug) }}" class="btn btn-outline-primary w-100" target="_blank"><i class="bi bi-box-arrow-up-right"></i> View on Site</a>
            </div>
        </div>
    </div>
</div>
@endsection