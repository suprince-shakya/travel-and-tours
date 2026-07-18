@extends('layouts.frontend')

@section('title', 'About Us - Travels & Tours')
@section('meta_description', 'Learn about our journey, mission, and the team behind Travels & Tours.')


@section('content')
<section class="about-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold text-white mb-3">Our Story</h1>
                <p class="lead text-white-50 mb-4">We believe travel is not just about reaching a destination — it's about the journey, the people you meet, and the memories you create along the way.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('tours.index') }}" class="btn btn-light rounded-pill px-4 py-2 fw-semibold">Explore Tours</a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light rounded-pill px-4 py-2">Contact Us</a>
                </div>
            </div>
        </div>
        <div class="row g-4 mt-5" id="statsRow">
            @foreach($stats as $stat)
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-number stat-counter" data-target="{{ $stat['number'] }}">0</div>
                    <div class="stat-label">{{ $stat['label'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                     alt="About us" class="w-100 rounded-4 shadow-sm">
            </div>
            <div class="col-lg-6 offset-lg-1">
                <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">Who We Are</span>
                <h2 class="fw-bold mb-3" style="color: #181d2e;">Passionate About Creating <span style="color: #3c453e;">Unforgettable</span> Travel Experiences</h2>
                <p class="text-muted" style="line-height: 1.8;">Founded in 2010, Travels & Tours has grown from a small local agency into a premier travel company offering curated experiences across the globe. Our team of passionate travelers, local experts, and adventure enthusiasts work tirelessly to craft journeys that go beyond the ordinary.</p>
                <p class="text-muted" style="line-height: 1.8;">We personally vet every tour, handpick our guides, and build relationships with local communities to ensure every trip is authentic, responsible, and truly memorable.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">Our Mission</span>
            <h2 class="fw-bold" style="color: #181d2e;">What Drives Us</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="mission-card card shadow-sm bg-white">
                    <div class="mission-icon" style="background: rgba(60,69,62,0.1); color: #3c453e;">
                        <i class="bi bi-compass"></i>
                    </div>
                    <h5 class="fw-bold">Mission</h5>
                    <p class="text-muted small mb-0">To inspire and enable meaningful travel experiences that connect people with cultures, landscapes, and adventures they'll treasure forever.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mission-card card shadow-sm bg-white">
                    <div class="mission-icon" style="background: rgba(24,29,46,0.1); color: #181d2e;">
                        <i class="bi bi-eye"></i>
                    </div>
                    <h5 class="fw-bold">Vision</h5>
                    <p class="text-muted small mb-0">To be the most trusted and inspiring travel company, setting the standard for sustainable, immersive, and transformative travel worldwide.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mission-card card shadow-sm bg-white">
                    <div class="mission-icon" style="background: rgba(60,69,62,0.1); color: #3c453e;">
                        <i class="bi bi-heart"></i>
                    </div>
                    <h5 class="fw-bold">Values</h5>
                    <p class="text-muted small mb-0">Authenticity, sustainability, safety, and genuine hospitality — these principles guide every decision we make and every tour we design.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">Our Journey</span>
            <h2 class="fw-bold" style="color: #181d2e;">How It All Started</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="timeline">
                    <div class="timeline-item">
                        <h6 class="fw-bold" style="color: #3c453e;">2010</h6>
                        <p class="text-muted small mb-0">Founded by a group of travel enthusiasts with a shared dream of creating authentic adventure experiences.</p>
                    </div>
                    <div class="timeline-item">
                        <h6 class="fw-bold" style="color: #3c453e;">2013</h6>
                        <p class="text-muted small mb-0">Expanded to 10 countries, launched our signature guided trekking programs and cultural immersion tours.</p>
                    </div>
                    <div class="timeline-item">
                        <h6 class="fw-bold" style="color: #3c453e;">2017</h6>
                        <p class="text-muted small mb-0">Reached milestone of 10,000 happy travelers. Launched sustainable tourism initiative with local communities.</p>
                    </div>
                    <div class="timeline-item">
                        <h6 class="fw-bold" style="color: #3c453e;">2020</h6>
                        <p class="text-muted small mb-0">Adapted to global challenges, introduced private tours, virtual previews, and flexible booking policies.</p>
                    </div>
                    <div class="timeline-item">
                        <h6 class="fw-bold" style="color: #3c453e;">2024</h6>
                        <p class="text-muted small mb-0">Now operating in 20+ countries with 100+ expert guides, offering 200+ unique tours and experiences.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">What We Stand For</span>
            <h2 class="fw-bold" style="color: #181d2e;">Our Core Values</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon" style="background: rgba(60,69,62,0.1); color: #3c453e;">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h6 class="fw-bold">Safety First</h6>
                    <p class="text-muted small mb-0">Every tour is risk-assessed, guides are certified, and emergency protocols are always in place.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon" style="background: rgba(24,29,46,0.1); color: #181d2e;">
                        <i class="bi bi-globe2"></i>
                    </div>
                    <h6 class="fw-bold">Sustainable Travel</h6>
                    <p class="text-muted small mb-0">We minimize environmental impact, support local economies, and promote responsible tourism practices.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon" style="background: rgba(60,69,62,0.1); color: #3c453e;">
                        <i class="bi bi-star"></i>
                    </div>
                    <h6 class="fw-bold">Quality Assurance</h6>
                    <p class="text-muted small mb-0">From accommodation to guides, we maintain the highest standards to ensure an exceptional experience.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon" style="background: rgba(24,29,46,0.1); color: #181d2e;">
                        <i class="bi bi-hand-heart"></i>
                    </div>
                    <h6 class="fw-bold">Local Connection</h6>
                    <p class="text-muted small mb-0">We work with local guides, stay in locally-owned accommodations, and eat at family-run restaurants.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon" style="background: rgba(60,69,62,0.1); color: #3c453e;">
                        <i class="bi bi-people"></i>
                    </div>
                    <h6 class="fw-bold">Community</h6>
                    <p class="text-muted small mb-0">Travel is better together. We foster connections between travelers and the communities they visit.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon" style="background: rgba(24,29,46,0.1); color: #181d2e;">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <h6 class="fw-bold">Flexibility</h6>
                    <p class="text-muted small mb-0">Plans change. With our flexible booking policies, you can adjust your travel with confidence.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@if($testimonials->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">Testimonials</span>
            <h2 class="fw-bold" style="color: #181d2e;">What Our Travelers Say</h2>
        </div>
        <div class="row g-4">
            @foreach($testimonials as $testimonial)
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        @if($testimonial->image)
                            <img src="{{ storage_url($testimonial->image) }}" alt="" class="rounded-circle me-3" style="width: 48px; height: 48px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white me-3 fw-bold" style="width: 48px; height: 48px;">
                                {{ strtoupper(substr($testimonial->name ?? $testimonial->user?->name ?? 'T', 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h6 class="fw-bold mb-0 small">{{ $testimonial->name ?? $testimonial->user?->name ?? 'Anonymous' }}</h6>
                            @if($testimonial->position)
                                <small class="text-muted">{{ $testimonial->position }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="quote mb-0">"{{ $testimonial->content ?? $testimonial->comment }}"</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($tours->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">Featured Tours</span>
            <h2 class="fw-bold" style="color: #181d2e;">Experience Our Top Tours</h2>
        </div>
        <div class="row g-4">
            @foreach($tours as $tour)
            <div class="col-lg-4 col-md-6">
                @component('components.tour-card', ['tour' => $tour])
                @endcomponent
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($partners->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-4">
            <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">Our Partners</span>
            <h2 class="fw-bold" style="color: #181d2e;">Trusted By The Best</h2>
        </div>
        <div class="row g-4 align-items-center justify-content-center">
            @foreach($partners as $partner)
            <div class="col-4 col-md-2 text-center">
                <img src="{{ storage_url($partner->logo) }}" alt="{{ $partner->name }}" style="max-height: 50px; filter: grayscale(1); opacity: 0.6; transition: all 0.3s;" class="partner-logo" onmouseover="this.style.filter='grayscale(0)';this.style.opacity='1'" onmouseout="this.style.filter='grayscale(1)';this.style.opacity='0.6'">
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-5">
    <div class="container">
        <div class="cta-section">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="text-white fw-bold mb-2">Ready for Your Next Adventure?</h3>
                    <p class="text-white-50 mb-0">Browse our curated tours and find the perfect journey for you.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('tours.index') }}" class="btn btn-light rounded-pill px-5 py-2 fw-semibold">Explore Tours</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.stat-counter');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.dataset.target);
                let current = 0;
                const step = Math.ceil(target / 40);
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        el.textContent = target;
                        clearInterval(timer);
                    } else {
                        el.textContent = current;
                    }
                }, 30);
                observer.unobserve(el);
            }
        });
    });
    counters.forEach(c => observer.observe(c));
});
</script>
@endpush
