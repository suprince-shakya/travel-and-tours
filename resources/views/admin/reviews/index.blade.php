@extends('layouts.admin')

@section('title', 'Reviews Management')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-star me-2" style="color: var(--primary);"></i>Reviews</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Reviews</li>
            </ol>
        </nav>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4"><input type="text" class="form-control" placeholder="Search user or tour..." id="searchInput"></div>
            <div class="col-md-3">
                <select class="form-select" id="filterStatus">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterRating">
                    <option value="">All Ratings</option>
                    <option value="5">5 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="2">2 Stars</option>
                    <option value="1">1 Star</option>
                </select>
            </div>
        </div>
        <div id="reviewsTableWrapper">
            @include('admin.reviews._table')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('reviewsTableWrapper');
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const filterRating = document.getElementById('filterRating');

    function getParams() {
        const p = new URLSearchParams();
        if (searchInput.value) p.set('search', searchInput.value);
        if (filterStatus.value) p.set('status', filterStatus.value);
        if (filterRating.value) p.set('rating', filterRating.value);
        return p;
    }

    function filterReviews() {
        wrapper.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        fetch('{{ route('admin.reviews.index') }}?' + getParams().toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.text())
        .then(html => { wrapper.innerHTML = html; });
    }

    let debounceTimer;
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(filterReviews, 400);
    });
    filterStatus.addEventListener('change', filterReviews);
    filterRating.addEventListener('change', filterReviews);

    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (!link || !link.closest('#reviewsPagination')) return;
        e.preventDefault();
        const url = new URL(link.href);
        searchInput.value = url.searchParams.get('search') || '';
        filterStatus.value = url.searchParams.get('status') || '';
        filterRating.value = url.searchParams.get('rating') || '';

        wrapper.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        fetch(link.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.text())
            .then(html => { wrapper.innerHTML = html; });
    });
});
</script>
@endpush