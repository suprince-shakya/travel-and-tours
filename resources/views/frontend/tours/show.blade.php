@extends('layouts.frontend')

@section('title', ($tour->meta_title ?? $tour->title) . ' - Travels & Tours')
@section('meta_description', $tour->meta_description ?? Str::limit(strip_tags($tour->overview), 160))
@section('meta_keywords', $tour->meta_keywords ?? '')

@section('content')

<section class="tour-hero d-flex align-items-end parallax-hero"
         @if($tour->thumbnail)
         style="background-image: url('{{ storage_url($tour->thumbnail) }}');"
         @else
         style="background-image: url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');"
         @endif
         data-parallax-factor="0.35">
    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-8">
                @component('components.breadcrumb', ['items' => [
                    ['label' => 'Tours', 'url' => route('tours.index')],
                    ['label' => $tour->title]
                ]])
                @endcomponent
                <h1 class="text-white mb-3">{{ $tour->title }}</h1>
                <div class="hero-meta d-flex flex-wrap align-items-center gap-3 mb-3">
                    <span><i class="bi bi-geo-alt me-1"></i>{{ $tour->country?->name ?? 'N/A' }}</span>
                    <span><i class="bi bi-clock me-1"></i>{{ $tour->duration }}</span>
                    <span class="hero-badge" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(4px);">
                        <i class="bi bi-bar-chart me-1"></i>{{ $tour->difficulty }}
                    </span>
                    @if($tour->max_group_size)
                        <span><i class="bi bi-people me-1"></i>Max {{ $tour->max_group_size }}</span>
                    @endif
                    @php $avgRating = $tour->reviews()->approved()->avg('rating'); @endphp
                    @if($avgRating)
                        <span class="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= round($avgRating) ? '-fill' : '' }}"></i>
                            @endfor
                            <small>({{ $tour->reviews()->approved()->count() }})</small>
                        </span>
                    @endif
                </div>
                <div class="d-flex align-items-center gap-3">
                    @if($tour->discount_price)
                        <span class="text-white-50 text-decoration-line-through fs-5">${{ number_format($tour->price) }}</span>
                        <span class="text-white fw-bold fs-3">${{ number_format($tour->discount_price) }}</span>
                        <span class="badge bg-danger rounded-pill">-{{ round((($tour->price - $tour->discount_price) / $tour->price) * 100) }}%</span>
                    @else
                        <span class="text-white fw-bold fs-3">${{ number_format($tour->price) }}</span>
                    @endif
                    <span class="text-white-50">/ person</span>
                </div>
            </div>
        </div>
    </div>

    <div class="floating-stats-bar">
        <div class="stat-item">
            <div class="stat-icon"><i class="bi bi-clock"></i></div>
            <div class="stat-value counter-value" data-target="{{ preg_replace('/[^0-9]/', '', $tour->duration) ?: 0 }}">0</div>
            <div class="stat-label">Days</div>
        </div>
        <div class="stat-item">
            <div class="stat-icon"><i class="bi bi-bar-chart"></i></div>
            <div class="stat-value">{{ $tour->difficulty }}</div>
            <div class="stat-label">Difficulty</div>
        </div>
        @if($tour->max_group_size)
        <div class="stat-item">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <div class="stat-value counter-value" data-target="{{ $tour->max_group_size }}">0</div>
            <div class="stat-label">Max Group</div>
        </div>
        @endif
    </div>
</section>

