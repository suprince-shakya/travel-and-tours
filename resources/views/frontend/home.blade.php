@extends('layouts.frontend')

@section('content')

{{-- ===== 1. HERO ===== --}}
<section class="hero-section d-flex align-items-center position-relative overflow-hidden">
    <div class="hero-particles">
        <span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span>
    </div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10 col-xl-8">
                <div class="hero-badge mb-4">
                    <span class="badge-pill">
                        <i class="bi bi-globe2 me-2"></i>Explore Amazing Destinations
                    </span>
                </div>
                <h1 class="hero-title">
                    Discover The<br>World's Hidden Gems
                </h1>
                <p class="hero-subtitle">
                    Curated travel experiences that take you beyond the ordinary.
                    From ancient wonders to hidden paradises — your next adventure awaits.
                </p>

                <form class="hero-search-form mx-auto" action="{{ route('tours.index') }}" method="GET">
                    <div class="search-group">
                        <div class="search-field">
                            <i class="bi bi-search"></i>
                            <input type="text" name="destination" placeholder="Destination" aria-label="Destination">
                        </div>
                        <div class="search-divider"></div>
                        <div class="search-field">
                            <i class="bi bi-calendar3"></i>
                            <input type="date" name="date" aria-label="Date">
                        </div>
                        <div class="search-divider"></div>
                        <div class="search-field">
                            <i class="bi bi-people"></i>
                            <select name="guests" aria-label="Guests">
                                <option value="1">1 Guest</option>
                                <option value="2" selected>2 Guests</option>
                                <option value="3">3 Guests</option>
                                <option value="4">4 Guests</option>
                                <option value="5">5+ Guests</option>
                            </select>
                        </div>
                        <button type="submit" class="search-btn">
                            <i class="bi bi-search me-2"></i>Search
                        </button>
                    </div>
                </form>

                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-value">500+</span>
                        <span class="stat-label">Tours</span>
                    </div>
                    <div class="stat-dot"></div>
                    <div class="stat-item">
                        <span class="stat-value">100+</span>
                        <span class="stat-label">Destinations</span>
                    </div>
                    <div class="stat-dot"></div>
                    <div class="stat-item">
                        <span class="stat-value">50k+</span>
                        <span class="stat-label">Travelers</span>
                    </div>
                    <div class="stat-dot"></div>
                    <div class="stat-item">
                        <span class="stat-value">4.8</span>
                        <span class="stat-label">Rating</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-scroll-indicator">
        <span>Scroll</span>
        <i class="bi bi-chevron-down"></i>
    </div>
</section>

