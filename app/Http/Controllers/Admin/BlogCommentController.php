<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogComment::with(['blog', 'user']);

        if ($status = $request->get('status')) {
            if ($status === 'approved') {
                $query->where('status', true);
            } elseif ($status === 'pending') {
                $query->where('status', false);
            }
        }

        if ($blogId = $request->get('blog_id')) {
            $query->where('blog_id', $blogId);
        }

        $comments = $query->latest()->paginate(15)->withQueryString();
        $posts = Blog::select('id', 'title')->orderBy('title')->get();

        return view('admin.blog-comments.index', compact('comments', 'posts'));
    }

    public function approve($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->update(['status' => true]);

        return redirect()->back()->with('success', 'Comment approved successfully.');
    }

    public function reject($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->update(['status' => false]);

        return redirect()->back()->with('success', 'Comment rejected successfully.');
    }

    public function destroy($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->delete();

        return redirect()->route('admin.blog-comments.index')
            ->with('success', 'Comment deleted successfully.');
    }
}
