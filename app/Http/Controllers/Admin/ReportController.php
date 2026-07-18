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

class ReportController extends Controller
{
    public function revenue(Request $request)
    {
        $query = Payment::where('status', 'completed');

        if ($from = $request->get('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->get('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $groupBy = $request->get('group_by', 'month');

        $selectRaw = match ($groupBy) {
            'day' => DB::raw("DATE(created_at) as period"),
            default => DB::raw("strftime('%Y-%m', created_at) as period"),
        };

        $revenueData = (clone $query)
            ->select($selectRaw, DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $totalRevenue = (clone $query)->sum('amount');
        $totalPayments = (clone $query)->count();
        $avgOrderValue = $totalPayments > 0 ? $totalRevenue / $totalPayments : 0;

        $revenueByMethod = (clone $query)
            ->select('payment_method', DB::raw('SUM(amount) as total'))
            ->groupBy('payment_method')
            ->get();

        return view('admin.reports.revenue', compact(
            'revenueData', 'totalRevenue', 'totalPayments',
            'avgOrderValue', 'revenueByMethod', 'groupBy'
        ));
    }

    public function bookings(Request $request)
    {
        $query = Booking::query();

        if ($from = $request->get('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->get('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $totalBookings = (clone $query)->count();
        $totalRevenue = (clone $query)->sum('total');
        $avgBookingValue = $totalBookings > 0 ? $totalRevenue / $totalBookings : 0;

        $bookingsByStatus = (clone $query)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        $bookingsByMonth = (clone $query)
            ->select(DB::raw("strftime('%Y-%m', created_at) as month"), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $recentBookings = (clone $query)
            ->with(['user', 'tour'])
            ->latest()
            ->take(20)
            ->get();

        return view('admin.reports.bookings', compact(
            'totalBookings', 'totalRevenue', 'avgBookingValue',
            'bookingsByStatus', 'bookingsByMonth', 'recentBookings'
        ));
    }

    public function customers(Request $request)
    {
        $query = User::where('role', 'customer');

        if ($from = $request->get('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->get('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $totalCustomers = (clone $query)->count();
        $activeCustomers = (clone $query)->where('status', true)->count();

        $customersByMonth = (clone $query)
            ->select(DB::raw("strftime('%Y-%m', created_at) as month"), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $topCustomers = User::where('role', 'customer')
            ->withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(10)
            ->get();

        $customersWithBookings = User::where('role', 'customer')
            ->whereHas('bookings')
            ->count();

        return view('admin.reports.customers', compact(
            'totalCustomers', 'activeCustomers', 'customersByMonth',
            'topCustomers', 'customersWithBookings'
        ));
    }

    public function tours(Request $request)
    {
        $query = Tour::withCount(['bookings', 'reviews'])
            ->withAvg('reviews', 'rating');

        if ($categoryId = $request->get('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($countryId = $request->get('country_id')) {
            $query->where('country_id', $countryId);
        }

        $topTours = (clone $query)
            ->orderBy('bookings_count', 'desc')
            ->take(20)
            ->get();

        $totalTours = Tour::count();
        $totalBookings = Booking::count();
        $popularTours = Tour::where('popular', true)->count();
        $featuredTours = Tour::where('featured', true)->count();

        return view('admin.reports.tours', compact(
            'topTours', 'totalTours', 'totalBookings',
            'popularTours', 'featuredTours'
        ));
    }

    public function exportReport($type, $format, Request $request)
    {
        $filename = "{$type}-report-" . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($type, $request) {
            $handle = fopen('php://output', 'w');

            match ($type) {
                'revenue' => $this->exportRevenueCsv($handle, $request),
                'bookings' => $this->exportBookingsCsv($handle, $request),
                'customers' => $this->exportCustomersCsv($handle, $request),
                'tours' => $this->exportToursCsv($handle, $request),
                default => null,
            };

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportRevenueCsv($handle, Request $request)
    {
        fputcsv($handle, ['Period', 'Transactions', 'Revenue']);

        $query = Payment::where('status', 'completed');

        if ($from = $request->get('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->get('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $data = $query->select(
            DB::raw("strftime('%Y-%m', created_at) as period"),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(amount) as total')
        )
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        foreach ($data as $row) {
            fputcsv($handle, [$row->period, $row->count, number_format($row->total, 2)]);
        }
    }

    private function exportBookingsCsv($handle, Request $request)
    {
        fputcsv($handle, ['Booking #', 'Customer', 'Tour', 'Travelers', 'Total', 'Status', 'Payment', 'Date']);

        $query = Booking::with(['user', 'tour']);

        if ($from = $request->get('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->get('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $query->chunk(100, function ($bookings) use ($handle) {
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
        });
    }

    private function exportCustomersCsv($handle, Request $request)
    {
        fputcsv($handle, ['Name', 'Email', 'Phone', 'Status', 'Total Bookings', 'Registered At']);

        $query = User::where('role', 'customer')->withCount('bookings');

        if ($from = $request->get('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->get('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $query->chunk(100, function ($users) use ($handle) {
            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->name,
                    $user->email,
                    $user->phone ?? 'N/A',
                    $user->status ? 'Active' : 'Inactive',
                    $user->bookings_count,
                    $user->created_at->format('Y-m-d H:i'),
                ]);
            }
        });
    }

    private function exportToursCsv($handle, Request $request)
    {
        fputcsv($handle, ['Tour', 'Category', 'Price', 'Bookings', 'Avg Rating', 'Status']);

        $query = Tour::with('category')
            ->withCount('bookings')
            ->withAvg('reviews', 'rating');

        if ($categoryId = $request->get('category_id')) {
            $query->where('category_id', $categoryId);
        }

        $query->chunk(100, function ($tours) use ($handle) {
            foreach ($tours as $tour) {
                fputcsv($handle, [
                    $tour->title,
                    $tour->category?->name ?? 'N/A',
                    number_format($tour->price, 2),
                    $tour->bookings_count,
                    number_format($tour->reviews_avg_rating ?? 0, 1),
                    $tour->status ? 'Active' : 'Inactive',
                ]);
            }
        });
    }
}
