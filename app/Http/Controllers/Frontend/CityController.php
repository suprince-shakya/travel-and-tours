<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;

class CityController extends Controller
{
    public function show($slug)
    {
        $city = City::where('slug', $slug)
            ->where('status', true)
            ->with('country', 'region')
            ->firstOrFail();

        $tours = $city->tours()->where('status', true)->latest()->paginate(9);

        $attractions = $city->attractions;

        return view('frontend.cities.show', compact('city', 'tours', 'attractions'));
    }
}
