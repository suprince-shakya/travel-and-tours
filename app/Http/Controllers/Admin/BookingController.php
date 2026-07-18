<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'tour', 'payments']);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('tour', fn($t) => $t->where('title', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($paymentStatus = $request->get('payment_status')) {
            $query->where('payment_status', $paymentStatus);
        }

        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $bookings = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return view('admin.bookings._table', compact('bookings'));
        }

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with([
            'user', 'tour', 'tourDate', 'guide', 'items', 'payments', 'review',
        ])->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::with(['user', 'tour', 'payments'])->findOrFail($id);

        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,completed,cancelled,refunded',
            'payment_status' => 'required|in:unpaid,partial,paid,refunded',
            'customer_notes' => 'nullable|string',
            'special_requests' => 'nullable|string',
        ]);

        if ($validated['status'] === 'cancelled' && $booking->status !== 'cancelled') {
            $validated['cancelled_at'] = now();
            $validated['cancellation_reason'] = $request->cancellation_reason;
        }

        if ($validated['status'] === 'refunded' && $booking->status !== 'refunded') {
            $validated['refunded_at'] = now();
        }

        $booking->update($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    public function generateInvoice($id)
    {
        $booking = Booking::with([
            'user', 'tour', 'tourDate', 'items', 'payments',
        ])->findOrFail($id);

        return view('admin.bookings.invoice', compact('booking'));
    }

    public function export(Request $request)
    {
        $query = Booking::with(['user', 'tour']);

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($from = $request->get('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->get('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $bookings = $query->latest()->get();

        $filename = 'bookings-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($bookings) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Booking #', 'Customer', 'Tour', 'Travelers', 'Total',
                'Status', 'Payment Status', 'Date',
            ]);

            foreach ($bookings as $booking) {
                fputcsv($handle, [
                    $booking->booking_number,
                    $booking->user?->name ?? 'N/A',
                    $booking->tour?->title ?? 'N/A',
                    $booking->total_travelers,
                    number_format($booking->total, 2),
                    $booking->status,
                    $booking->payment_status,
                    $booking->created_at->format('Y-m-d H:i'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
