<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::where('status', true)
            ->withCount(['tours' => function ($q) {
                $q->where('status', true);
            }])
            ->paginate(12);

        return view('frontend.countries.index', compact('countries'));
    }

    public function show($slug)
    {
        $country = Country::where('slug', $slug)
            ->where('status', true)
            ->withCount(['tours' => function ($q) {
                $q->where('status', true);
            }])
            ->firstOrFail();

        $regions = $country->regions()->where('status', true)->get();

        $tours = $country->tours()->where('status', true)->latest()->paginate(9);

        $cities = $country->cities()->where('status', true)->get();

        return view('frontend.countries.show', compact('country', 'regions', 'tours', 'cities'));
    }
}
