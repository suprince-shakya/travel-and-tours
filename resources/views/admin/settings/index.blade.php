@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-gear me-2" style="color: var(--primary);"></i>Settings</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Settings</li>
            </ol>
        </nav>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<ul class="nav nav-tabs mb-3" id="settingsTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab"><i class="bi bi-sliders"></i> General</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab"><i class="bi bi-share"></i> Social</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab"><i class="bi bi-search"></i> SEO</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button" role="tab"><i class="bi bi-credit-card"></i> Payment</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="appearance-tab" data-bs-toggle="tab" data-bs-target="#appearance" type="button" role="tab"><i class="bi bi-palette"></i> Appearance</button>
    </li>
</ul>

<div class="tab-content" id="settingsTabsContent">
    <div class="tab-pane fade show active" id="general" role="tabpanel">
        <div class="card">
            <div class="card-header">General Settings</div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="section" value="general">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Site Name</label><input type="text" name="site_name" class="form-control" value="{{ config('app.name') }}"></div>
                        <div class="col-md-6"><label class="form-label">Site Description</label><input type="text" name="site_description" class="form-control" value="{{ $settings['site_description'] ?? '' }}"></div>
                        <div class="col-md-6"><label class="form-label">Logo</label><input type="file" name="logo" class="form-control" accept="image/*"></div>
                        <div class="col-md-6"><label class="form-label">Favicon</label><input type="file" name="favicon" class="form-control" accept="image/*"></div>
                        <div class="col-md-4"><label class="form-label">Address</label><input type="text" name="address" class="form-control" value="{{ $settings['address'] ?? '' }}"></div>
                        <div class="col-md-4"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ $settings['phone'] ?? '' }}"></div>
                        <div class="col-md-4"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ $settings['email'] ?? '' }}"></div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-check-lg"></i> Save General Settings</button>
                </form>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="social" role="tabpanel">
        <div class="card">
            <div class="card-header">Social Media Links</div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="section" value="social">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label"><i class="bi bi-facebook text-primary"></i> Facebook</label><input type="url" name="facebook" class="form-control" value="{{ $settings['facebook'] ?? '' }}"></div>
                        <div class="col-md-6"><label class="form-label"><i class="bi bi-twitter text-info"></i> Twitter</label><input type="url" name="twitter" class="form-control" value="{{ $settings['twitter'] ?? '' }}"></div>
                        <div class="col-md-6"><label class="form-label"><i class="bi bi-instagram text-danger"></i> Instagram</label><input type="url" name="instagram" class="form-control" value="{{ $settings['instagram'] ?? '' }}"></div>
                        <div class="col-md-6"><label class="form-label"><i class="bi bi-youtube text-danger"></i> YouTube</label><input type="url" name="youtube" class="form-control" value="{{ $settings['youtube'] ?? '' }}"></div>
                        <div class="col-md-6"><label class="form-label"><i class="bi bi-linkedin text-primary"></i> LinkedIn</label><input type="url" name="linkedin" class="form-control" value="{{ $settings['linkedin'] ?? '' }}"></div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-check-lg"></i> Save Social Links</button>
                </form>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="seo" role="tabpanel">
        <div class="card">
            <div class="card-header">SEO Settings</div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="section" value="seo">
                    <div class="mb-3"><label class="form-label">Default Meta Title</label><input type="text" name="meta_title" class="form-control" value="{{ $settings['meta_title'] ?? '' }}"></div>
                    <div class="mb-3"><label class="form-label">Default Meta Description</label><textarea name="meta_description" class="form-control" rows="3">{{ $settings['meta_description'] ?? '' }}</textarea></div>
                    <div class="mb-3"><label class="form-label">Google Analytics ID</label><input type="text" name="google_analytics_id" class="form-control" value="{{ $settings['google_analytics_id'] ?? '' }}"></div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Save SEO Settings</button>
                </form>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="payment" role="tabpanel">
        <div class="card">
            <div class="card-header">Payment Gateway Settings</div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="section" value="payment">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <h6 class="fw-semibold mb-2"><i class="bi bi-stripe"></i> Stripe</h6>
                            <div class="mb-2"><input type="password" name="stripe_key" class="form-control" placeholder="Stripe Publishable Key" value="{{ $settings['stripe_key'] ?? '' }}"></div>
                            <div class="mb-2"><input type="password" name="stripe_secret" class="form-control" placeholder="Stripe Secret Key" value="{{ $settings['stripe_secret'] ?? '' }}"></div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-semibold mb-2"><i class="bi bi-paypal"></i> PayPal</h6>
                            <div class="mb-2"><input type="password" name="paypal_client_id" class="form-control" placeholder="PayPal Client ID" value="{{ $settings['paypal_client_id'] ?? '' }}"></div>
                            <div class="mb-2"><input type="password" name="paypal_secret" class="form-control" placeholder="PayPal Secret" value="{{ $settings['paypal_secret'] ?? '' }}"></div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-2">eSewa</h6>
                            <input type="password" name="esewa_merchant" class="form-control" placeholder="eSewa Merchant Code" value="{{ $settings['esewa_merchant'] ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-2">Khalti</h6>
                            <input type="password" name="khalti_secret" class="form-control" placeholder="Khalti Secret Key" value="{{ $settings['khalti_secret'] ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-2">FonePay</h6>
                            <input type="password" name="fonepay_merchant" class="form-control" placeholder="FonePay Merchant ID" value="{{ $settings['fonepay_merchant'] ?? '' }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-check-lg"></i> Save Payment Settings</button>
                </form>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="appearance" role="tabpanel">
        <div class="card">
            <div class="card-header">Appearance</div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="section" value="appearance">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Primary Color</label><input type="color" name="primary_color" class="form-control form-control-color" value="{{ $settings['primary_color'] ?? '#3c453e' }}"></div>
                        <div class="col-md-6"><label class="form-label">Secondary Color</label><input type="color" name="secondary_color" class="form-control form-control-color" value="{{ $settings['secondary_color'] ?? '#181d2e' }}"></div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-check-lg"></i> Save Appearance</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection