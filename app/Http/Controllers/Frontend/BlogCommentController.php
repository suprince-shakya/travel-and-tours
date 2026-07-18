<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function index(Blog $blog)
    {
        $comments = $blog->comments()
            ->where('status', true)
            ->latest()
            ->get();

        if (request()->wantsJson()) {
            $html = view('frontend.blog._comments', compact('comments'))->render();
            return response()->json(['html' => $html, 'count' => $comments->count()]);
        }

        return $comments;
    }

    public function store(Request $request, Blog $blog)
    {
        $request->validate([
            'name' => auth()->check() ? 'nullable' : 'required|string|max:255',
            'email' => auth()->check() ? 'nullable' : 'required|email|max:255',
            'comment' => 'required|string|min:3|max:2000',
        ]);

        abort_unless($blog->status && $blog->published_at, 404);

        $comment = BlogComment::create([
            'blog_id' => $blog->id,
            'user_id' => auth()->id(),
            'name' => auth()->check() ? auth()->user()->name : $request->name,
            'email' => auth()->check() ? auth()->user()->email : $request->email,
            'comment' => $request->comment,
            'status' => config('app.comment_auto_approve', false) ? 1 : 0,
        ]);

        if ($request->wantsJson()) {
            $autoApprove = config('app.comment_auto_approve', false);
            if ($autoApprove) {
                $html = view('frontend.blog._comment', ['comment' => $comment])->render();
                return response()->json([
                    'success' => true,
                    'message' => 'Your comment has been posted!',
                    'comment' => $html,
                    'auto_approved' => true,
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'Your comment has been submitted and is pending approval.',
                'auto_approved' => false,
            ]);
        }

        return redirect()->back()->with('success', 'Your comment has been submitted and is pending approval.');
    }
}
