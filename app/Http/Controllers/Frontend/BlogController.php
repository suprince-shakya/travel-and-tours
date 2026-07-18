<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::published()
            ->with('user', 'category')
            ->latest()
            ->paginate(6);

        return view('frontend.blog.index', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->published()
            ->with(['user', 'category', 'comments' => function ($q) {
                $q->where('status', true)->latest();
            }])
            ->firstOrFail();

        $blog->increment('views');

        $relatedPosts = Blog::published()
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.blog.show', compact('blog', 'relatedPosts'));
    }
}
