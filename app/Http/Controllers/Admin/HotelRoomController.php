<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelRoom;
use Illuminate\Http\Request;

class HotelRoomController extends Controller
{
    public function index(Request $request)
    {
        $query = HotelRoom::with('hotel');

        if ($hotelId = $request->get('hotel_id')) {
            $query->where('hotel_id', $hotelId);
        }

        if ($roomType = $request->get('room_type')) {
            $query->where('room_type', $roomType);
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status === 'active');
        }

        $rooms = $query->latest()->paginate(15)->withQueryString();
        $hotels = Hotel::where('status', true)->orderBy('name')->get();

        if ($request->ajax()) {
            return view('admin.hotel-rooms._table', compact('rooms'));
        }

        return view('admin.hotel-rooms.index', compact('rooms', 'hotels'));
    }

    public function create()
    {
        $hotels = Hotel::where('status', true)->orderBy('name')->get();

        return view('admin.hotel-rooms.form', compact('hotels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_guests' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'total_rooms' => 'required|integer|min:0',
            'available_rooms' => 'required|integer|min:0|lte:total_rooms',
            'amenities' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        if ($request->has('amenities')) {
            $validated['amenities'] = array_map('trim', explode(',', $request->amenities));
        }

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('hotel-rooms', 'public');
            }
            $validated['images'] = $paths;
        }

        HotelRoom::create($validated);

        return redirect()->route('admin.hotel-rooms.index')
            ->with('success', 'Hotel room created successfully.');
    }

    public function edit($id)
    {
        $room = HotelRoom::findOrFail($id);
        $hotels = Hotel::where('status', true)->orderBy('name')->get();

        return view('admin.hotel-rooms.form', compact('room', 'hotels'));
    }

    public function update(Request $request, $id)
    {
        $room = HotelRoom::findOrFail($id);

        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_guests' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'total_rooms' => 'required|integer|min:0',
            'available_rooms' => 'required|integer|min:0|lte:total_rooms',
            'amenities' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        if ($request->has('amenities')) {
            $validated['amenities'] = array_map('trim', explode(',', $request->amenities));
        }

        if ($request->hasFile('images')) {
            if ($room->images) {
                foreach ($room->images as $oldImage) {
                    \Storage::disk('public')->delete($oldImage);
                }
            }
            $paths = [];
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('hotel-rooms', 'public');
            }
            $validated['images'] = $paths;
        }

        $room->update($validated);

        return redirect()->route('admin.hotel-rooms.index')
            ->with('success', 'Hotel room updated successfully.');
    }

    public function destroy($id)
    {
        $room = HotelRoom::findOrFail($id);

        if ($room->images) {
            foreach ($room->images as $image) {
                \Storage::disk('public')->delete($image);
            }
        }

        $room->delete();

        return redirect()->route('admin.hotel-rooms.index')
            ->with('success', 'Hotel room deleted successfully.');
    }
}
