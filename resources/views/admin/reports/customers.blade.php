@extends('layouts.admin')

@section('title', 'Customers Report')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div><h1><i class="bi bi-people me-2" style="color: var(--primary);"></i>Customers Report</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('admin.reports') }}">Reports</a></li><li class="breadcrumb-item active">Customers</li></ol></nav></div>
    <a href="{{ route('admin.reports.export', ['type' => 'customers', 'format' => 'csv']) }}" class="btn btn-outline-success"><i class="bi bi-download"></i> Export CSV</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card p-3 text-center"><h3 style="color:var(--primary);">{{ number_format($totalCustomers ?? 0) }}</h3><p class="text-muted mb-0">Total Customers</p></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h3 style="color:#198754;">{{ number_format($newCustomers ?? 0) }}</h3><p class="text-muted mb-0">New This Month</p></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h3 style="color:#0d6efd;">{{ number_format($activeCustomers ?? 0) }}</h3><p class="text-muted mb-0">Active (with bookings)</p></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h3 style="color:#ffc107;">{{ number_format($totalBookings ?? 0) }}</h3><p class="text-muted mb-0">Total Bookings</p></div></div>
</div>

<div class="card mb-3">
    <div class="card-header">Customer Registrations</div>
    <div class="card-body"><canvas id="customerChart" height="80"></canvas></div>
</div>

<div class="card">
    <div class="card-header">Top Customers</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Bookings</th><th class="text-end">Total Spent</th></tr></thead>
                <tbody>
                    @forelse($topCustomers ?? [] as $c)
                        <tr><td>{{ $c->id }}</td><td class="fw-semibold">{{ $c->name }}</td><td>{{ $c->email }}</td><td>{{ number_format($c->bookings_count ?? 0) }}</td><td class="text-end">${{ number_format($c->total_spent ?? 0, 2) }}</td></tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted">No customer data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const labels = @json($chartLabels ?? []);
    const data = @json($chartData ?? []);
    if (labels.length > 0) {
        new Chart(document.getElementById('customerChart'), {
            type: 'line',
            data: { labels, datasets: [{ label: 'New Customers', data, borderColor: '#3c453e', backgroundColor: 'rgba(60,69,62,0.1)', fill: true, tension: 0.4 }] },
            options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });
    }
});
</script>
@endpush