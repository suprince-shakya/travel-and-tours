<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function pay($bookingNumber)
    {
        $booking = Booking::where('booking_number', $bookingNumber)
            ->with('tour', 'tourDate')
            ->firstOrFail();

        if ($booking->payment_status === 'paid') {
            return redirect()->route('booking.success', $booking->booking_number)
                ->with('info', 'This booking has already been paid.');
        }

        $payment = $booking->payments()->latest()->first();

        return view('frontend.payment.pay', compact('booking', 'payment'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'booking_number' => 'required|string|exists:bookings,booking_number',
            'payment_method' => 'required|in:stripe,paypal,bank_transfer,cash',
        ]);

        $booking = Booking::where('booking_number', $request->booking_number)->firstOrFail();

        if ($booking->payment_status === 'paid') {
            return redirect()->route('booking.success', $booking->booking_number)
                ->with('info', 'This booking has already been paid.');
        }

        $transactionId = 'TXN-' . strtoupper(Str::random(16));

        Payment::create([
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'transaction_id' => $transactionId,
            'payment_method' => $request->payment_method,
            'amount' => $booking->total,
            'currency' => 'USD',
            'status' => 'completed',
            'gateway_response' => json_encode(['status' => 'success', 'method' => $request->payment_method]),
            'paid_at' => now(),
        ]);

        $booking->update([
            'status' => 'confirmed',
            'payment_status' => 'paid',
        ]);

        return redirect()->route('booking.success', $booking->booking_number)
            ->with('success', 'Payment completed successfully! Your booking is confirmed.');
    }

    public function callback($gateway)
    {
        $status = request('status', 'success');

        if ($status === 'success') {
            return redirect()->route('home')->with('success', 'Payment completed via ' . $gateway . '.');
        }

        return redirect()->route('home')->with('error', 'Payment failed via ' . $gateway . '. Please try again.');
    }
}
