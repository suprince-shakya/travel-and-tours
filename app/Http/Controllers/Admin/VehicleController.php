<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status === 'active');
        }

        $vehicles = $query->latest()->paginate(15);

        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'model' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'price_per_day' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'driver_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'fuel_type' => 'nullable|string|max:50',
            'mileage' => 'nullable|string|max:50',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->has('features')) {
            $validated['features'] = array_map('trim', explode(',', $request->features));
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('vehicles', 'public');
        }

        if ($request->hasFile('gallery')) {
            $paths = [];
            foreach ($request->file('gallery') as $file) {
                $paths[] = $file->store('vehicles/gallery', 'public');
            }
            $validated['gallery'] = $paths;
        }

        Vehicle::create($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehicle created successfully.');
    }

    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        return view('admin.vehicles.form', compact('vehicle'));
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'model' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'price_per_day' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'driver_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'fuel_type' => 'nullable|string|max:50',
            'mileage' => 'nullable|string|max:50',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->has('features')) {
            $validated['features'] = array_map('trim', explode(',', $request->features));
        }

        if ($request->hasFile('image')) {
            if ($vehicle->image) {
                \Storage::disk('public')->delete($vehicle->image);
            }
            $validated['image'] = $request->file('image')->store('vehicles', 'public');
        }

        if ($request->hasFile('gallery')) {
            if ($vehicle->gallery) {
                foreach ($vehicle->gallery as $oldImage) {
                    \Storage::disk('public')->delete($oldImage);
                }
            }
            $paths = [];
            foreach ($request->file('gallery') as $file) {
                $paths[] = $file->store('vehicles/gallery', 'public');
            }
            $validated['gallery'] = $paths;
        }

        $vehicle->update($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehicle updated successfully.');
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        if ($vehicle->image) {
            \Storage::disk('public')->delete($vehicle->image);
        }

        if ($vehicle->gallery) {
            foreach ($vehicle->gallery as $image) {
                \Storage::disk('public')->delete($image);
            }
        }

        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehicle deleted successfully.');
    }
}
