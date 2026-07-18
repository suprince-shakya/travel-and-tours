@extends('layouts.admin')

@section('title', 'Contact Inquiries')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-envelope me-2" style="color: var(--primary);"></i>Contact Inquiries</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item active">Contacts</li></ol></nav></div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4"><input type="text" class="form-control" id="searchInput" placeholder="Search name or email..."></div>
            <div class="col-md-3">
                <select class="form-select" id="filterStatus">
                    <option value="">All Status</option>
                    <option value="unread">Unread</option>
                    <option value="read">Read</option>
                    <option value="replied">Replied</option>
                </select>
            </div>
        </div>
        <div id="contactsTableWrapper">@include('admin.contacts._table')</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let searchInput = document.getElementById('searchInput');
    let filterStatus = document.getElementById('filterStatus');
    let wrapper = document.getElementById('contactsTableWrapper');
    let timeout;

    function fetchContacts() {
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            let params = new URLSearchParams();
            if (searchInput.value) params.set('search', searchInput.value);
            if (filterStatus.value) params.set('status', filterStatus.value);
            fetch('{{ route('admin.contacts.index') }}?' + params.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.text())
            .then(html => { wrapper.innerHTML = html; })
            .catch(() => {});
        }, 300);
    }

    searchInput.addEventListener('input', fetchContacts);
    filterStatus.addEventListener('change', fetchContacts);

    document.addEventListener('click', function (e) {
        let link = e.target.closest('#contactsPagination a');
        if (!link) return;
        e.preventDefault();
        fetch(link.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.text())
            .then(html => { wrapper.innerHTML = html; })
            .catch(() => {});
    });
});
</script>
@endpush