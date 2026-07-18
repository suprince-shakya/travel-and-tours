<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', auth()->id())
            ->with('tour')
            ->latest()
            ->paginate(12);

        return view('frontend.wishlists.index', compact('wishlists'));
    }

    public function toggle($tourId, Request $request)
    {
        $tour = Tour::where('id', $tourId)->where('status', true)->firstOrFail();

        $existing = Wishlist::where('user_id', auth()->id())
            ->where('tour_id', $tourId)
            ->first();

        if ($existing) {
            $existing->delete();

            if ($request->expectsJson()) {
                return response()->json(['status' => 'removed', 'message' => 'Tour removed from wishlist.']);
            }

            return redirect()->back()->with('success', 'Tour removed from wishlist.');
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'tour_id' => $tourId,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'added', 'message' => 'Tour added to wishlist!']);
        }

        return redirect()->back()->with('success', 'Tour added to wishlist!');
    }

    public function add($tourId)
    {
        $tour = Tour::where('id', $tourId)->where('status', true)->firstOrFail();

        $existing = Wishlist::where('user_id', auth()->id())
            ->where('tour_id', $tourId)
            ->first();

        if ($existing) {
            return redirect()->back()->with('info', 'This tour is already in your wishlist.');
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'tour_id' => $tourId,
        ]);

        return redirect()->back()->with('success', 'Tour added to wishlist!');
    }
}
