@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-shield-lock me-2" style="color: var(--primary);"></i>Users</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add New User
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
                <select class="form-select" id="filterRole">
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                    <option value="customer">Customer</option>
                    <option value="guide">Guide</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterStatus">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div id="usersTableWrapper">
            @include('admin.users._table')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('usersTableWrapper');
    const searchInput = document.getElementById('searchInput');
    const filterRole = document.getElementById('filterRole');
    const filterStatus = document.getElementById('filterStatus');

    function getParams() {
        const p = new URLSearchParams();
        if (searchInput.value) p.set('search', searchInput.value);
        if (filterRole.value) p.set('role', filterRole.value);
        if (filterStatus.value) p.set('status', filterStatus.value);
        return p;
    }

    function filterUsers() {
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
        debounceTimer = setTimeout(filterUsers, 400);
    });
    filterRole.addEventListener('change', filterUsers);
    filterStatus.addEventListener('change', filterUsers);

    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (!link || !link.closest('#usersPagination')) return;
        e.preventDefault();
        const url = new URL(link.href);
        searchInput.value = url.searchParams.get('search') || '';
        filterRole.value = url.searchParams.get('role') || '';
        filterStatus.value = url.searchParams.get('status') || '';

        wrapper.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        fetch(link.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.text())
            .then(html => { wrapper.innerHTML = html; });
    });
});
</script>
@endpush