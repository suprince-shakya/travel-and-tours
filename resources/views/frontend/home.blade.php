@extends('layouts.frontend')

@section('content')


{{-- ===== 1. HERO BANNER ===== --}}
<section class="hero-section d-flex align-items-center position-relative overflow-hidden">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10 col-xl-8">
                <span class="badge bg-white text-dark px-4 py-2 mb-4 rounded-pill fw-semibold fs-6" style="background: rgba(255,255,255,0.15) !important; backdrop-filter: blur(8px); color:#fff !important; border:1px solid rgba(255,255,255,0.2);">
                    <i class="bi bi-globe2 me-2"></i>Explore Amazing Destinations
                </span>
                <h1 class="display-3 fw-bold text-white mb-3" style="letter-spacing: -0.5px;">
                    Explore The World <br class="d-none d-sm-block">With Us
                </h1>
                <p class="lead text-white-50 mb-4 mx-auto" style="max-width: 600px;">
                    Find the best tours, adventures, and travel experiences across the globe
                </p>

                <form class="hero-search-form d-flex align-items-center flex-wrap mx-auto" style="max-width: 750px;" action="{{ route('tours.index') }}" method="GET">
                    <div class="flex-grow-1 d-flex align-items-center px-2" style="min-width: 160px;">
                        <i class="bi bi-search text-white-50 me-2"></i>
                        <input type="text" class="form-control" name="destination" placeholder="Where to?" aria-label="Destination">
                    </div>
                    <div class="d-flex align-items-center px-2" style="min-width: 140px;">
                        <i class="bi bi-calendar3 text-white-50 me-2"></i>
                        <input type="date" class="form-control" name="date" aria-label="Date">
                    </div>
                    <div class="d-flex align-items-center px-2" style="min-width: 120px;">
                        <i class="bi bi-people text-white-50 me-2"></i>
                        <select class="form-select" name="guests" aria-label="Guests">
                            <option value="1">1 Guest</option>
                            <option value="2" selected>2 Guests</option>
                            <option value="3">3 Guests</option>
                            <option value="4">4 Guests</option>
                            <option value="5">5+ Guests</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-search d-block mx-auto mt-2">
                        <i class="bi bi-search me-2"></i>Search
                    </button>
                </form>

                <div class="d-flex justify-content-center gap-4 mt-4 flex-wrap">
                    <div class="text-white d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span class="text-white-50">500+ Tours</span>
                    </div>
                    <div class="text-white d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span class="text-white-50">100+ Destinations</span>
                    </div>
                    <div class="text-white d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span class="text-white-50">50k+ Happy Travelers</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 2. TOUR SEARCH SECTION ===== --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5" style="margin-top: -60px; position: relative; z-index: 3;">
            <form action="{{ route('tours.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small text-uppercase text-muted">Destination</label>
                    <input type="text" class="form-control form-control-lg rounded-pill" name="destination" placeholder="City or country">
                </div>
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-semibold small text-uppercase text-muted">Category</label>
                    <select class="form-select form-select-lg rounded-pill" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-semibold small text-uppercase text-muted">Min Price</label>
                    <input type="number" class="form-control form-control-lg rounded-pill" name="min_price" placeholder="$0" min="0">
                </div>
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-semibold small text-uppercase text-muted">Max Price</label>
                    <input type="number" class="form-control form-control-lg rounded-pill" name="max_price" placeholder="$9999" min="0">
                </div>
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-semibold small text-uppercase text-muted">Duration</label>
                    <select class="form-select form-select-lg rounded-pill" name="duration">
                        <option value="">Any</option>
                        <option value="1-3">1-3 Days</option>
                        <option value="4-7">4-7 Days</option>
                        <option value="8-14">1-2 Weeks</option>
                        <option value="15">2+ Weeks</option>
                    </select>
                </div>
                <div class="col-lg-1 col-md-6 d-grid">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- ===== 3. FEATURED DESTINATIONS CAROUSEL ===== --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-center">Featured Destinations</h2>
            <p class="section-subtitle">Handpicked destinations for your next adventure</p>
        </div>
        <div id="destinationsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @forelse($featuredDestinations->chunk(4) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach($chunk as $destination)
                        <div class="col-md-3">
                            <div class="card destination-card h-100">
                                <img src="{{ $destination->image_url ?? 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                                    class="card-img-top" alt="{{ $destination->name }}">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        @if($destination->flag_url)
                                        <img src="{{ $destination->flag_url }}" alt="{{ $destination->code }}" class="country-flag">
                                        @elseif($destination->flag)
                                        <img src="{{ storage_url($destination->flag) }}" alt="{{ $destination->code }}" class="country-flag">
                                        @endif
                                        <h6 class="fw-bold mb-0">{{ $destination->name }}</h6>
                                    </div>
                                    <p class="tour-count mb-3">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $destination->tours_count ?? 0 }} Tours Available
                                    </p>
                                    <div class="mt-auto">
                                        <a href="{{ route('tours.index', ['country' => $destination->slug]) }}"
                                            class="btn btn-outline-primary btn-sm rounded-pill px-4 w-100">
                                            Explore <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">No featured destinations available.</div>
                @endforelse
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#destinationsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#destinationsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

