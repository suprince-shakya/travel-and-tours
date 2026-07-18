<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Explore amazing travel destinations, tours, and packages with Travels & Tours.')">
    <meta name="keywords" content="@yield('meta_keywords', 'travel, tours, destinations, travel agency, tour packages')">
    <meta name="author" content="Travels & Tours">
    <title>@yield('title', 'Travels & Tours - Explore Amazing Destinations')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <link href="{{ asset('css/frontend.css') }}" rel="stylesheet">
    @stack('styles')

    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}" style="color: var(--primary-color);">
                <i class="bi bi-compass"></i> Travels & Tours
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('destinations.*') ? 'active' : '' }}" href="{{ route('destinations.index') }}">Destinations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tours.*') ? 'active' : '' }}" href="{{ route('tours.index') }}">Tours</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pages.about') ? 'active' : '' }}" href="{{ route('pages.about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pages.faq') ? 'active' : '' }}" href="{{ route('pages.faq') }}">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}" href="{{ route('blog.index') }}">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>

                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('search') }}" title="Search">
                            <i class="bi bi-search fs-5"></i>
                        </a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('customer.wishlists') }}" title="Wishlist">
                                <i class="bi bi-heart fs-5"></i>
                                @php
                                    $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                                @endphp
                                @if($wishlistCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                                        {{ $wishlistCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white" style="width: 34px; height: 34px; font-size: 14px; font-weight: 600;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}"><i class="bi bi-grid me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('customer.profile') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('customer.bookings') }}"><i class="bi bi-calendar-check me-2"></i>My Bookings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('customer.login') }}">Login</a>
                        </li>
                        <li class="nav-item ms-1">
                            <a class="btn btn-primary btn-sm rounded-pill px-3" href="{{ route('customer.register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer style="background-color: #181d2e; color: rgba(255,255,255,0.85);">
        <div class="container py-5">
            <div class="row g-4 footer-grid">
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold text-white mb-3">
                        <i class="bi bi-compass"></i> Travels & Tours
                    </h5>
                    <p class="small" style="color: rgba(255,255,255,0.7);">
                        Discover amazing destinations and unforgettable experiences with Travels & Tours. 
                        We curate the best travel packages to make your journey memorable.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold text-white mb-3">Quick Links</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-decoration-none" style="color: rgba(255,255,255,0.7);">Home</a></li>
                        <li class="mb-2"><a href="{{ route('tours.index') }}" class="text-decoration-none" style="color: rgba(255,255,255,0.7);">Tours</a></li>
                        <li class="mb-2"><a href="{{ route('destinations.index') }}" class="text-decoration-none" style="color: rgba(255,255,255,0.7);">Destinations</a></li>
                        <li class="mb-2"><a href="{{ route('pages.about') }}" class="text-decoration-none" style="color: rgba(255,255,255,0.7);">About</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}" class="text-decoration-none" style="color: rgba(255,255,255,0.7);">Contact</a></li>
                        <li class="mb-2"><a href="{{ route('blog.index') }}" class="text-decoration-none" style="color: rgba(255,255,255,0.7);">Blog</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold text-white mb-3">Support</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('pages.faq') }}" class="text-decoration-none" style="color: rgba(255,255,255,0.7);">FAQ</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none" style="color: rgba(255,255,255,0.7);">Privacy Policy</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none" style="color: rgba(255,255,255,0.7);">Terms & Conditions</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none" style="color: rgba(255,255,255,0.7);">Cancellation Policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold text-white mb-3">Contact Info</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2 d-flex align-items-start">
                            <i class="bi bi-geo-alt me-2 mt-1"></i>
                            <span style="color: rgba(255,255,255,0.7);">123 Travel Street, Adventure City, AC 10001</span>
                        </li>
                        <li class="mb-2">
                            <a href="tel:+1234567890" class="text-decoration-none" style="color: rgba(255,255,255,0.7);">
                                <i class="bi bi-telephone me-2"></i>+1 (234) 567-890
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="mailto:info@travelsandtours.com" class="text-decoration-none" style="color: rgba(255,255,255,0.7);">
                                <i class="bi bi-envelope me-2"></i>info@travelsandtours.com
                            </a>
                        </li>
                    </ul>
                    <h6 class="fw-bold text-white mb-2 mt-4">Newsletter</h6>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="input-group">
                        @csrf
                        <input type="email" name="email" class="form-control form-control-sm" placeholder="Your email" required>
                        <button class="btn btn-primary btn-sm" type="submit"><i class="bi bi-send"></i></button>
                    </form>
                </div>
            </div>
        </div>

        <div style="background-color: rgba(0,0,0,0.2);">
            <div class="container py-3">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                        <small style="color: rgba(255,255,255,0.6);">© {{ date('Y') }} Travels & Tours. All rights reserved.</small>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.0.0/min/flat/visa.svg" alt="Visa" height="24" class="me-2">
                        <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.0.0/min/flat/mastercard.svg" alt="Mastercard" height="24" class="me-2">
                        <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.0.0/min/flat/amex.svg" alt="Amex" height="24" class="me-2">
                        <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.0.0/min/flat/paypal.svg" alt="PayPal" height="24" class="me-2">
                        <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.0.0/min/flat/discover.svg" alt="Discover" height="24">
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <button id="scrollTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        <i class="bi bi-chevron-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/frontend.js') }}"></script>

    <script>
        window.addEventListener('scroll', function() {
            const btn = document.getElementById('scrollTopBtn');
            if (window.scrollY > 300) {
                btn.style.display = 'block';
            } else {
                btn.style.display = 'none';
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
