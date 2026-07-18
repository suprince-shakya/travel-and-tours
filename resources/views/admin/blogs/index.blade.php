@extends('layouts.admin')

@section('title', 'Blog Management')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-newspaper me-2" style="color: var(--primary);"></i>Blog Posts</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Blog</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Post</a>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="card">
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <input type="text" id="searchInput" class="form-control" placeholder="Search posts...">
            </div>
            <div class="col-md-3">
                <select id="filterCategory" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($blogCategories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select id="filterStatus" class="form-select">
                    <option value="">All Status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary me-2" onclick="applyFilters()"><i class="bi bi-filter"></i> Filter</button>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Clear</a>
            </div>
        </div>
        <div id="blogsTableWrapper">@include('admin.blogs._table')</div>
    </div>
</div>
@push('scripts')
<script>
function applyFilters(page) {
    page = page || 1;
    const params = new URLSearchParams();
    const search = document.getElementById('searchInput').value;
    const category = document.getElementById('filterCategory').value;
    const status = document.getElementById('filterStatus').value;
    if (search) params.set('search', search);
    if (category) params.set('category_id', category);
    if (status) params.set('status', status);
    params.set('page', page);
    fetch('{{ route("admin.blogs.index") }}?' + params.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.text())
        .then(html => {
            document.getElementById('blogsTableWrapper').innerHTML = html;
            document.querySelectorAll('#blogsPagination a').forEach(a => {
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
    document.getElementById('filterCategory').addEventListener('change', function() { applyFilters(); });
    document.getElementById('filterStatus').addEventListener('change', function() { applyFilters(); });
    document.querySelectorAll('#blogsPagination a').forEach(a => {
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