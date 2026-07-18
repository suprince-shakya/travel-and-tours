@extends('layouts.admin')

@section('title', 'Hotel Rooms')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-door-open me-2" style="color: var(--primary);"></i>Hotel Rooms</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.hotels.index') }}">Hotels</a></li><li class="breadcrumb-item active">Rooms</li></ol></nav></div>
    <a href="{{ route('admin.hotel-rooms.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Room</a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <select class="form-select" id="filterHotel">
                    <option value="">All Hotels</option>
                    @foreach($hotels ?? [] as $h)<option value="{{ $h->id }}">{{ $h->name }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterRoomType">
                    <option value="">All Room Types</option>
                    <option value="single">Single</option>
                    <option value="double">Double</option>
                    <option value="suite">Suite</option>
                    <option value="deluxe">Deluxe</option>
                    <option value="family">Family</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterStatus">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div id="roomsTableWrapper">@include('admin.hotel-rooms._table')</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let filterHotel = document.getElementById('filterHotel');
    let filterRoomType = document.getElementById('filterRoomType');
    let filterStatus = document.getElementById('filterStatus');
    let wrapper = document.getElementById('roomsTableWrapper');
    let timeout;

    function fetchRooms() {
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            let params = new URLSearchParams();
            if (filterHotel.value) params.set('hotel_id', filterHotel.value);
            if (filterRoomType.value) params.set('room_type', filterRoomType.value);
            if (filterStatus.value) params.set('status', filterStatus.value);
            fetch('{{ route('admin.hotel-rooms.index') }}?' + params.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.text())
            .then(html => { wrapper.innerHTML = html; })
            .catch(() => {});
        }, 300);
    }

    filterHotel.addEventListener('change', fetchRooms);
    filterRoomType.addEventListener('change', fetchRooms);
    filterStatus.addEventListener('change', fetchRooms);

    document.addEventListener('click', function (e) {
        let link = e.target.closest('#roomsPagination a');
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