<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index()
    {
        $compareIds = session('compare', []);

        $tours = collect();
        if (!empty($compareIds)) {
            $tours = Tour::whereIn('id', $compareIds)
                ->where('status', true)
                ->get();
        }

        return view('frontend.compare.index', compact('tours'));
    }

    public function add($tourId)
    {
        $tour = Tour::where('id', $tourId)->where('status', true)->firstOrFail();

        $compare = session('compare', []);

        if (in_array($tourId, $compare)) {
            return redirect()->back()->with('info', 'This tour is already in your comparison list.');
        }

        if (count($compare) >= 4) {
            return redirect()->back()->with('error', 'You can compare up to 4 tours at a time.');
        }

        $compare[] = (int) $tourId;
        session(['compare' => $compare]);

        return redirect()->back()->with('success', 'Tour added to comparison.');
    }

    public function remove($tourId)
    {
        $compare = session('compare', []);

        $compare = array_filter($compare, function ($id) use ($tourId) {
            return (int) $id !== (int) $tourId;
        });

        session(['compare' => array_values($compare)]);

        return redirect()->back()->with('success', 'Tour removed from comparison.');
    }

    public function clear()
    {
        session()->forget('compare');

        return redirect()->back()->with('success', 'Comparison list cleared.');
    }
}
