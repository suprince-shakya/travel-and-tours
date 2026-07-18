@extends('layouts.admin')

@section('title', 'Customers Management')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-people me-2" style="color: var(--primary);"></i>Customers</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Customers</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add New Customer
    </a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Search by name or email..." id="searchInput">
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterStatus">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div id="customersTableWrapper">
            @include('admin.customers._table')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('customersTableWrapper');
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');

    function getParams() {
        const p = new URLSearchParams();
        if (searchInput.value) p.set('search', searchInput.value);
        if (filterStatus.value) p.set('status', filterStatus.value);
        return p;
    }

    function filterCustomers() {
        wrapper.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        fetch(window.location.pathname + '?' + getParams().toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.text())
        .then(html => { wrapper.innerHTML = html; });
    }

    let debounceTimer;
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(filterCustomers, 400);
    });
    filterStatus.addEventListener('change', filterCustomers);

    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (!link || !link.closest('#customersPagination')) return;
        e.preventDefault();
        const url = new URL(link.href);
        searchInput.value = url.searchParams.get('search') || '';
        filterStatus.value = url.searchParams.get('status') || '';

        wrapper.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        fetch(link.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.text())
            .then(html => { wrapper.innerHTML = html; });
    });
});
</script>
@endpush