{{-- ===== 4. POPULAR COUNTRIES ===== --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title text-center">Top Travel Countries</h2>
            <p class="section-subtitle">Discover tours by country</p>
        </div>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            @forelse($countries as $country)
            <a href="{{ route('tours.index', ['country' => $country->slug]) }}" class="country-pill scroll-animate">
                @if($country->flag_url)
                <img src="{{ $country->flag_url }}" alt="{{ $country->code }}">
                @elseif($country->flag)
                <img src="{{ storage_url($country->flag) }}" alt="{{ $country->code }}">
                @endif
                <span>{{ $country->name }}</span>
                <span class="ms-2 text-muted fw-normal">({{ $country->tours_count ?? 0 }})</span>
            </a>
            @empty
            <div class="text-muted py-3">No countries available.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ===== 5. TRENDING TOURS ===== --}}
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="section-title mb-0">Trending Tours</h2>
                <p class="section-subtitle mb-0">Most popular tours right now</p>
            </div>
            <a href="{{ route('tours.index', ['sort' => 'popular']) }}" class="btn btn-outline-primary rounded-pill px-4 d-none d-md-inline-block">
                View All <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-4">
            @forelse($popularTours as $tour)
            <div class="col-lg-4 col-md-6">
                <div class="tour-card-wrapper scroll-animate">
                    @component('components.tour-card', ['tour' => $tour])
                    @endcomponent
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">No trending tours available.</div>
            @endforelse
        </div>
        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('tours.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                View All Tours <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- ===== 6. FEATURED PACKAGES ===== --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-center">Featured Packages</h2>
            <p class="section-subtitle">Special curated packages with exclusive deals</p>
        </div>
        <div class="row g-4">
            @forelse($featuredTours as $tour)
            <div class="col-lg-4 col-md-6">
                <div class="tour-card-wrapper scroll-animate position-relative">
                    @if($tour->discounted_price)
                    <span class="badge-discount">
                        <i class="bi bi-tag-fill me-1"></i>
                        @php $discountPct = round((1 - $tour->discount_price / $tour->price) * 100); @endphp
                        {{ $discountPct }}% OFF
                    </span>
                    @else
                    <span class="package-badge">Featured</span>
                    @endif
                    @component('components.tour-card', ['tour' => $tour])
                    @endcomponent
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">No featured packages available.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ===== 7. WHY CHOOSE US ===== --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-center">Why Choose Us</h2>
            <p class="section-subtitle">We go above and beyond to make your travel experience unforgettable</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="feature-card scroll-animate">
                    <div class="feature-icon"><i class="bi bi-person-badge"></i></div>
                    <h5>Expert Local Guides</h5>
                    <p>Knowledgeable local guides who bring destinations to life with insider stories and expertise.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-card scroll-animate">
                    <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                    <h5>Best Price Guarantee</h5>
                    <p>We match any lower price and offer the best value for your travel budget.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-card scroll-animate">
                    <div class="feature-icon"><i class="bi bi-headset"></i></div>
                    <h5>24/7 Customer Support</h5>
                    <p>Round-the-clock assistance to ensure your travel goes smoothly from start to finish.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-card scroll-animate">
                    <div class="feature-icon"><i class="bi bi-heart"></i></div>
                    <h5>Handpicked Experiences</h5>
                    <p>Every tour is carefully curated to deliver authentic, memorable travel experiences.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 8. ADVENTURE CATEGORIES CAROUSEL ===== --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-center">Adventure Categories</h2>
            <p class="section-subtitle">Find your perfect adventure by category</p>
        </div>
        <div id="categoriesCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @forelse($categories->chunk(6) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach($chunk as $category)
                        <div class="col-md-2 col-6">
                            <a href="{{ route('tours.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                                <div class="card category-card text-center h-100">
                                    <img src="{{ $category->image ? storage_url($category->image) : 'https://images.unsplash.com/photo-1501555088659-1a8a10c1e3c9?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}"
                                        alt="{{ $category->name }}">
                                    <div class="card-body">
                                        <h6 class="text-dark">{{ $category->name }}</h6>
                                        <small class="text-muted">{{ $category->tours_count ?? 0 }} Tours</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">No categories available.</div>
                @endforelse
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#categoriesCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#categoriesCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

{{-- ===== 9. CUSTOMER TESTIMONIALS ===== --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-center">What Our Travelers Say</h2>
            <p class="section-subtitle">Real reviews from real travelers</p>
        </div>
        <div class="row g-4">
            @forelse($testimonials as $testimonial)
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card scroll-animate">
                    <i class="bi bi-quote quote-icon"></i>
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $testimonial->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($testimonial->name) . '&background=3c453e&color=fff&size=56' }}"
                            alt="{{ $testimonial->name }}" class="testimonial-photo">
                        <div>
                            <h6 class="fw-bold mb-0">{{ $testimonial->name }}</h6>
                            <small class="text-muted">{{ $testimonial->designation }}</small>
                        </div>
                    </div>
                    <div class="stars mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $testimonial->rating ? '-fill' : '' }}"></i>
                            @endfor
                    </div>
                    <p class="testimonial-text mb-0">{{ Str::limit($testimonial->content, 160) }}</p>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">No testimonials available.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ===== 10. LUXURY PACKAGES ===== --}}
@if($featuredTours->count() >= 3)
<section class="py-5 bg-dark" style="background: linear-gradient(135deg, #181d2e 0%, #2a3a4a 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-center" style="color:#fff;">Luxury Experiences</h2>
            <p class="section-subtitle" style="color: rgba(255,255,255,0.6);">Premium tours for discerning travelers</p>
        </div>
        <div class="row g-4">
            @foreach($featuredTours->take(3) as $tour)
            <div class="col-lg-4 col-md-6">
                <div class="tour-card-wrapper scroll-animate position-relative">
                    <span class="package-badge" style="background:#f8b84a; color:#181d2e;">
                        <i class="bi bi-gem me-1"></i>Luxury
                    </span>
                    @component('components.tour-card', ['tour' => $tour])
                    @endcomponent
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== 11. FAMILY PACKAGES ===== --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-center">Family Adventures</h2>
            <p class="section-subtitle">Fun for the whole family</p>
        </div>
        <div class="row g-4">
            @forelse($popularTours->take(3) as $tour)
            <div class="col-lg-4 col-md-6">
                <div class="tour-card-wrapper scroll-animate position-relative">
                    <span class="package-badge" style="background:#198754;">
                        <i class="bi bi-people-fill me-1"></i>Family
                    </span>
                    @component('components.tour-card', ['tour' => $tour])
                    @endcomponent
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">No family packages available.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ===== 12. HONEYMOON PACKAGES ===== --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-center">Romantic Getaways</h2>
            <p class="section-subtitle">Perfect escapes for couples and honeymooners</p>
        </div>
        <div class="row g-4">
            @forelse($featuredTours->take(3) as $tour)
            <div class="col-lg-4 col-md-6">
                <div class="tour-card-wrapper scroll-animate position-relative">
                    <span class="package-badge" style="background:#dc3545;">
                        <i class="bi bi-heart-fill me-1"></i>Romantic
                    </span>
                    @component('components.tour-card', ['tour' => $tour])
                    @endcomponent
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">No honeymoon packages available.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ===== 13. UPCOMING FESTIVALS ===== --}}
@if($featuredTours->where('available_from', '!=', null)->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-center">Upcoming Festivals & Events</h2>
            <p class="section-subtitle">Don't miss these incredible cultural celebrations</p>
        </div>
        <div class="row g-4">
            @foreach($featuredTours->where('available_from', '!=', null)->take(4) as $tour)
            <div class="col-lg-3 col-md-6">
                <div class="card destination-card scroll-animate h-100">
                    <div class="position-relative">
                        <img src="{{ $tour->thumbnail_url ?? 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                            class="card-img-top" alt="{{ $tour->title }}">
                        <div class="position-absolute bottom-0 start-0 end-0 p-2" style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
                            <small class="text-white">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ $tour->available_from ? $tour->available_from->format('M d, Y') : 'TBD' }}
                            </small>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">{{ $tour->title }}</h6>
                        <small class="text-muted">
                            <i class="bi bi-geo-alt me-1"></i>
                            {{ $tour->country->name ?? 'Various Locations' }}
                        </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== 14. BLOG SECTION ===== --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="section-title mb-0">Latest Travel Stories</h2>
                <p class="section-subtitle mb-0">Inspiration for your next journey</p>
            </div>
            <a href="{{ route('blog.index') }}" class="btn btn-outline-primary rounded-pill px-4 d-none d-md-inline-block">
                View All <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-4">
            @forelse($blogs as $blog)
            <div class="col-lg-4 col-md-6">
                <div class="scroll-animate">
                    @component('components.blog-card', ['blog' => $blog])
                    @endcomponent
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">No blog posts available.</div>
            @endforelse
        </div>
        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('blog.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                View All Stories <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- ===== 15. INSTAGRAM GALLERY ===== --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-center">Follow Our Adventures</h2>
            <p class="section-subtitle">Tag us @travels for a chance to be featured</p>
        </div>
        <div class="instagram-grid">
            @php
            $igImages = [
            'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1500835556837-99ac94a94552?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            ];
            @endphp
            @foreach($igImages as $igImg)
            <a href="https://instagram.com" target="_blank" class="scroll-animate">
                <img src="{{ $igImg }}" alt="Instagram" loading="lazy">
                <div class="ig-overlay">
                    <i class="bi bi-instagram"></i>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== 16. NEWSLETTER SECTION ===== --}}
