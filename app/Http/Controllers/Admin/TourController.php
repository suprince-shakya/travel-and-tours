<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Guide;
use App\Models\Region;
use App\Models\Tour;
use App\Models\TourDate;
use App\Models\TourGallery;
use App\Models\TourItinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::with(['category', 'country', 'guide']);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($categoryId = $request->get('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($countryId = $request->get('country_id')) {
            $query->where('country_id', $countryId);
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status === 'active');
        }

        if ($difficulty = $request->get('difficulty')) {
            $query->where('difficulty', $difficulty);
        }

        $tours = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::where('status', true)->orderBy('name')->get();
        $countries = Country::where('status', true)->orderBy('name')->get();

        if ($request->ajax()) {
            return view('admin.tours._table', compact('tours'));
        }

        return view('admin.tours.index', compact('tours', 'categories', 'countries'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->orderBy('name')->get();
        $countries = Country::where('status', true)->orderBy('name')->get();
        $regions = collect();
        $cities = collect();
        $guides = Guide::where('status', true)->orderBy('name')->get();

        return view('admin.tours.form', compact('categories', 'countries', 'regions', 'cities', 'guides'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'country_id' => 'required|exists:countries,id',
            'region_id' => 'nullable|exists:regions,id',
            'city_id' => 'nullable|exists:cities,id',
            'title' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'difficulty' => 'required|in:easy,moderate,challenging,difficult',
            'max_elevation' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'currency' => 'nullable|string|max:10',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video_url' => 'nullable|url|max:500',
            'map_embed' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'nullable|string',
            'overview' => 'nullable|string',
            'highlights' => 'nullable|string',
            'included' => 'nullable|string',
            'excluded' => 'nullable|string',
            'accommodation' => 'nullable|string',
            'transportation' => 'nullable|string',
            'meals' => 'nullable|string',
            'fitness_level' => 'nullable|string|max:255',
            'packing_list' => 'nullable|string',
            'best_season' => 'nullable|string|max:255',
            'weather_info' => 'nullable|string',
            'languages' => 'nullable|string|max:255',
            'cancellation_policy' => 'nullable|string',
            'terms' => 'nullable|string',
            'guide_id' => 'nullable|exists:guides,id',
            'max_group_size' => 'nullable|integer|min:1',
            'remaining_seats' => 'nullable|integer|min:0',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date|after_or_equal:available_from',
            'status' => 'boolean',
            'featured' => 'boolean',
            'popular' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',

            'gallery' => 'nullable|array',
            'gallery.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery.*.caption' => 'nullable|string|max:255',

            'itineraries' => 'nullable|array',
            'itineraries.*.day' => 'required|integer|min:1',
            'itineraries.*.title' => 'required|string|max:255',
            'itineraries.*.description' => 'nullable|string',
            'itineraries.*.activities' => 'nullable|string',
            'itineraries.*.meals_included' => 'nullable|string|max:255',
            'itineraries.*.accommodation' => 'nullable|string|max:255',

            'dates' => 'nullable|array',
            'dates.*.start_date' => 'required|date',
            'dates.*.end_date' => 'required|date|after_or_equal:d.*.start_date',
            'dates.*.price' => 'nullable|numeric|min:0',
            'dates.*.available_seats' => 'required|integer|min:0',
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['featured'] = $request->boolean('featured');
        $validated['popular'] = $request->boolean('popular');

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('tours/thumbnails', 'public');
        }

        $tour = Tour::create($validated);

        if ($request->has('gallery')) {
            foreach ($request->file('gallery', []) as $galleryItem) {
                if (isset($galleryItem['image']) && $galleryItem['image']) {
                    $path = $galleryItem['image']->store('tours/gallery', 'public');
                    TourGallery::create([
                        'tour_id' => $tour->id,
                        'image' => $path,
                        'caption' => $galleryItem['caption'] ?? null,
                    ]);
                }
            }
        }

        if ($request->has('itineraries')) {
            foreach ($request->input('itineraries', []) as $itinerary) {
                TourItinerary::create([
                    'tour_id' => $tour->id,
                    'day' => $itinerary['day'],
                    'title' => $itinerary['title'],
                    'description' => $itinerary['description'] ?? null,
                    'activities' => $itinerary['activities'] ?? null,
                    'meals_included' => $itinerary['meals_included'] ?? null,
                    'accommodation' => $itinerary['accommodation'] ?? null,
                ]);
            }
        }

        if ($request->has('dates')) {
            foreach ($request->input('dates', []) as $date) {
                TourDate::create([
                    'tour_id' => $tour->id,
                    'start_date' => $date['start_date'],
                    'end_date' => $date['end_date'],
                    'price' => $date['price'] ?? null,
                    'available_seats' => $date['available_seats'],
                    'status' => true,
                ]);
            }
        }

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour created successfully.');
    }

    public function show($id)
    {
        $tour = Tour::with([
            'category', 'country', 'region', 'city', 'guide',
            'galleries', 'itineraries' => fn($q) => $q->orderBy('day'),
            'dates', 'reviews.user',
        ])->findOrFail($id);

        return view('admin.tours.show', compact('tour'));
    }

    public function edit($id)
    {
        $tour = Tour::with(['galleries', 'itineraries' => fn($q) => $q->orderBy('day'), 'dates'])->findOrFail($id);

        $categories = Category::where('status', true)->orderBy('name')->get();
        $countries = Country::where('status', true)->orderBy('name')->get();
        $regions = Region::where('country_id', $tour->country_id)
            ->where('status', true)
            ->orderBy('name')
            ->get();
        $cities = City::where('country_id', $tour->country_id)
            ->when($tour->region_id, fn($q) => $q->where('region_id', $tour->region_id))
            ->where('status', true)
            ->orderBy('name')
            ->get();
        $guides = Guide::where('status', true)->orderBy('name')->get();

        return view('admin.tours.form', compact('tour', 'categories', 'countries', 'regions', 'cities', 'guides'));
    }

    public function update(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'country_id' => 'required|exists:countries,id',
            'region_id' => 'nullable|exists:regions,id',
            'city_id' => 'nullable|exists:cities,id',
            'title' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'difficulty' => 'required|in:easy,moderate,challenging,difficult',
            'max_elevation' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'currency' => 'nullable|string|max:10',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video_url' => 'nullable|url|max:500',
            'map_embed' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'nullable|string',
            'overview' => 'nullable|string',
            'highlights' => 'nullable|string',
            'included' => 'nullable|string',
            'excluded' => 'nullable|string',
            'accommodation' => 'nullable|string',
            'transportation' => 'nullable|string',
            'meals' => 'nullable|string',
            'fitness_level' => 'nullable|string|max:255',
            'packing_list' => 'nullable|string',
            'best_season' => 'nullable|string|max:255',
            'weather_info' => 'nullable|string',
            'languages' => 'nullable|string|max:255',
            'cancellation_policy' => 'nullable|string',
            'terms' => 'nullable|string',
            'guide_id' => 'nullable|exists:guides,id',
            'max_group_size' => 'nullable|integer|min:1',
            'remaining_seats' => 'nullable|integer|min:0',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date|after_or_equal:available_from',
            'status' => 'boolean',
            'featured' => 'boolean',
            'popular' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['featured'] = $request->boolean('featured');
        $validated['popular'] = $request->boolean('popular');

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('thumbnail')) {
            if ($tour->thumbnail) {
                \Storage::disk('public')->delete($tour->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('tours/thumbnails', 'public');
        }

        $tour->update($validated);

        if ($request->has('itineraries')) {
            $existingIds = $tour->itineraries()->pluck('id')->toArray();
            $submittedIds = [];

            foreach ($request->input('itineraries', []) as $itinerary) {
                if (isset($itinerary['id']) && $itinerary['id'] && in_array($itinerary['id'], $existingIds)) {
                    TourItinerary::where('id', $itinerary['id'])->update([
                        'day' => $itinerary['day'],
                        'title' => $itinerary['title'],
                        'description' => $itinerary['description'] ?? null,
                        'activities' => $itinerary['activities'] ?? null,
                        'meals_included' => $itinerary['meals_included'] ?? null,
                        'accommodation' => $itinerary['accommodation'] ?? null,
                    ]);
                    $submittedIds[] = $itinerary['id'];
                } else {
                    $new = TourItinerary::create([
                        'tour_id' => $tour->id,
                        'day' => $itinerary['day'],
                        'title' => $itinerary['title'],
                        'description' => $itinerary['description'] ?? null,
                        'activities' => $itinerary['activities'] ?? null,
                        'meals_included' => $itinerary['meals_included'] ?? null,
                        'accommodation' => $itinerary['accommodation'] ?? null,
                    ]);
                    $submittedIds[] = $new->id;
                }
            }

            $idsToDelete = array_diff($existingIds, $submittedIds);
            TourItinerary::whereIn('id', $idsToDelete)->delete();
        }

        if ($request->has('dates')) {
            $existingDateIds = $tour->dates()->pluck('id')->toArray();
            $submittedDateIds = [];

            foreach ($request->input('dates', []) as $date) {
                if (isset($date['id']) && $date['id'] && in_array($date['id'], $existingDateIds)) {
                    TourDate::where('id', $date['id'])->update([
                        'start_date' => $date['start_date'],
                        'end_date' => $date['end_date'],
                        'price' => $date['price'] ?? null,
                        'available_seats' => $date['available_seats'],
                        'status' => $date['status'] ?? true,
                    ]);
                    $submittedDateIds[] = $date['id'];
                } else {
                    $new = TourDate::create([
                        'tour_id' => $tour->id,
                        'start_date' => $date['start_date'],
                        'end_date' => $date['end_date'],
                        'price' => $date['price'] ?? null,
                        'available_seats' => $date['available_seats'],
                        'status' => $date['status'] ?? true,
                    ]);
                    $submittedDateIds[] = $new->id;
                }
            }

            $dateIdsToDelete = array_diff($existingDateIds, $submittedDateIds);
            TourDate::whereIn('id', $dateIdsToDelete)->delete();
        }

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour updated successfully.');
    }

    public function destroy($id)
    {
        $tour = Tour::findOrFail($id);

        if ($tour->bookings()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete tour with active bookings.');
        }

        if ($tour->thumbnail) {
            \Storage::disk('public')->delete($tour->thumbnail);
        }

        foreach ($tour->galleries as $gallery) {
            \Storage::disk('public')->delete($gallery->image);
            $gallery->delete();
        }

        $tour->itineraries()->delete();
        $tour->dates()->delete();
        $tour->delete();

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour deleted successfully.');
    }

    public function storeGallery(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $path = $request->file('image')->store('tours/gallery', 'public');

        TourGallery::create([
            'tour_id' => $tour->id,
            'image' => $path,
            'caption' => $request->caption,
        ]);

        return redirect()->back()->with('success', 'Gallery image added successfully.');
    }

    public function deleteGallery($id)
    {
        $gallery = TourGallery::findOrFail($id);
        \Storage::disk('public')->delete($gallery->image);
        $gallery->delete();

        return redirect()->back()->with('success', 'Gallery image deleted successfully.');
    }
}
