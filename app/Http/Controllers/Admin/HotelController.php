<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $query = Hotel::with(['country', 'city']);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($countryId = $request->get('country_id')) {
            $query->where('country_id', $countryId);
        }

        if ($starRating = $request->get('star_rating')) {
            $query->where('star_rating', $starRating);
        }

        $hotels = $query->latest()->paginate(15);
        $countries = Country::where('status', true)->orderBy('name')->get();

        return view('admin.hotels.index', compact('hotels', 'countries'));
    }

    public function create()
    {
        $countries = Country::where('status', true)->orderBy('name')->get();
        $cities = collect();

        return view('admin.hotels.form', compact('countries', 'cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:500',
            'star_rating' => 'nullable|integer|min:1|max:5',
            'amenities' => 'nullable|string',
            'check_in' => 'nullable|string|max:10',
            'check_out' => 'nullable|string|max:10',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'boolean',
            'featured' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = $request->boolean('status');
        $validated['featured'] = $request->boolean('featured');

        if ($request->has('amenities')) {
            $validated['amenities'] = array_map('trim', explode(',', $request->amenities));
        }

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('hotels', 'public');
            }
            $validated['images'] = $paths;
        }

        Hotel::create($validated);

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel created successfully.');
    }

    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        $countries = Country::where('status', true)->orderBy('name')->get();
        $cities = City::where('country_id', $hotel->country_id)
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return view('admin.hotels.form', compact('hotel', 'countries', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:500',
            'star_rating' => 'nullable|integer|min:1|max:5',
            'amenities' => 'nullable|string',
            'check_in' => 'nullable|string|max:10',
            'check_out' => 'nullable|string|max:10',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'boolean',
            'featured' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = $request->boolean('status');
        $validated['featured'] = $request->boolean('featured');

        if ($request->has('amenities')) {
            $validated['amenities'] = array_map('trim', explode(',', $request->amenities));
        }

        if ($request->hasFile('images')) {
            if ($hotel->images) {
                foreach ($hotel->images as $oldImage) {
                    \Storage::disk('public')->delete($oldImage);
                }
            }
            $paths = [];
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('hotels', 'public');
            }
            $validated['images'] = $paths;
        }

        $hotel->update($validated);

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel updated successfully.');
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);

        if ($hotel->rooms()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete hotel with associated rooms.');
        }

        if ($hotel->images) {
            foreach ($hotel->images as $image) {
                \Storage::disk('public')->delete($image);
            }
        }

        $hotel->delete();

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel deleted successfully.');
    }
}
