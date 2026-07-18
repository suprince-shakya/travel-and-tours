@extends('layouts.frontend')

@section('title', 'Compare Tours - Travels & Tours')

@section('content')

<section class="compare-hero">
    <div class="container">
        <h1 class="display-5 fw-bold text-white mb-2">Compare Tours</h1>
        <p class="lead text-white-50 mb-0">Side-by-side comparison of your selected tours</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if(count($tours) > 0)
            <div class="d-flex justify-content-between align-items-center mb-3">
                <small class="text-muted">Comparing {{ count($tours) }} of 4 tours</small>
                <form method="POST" action="{{ route('compare.clear') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Clear All</button>
                </form>
            </div>

            <div class="scroll-x">
                <table class="table table-bordered compare-table">
                    <thead>
                        <tr>
                            <th style="min-width: 140px;">Feature</th>
                            @foreach($tours as $tour)
                                <th class="text-center position-relative" style="min-width: 220px;">
                                    <form method="POST" action="{{ route('compare.remove', $tour->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="remove-btn"><i class="bi bi-x"></i></button>
                                    </form>
                                    <img src="{{ $tour->thumbnail_url ?? 'https://placehold.co/400x300/3c453e/white?text=No+Image' }}"
                                         alt="{{ $tour->title }}" class="tour-img mb-2">
                                    <h6 class="fw-bold mb-1">{{ Str::limit($tour->title, 30) }}</h6>
                                    @if($tour->discount_price)
                                        <span class="text-muted text-decoration-line-through small">${{ number_format($tour->price) }}</span>
                                        <span class="fw-bold" style="color: var(--primary-color);">${{ number_format($tour->discount_price) }}</span>
                                    @else
                                        <span class="fw-bold" style="color: var(--primary-color);">${{ number_format($tour->price) }}</span>
                                    @endif
                                    <br>
                                    <a href="{{ route('tours.show', $tour->slug) }}" class="btn btn-sm btn-primary rounded-pill mt-2">View Details</a>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Price</th>
                            @foreach($tours as $tour)
                                <td class="text-center">
                                    @if($tour->discount_price)
                                        <span class="text-muted text-decoration-line-through">${{ number_format($tour->price) }}</span><br>
                                        <strong style="color: var(--primary-color);">${{ number_format($tour->discount_price) }}</strong>
                                    @else
                                        <strong>${{ number_format($tour->price) }}</strong>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Duration</th>
                            @foreach($tours as $tour)
                                <td class="text-center">{{ $tour->duration }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Difficulty</th>
                            @foreach($tours as $tour)
                                <td class="text-center">
                                    <span class="badge rounded-pill px-3" style="background: var(--primary-color);">{{ $tour->difficulty }}</span>
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Group Size</th>
                            @foreach($tours as $tour)
                                <td class="text-center">{{ $tour->max_group_size ?? 'N/A' }}</td>
                            @endforeach
                        </tr>
                        @if($tours->firstWhere('max_elevation'))
                        <tr>
                            <th>Max Elevation</th>
                            @foreach($tours as $tour)
                                <td class="text-center">{{ $tour->max_elevation ?? 'N/A' }}</td>
                            @endforeach
                        </tr>
                        @endif
                        <tr>
                            <th>Country</th>
                            @foreach($tours as $tour)
                                <td class="text-center">{{ $tour->country?->name ?? 'N/A' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Best Season</th>
                            @foreach($tours as $tour)
                                <td class="text-center">{{ $tour->best_season ?? 'Year-round' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Languages</th>
                            @foreach($tours as $tour)
                                <td class="text-center">{{ $tour->languages ?? 'English' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Description</th>
                            @foreach($tours as $tour)
                                <td><small>{{ Str::limit(strip_tags($tour->overview ?? $tour->description), 150) }}</small></td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Highlights</th>
                            @foreach($tours as $tour)
                                <td>
                                    @php $highlights = is_array($tour->highlights) ? $tour->highlights : (json_decode($tour->highlights, true) ?? []); @endphp
                                    <ul class="list-unstyled mb-0">
                                        @foreach(array_slice($highlights, 0, 4) as $h)
                                            <li class="small mb-1"><i class="bi bi-check-circle-fill text-success me-1"></i>{{ $h }}</li>
                                        @endforeach
                                        @if(count($highlights) > 4)
                                            <li class="small text-muted">+{{ count($highlights) - 4 }} more</li>
                                        @endif
                                    </ul>
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Included</th>
                            @foreach($tours as $tour)
                                <td>
                                    @php $included = is_array($tour->included) ? $tour->included : (json_decode($tour->included, true) ?? []); @endphp
                                    <ul class="list-unstyled mb-0">
                                        @foreach(array_slice($included, 0, 4) as $i)
                                            <li class="small mb-1"><i class="bi bi-check-lg text-success me-1"></i>{{ $i }}</li>
                                        @endforeach
                                        @if(count($included) > 4)
                                            <li class="small text-muted">+{{ count($included) - 4 }} more</li>
                                        @endif
                                    </ul>
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Excluded</th>
                            @foreach($tours as $tour)
                                <td>
                                    @php $excluded = is_array($tour->excluded) ? $tour->excluded : (json_decode($tour->excluded, true) ?? []); @endphp
                                    <ul class="list-unstyled mb-0">
                                        @foreach(array_slice($excluded, 0, 4) as $e)
                                            <li class="small mb-1"><i class="bi bi-x-lg text-danger me-1"></i>{{ $e }}</li>
                                        @endforeach
                                        @if(count($excluded) > 4)
                                            <li class="small text-muted">+{{ count($excluded) - 4 }} more</li>
                                        @endif
                                    </ul>
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>Total Itinerary Days</th>
                            @foreach($tours as $tour)
                                <td class="text-center">{{ $tour->itineraries->count() }} days</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th></th>
                            @foreach($tours as $tour)
                                <td class="text-center">
                                    @auth
                                        <a href="{{ route('booking.step1', $tour->slug) }}" class="btn btn-primary rounded-pill px-4 w-100">
                                            <i class="bi bi-calendar-check me-1"></i>Book Now
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 w-100">
                                            Login to Book
                                        </a>
                                    @endauth
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-arrow-left-right fs-1 text-muted mb-3 d-block"></i>
                <h5 class="fw-bold">No Tours to Compare</h5>
                <p class="text-muted mb-3">Add tours to compare by clicking the compare button on tour cards.</p>
                <a href="{{ route('tours.index') }}" class="btn btn-primary rounded-pill px-4">Browse Tours</a>
            </div>
        @endif
    </div>
</section>
@endsection
