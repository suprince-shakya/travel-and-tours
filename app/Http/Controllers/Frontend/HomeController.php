<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Country;
use App\Models\Faq;
use App\Models\Partner;
use App\Models\Testimonial;
use App\Models\Tour;

class HomeController extends Controller
{
    public function index()
    {
        $featuredTours = Tour::where('featured', true)
            ->where('status', true)
            ->latest()
            ->take(6)
            ->get();

        $popularTours = Tour::where('popular', true)
            ->where('status', true)
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::where('status', true)
            ->withCount(['tours' => function ($q) {
                $q->where('status', true);
            }])
            ->orderBy('order')
            ->get();

        $countries = Country::where('status', true)
            ->withCount(['tours' => function ($q) {
                $q->where('status', true);
            }])
            ->get();

        $testimonials = Testimonial::where('status', true)
            ->latest()
            ->take(6)
            ->get();

        $blogs = Blog::published()
            ->latest()
            ->take(6)
            ->get();

        $partners = Partner::where('status', true)
            ->orderBy('order')
            ->get();

        $faqs = Faq::where('status', true)
            ->latest()
            ->take(6)
            ->get();

        $featuredDestinations = Country::where('featured', true)
            ->where('status', true)
            ->get();

        return view('frontend.home', compact(
            'featuredTours',
            'popularTours',
            'categories',
            'countries',
            'testimonials',
            'blogs',
            'partners',
            'faqs',
            'featuredDestinations'
        ));
    }
}
