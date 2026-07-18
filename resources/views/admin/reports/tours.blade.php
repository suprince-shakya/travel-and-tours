@extends('layouts.admin')

@section('title', 'Tours Performance Report')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-backpack me-2" style="color: var(--primary);"></i>Tours Performance Report</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.reports') }}">Reports</a></li><li class="breadcrumb-item active">Tours</li></ol></nav></div>
    <a href="{{ route('admin.reports.export', ['type' => 'tours', 'format' => 'csv']) }}" class="btn btn-outline-success"><i class="bi bi-download"></i> Export CSV</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card p-3 text-center"><h3 style="color:var(--primary);">{{ number_format($totalTours ?? 0) }}</h3><p class="text-muted mb-0">Total Tours</p></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h3 style="color:#198754;">{{ number_format($activeTours ?? 0) }}</h3><p class="text-muted mb-0">Active Tours</p></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h3 style="color:#0d6efd;">{{ number_format($totalBookings ?? 0) }}</h3><p class="text-muted mb-0">Total Bookings</p></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h3 style="color:#ffc107;">${{ number_format($totalRevenue ?? 0, 2) }}</h3><p class="text-muted mb-0">Total Revenue</p></div></div>
</div>

<div class="card mb-3">
    <div class="card-header">Top Performing Tours</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>#</th><th>Tour</th><th>Category</th><th>Bookings</th><th>Revenue</th><th class="text-center">Rating</th></tr></thead>
                <tbody>
                    @forelse($topTours ?? [] as $tour)
                        <tr>
                            <td>{{ $tour->id }}</td>
                            <td class="fw-semibold">{{ $tour->title }}</td>
                            <td>{{ $tour->category->name ?? 'N/A' }}</td>
                            <td>{{ number_format($tour->bookings_count ?? 0) }}</td>
                            <td>${{ number_format($tour->revenue ?? 0, 2) }}</td>
                            <td class="text-center">
                                <span class="stars">@for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=($tour->avg_rating ?? 0) ? '-fill' : '' }}"></i>@endfor</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">No tour data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Bookings by Tour</div>
    <div class="card-body"><canvas id="toursChart" height="80"></canvas></div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const labels = @json($chartLabels ?? []);
    const data = @json($chartData ?? []);
    if (labels.length > 0) {
        new Chart(document.getElementById('toursChart'), {
            type: 'bar',
            data: { labels, datasets: [{ label: 'Bookings', data, backgroundColor: 'rgba(60,69,62,0.7)', borderRadius: 4 }] },
            options: { responsive: true, indexAxis: 'y', plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });
    }
});
</script>
@endpush