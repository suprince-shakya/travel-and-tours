<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::where('status', true);

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($categories = $request->input('category')) {
            $catIds = Category::whereIn('slug', (array)$categories)->where('status', true)->pluck('id');
            if ($catIds->isNotEmpty()) {
                $query->whereIn('category_id', $catIds);
            }
        }

        if ($request->filled('country')) {
            $country = Country::where('slug', $request->country)->where('status', true)->first();
            if ($country) {
                $query->where('country_id', $country->id);
            }
        }

        if ($difficulties = $request->input('difficulty')) {
            $query->whereIn('difficulty', array_map('strtolower', (array)$difficulties));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('duration')) {
            $duration = $request->duration;
            if (str_contains($duration, '-')) {
                [$min, $max] = explode('-', $duration);
                $query->where('duration', '>=', (int)$min)->where('duration', '<=', (int)$max);
            } else {
                $query->where('duration', '>=', (int)$duration);
            }
        }

        if ($request->filled('season')) {
            $query->where('best_season', $request->season);
        }

        if ($request->filled('rating')) {
            $query->whereHas('reviews', function ($q) use ($request) {
                $q->where('rating', '>=', $request->rating);
            });
        }

        $sort = $request->sort;
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'duration':
                $query->orderBy('duration', 'asc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $tours = $query->paginate(9)->withQueryString();

        if ($request->ajax()) {
            return view('frontend.tours._list', compact('tours'));
        }

        $categories = Category::where('status', true)->get();
        $countries = Country::where('status', true)->get();

        return view('frontend.tours.index', compact('tours', 'categories', 'countries'));
    }

    public function show($slug)
    {
        $tour = Tour::where('slug', $slug)
            ->where('status', true)
            ->with([
                'category',
                'country',
                'region',
                'city',
                'galleries',
                'dates' => function ($q) {
                    $q->where('status', true)->where('start_date', '>=', now());
                },
                'itineraries' => function ($q) {
                    $q->orderBy('day');
                },
                'guide',
                'reviews' => function ($q) {
                    $q->approved()->with('user');
                },
            ])
            ->firstOrFail();

        $tour->increment('views');

        $relatedTours = Tour::where('status', true)
            ->where('id', '!=', $tour->id)
            ->where(function ($q) use ($tour) {
                $q->where('category_id', $tour->category_id)
                  ->orWhere('country_id', $tour->country_id);
            })
            ->latest()
            ->take(8)
            ->get();

        return view('frontend.tours.show', compact('tour', 'relatedTours'));
    }
}
