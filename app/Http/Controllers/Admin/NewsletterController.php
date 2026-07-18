<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $query = Newsletter::query();

        if ($search = $request->get('search')) {
            $query->where('email', 'like', "%{$search}%");
        }

        if ($request->has('subscribed')) {
            $query->where('subscribed', $request->boolean('subscribed'));
        }

        $subscribers = $query->latest()->paginate(15);

        return view('admin.newsletters.index', compact('subscribers'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $subscribers = Newsletter::where('subscribed', true)->get();

        foreach ($subscribers as $subscriber) {
            try {
                Mail::raw($validated['content'], function ($message) use ($subscriber, $validated) {
                    $message->to($subscriber->email)
                        ->subject($validated['subject']);
                });
            } catch (\Exception $e) {
                \Log::error("Newsletter send failed to {$subscriber->email}: " . $e->getMessage());
            }
        }

        return redirect()->route('admin.newsletters.index')
            ->with('success', "Newsletter sent to {$subscribers->count()} subscribers.");
    }

    public function export()
    {
        $subscribers = Newsletter::where('subscribed', true)->latest()->get();

        $filename = 'newsletter-subscribers-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($subscribers) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Email', 'Subscribed', 'Date']);

            foreach ($subscribers as $sub) {
                fputcsv($handle, [
                    $sub->email,
                    $sub->subscribed ? 'Subscribed' : 'Unsubscribed',
                    $sub->created_at ? $sub->created_at->format('Y-m-d H:i') : 'N/A',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy($id)
    {
        $subscriber = Newsletter::findOrFail($id);
        $subscriber->delete();

        return redirect()->route('admin.newsletters.index')
            ->with('success', 'Subscriber deleted successfully.');
    }
}
