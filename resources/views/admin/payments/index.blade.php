@extends('layouts.admin')

@section('title', 'Payments Management')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-currency-dollar me-2" style="color: var(--primary);"></i>Payments</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Payments</li>
            </ol>
        </nav>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search transaction ID..." id="searchInput">
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterStatus">
                    <option value="">All Status</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterMethod">
                    <option value="">All Methods</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-primary w-100" onclick="applyFilters()"><i class="bi bi-funnel"></i> Filter</button>
            </div>
        </div>

        <div id="paymentsTableWrapper">@include('admin.payments._table')</div>
    </div>
</div>

@push('scripts')
<script>
function applyFilters(page) {
    page = page || 1;
    const params = new URLSearchParams();
    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('filterStatus').value;
    const method = document.getElementById('filterMethod').value;
    if (search) params.set('search', search);
    if (status) params.set('status', status);
    if (method) params.set('payment_method', method);
    params.set('page', page);
    fetch('{{ route("admin.payments.index") }}?' + params.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.text())
        .then(html => {
            document.getElementById('paymentsTableWrapper').innerHTML = html;
            document.querySelectorAll('#paymentsPagination a').forEach(a => {
                a.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = new URL(this.href);
                    applyFilters(url.searchParams.get('page') || 1);
                });
            });
        });
}
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchInput').addEventListener('input', function() { applyFilters(); });
    document.getElementById('filterStatus').addEventListener('change', function() { applyFilters(); });
    document.getElementById('filterMethod').addEventListener('change', function() { applyFilters(); });
    document.querySelectorAll('#paymentsPagination a').forEach(a => {
        a.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            applyFilters(url.searchParams.get('page') || 1);
        });
    });
});
</script>
@endpush
@endsection
