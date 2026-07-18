<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;

class DestinationController extends Controller
{
    public function index()
    {
        $featuredCountries = Country::where('featured', true)
            ->where('status', true)
            ->withCount(['tours' => function ($q) {
                $q->where('status', true);
            }])
            ->get();

        $countries = Country::where('status', true)
            ->where('featured', false)
            ->withCount(['tours' => function ($q) {
                $q->where('status', true);
            }])
            ->get();

        return view('frontend.destinations.index', compact('featuredCountries', 'countries'));
    }

    public function show($slug)
    {
        $country = Country::where('slug', $slug)
            ->where('status', true)
            ->with(['regions' => function ($q) {
                $q->where('status', true);
            }, 'cities' => function ($q) {
                $q->where('status', true);
            }])
            ->withCount(['tours' => function ($q) {
                $q->where('status', true);
            }])
            ->firstOrFail();

        $tours = $country->tours()
            ->where('status', true)
            ->latest()
            ->paginate(9);

        return view('frontend.destinations.show', compact('country', 'tours'));
    }
}
