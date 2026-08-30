<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Tour;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalTours = Tour::count();
        $totalBookings = Booking::count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');

        $recentBookings = Booking::with(['user', 'tour'])
            ->latest()
            ->take(10)
            ->get();

        $recentUsers = User::latest()
            ->take(4)
            ->get();

        $recentReviews = Review::with('user', 'tour')
            ->latest()
            ->take(4)
            ->get();

        $monthlyRevenue = Payment::where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month');

        $bookingsByStatus = Booking::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        $topTours = Tour::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalTours',
            'totalBookings',
            'totalRevenue',
            'recentBookings',
            'recentUsers',
            'recentReviews',
            'monthlyRevenue',
            'bookingsByStatus',
            'topTours'
        ));
    }
}
