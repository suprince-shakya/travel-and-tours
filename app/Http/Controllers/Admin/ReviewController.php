<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'tour']);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('tour', fn($t) => $t->where('title', 'like', "%{$search}%"))
                  ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            if ($status === 'approved') {
                $query->where('status', true);
            } elseif ($status === 'pending') {
                $query->where('status', false);
            }
        }

        if ($tourId = $request->get('tour_id')) {
            $query->where('tour_id', $tourId);
        }

        if ($rating = $request->get('rating')) {
            $query->where('rating', $rating);
        }

        $reviews = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return view('admin.reviews._table', compact('reviews'));
        }

        return view('admin.reviews.index', compact('reviews'));
    }

    public function show($id)
    {
        $review = Review::with(['user', 'tour', 'booking'])->findOrFail($id);

        return view('admin.reviews.show', compact('review'));
    }

    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['status' => true]);

        return redirect()->back()->with('success', 'Review approved successfully.');
    }

    public function reject($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['status' => false]);

        return redirect()->back()->with('success', 'Review rejected successfully.');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}
