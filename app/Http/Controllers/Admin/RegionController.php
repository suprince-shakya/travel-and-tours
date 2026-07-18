<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegionController extends Controller
{
    public function byCountry($countryId)
    {
        $regions = Region::where('country_id', $countryId)
            ->where('status', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($regions);
    }

    public function index(Request $request)
    {
        $query = Region::with('country');

        if ($countryId = $request->get('country_id')) {
            $query->where('country_id', $countryId);
        }

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $regions = $query->latest()->paginate(15);
        $countries = Country::where('status', true)->orderBy('name')->get();

        return view('admin.regions.index', compact('regions', 'countries'));
    }

    public function create()
    {
        $countries = Country::where('status', true)->orderBy('name')->get();

        return view('admin.regions.form', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('regions', 'public');
        }

        Region::create($validated);

        return redirect()->route('admin.regions.index')
            ->with('success', 'Region created successfully.');
    }

    public function edit($id)
    {
        $region = Region::findOrFail($id);
        $countries = Country::where('status', true)->orderBy('name')->get();

        return view('admin.regions.form', compact('region', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $region = Region::findOrFail($id);

        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('image')) {
            if ($region->image) {
                \Storage::disk('public')->delete($region->image);
            }
            $validated['image'] = $request->file('image')->store('regions', 'public');
        }

        $region->update($validated);

        return redirect()->route('admin.regions.index')
            ->with('success', 'Region updated successfully.');
    }

    public function destroy($id)
    {
        $region = Region::findOrFail($id);

        if ($region->tours()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete region with associated tours.');
        }

        if ($region->image) {
            \Storage::disk('public')->delete($region->image);
        }

        $region->delete();

        return redirect()->route('admin.regions.index')
            ->with('success', 'Region deleted successfully.');
    }
}
