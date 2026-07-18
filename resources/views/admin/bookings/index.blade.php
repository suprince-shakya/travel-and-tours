@extends('layouts.admin')

@section('title', 'Bookings Management')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-calendar-check me-2" style="color: var(--primary);"></i>Bookings</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Bookings</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.bookings.export', ['format' => 'csv']) }}" class="btn btn-outline-success me-2"><i class="bi bi-download"></i> Export CSV</a>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Search booking # or customer..." id="searchInput">
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterStatus">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterPayment">
                    <option value="">All Payments</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="failed">Failed</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" id="filterDateFrom" placeholder="From">
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" id="filterDateTo" placeholder="To">
            </div>
            <div class="col-md-1">
                <button class="btn btn-outline-primary w-100"><i class="bi bi-funnel"></i></button>
            </div>
        </div>

        <div id="bookingsTableWrapper">
            @include('admin.bookings._table')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('bookingsTableWrapper');
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const filterPayment = document.getElementById('filterPayment');
    const filterDateFrom = document.getElementById('filterDateFrom');
    const filterDateTo = document.getElementById('filterDateTo');

    function getParams() {
        const p = new URLSearchParams();
        if (searchInput.value) p.set('search', searchInput.value);
        if (filterStatus.value) p.set('status', filterStatus.value);
        if (filterPayment.value) p.set('payment_status', filterPayment.value);
        if (filterDateFrom.value) p.set('date_from', filterDateFrom.value);
        if (filterDateTo.value) p.set('date_to', filterDateTo.value);
        return p;
    }

    function filterBookings() {
        wrapper.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        fetch('{{ route('admin.bookings.index') }}?' + getParams().toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.text())
        .then(html => { wrapper.innerHTML = html; });
    }

    let debounceTimer;
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(filterBookings, 400);
    });
    filterStatus.addEventListener('change', filterBookings);
    filterPayment.addEventListener('change', filterBookings);
    filterDateFrom.addEventListener('change', filterBookings);
    filterDateTo.addEventListener('change', filterBookings);

    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (!link || !link.closest('#bookingsPagination')) return;
        e.preventDefault();
        const url = new URL(link.href);
        searchInput.value = url.searchParams.get('search') || '';
        filterStatus.value = url.searchParams.get('status') || '';
        filterPayment.value = url.searchParams.get('payment_status') || '';
        filterDateFrom.value = url.searchParams.get('date_from') || '';
        filterDateTo.value = url.searchParams.get('date_to') || '';

        wrapper.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        fetch(link.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.text())
            .then(html => { wrapper.innerHTML = html; });
    });
});
</script>
@endpush