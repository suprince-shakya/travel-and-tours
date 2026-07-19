<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    @stack('styles')
</head>
<body>

<div class="wrapper">
    <aside class="sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <i class="bi bi-compass"></i>
            <a href="{{ route('admin.dashboard') }}">Travels & Tours</a>
        </div>

        <nav class="sidebar-nav">
            @php
                $mainActive = request()->routeIs('admin.dashboard') || request()->routeIs('admin.tours.*') || request()->routeIs('admin.bookings.*') || request()->routeIs('admin.customers.*');
                $contentActive = request()->routeIs('admin.countries.*') || request()->routeIs('admin.regions.*') || request()->routeIs('admin.cities.*') || request()->routeIs('admin.categories.*') || request()->routeIs('admin.hotels.*') || request()->routeIs('admin.hotel-rooms.*') || request()->routeIs('admin.vehicles.*') || request()->routeIs('admin.guides.*') || request()->routeIs('admin.reviews.*') || request()->routeIs('admin.payments.*') || request()->routeIs('admin.coupons.*');
                $blogActive = request()->routeIs('admin.blogs.*') || request()->routeIs('admin.blog-categories.*') || request()->routeIs('admin.blog-comments.*');
                $pagesActive = request()->routeIs('admin.pages.*') || request()->routeIs('admin.testimonials.*') || request()->routeIs('admin.faqs.*') || request()->routeIs('admin.partners.*');
                $commActive = request()->routeIs('admin.contacts.*') || request()->routeIs('admin.newsletters.*');
                $sysActive = request()->routeIs('admin.users.*') || request()->routeIs('admin.reports*') || request()->routeIs('admin.settings.*');
            @endphp
            <div class="nav-header" role="button" data-bs-toggle="collapse" data-bs-target="#collapseMain" aria-expanded="true">
                <i class="bi bi-chevron-down toggle-icon"></i> Main
            </div>
            <div class="collapse show" id="collapseMain">
                <div class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.tours.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.tours.*') ? 'active' : '' }}">
                        <i class="bi bi-backpack"></i> Tours
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.bookings.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-check"></i> Bookings
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.customers.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Customers
                    </a>
                </div>
            </div>

            <div class="nav-header" role="button" data-bs-toggle="collapse" data-bs-target="#collapseContent" aria-expanded="{{ $contentActive ? 'true' : 'false' }}">
                <i class="bi bi-chevron-down toggle-icon"></i> Content
            </div>
            <div class="collapse {{ $contentActive ? 'show' : '' }}" id="collapseContent">
                <div class="nav-item">
                    <a href="{{ route('admin.countries.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.countries.*') ? 'active' : '' }}">
                        <i class="bi bi-geo-alt"></i> Countries
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.regions.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.regions.*') ? 'active' : '' }}">
                        <i class="bi bi-pin-map"></i> Regions
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.cities.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.cities.*') ? 'active' : '' }}">
                        <i class="bi bi-building"></i> Cities
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.categories.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i> Categories
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.hotels.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.hotels.*') ? 'active' : '' }}">
                        <i class="bi bi-building"></i> Hotels
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.hotel-rooms.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.hotel-rooms.*') ? 'active' : '' }}">
                        <i class="bi bi-door-open"></i> Hotel Rooms
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.vehicles.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}">
                        <i class="bi bi-truck"></i> Vehicles
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.guides.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.guides.*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge"></i> Guides
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.reviews.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                        <i class="bi bi-star"></i> Reviews
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.payments.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                        <i class="bi bi-credit-card"></i> Payments
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.coupons.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                        <i class="bi bi-ticket-perforated"></i> Coupons
                    </a>
                </div>
            </div>

            <div class="nav-header" role="button" data-bs-toggle="collapse" data-bs-target="#collapseBlog" aria-expanded="{{ $blogActive ? 'true' : 'false' }}">
                <i class="bi bi-chevron-down toggle-icon"></i> Blog
            </div>
            <div class="collapse {{ $blogActive ? 'show' : '' }}" id="collapseBlog">
                <div class="nav-item">
                    <a href="{{ route('admin.blogs.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                        <i class="bi bi-newspaper"></i> Posts
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.blog-categories.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}">
                        <i class="bi bi-folder"></i> Categories
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.blog-comments.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.blog-comments.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-dots"></i> Comments
                    </a>
                </div>
            </div>

            <div class="nav-header" role="button" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="{{ $pagesActive ? 'true' : 'false' }}">
                <i class="bi bi-chevron-down toggle-icon"></i> Pages
            </div>
            <div class="collapse {{ $pagesActive ? 'show' : '' }}" id="collapsePages">
                <div class="nav-item">
                    <a href="{{ route('admin.pages.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                        <i class="bi bi-file-text"></i> Pages
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.testimonials.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-quote"></i> Testimonials
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.faqs.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                        <i class="bi bi-question-circle"></i> FAQ
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.partners.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
                        <i class="bi bi-link-45deg"></i> Partners
                    </a>
                </div>
            </div>

            <div class="nav-header" role="button" data-bs-toggle="collapse" data-bs-target="#collapseCommunication" aria-expanded="{{ $commActive ? 'true' : 'false' }}">
                <i class="bi bi-chevron-down toggle-icon"></i> Communication
            </div>
            <div class="collapse {{ $commActive ? 'show' : '' }}" id="collapseCommunication">
                <div class="nav-item">
                    <a href="{{ route('admin.contacts.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                        <i class="bi bi-envelope"></i> Contact Messages
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.newsletters.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.newsletters.*') ? 'active' : '' }}">
                        <i class="bi bi-send"></i> Newsletters
                    </a>
                </div>
            </div>

            <div class="nav-header" role="button" data-bs-toggle="collapse" data-bs-target="#collapseSystem" aria-expanded="{{ $sysActive ? 'true' : 'false' }}">
                <i class="bi bi-chevron-down toggle-icon"></i> System
            </div>
            <div class="collapse {{ $sysActive ? 'show' : '' }}" id="collapseSystem">
                <div class="nav-item">
                    <a href="{{ route('admin.users.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-lock"></i> Users
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.reports') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                        <i class="bi bi-bar-chart"></i> Reports
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.settings.index') ?? '#' }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i> Settings
                    </a>
                </div>
            </div>
        </nav>

        <div class="sidebar-footer">
            <i class="bi bi-circle-fill" style="font-size: 8px; color: #198754;"></i>
            &nbsp; v1.0.0
        </div>
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="main-content">
        <header class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <span class="d-none d-sm-inline fw-semibold" style="color: var(--primary);">Admin Panel</span>
            </div>

            <div class="topbar-right">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted" title="View Site">
                    <i class="bi bi-box-arrow-up-right"></i>
                </a>

                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                        <div class="avatar-sm">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'Admin' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('admin.profile.index') ?? '#' }}"><i class="bi bi-person"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.settings.index') ?? '#' }}"><i class="bi bi-gear"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="content-area">
            @yield('content')
        </div>

        <footer class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleSidebar() {
        document.getElementById('adminSidebar').classList.toggle('show');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }
</script>

@stack('scripts')
</body>
</html>
