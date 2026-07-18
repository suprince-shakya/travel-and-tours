<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\TourDate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function step1($tourSlug)
    {
        $tour = Tour::where('slug', $tourSlug)
            ->where('status', true)
            ->with(['dates' => function ($q) {
                $q->where('status', true)->where('start_date', '>=', now());
            }])
            ->firstOrFail();

        return view('frontend.booking.step1', compact('tour'));
    }

    public function step2(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'tour_date_id' => 'required|exists:tour_dates,id',
            'adults' => 'required|integer|min:1|max:20',
            'children' => 'required|integer|min:0|max:20',
        ]);

        $tour = Tour::findOrFail($request->tour_id);
        $tourDate = TourDate::findOrFail($request->tour_date_id);

        $adults = $request->adults;
        $children = $request->children;
        $travelers = $adults + $children;
        $pricePerPerson = $tourDate->price ?? $tour->price;
        $childPrice = $pricePerPerson * 0.7;
        $subtotal = ($pricePerPerson * $adults) + ($childPrice * $children);
        $tax = $subtotal * 0.10;
        $total = $subtotal + $tax;

        session([
            'booking' => [
                'tour_id' => $tour->id,
                'tour_date_id' => $tourDate->id,
                'adults' => $adults,
                'children' => $children,
                'travelers' => $travelers,
                'price_per_person' => $pricePerPerson,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
            ]
        ]);

        $unitPrice = $pricePerPerson;
        $selectedDate = $tourDate;

        return view('frontend.booking.step2', compact(
            'tour', 'selectedDate', 'adults', 'children', 'travelers',
            'unitPrice', 'subtotal', 'tax', 'total', 'tourDate'
        ));
    }

    public function step3(Request $request)
    {
        $bookingData = session('booking');

        if (!$bookingData) {
            return redirect()->route('tours.index')->with('error', 'Booking session expired. Please start again.');
        }

        $tour = Tour::findOrFail($bookingData['tour_id']);
        $tourDate = TourDate::findOrFail($bookingData['tour_date_id']);

        return view('frontend.booking.step3', compact('bookingData', 'tour', 'tourDate'));
    }

    public function store(Request $request)
    {
        $bookingData = session('booking');

        if (!$bookingData) {
            return redirect()->route('tours.index')->with('error', 'Booking session expired. Please start again.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'special_requests' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:stripe,paypal,bank_transfer,cash',
        ]);

        $bookingNumber = 'BK-' . strtoupper(Str::random(10));

        $booking = Booking::create([
            'booking_number' => $bookingNumber,
            'user_id' => auth()->id(),
            'tour_id' => $bookingData['tour_id'],
            'tour_date_id' => $bookingData['tour_date_id'],
            'total_travelers' => $bookingData['travelers'],
            'subtotal' => $bookingData['subtotal'],
            'tax' => $bookingData['tax'],
            'total' => $bookingData['total'],
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'customer_notes' => $request->special_requests,
            'special_requests' => $request->special_requests,
        ]);

        session()->forget('booking');

        session(['pending_booking_id' => $booking->id]);

        return redirect()->route('payment.pay', $booking->booking_number)
            ->with('success', 'Booking created successfully! Proceed to payment.');
    }

    public function success($bookingNumber)
    {
        $booking = Booking::where('booking_number', $bookingNumber)
            ->with('tour', 'tourDate')
            ->firstOrFail();

        return view('frontend.booking.success', compact('booking'));
    }

    public function cancel($bookingNumber)
    {
        $booking = Booking::where('booking_number', $bookingNumber)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'This booking cannot be cancelled.');
        }

        $booking->update([
            'status' => 'cancelled',
            'cancellation_reason' => request('reason', 'Cancelled by customer'),
            'cancelled_at' => now(),
        ]);

        return redirect()->route('customer.bookings')->with('success', 'Booking cancelled successfully.');
    }

    public function invoice($bookingNumber)
    {
        $booking = Booking::where('booking_number', $bookingNumber)
            ->with('tour', 'tourDate', 'items', 'payments')
            ->firstOrFail();

        return view('frontend.booking.invoice', compact('booking'));
    }
}