{{-- ===== 2. FEATURED DESTINATIONS ===== --}}
<section class="section section-destinations">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-tag">Destinations</span>
                <h2 class="section-title">Featured Destinations</h2>
                <p class="section-subtitle">Handpicked destinations for your next adventure</p>
            </div>
            <a href="{{ route('destinations.index') }}" class="btn-outline-link d-none d-md-flex">
                View All <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
        <div id="destinationsCarousel" class="carousel slide" data-bs-ride="false" data-bs-interval="false">
            <div class="carousel-inner">
                @forelse($featuredDestinations->chunk(4) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach($chunk as $destination)
                        <div class="col-md-3 mb-4">
                            <a href="{{ route('tours.index', ['country' => $destination->slug]) }}" class="dest-card-link">
                                <div class="dest-card-featured scroll-animate">
                                    <div class="dest-card-bg">
                                        <img src="{{ $destination->image_url ?? 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=800&q=80' }}"
                                            alt="{{ $destination->name }}">
                                    </div>
                                    <div class="dest-card-gradient"></div>
                                    @if($destination->flag_url)
                                    <img src="{{ $destination->flag_url }}" alt="{{ $destination->code }}" class="dest-card-flag">
                                    @elseif($destination->flag)
                                    <img src="{{ storage_url($destination->flag) }}" alt="{{ $destination->code }}" class="dest-card-flag">
                                    @endif
                                    <div class="dest-card-content">
                                        <h4>{{ $destination->name }}</h4>
                                        <span>
                                            <i class="bi bi-geo-alt me-1"></i>{{ $destination->tours_count ?? 0 }} tours available
                                        </span>
                                    </div>
                                    <div class="dest-card-hover">
                                        <span>Explore <i class="bi bi-arrow-right ms-1"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="text-center py-5 text-muted">No featured destinations available.</div>
                @endforelse
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#destinationsCarousel" data-bs-slide="prev">
                <span class="carousel-arrow" aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#destinationsCarousel" data-bs-slide="next">
                <span class="carousel-arrow" aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('destinations.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                View All <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- ===== 3. TRENDING TOURS ===== --}}
<section class="section section-trending bg-light">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-tag">Trending</span>
                <h2 class="section-title">Trending Tours</h2>
                <p class="section-subtitle">Most popular tours right now</p>
            </div>
            <a href="{{ route('tours.index', ['sort' => 'popular']) }}" class="btn-outline-link d-none d-md-flex">
                View All <i class="bi bi-arrow-right ms-2"></i>
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

{{-- ===== 4. WHY CHOOSE US ===== --}}
<section class="section section-why">
    <div class="container">
        <div class="section-header text-center">
            <div>
                <span class="section-tag">Why Us</span>
                <h2 class="section-title">Why Choose Us</h2>
                <p class="section-subtitle">We go above and beyond to make your travel experience unforgettable</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="feature-card-modern scroll-animate">
                    <div class="feature-icon-wrap" style="background: linear-gradient(135deg, #3c453e, #5a6b5e);">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <h5>Expert Local Guides</h5>
                    <p>Knowledgeable local guides who bring destinations to life with insider stories and expertise.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-card-modern scroll-animate">
                    <div class="feature-icon-wrap" style="background: linear-gradient(135deg, #181d2e, #2d3a5c);">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h5>Best Price Guarantee</h5>
                    <p>We match any lower price and offer the best value for your travel budget.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-card-modern scroll-animate">
                    <div class="feature-icon-wrap" style="background: linear-gradient(135deg, #3c453e, #5a6b5e);">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h5>24/7 Customer Support</h5>
                    <p>Round-the-clock assistance to ensure your travel goes smoothly from start to finish.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-card-modern scroll-animate">
                    <div class="feature-icon-wrap" style="background: linear-gradient(135deg, #181d2e, #2d3a5c);">
                        <i class="bi bi-heart"></i>
                    </div>
                    <h5>Handpicked Experiences</h5>
                    <p>Every tour is carefully curated to deliver authentic, memorable travel experiences.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 5. CATEGORIES ===== --}}
