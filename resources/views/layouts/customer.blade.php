@extends('layouts.frontend')

@section('title', $title ?? 'Dashboard - Travels & Tours')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-body text-center p-4">
                        @php $user = auth()->user(); @endphp
                        @if($user->avatar)
                            <img src="{{ storage_url($user->avatar) }}" alt="" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--primary-color); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; margin: 0 auto 1rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <h6 class="fw-bold mb-0">{{ $user->name }}</h6>
                        <small class="text-muted">{{ $user->email }}</small>
                        <hr>
                        <div class="nav flex-column nav-pills gap-1">
                            <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" href="{{ route('customer.dashboard') }}">
                                <i class="bi bi-grid me-2"></i>Dashboard
                            </a>
                            <a class="nav-link {{ request()->routeIs('customer.profile') ? 'active' : '' }}" href="{{ route('customer.profile') }}">
                                <i class="bi bi-person me-2"></i>Profile
                            </a>
                            <a class="nav-link {{ request()->routeIs('customer.bookings') ? 'active' : '' }}" href="{{ route('customer.bookings') }}">
                                <i class="bi bi-calendar-check me-2"></i>My Bookings
                            </a>
                            <a class="nav-link {{ request()->routeIs('customer.reviews') ? 'active' : '' }}" href="{{ route('customer.reviews') }}">
                                <i class="bi bi-star me-2"></i>My Reviews
                            </a>
                            <a class="nav-link {{ request()->routeIs('customer.wishlists') ? 'active' : '' }}" href="{{ route('customer.wishlists') }}">
                                <i class="bi bi-heart me-2"></i>Wishlist
                            </a>
                        </div>
                        <hr>
                        <a href="{{ route('tours.index') }}" class="btn btn-outline-primary btn-sm rounded-pill w-100">
                            <i class="bi bi-compass me-1"></i>Browse Tours
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h5 class="fw-bold mb-0" style="color: var(--secondary-color);">@yield('page-title', 'Dashboard')</h5>
                        <small class="text-muted">@yield('page-subtitle')</small>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success rounded-4 d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger rounded-4 d-flex align-items-center">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                    </div>
                @endif
                @if(session('info'))
                    <div class="alert alert-info rounded-4 d-flex align-items-center">
                        <i class="bi bi-info-circle-fill me-2"></i>{{ session('info') }}
                    </div>
                @endif

                @yield('customer-content')
            </div>
        </div>
    </div>
</section>
@endsection