<section class="content-section" id="mainContent">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                @if($tour->galleries->count() > 0)
                    <div class="mb-4">
                        <div class="gallery-masonry">
                            @foreach($tour->galleries as $index => $gallery)
                                <div class="gallery-item"
                                     data-index="{{ $index }}"
                                     data-bs-toggle="modal"
                                     data-bs-target="#galleryModal">
                                    <img src="{{ storage_url($gallery->image) ?? 'https://placehold.co/600x400/3c453e/white?text=Gallery' }}"
                                         alt="{{ $gallery->caption ?? 'Gallery' }}">
                                    @if($gallery->caption)
                                        <div class="gallery-caption">{{ $gallery->caption }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <ul class="nav nav-tabs border-0" id="tourTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button">Overview</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="highlights-tab" data-bs-toggle="tab" data-bs-target="#highlights" type="button">Highlights</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="itinerary-tab" data-bs-toggle="tab" data-bs-target="#itinerary" type="button">Itinerary</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="inclusions-tab" data-bs-toggle="tab" data-bs-target="#inclusions" type="button">Includes/Excludes</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="map-tab" data-bs-toggle="tab" data-bs-target="#map" type="button">Map</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="dates-tab" data-bs-toggle="tab" data-bs-target="#dates" type="button">Dates & Pricing</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button">Reviews</button>
                    </li>
                </ul>

                <div class="tab-content" id="tourTabsContent">
                    <div class="tab-pane fade show active" id="overview">
                        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">About This Tour</h5>
                        <p style="line-height: 1.8; color: #495057;">{!! nl2br(e($tour->overview ?? $tour->description)) !!}</p>
                        @if($tour->accommodation)
                            <h6 class="fw-bold mt-4"><i class="bi bi-building me-2"></i>Accommodation</h6>
                            <p style="color: #495057;">{{ $tour->accommodation }}</p>
                        @endif
                        @if($tour->meals)
                            <h6 class="fw-bold mt-4"><i class="bi bi-cup-hot me-2"></i>Meals</h6>
                            <p style="color: #495057;">{{ $tour->meals }}</p>
                        @endif
                        @if($tour->transportation)
                            <h6 class="fw-bold mt-4"><i class="bi bi-bus-front me-2"></i>Transportation</h6>
                            <p style="color: #495057;">{{ $tour->transportation }}</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="highlights">
                        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Tour Highlights</h5>
                        @php $highlights = is_array($tour->highlights) ? $tour->highlights : (json_decode($tour->highlights, true) ?? explode("\n", $tour->highlights ?? '')); @endphp
                        @if(count($highlights) > 0)
                            <ul class="list-unstyled">
                                @foreach($highlights as $highlight)
                                    <li class="mb-3 d-flex">
                                        <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                        <span>{{ $highlight }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No highlights available.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="itinerary">
                        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Day-by-Day Itinerary</h5>
                        @if($tour->itineraries->count() > 0)
                            @foreach($tour->itineraries as $itinerary)
                                <div class="itinerary-day" data-day="{{ $itinerary->day }}">
                                    <h6 class="fw-bold">{{ $itinerary->title ?? 'Day ' . $itinerary->day }}</h6>
                                    <p style="color: #495057;">{!! nl2br(e($itinerary->description)) !!}</p>
                                    @if($itinerary->activities)
                                        <small class="text-muted"><i class="bi bi-activity me-1"></i>Activities: {{ $itinerary->activities }}</small><br>
                                    @endif
                                    @if($itinerary->meals_included)
                                        <small class="text-muted"><i class="bi bi-cup-hot me-1"></i>Meals: {{ $itinerary->meals_included }}</small>
                                    @endif
                                    @if($itinerary->accommodation)
                                        <br><small class="text-muted"><i class="bi bi-building me-1"></i>Accommodation: {{ $itinerary->accommodation }}</small>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Itinerary details coming soon.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="inclusions">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3 text-success"><i class="bi bi-check-circle me-2"></i>Included</h6>
                                @php $included = is_array($tour->included) ? $tour->included : (json_decode($tour->included, true) ?? explode("\n", $tour->included ?? '')); @endphp
                                @if(count($included) > 0)
                                    <ul class="list-unstyled">
                                        @foreach($included as $item)
                                            <li class="mb-2 included-item d-flex">
                                                <i class="bi bi-check-lg me-2"></i>{{ $item }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">No inclusions listed.</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3 text-danger"><i class="bi bi-x-circle me-2"></i>Excluded</h6>
                                @php $excluded = is_array($tour->excluded) ? $tour->excluded : (json_decode($tour->excluded, true) ?? explode("\n", $tour->excluded ?? '')); @endphp
                                @if(count($excluded) > 0)
                                    <ul class="list-unstyled">
                                        @foreach($excluded as $item)
                                            <li class="mb-2 excluded-item d-flex">
                                                <i class="bi bi-x-lg me-2"></i>{{ $item }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">No exclusions listed.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="map">
                        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Location</h5>
                        @if($tour->map_embed)
                            <div class="ratio ratio-16x9 rounded-4 overflow-hidden">
                                {!! $tour->map_embed !!}
                            </div>
                        @else
                            <div class="bg-light rounded-4 d-flex align-items-center justify-content-center" style="height: 400px;">
                                <div class="text-center text-muted">
                                    <i class="bi bi-map fs-1 d-block mb-2"></i>
                                    <span>Map not available</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="dates">
                        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Available Dates & Pricing</h5>
                        @if($tour->dates->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover dates-table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Price</th>
                                            <th>Available Seats</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tour->dates as $date)
                                            <tr>
                                                <td>{{ $date->start_date?->format('M d, Y') ?? 'TBD' }}</td>
                                                <td>{{ $date->end_date?->format('M d, Y') ?? 'TBD' }}</td>
                                                <td class="fw-bold" style="color: var(--primary-color);">${{ number_format($date->price ?? $tour->price) }}</td>
                                                <td>
                                                    @if($date->available_seats > 5)
                                                        <span class="badge bg-success">{{ $date->available_seats }} seats</span>
                                                    @elseif($date->available_seats > 0)
                                                        <span class="badge bg-warning">Only {{ $date->available_seats }} left!</span>
                                                    @else
                                                        <span class="badge bg-danger">Sold Out</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @auth
                                                        @if($date->available_seats > 0 && $date->status)
                                                            <a href="{{ route('booking.step1', $tour->slug) }}?date_id={{ $date->id }}" class="btn btn-sm btn-primary rounded-pill">Book</a>
                                                        @else
                                                            <button class="btn btn-sm btn-secondary rounded-pill" disabled>Sold Out</button>
                                                        @endif
                                                    @else
                                                        <a href="{{ route('customer.login') }}" class="btn btn-sm btn-outline-primary rounded-pill">Login to Book</a>
                                                    @endauth
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No dates available yet. Contact us for more information.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="reviews">
                        @php
                            $reviews = $tour->reviews()->approved()->latest()->get();
                            $avgRating = $reviews->avg('rating');
                            $ratingCounts = [];
                            for($i = 1; $i <= 5; $i++) {
                                $ratingCounts[$i] = $reviews->where('rating', $i)->count();
                            }
                        @endphp

                        <div class="row g-4 mb-4 p-4 bg-light rounded-4">
                            <div class="col-md-4 text-center">
                                <div class="display-3 fw-bold" style="color: var(--secondary-color);">{{ number_format($avgRating, 1) ?? '0.0' }}</div>
                                <div class="star-rating fs-5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= round($avgRating ?? 0) ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                                <small class="text-muted">{{ $reviews->count() }} reviews</small>
                            </div>
                            <div class="col-md-8">
                                @for($i = 5; $i >= 1; $i--)
                                    <div class="d-flex align-items-center mb-1">
                                        <small class="me-2" style="width: 40px;">{{ $i }} <i class="bi bi-star-fill" style="color: #f8b84a; font-size: 0.7rem;"></i></small>
                                        <div class="review-rating-bar flex-grow-1">
                                            @php $pct = $reviews->count() > 0 ? ($ratingCounts[$i] / $reviews->count()) * 100 : 0; @endphp
                                            <div class="progress-fill" style="width: {{ $pct }}%;"></div>
                                        </div>
                                        <small class="ms-2 text-muted" style="width: 30px;">{{ $ratingCounts[$i] }}</small>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        @if($reviews->count() > 0)
                            @foreach($reviews as $review)
                                <div class="review-card">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white me-3"
                                             style="width: 44px; height: 44px; font-weight: 600;">
                                            {{ strtoupper(substr($review->user?->name ?? 'A', 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0">{{ $review->user?->name ?? 'Anonymous' }}</h6>
                                            <div class="star-rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}" style="font-size: 0.8rem;"></i>
                                                @endfor
                                                @if($review->verified)
                                                    <span class="badge bg-success ms-2" style="font-size: 0.65rem;">Verified</span>
                                                @endif
                                            </div>
                                        </div>
                                        <small class="text-muted ms-auto">{{ $review->created_at->format('M d, Y') }}</small>
                                    </div>
                                    @if($review->title)
                                        <h6 class="fw-semibold mb-1">{{ $review->title }}</h6>
                                    @endif
                                    <p style="color: #495057;">{{ $review->review }}</p>
                                    <div class="d-flex align-items-center gap-3">
                                        <button class="btn btn-sm btn-outline-secondary rounded-pill helpful-btn"
                                                data-review-id="{{ $review->id }}">
                                            <i class="bi bi-hand-thumbs-up me-1"></i>Helpful
                                            <span class="helpful-count">({{ $review->helpful_votes }})</span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No reviews yet. Be the first to review this tour!</p>
                        @endif

                        @auth
                            @php $userBooking = $tour->bookings()->where('user_id', auth()->id())->where('status', 'completed')->first(); @endphp
                            @if($userBooking && !$userBooking->review)
                                <div class="mt-4 p-4 bg-light rounded-4">
                                    <h6 class="fw-bold mb-3">Write a Review</h6>
                                    <form action="{{ route('reviews.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                                        <input type="hidden" name="booking_id" value="{{ $userBooking->id }}">
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">Rating</label>
                                            <div class="star-rating fs-4" id="ratingStars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi bi-star" data-rating="{{ $i }}" style="cursor: pointer; color: #f8b84a;"></i>
                                                @endfor
                                            </div>
                                            <input type="hidden" name="rating" id="ratingInput" value="0">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" name="title" class="form-control rounded-pill" placeholder="Review title (optional)">
                                        </div>
                                        <div class="mb-3">
                                            <textarea name="review" class="form-control rounded-4" rows="4" placeholder="Share your experience..." required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary rounded-pill px-4">Submit Review</button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sidebar-price-box p-4">
                    <h5 class="fw-bold mb-1" style="color: var(--secondary-color);">Price</h5>
                    @if($tour->discount_price)
                        <div class="d-flex align-items-baseline gap-2 mb-3">
                            <span class="text-muted text-decoration-line-through fs-5">${{ number_format($tour->price) }}</span>
                            <span class="fw-bold fs-3 price-pulse" style="color: var(--primary-color);">${{ number_format($tour->discount_price) }}</span>
                            <span class="badge bg-danger">-{{ round((($tour->price - $tour->discount_price) / $tour->price) * 100) }}%</span>
                        </div>
                    @else
                        <div class="fw-bold fs-3 mb-3 price-pulse" style="color: var(--primary-color);">${{ number_format($tour->price) }}</div>
                    @endif
                    <small class="text-muted d-block mb-3">per person</small>

                    @auth
                        <a href="{{ route('booking.step1', $tour->slug) }}" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold mb-3">
                            <i class="bi bi-calendar-check me-2"></i>Book Now
                        </a>
                    @else
                        <a href="{{ route('customer.login') }}" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold mb-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login to Book
                        </a>
                    @endauth

                    <button class="btn btn-outline-primary w-100 rounded-pill mb-3 add-to-wishlist" data-tour-id="{{ $tour->id }}">
                        <i class="bi bi-heart me-2"></i>Add to Wishlist
                    </button>

                    <hr>

                    <h6 class="fw-bold mb-3" style="color: var(--secondary-color);">Tour Information</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <small class="text-muted"><i class="bi bi-clock me-1"></i>Duration</small>
                        <small class="fw-semibold">{{ $tour->duration }}</small>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <small class="text-muted"><i class="bi bi-people me-1"></i>Group Size</small>
                        <small class="fw-semibold">{{ $tour->max_group_size ?? 'N/A' }}</small>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <small class="text-muted"><i class="bi bi-bar-chart me-1"></i>Difficulty</small>
                        <small class="fw-semibold">{{ $tour->difficulty }}</small>
                    </div>
                    @if($tour->max_elevation)
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted"><i class="bi bi-triangle me-1"></i>Max Elevation</small>
                            <small class="fw-semibold">{{ $tour->max_elevation }}</small>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between mb-2">
                        <small class="text-muted"><i class="bi bi-sun me-1"></i>Best Season</small>
                        <small class="fw-semibold">{{ $tour->best_season ?? 'Year-round' }}</small>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <small class="text-muted"><i class="bi bi-chat me-1"></i>Languages</small>
                        <small class="fw-semibold">{{ $tour->languages ?? 'English' }}</small>
                    </div>

                    @if($tour->guide)
                        <hr>
                        <h6 class="fw-bold mb-3" style="color: var(--secondary-color);">Your Guide</h6>
                        <div class="d-flex align-items-center">
                            <img src="{{ storage_url($tour->guide->photo) ?? 'https://ui-avatars.com/api/?name=' . urlencode($tour->guide->name) . '&background=3c453e&color=fff&size=56' }}"
                                 alt="{{ $tour->guide->name }}" class="rounded-circle me-3" style="width: 56px; height: 56px; object-fit: cover;">
                            <div>
                                <h6 class="fw-bold mb-0">{{ $tour->guide->name }}</h6>
                                <small class="text-muted">{{ $tour->guide->experience ?? '' }}</small>
                                @if($tour->guide->rating)
                                    <div class="star-rating small">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= round($tour->guide->rating) ? '-fill' : '' }}"></i>
                                        @endfor
                                        <small>({{ $tour->guide->rating }})</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <hr>
                    <h6 class="fw-bold mb-2" style="color: var(--secondary-color);">Share This Tour</h6>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="share-btn"><i class="bi bi-facebook"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($tour->title) }}" target="_blank" class="share-btn"><i class="bi bi-twitter-x"></i></a>
                        <a href="https://wa.me/?text={{ urlencode($tour->title . ' ' . request()->url()) }}" target="_blank" class="share-btn"><i class="bi bi-whatsapp"></i></a>
                        <a href="mailto:?subject={{ urlencode($tour->title) }}&body={{ urlencode('Check out this tour: ' . request()->url()) }}" class="share-btn"><i class="bi bi-envelope"></i></a>
                        <button class="share-btn" onclick="navigator.clipboard.writeText(window.location.href).then(() => alert('Link copied!'))"><i class="bi bi-link-45deg"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($relatedTours->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <h4 class="fw-bold mb-4" style="color: var(--secondary-color);">Related Tours</h4>
        <div class="row g-4">
            @foreach($relatedTours as $related)
                <div class="col-lg-3 col-md-6">
                    @component('components.tour-card', ['tour' => $related])
                    @endcomponent
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($faqs->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-4 text-center" style="color: var(--secondary-color);">Frequently Asked Questions</h4>
                <div class="accordion faq-accordion" id="faqAccordion">
                    @foreach($faqs as $index => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq{{ $index }}">
                                    {{ $faq->question }}
                                </button>
                            </h2>
                            <div id="faq{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">{{ $faq->answer }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-body p-0 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-4 z-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <div id="galleryCarousel" class="carousel slide" data-bs-interval="false">
                    @if($tour->galleries->count() > 1)
                    <div class="carousel-indicators">
                        @foreach($tour->galleries as $index => $gallery)
                            <button type="button" data-bs-target="#galleryCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"
                                    aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                    @endif
                    <div class="carousel-inner">
                        @foreach($tour->galleries as $index => $gallery)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ storage_url($gallery->image) ?? 'https://placehold.co/1200x800/3c453e/white?text=Gallery' }}" class="d-block w-100" alt="{{ $gallery->caption ?? 'Gallery' }}">
                            </div>
                        @endforeach
                    </div>
                    @if($tour->galleries->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<a href="#dates" class="btn btn-primary d-md-none fixed-bottom mobile-book-btn" id="mobileBookBtn">
    <i class="bi bi-calendar-check me-2"></i>Book Now
</a>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
    <div id="wishlistToast" class="toast align-items-center border-0 rounded-4" role="alert" aria-live="assertive" aria-atomic="true" style="background: #181d2e; color: #fff;">
        <div class="d-flex">
            <div class="toast-body fw-semibold"><i class="bi bi-heart-fill text-danger me-2"></i><span>Added to Wishlist</span></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingStars = document.querySelectorAll('#ratingStars i');
    const ratingInput = document.getElementById('ratingInput');
    ratingStars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            ratingInput.value = rating;
            ratingStars.forEach((s, i) => {
                if (i < rating) s.className = 'bi bi-star-fill';
                else s.className = 'bi bi-star';
            });
        });
    });

    const wishlistBtn = document.querySelector('.add-to-wishlist');
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function() {
            const tourId = this.dataset.tourId;
            const toastEl = document.getElementById('wishlistToast');
            fetch('/customer/wishlist/toggle/' + tourId, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            }).then(r => r.json()).then(d => {
                if (d.status === 'added') {
                    this.innerHTML = '<i class="bi bi-heart-fill me-2"></i>Remove from Wishlist';
                    toastEl.querySelector('.toast-body').textContent = 'Added to Wishlist';
                } else {
                    this.innerHTML = '<i class="bi bi-heart me-2"></i>Add to Wishlist';
                    toastEl.querySelector('.toast-body').textContent = 'Removed from Wishlist';
                }
                const toast = bootstrap.Toast.getOrCreateInstance(toastEl);
                toast.show();
            });
        });
    }

    const galleryItems = document.querySelectorAll('.gallery-item');
    let galleryCarousel = null;
    const galleryModalEl = document.getElementById('galleryModal');
    if (galleryModalEl) {
        galleryModalEl.addEventListener('shown.bs.modal', function () {
            galleryCarousel = new bootstrap.Carousel(document.getElementById('galleryCarousel'), {
                interval: false
            });
        });
        galleryModalEl.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            if (trigger && trigger.dataset.index !== undefined) {
                const index = parseInt(trigger.dataset.index);
                const carouselEl = document.getElementById('galleryCarousel');
                const carousel = bootstrap.Carousel.getInstance(carouselEl);
                if (carousel) {
                    carousel.to(index);
                } else {
                    galleryCarousel = new bootstrap.Carousel(carouselEl, { interval: false });
                    setTimeout(function() {
                        const c = bootstrap.Carousel.getInstance(carouselEl);
                        if (c) c.to(index);
                    }, 100);
                }
            }
        });
    }

    const navLinks = document.querySelectorAll('#tourTabs .nav-link');
    navLinks.forEach(link => {
        link.addEventListener('shown.bs.tab', function (e) {
            const target = document.querySelector(e.target.getAttribute('data-bs-target'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    const helpfulBtns = document.querySelectorAll('.helpful-btn');
    helpfulBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const reviewId = this.dataset.reviewId;
            const countSpan = this.querySelector('.helpful-count');
            fetch('/reviews/' + reviewId + '/helpful', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).then(r => r.json()).then(d => {
                if (d.success && countSpan) {
                    countSpan.textContent = '(' + d.total + ')';
                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('btn-secondary');
                }
            }).catch(function() {
                window.location.href = '{{ route("customer.login") }}';
            });
        });
    });

    const mobileBookBtn = document.getElementById('mobileBookBtn');
    if (mobileBookBtn) {
        mobileBookBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const datesTab = document.getElementById('dates-tab');
            if (datesTab) {
                const tab = new bootstrap.Tab(datesTab);
                tab.show();
            }
            const datesPane = document.getElementById('dates');
            if (datesPane) {
                datesPane.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }

    const hero = document.querySelector('.parallax-hero');
    if (hero && window.innerWidth > 768) {
        const factor = parseFloat(hero.dataset.parallaxFactor) || 0.35;
        function updateParallax() {
            const scrolled = window.pageYOffset;
            const heroBottom = hero.offsetTop + hero.offsetHeight;
            if (scrolled <= heroBottom) {
                hero.style.backgroundPosition = '50% ' + (scrolled * factor) + 'px';
            }
        }
        window.addEventListener('scroll', updateParallax, { passive: true });
        updateParallax();
    }

    const counterEls = document.querySelectorAll('.counter-value');
    if (counterEls.length > 0) {
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.dataset.target);
                    if (isNaN(target) || target === 0) {
                        el.textContent = target || 0;
                        return;
                    }
                    const duration = 1200;
                    const startTime = performance.now();
                    function step(currentTime) {
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3);
                        el.textContent = Math.floor(eased * target);
                        if (progress < 1) {
                            requestAnimationFrame(step);
                        } else {
                            el.textContent = target;
                        }
                    }
                    requestAnimationFrame(step);
                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.3 });
        counterEls.forEach(el => observer.observe(el));
    }
});
</script>
@endpush
