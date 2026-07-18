<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'review' => 'required|string|min:10|max:5000',
        ]);

        $existing = Review::where('user_id', auth()->id())
            ->where('tour_id', $request->tour_id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'You have already reviewed this tour.');
        }

        $autoApprove = config('app.review_auto_approve', false);

        Review::create([
            'user_id' => auth()->id(),
            'tour_id' => $request->tour_id,
            'booking_id' => $request->booking_id,
            'rating' => $request->rating,
            'title' => $request->title,
            'review' => $request->review,
            'status' => $autoApprove ? 1 : 0,
            'verified' => $request->has('booking_id'),
        ]);

        $message = $autoApprove
            ? 'Your review has been submitted successfully.'
            : 'Your review has been submitted and is pending approval.';

        return redirect()->back()->with('success', $message);
    }
}