<section class="py-5">
    <div class="container">
        <div class="newsletter-section">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-8 col-xl-6 text-center">
                    <i class="bi bi-envelope-paper-heart text-white fs-1 mb-3 d-block"></i>
                    <h3 class="text-white fw-bold mb-2">Stay Updated</h3>
                    <p class="text-white-50 mb-4">Subscribe to our newsletter for exclusive deals, travel tips, and new adventures</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="d-flex mx-auto" style="max-width: 500px;">
                        @csrf
                        <input type="email" class="form-control form-control-lg" name="email" placeholder="Your email address" required>
                        <button type="submit" class="btn-subscribe">
                            <i class="bi bi-send me-2"></i>Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 17. PARTNERS / CLIENTS ===== --}}
@if($partners->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <h5 class="text-muted text-uppercase fw-semibold small" style="letter-spacing: 2px;">Our Partners</h5>
        </div>
        <div class="row align-items-center justify-content-center g-4">
            @foreach($partners as $partner)
            <div class="col-lg-2 col-md-3 col-4 text-center">
                <a href="{{ $partner->website }}" target="_blank" rel="noopener noreferrer" class="d-block">
                    <img src="{{ $partner->logo_url ?? 'https://via.placeholder.com/150x50/e9ecef/6c757d?text=' . urlencode($partner->name) }}"
                        alt="{{ $partner->name }}" class="partner-logo scroll-animate">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== 18. FAQs ===== --}}
