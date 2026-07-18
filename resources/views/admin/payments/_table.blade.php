<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Customer</th>
                <th>Booking</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Date</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td class="fw-semibold">{{ $payment->transaction_id ?? 'N/A' }}</td>
                    <td>{{ $payment->user->name ?? $payment->booking->user->name ?? 'N/A' }}</td>
                    <td>{{ $payment->booking->booking_number ?? 'N/A' }}</td>
                    <td>${{ number_format($payment->amount ?? 0, 2) }}</td>
                    <td>{{ ucwords(str_replace('_', ' ', $payment->payment_method ?? 'N/A')) }}</td>
                    <td>
                        @php
                            $s = $payment->status ?? 'pending';
                            $sb = match($s) {
                                'completed' => 'badge-soft-success', 'failed' => 'badge-soft-danger',
                                'refunded' => 'badge-soft-secondary', default => 'badge-soft-warning'
                            };
                        @endphp
                        <span class="badge {{ $sb }}">{{ ucfirst($s) }}</span>
                    </td>
                    <td>{{ $payment->created_at ? $payment->created_at->format('M d, Y') : 'N/A' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-outline-primary" title="View"><i class="bi bi-eye"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No payments found</p></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center mt-3" id="paymentsPagination">{{ $payments->links() }}</div>
