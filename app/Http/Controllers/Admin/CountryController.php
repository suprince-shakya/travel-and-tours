<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $query = Country::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $countries = $query->latest()->paginate(15);

        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.countries.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|size:2|unique:countries,code',
            'phone_code' => 'nullable|string|max:10',
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'currency' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:5',
            'language' => 'nullable|string|max:100',
            'timezone' => 'nullable|string|max:100',
            'capital' => 'nullable|string|max:255',
            'population' => 'nullable|integer',
            'area' => 'nullable|numeric',
            'visa_info' => 'nullable|string',
            'best_season' => 'nullable|string|max:255',
            'travel_tips' => 'nullable|string',
            'emergency_contacts' => 'nullable|string',
            'weather_info' => 'nullable|string',
            'status' => 'boolean',
            'featured' => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['featured'] = $request->boolean('featured');

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('flag')) {
            $validated['flag'] = $request->file('flag')->store('countries', 'public');
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('countries', 'public');
        }

        Country::create($validated);

        return redirect()->route('admin.countries.index')
            ->with('success', 'Country created successfully.');
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);

        return view('admin.countries.form', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $country = Country::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => ['required', 'string', 'size:2', \Illuminate\Validation\Rule::unique('countries', 'code')->ignore($country->id)],
            'phone_code' => 'nullable|string|max:10',
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'currency' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:5',
            'language' => 'nullable|string|max:100',
            'timezone' => 'nullable|string|max:100',
            'capital' => 'nullable|string|max:255',
            'population' => 'nullable|integer',
            'area' => 'nullable|numeric',
            'visa_info' => 'nullable|string',
            'best_season' => 'nullable|string|max:255',
            'travel_tips' => 'nullable|string',
            'emergency_contacts' => 'nullable|string',
            'weather_info' => 'nullable|string',
            'status' => 'boolean',
            'featured' => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['featured'] = $request->boolean('featured');

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('flag')) {
            if ($country->flag) {
                \Storage::disk('public')->delete($country->flag);
            }
            $validated['flag'] = $request->file('flag')->store('countries', 'public');
        }

        if ($request->hasFile('image')) {
            if ($country->image) {
                \Storage::disk('public')->delete($country->image);
            }
            $validated['image'] = $request->file('image')->store('countries', 'public');
        }

        $country->update($validated);

        return redirect()->route('admin.countries.index')
            ->with('success', 'Country updated successfully.');
    }

    public function destroy($id)
    {
        $country = Country::findOrFail($id);

        if ($country->tours()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete country with associated tours.');
        }

        if ($country->flag) {
            \Storage::disk('public')->delete($country->flag);
        }

        if ($country->image) {
            \Storage::disk('public')->delete($country->image);
        }

        $country->delete();

        return redirect()->route('admin.countries.index')
            ->with('success', 'Country deleted successfully.');
    }
}