@if($faqs->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h2 class="section-title text-center">Frequently Asked Questions</h2>
                    <p class="section-subtitle">Everything you need to know before booking</p>
                </div>
                <div class="accordion faq-accordion" id="faqAccordion">
                    @foreach($faqs as $index => $faq)
                    <div class="accordion-item scroll-animate">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faq{{ $index }}"
                                aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                                <i class="bi bi-question-circle me-2" style="color: var(--primary);"></i>
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="faq{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ===== 19. CALL TO ACTION ===== --}}
<section class="py-5">
    <div class="container">
        <div class="cta-section text-center position-relative" style="z-index: 1;">
            <div class="position-relative" style="z-index: 2;">
                <h2 class="display-5 fw-bold text-white mb-3">Ready for Your Next Adventure?</h2>
                <p class="lead text-white-50 mb-4 mx-auto" style="max-width: 550px;">
                    Join thousands of happy travelers. Book your dream tour today and create memories that last a lifetime.
                </p>
                <a href="{{ route('tours.index') }}" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold" style="color: var(--secondary);">
                    Explore Tours <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===== 20. VIDEO BANNER SECTION ===== --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="video-section d-flex align-items-center justify-content-center p-5">
            <div class="text-center">
                <a href="#" class="video-play-btn mx-auto mb-4" data-bs-toggle="modal" data-bs-target="#videoModal">
                    <i class="bi bi-play-fill ms-1"></i>
                </a>
                <h3 class="text-white fw-bold mb-1">Watch Our Story</h3>
                <p class="text-white-50 mb-0">See what makes our tours unforgettable</p>
            </div>
        </div>
    </div>

    <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 bg-transparent">
                <div class="modal-body p-0 position-relative">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="ratio ratio-16x9 bg-dark rounded-4 overflow-hidden">
                        <div class="d-flex align-items-center justify-content-center text-white-50">
                            <i class="bi bi-film fs-1 me-2"></i>
                            <span>Your promo video will play here</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const animateElements = document.querySelectorAll('.scroll-animate');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        animateElements.forEach(el => observer.observe(el));

        const heroForm = document.querySelector('.hero-search-form');
        if (heroForm) {
            const selects = heroForm.querySelectorAll('.form-select');
            selects.forEach(select => {
                select.addEventListener('change', function() {
                    if (this.value) {
                        this.style.color = '#fff';
                    }
                });
            });
        }
    });
</script>
@endpush

@endsection