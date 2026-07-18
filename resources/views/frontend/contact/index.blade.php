@extends('layouts.frontend')

@section('title', 'Contact Us - Travels & Tours')
@section('meta_description', 'Get in touch with us. We\'d love to hear from you.')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')
<section class="contact-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <span class="badge bg-light text-dark rounded-pill px-3 py-2 mb-3">Get in Touch</span>
                <h1 class="display-4 fw-bold text-white mb-3">We'd Love to Hear From You</h1>
                <p class="lead text-white-50 mb-0">Have a question about a tour, need help planning your trip, or just want to say hello? Our team is here for you.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if(session('success'))
            <div class="success-alert d-flex align-items-center mb-4">
                <i class="bi bi-check-circle-fill text-success me-3 fs-4"></i>
                <span class="fw-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="info-card card shadow-sm">
                    <div class="info-icon" style="background: rgba(60,69,62,0.1); color: #3c453e;">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Our Address</h6>
                    <p class="text-muted small mb-0">{{ $companyInfo['address'] ?? '123 Travel Street, Adventure City, AC 10001' }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card card shadow-sm">
                    <div class="info-icon" style="background: rgba(24,29,46,0.1); color: #181d2e;">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Phone</h6>
                    <p class="text-muted small mb-0">
                        <a href="tel:{{ $companyInfo['phone'] ?? '+1234567890' }}" class="text-decoration-none fw-semibold" style="color: #181d2e;">
                            {{ $companyInfo['phone'] ?? '+1 (234) 567-890' }}
                        </a>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card card shadow-sm">
                    <div class="info-icon" style="background: rgba(60,69,62,0.1); color: #3c453e;">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Email</h6>
                    <p class="text-muted small mb-0">
                        <a href="mailto:{{ $companyInfo['email'] ?? 'info@travelsandtours.com' }}" class="text-decoration-none fw-semibold" style="color: #3c453e;">
                            {{ $companyInfo['email'] ?? 'info@travelsandtours.com' }}
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div style="width: 48px; height: 48px; border-radius: 16px; background: rgba(60,69,62,0.1); display: flex; align-items: center; justify-content: center; color: #3c453e; font-size: 1.25rem;">
                                <i class="bi bi-chat-dots"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0" style="color: #181d2e;">Send Us a Message</h5>
                                <small class="text-muted">We typically reply within 24 hours</small>
                            </div>
                        </div>
                        <form action="{{ route('contact') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Your Name</label>
                                    <input type="text" name="name" class="form-control form-control-lg" placeholder="John Doe" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Email Address</label>
                                    <input type="email" name="email" class="form-control form-control-lg" placeholder="john@example.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Phone (optional)</label>
                                    <input type="tel" name="phone" class="form-control form-control-lg" placeholder="+1 (555) 000-0000">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Subject</label>
                                    <input type="text" name="subject" class="form-control form-control-lg" placeholder="How can we help?" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-semibold">Message</label>
                                    <textarea name="message" class="form-control" rows="5" placeholder="Tell us more about what you're looking for..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-5 py-2">
                                        <i class="bi bi-send me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div style="width: 48px; height: 48px; border-radius: 16px; background: rgba(24,29,46,0.1); display: flex; align-items: center; justify-content: center; color: #181d2e; font-size: 1.25rem;">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #181d2e;">Business Hours</h6>
                            </div>
                        </div>
                        <div class="hours-item small">
                            <span class="text-muted">Monday - Friday</span>
                            <span class="fw-semibold">9:00 AM - 6:00 PM</span>
                        </div>
                        <div class="hours-item small">
                            <span class="text-muted">Saturday</span>
                            <span class="fw-semibold">10:00 AM - 4:00 PM</span>
                        </div>
                        <div class="hours-item small">
                            <span class="text-muted">Sunday</span>
                            <span class="fw-semibold text-danger">Closed</span>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div style="width: 48px; height: 48px; border-radius: 16px; background: rgba(60,69,62,0.1); display: flex; align-items: center; justify-content: center; color: #3c453e; font-size: 1.25rem;">
                                <i class="bi bi-share"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #181d2e;">Follow Us</h6>
                                <small class="text-muted">Stay connected for travel inspiration</small>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#" class="social-btn" style="background: #1877F2;" title="Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="social-btn" style="background: #E4405F;" title="Instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="social-btn" style="background: #000;" title="Twitter/X"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" class="social-btn" style="background: #FF0000;" title="YouTube"><i class="bi bi-youtube"></i></a>
                            <a href="#" class="social-btn" style="background: #0A66C2;" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="social-btn" style="background: #25D366;" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div id="contactMap"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('contactMap').setView([40.7128, -74.0060], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19,
    }).addTo(map);

    const marker = L.marker([40.7128, -74.0060]).addTo(map);
    marker.bindPopup(`
        <div style="font-family: system-ui, sans-serif;">
            <strong style="color: #3c453e;">Travels & Tours</strong><br>
            <small>123 Travel Street<br>Adventure City, AC 10001</small>
        </div>
    `);

    const circleIcon = L.divIcon({
        html: '<div style="width: 16px; height: 16px; background: #3c453e; border: 3px solid #fff; border-radius: 50%; box-shadow: 0 2px 8px rgba(0,0,0,0.3);"></div>',
        iconSize: [16, 16],
        iconAnchor: [8, 8],
        className: ''
    });
    marker.setIcon(circleIcon);
});
</script>
@endpush
