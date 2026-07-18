<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CityController extends Controller
{
    public function byCountry($countryId)
    {
        $cities = City::where('country_id', $countryId)
            ->where('status', true)
            ->orderBy('name')
            ->get(['id', 'name', 'region_id']);

        return response()->json($cities);
    }

    public function byRegion($regionId)
    {
        $cities = City::where('region_id', $regionId)
            ->where('status', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($cities);
    }

    public function index(Request $request)
    {
        $query = City::with(['country', 'region']);

        if ($countryId = $request->get('country_id')) {
            $query->where('country_id', $countryId);
        }

        if ($regionId = $request->get('region_id')) {
            $query->where('region_id', $regionId);
        }

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $cities = $query->latest()->paginate(15);
        $countries = Country::where('status', true)->orderBy('name')->get();

        return view('admin.cities.index', compact('cities', 'countries'));
    }

    public function create()
    {
        $countries = Country::where('status', true)->orderBy('name')->get();
        $regions = collect();

        return view('admin.cities.form', compact('countries', 'regions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'region_id' => 'nullable|exists:regions,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'attractions' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cities', 'public');
        }

        City::create($validated);

        return redirect()->route('admin.cities.index')
            ->with('success', 'City created successfully.');
    }

    public function edit($id)
    {
        $city = City::findOrFail($id);
        $countries = Country::where('status', true)->orderBy('name')->get();
        $regions = Region::where('country_id', $city->country_id)
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return view('admin.cities.form', compact('city', 'countries', 'regions'));
    }

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);

        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'region_id' => 'nullable|exists:regions,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'attractions' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('image')) {
            if ($city->image) {
                \Storage::disk('public')->delete($city->image);
            }
            $validated['image'] = $request->file('image')->store('cities', 'public');
        }

        $city->update($validated);

        return redirect()->route('admin.cities.index')
            ->with('success', 'City updated successfully.');
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);

        if ($city->tours()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete city with associated tours.');
        }

        if ($city->image) {
            \Storage::disk('public')->delete($city->image);
        }

        $city->delete();

        return redirect()->route('admin.cities.index')
            ->with('success', 'City deleted successfully.');
    }
}
