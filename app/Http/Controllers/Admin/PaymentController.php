<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['booking', 'user']);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhere('payment_method', 'like', "%{$search}%")
                  ->orWhereHas('booking', fn($b) => $b->where('booking_number', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($method = $request->get('payment_method')) {
            $query->where('payment_method', $method);
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return view('admin.payments._table', compact('payments'));
        }

        return view('admin.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with(['booking.tour', 'booking.user', 'user'])->findOrFail($id);

        return view('admin.payments.show', compact('payment'));
    }

    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,completed,failed,refunded,partial',
        ]);

        $payment->update([
            'status' => $validated['status'],
            'paid_at' => $validated['status'] === 'completed' ? now() : $payment->paid_at,
        ]);

        $completedCount = $payment->booking->payments()
            ->where('status', 'completed')
            ->sum('amount');

        if ($completedCount >= $payment->booking->total) {
            $payment->booking->update(['payment_status' => 'paid']);
        } elseif ($completedCount > 0) {
            $payment->booking->update(['payment_status' => 'partial']);
        } else {
            $payment->booking->update(['payment_status' => 'unpaid']);
        }

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment status updated successfully.');
    }
}
