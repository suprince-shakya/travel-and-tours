<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Testimonial;
use App\Models\Tour;
use App\Models\Partner;

class PageController extends Controller
{
    public function show($slug)
    {
        if ($slug === 'about') {
            $stats = [
                ['number' => Tour::where('status', true)->count(), 'label' => 'Amazing Tours'],
                ['number' => number_format(Tour::sum('bookings_count') ?: 15000), 'label' => 'Happy Travelers'],
                ['number' => '100+', 'label' => 'Expert Guides'],
                ['number' => date('Y') - 2010, 'label' => 'Years Experience'],
            ];
            $testimonials = Testimonial::where('status', true)->latest()->get();
            $partners = Partner::where('status', true)->orderBy('order')->get();
            $tours = Tour::where('status', true)->where('featured', true)->latest()->take(6)->get();
            return view('frontend.pages.about', compact('stats', 'testimonials', 'partners', 'tours'));
        }

        $page = Page::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        return view('frontend.pages.show', compact('page'));
    }

    public function faq()
    {
        $categories = Faq::where('status', true)
            ->orderBy('order')
            ->get()
            ->groupBy('category');

        return view('frontend.pages.faq', compact('categories'));
    }
}
