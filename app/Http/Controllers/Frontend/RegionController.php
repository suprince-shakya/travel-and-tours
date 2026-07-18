<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Region;

class RegionController extends Controller
{
    public function show($slug)
    {
        $region = Region::where('slug', $slug)
            ->where('status', true)
            ->with('country')
            ->firstOrFail();

        $tours = $region->tours()->where('status', true)->latest()->paginate(9);

        $cities = $region->cities()->where('status', true)->get();

        return view('frontend.regions.show', compact('region', 'tours', 'cities'));
    }
}
