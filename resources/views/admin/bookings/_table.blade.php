<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Booking #</th>
                <th>Customer</th>
                <th>Tour</th>
                <th>Date</th>
                <th>Travelers</th>
                <th>Total</th>
                <th>Status</th>
                <th>Payment</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td class="fw-semibold">#{{ $booking->booking_number ?? $booking->id }}</td>
                    <td>{{ $booking->customer_name ?? $booking->user->name ?? 'N/A' }}</td>
                    <td>{{ $booking->tour_name ?? $booking->tour->title ?? 'N/A' }}</td>
                    <td>{{ $booking->booking_date ? $booking->booking_date->format('M d, Y') : ($booking->created_at ? $booking->created_at->format('M d, Y') : 'N/A') }}</td>
                    <td>{{ $booking->travelers ?? $booking->adults + ($booking->children ?? 0) }}</td>
                    <td>${{ number_format($booking->total_amount ?? $booking->amount ?? 0, 2) }}</td>
                    <td>
                        @php
                            $s = $booking->status ?? 'pending';
                            $sb = match($s) {
                                'confirmed' => 'badge-soft-info', 'completed' => 'badge-soft-success',
                                'cancelled' => 'badge-soft-danger', default => 'badge-soft-warning'
                            };
                        @endphp
                        <span class="badge {{ $sb }}">{{ ucfirst($s) }}</span>
                    </td>
                    <td>
                        @php
                            $p = $booking->payment_status ?? 'pending';
                            $pb = match($p) {
                                'paid' => 'badge-soft-success', 'failed' => 'badge-soft-danger',
                                'refunded' => 'badge-soft-secondary', default => 'badge-soft-warning'
                            };
                        @endphp
                        <span class="badge {{ $pb }}">{{ ucfirst($p) }}</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary" title="View"><i class="bi bi-eye"></i></a>
                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No bookings found</p></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div id="bookingsPagination" class="d-flex justify-content-center mt-3">{{ $bookings->links() }}</div>
