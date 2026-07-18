<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $existing = Newsletter::where('email', $request->email)->first();

        if ($existing) {
            if (!$existing->subscribed) {
                $existing->update([
                    'subscribed' => true,
                    'token' => Str::random(32),
                ]);

                return redirect()->back()->with('success', 'You have been re-subscribed to our newsletter!');
            }

            return redirect()->back()->with('info', 'You are already subscribed to our newsletter.');
        }

        Newsletter::create([
            'email' => $request->email,
            'subscribed' => true,
            'token' => Str::random(32),
        ]);

        return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter!');
    }

    public function unsubscribe($token)
    {
        $subscriber = Newsletter::where('token', $token)->firstOrFail();

        $subscriber->update(['subscribed' => false]);

        return redirect()->route('home')->with('success', 'You have been unsubscribed from our newsletter.');
    }
}
