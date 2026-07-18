<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Tour;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::where('status', true);

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('overview', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('country')) {
            $query->where('country_id', $request->country);
        }

        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('duration_min')) {
            $query->where('duration', '>=', $request->duration_min);
        }

        if ($request->filled('duration_max')) {
            $query->where('duration', '<=', $request->duration_max);
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

        $keyword = $request->keyword;

        $tours = $query->paginate(9)->withQueryString();

        $categories = Category::where('status', true)->get();
        $countries = Country::where('status', true)->get();
        $difficulties = Tour::where('status', true)->distinct()->pluck('difficulty');
        $seasons = Tour::where('status', true)->distinct()->pluck('best_season');

        return view('frontend.search.index', compact(
            'tours', 'categories', 'countries', 'difficulties', 'seasons', 'keyword'
        ));
    }
}