<section class="section section-categories bg-light">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-tag">Categories</span>
                <h2 class="section-title">Adventure Categories</h2>
                <p class="section-subtitle">Find your perfect adventure by category</p>
            </div>
        </div>
        <div id="categoriesCarousel" class="carousel slide" data-bs-ride="false" data-bs-interval="false">
            <div class="carousel-inner">
                @forelse($categories->chunk(4) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach($chunk as $category)
                        <div class="col-md-3 col-6 mb-4">
                            <a href="{{ route('tours.index', ['category' => $category->slug]) }}" class="dest-card-link">
                                <div class="cat-card-featured scroll-animate">
                                    <div class="cat-card-bg">
                                        <img src="{{ $category->image ? storage_url($category->image) : 'https://images.unsplash.com/photo-1501555088659-1a8a10c1e3c9?auto=format&fit=crop&w=600&q=80' }}"
                                            alt="{{ $category->name }}">
                                    </div>
                                    <div class="cat-card-gradient"></div>
                                    <div class="cat-card-content">
                                        <h5>{{ $category->name }}</h5>
                                        <span>
                                            <i class="bi bi-geo-alt me-1"></i>{{ $category->tours_count ?? 0 }} tours
                                        </span>
                                    </div>
                                    <div class="cat-card-hover">
                                        <span>Explore <i class="bi bi-arrow-right ms-1"></i></span>
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
                <span class="carousel-arrow" aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#categoriesCarousel" data-bs-slide="next">
                <span class="carousel-arrow" aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

{{-- ===== 6. FEATURED PACKAGES ===== --}}
@if($featuredTours->count() > 0)
<section class="section section-featured">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-tag">Special Offers</span>
                <h2 class="section-title">Featured Packages</h2>
                <p class="section-subtitle">Special curated packages with exclusive deals</p>
            </div>
        </div>
        <div id="packagesCarousel" class="carousel slide" data-bs-ride="false" data-bs-interval="false">
            <div class="carousel-inner">
                @forelse($featuredTours->chunk(3) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach($chunk as $tour)
                        <div class="col-md-4 mb-4">
                            <div class="tour-card-wrapper scroll-animate position-relative">
                                @if($tour->discount_price)
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
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">No featured packages available.</div>
                @endforelse
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#packagesCarousel" data-bs-slide="prev">
                <span class="carousel-arrow" aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#packagesCarousel" data-bs-slide="next">
                <span class="carousel-arrow" aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
@endif

{{-- ===== 7. TESTIMONIALS ===== --}}
<section class="section section-testimonials">
    <div class="container">
        <div class="section-header text-center">
            <div>
                <span class="section-tag">Testimonials</span>
                <h2 class="section-title">What Travelers Say</h2>
                <p class="section-subtitle">Real reviews from real travelers</p>
            </div>
        </div>
        <div class="row g-4">
            @forelse($testimonials as $testimonial)
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card-modern scroll-animate">
                    <div class="testimonial-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $testimonial->rating ? '-fill' : '' }}"></i>
                        @endfor
                    </div>
                    <p class="testimonial-text">"{{ Str::limit($testimonial->content, 150) }}"</p>
                    <div class="testimonial-author">
                        <img src="{{ $testimonial->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($testimonial->name) . '&background=3c453e&color=fff&size=56' }}"
                            alt="{{ $testimonial->name }}">
                        <div>
                            <h6>{{ $testimonial->name }}</h6>
                            <small>{{ $testimonial->designation }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">No testimonials available.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ===== 8. BLOG ===== --}}
<section class="section section-blog bg-light">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-tag">Blog</span>
                <h2 class="section-title">Latest Travel Stories</h2>
                <p class="section-subtitle">Inspiration for your next journey</p>
            </div>
            <a href="{{ route('blog.index') }}" class="btn-outline-link d-none d-md-flex">
                View All <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
        <div class="row g-4">
            @forelse($blogs as $blog)
            <div class="col-lg-4 col-md-6">
                <div class="scroll-animate h-100">
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

{{-- ===== 9. COUNTRIES ===== --}}
<section class="section section-countries">
    <div class="container">
        <div class="section-header text-center">
            <div>
                <span class="section-tag">Countries</span>
                <h2 class="section-title">Explore by Country</h2>
                <p class="section-subtitle">Discover tours by country</p>
            </div>
        </div>
        <div class="countries-grid">
            @forelse($countries as $country)
            <a href="{{ route('tours.index', ['country' => $country->slug]) }}" class="country-chip scroll-animate">
                @if($country->flag_url)
                <img src="{{ $country->flag_url }}" alt="{{ $country->code }}">
                @elseif($country->flag)
                <img src="{{ storage_url($country->flag) }}" alt="{{ $country->code }}">
                @endif
                <span>{{ $country->name }}</span>
                <span class="country-count">{{ $country->tours_count ?? 0 }}</span>
            </a>
            @empty
            <div class="text-muted py-3 text-center">No countries available.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ===== 10. NEWSLETTER ===== --}}
<section class="section section-newsletter">
    <div class="container">
        <div class="newsletter-card">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <span class="section-tag text-white-50">Stay Connected</span>
                    <h2 class="text-white fw-bold mb-2">Join Our Travel Community</h2>
                    <p class="text-white-50 mb-0">Subscribe for exclusive deals, travel tips, and new adventures</p>
                </div>
                <div class="col-lg-6">
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="newsletter-form">
                        @csrf
                        <div class="newsletter-input-group">
                            <i class="bi bi-envelope"></i>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                            <button type="submit" class="btn btn-light rounded-pill px-4 fw-semibold">
                                Subscribe <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 11. FAQ ===== --}}
@if($faqs->count() > 0)
<section class="section section-faq bg-light">
    <div class="container">
        <div class="section-header text-center">
            <div>
                <span class="section-tag">FAQ</span>
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">Everything you need to know before booking</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
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

{{-- ===== 12. CTA ===== --}}
<section class="section section-cta">
    <div class="container">
        <div class="cta-card">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="display-5 fw-bold text-white mb-3">Ready for Your Next Adventure?</h2>
                    <p class="lead text-white-50 mb-4 mx-auto" style="max-width: 550px;">
                        Join thousands of happy travelers. Book your dream tour today and create memories that last a lifetime.
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('tours.index') }}" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold" style="color: var(--secondary);">
                            Explore Tours <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg rounded-pill px-5 py-3 fw-bold">
                            Contact Us <i class="bi bi-chat-dots ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 13. PARTNERS ===== --}}
@if($partners->count() > 0)
<section class="section section-partners">
    <div class="container">
        <div class="text-center mb-4">
            <span class="section-tag">Partners</span>
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
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        animateElements.forEach(el => observer.observe(el));
    });
</script>
@endpush

@endsection
