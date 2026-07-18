<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('frontend.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $avatarPath]);
        }

        return redirect()->route('customer.profile')->with('success', 'Profile updated successfully.');
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('customer.profile')->with('success', 'Password changed successfully.');
    }

    public function bookings()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('tour', 'tourDate')
            ->latest()
            ->paginate(10);

        return view('frontend.profile.bookings', compact('bookings'));
    }

    public function reviews()
    {
        $reviews = auth()->user()->reviews()
            ->with('tour')
            ->latest()
            ->paginate(10);

        return view('frontend.profile.reviews', compact('reviews'));
    }

    public function wishlists()
    {
        $wishlists = auth()->user()->wishlists()
            ->with('tour')
            ->latest()
            ->paginate(12);

        return view('frontend.wishlists.index', compact('wishlists'));
    }

    public function dashboard()
    {
        $user = auth()->user();

        $totalBookings = Booking::where('user_id', $user->id)->count();
        $upcomingBookings = Booking::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();
        $completedBookings = Booking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        $totalReviews = $user->reviews()->count();
        $totalWishlists = $user->wishlists()->count();

        $recentBookings = Booking::where('user_id', $user->id)
            ->with('tour')
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.profile.dashboard', compact(
            'user',
            'totalBookings',
            'upcomingBookings',
            'completedBookings',
            'totalReviews',
            'totalWishlists',
            'recentBookings'
        ));
    }
}
