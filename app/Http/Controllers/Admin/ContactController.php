<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            if ($status === 'unread') {
                $query->whereNull('read_at');
            } elseif ($status === 'read') {
                $query->whereNotNull('read_at');
            }
        }

        $contacts = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return view('admin.contacts._table', compact('contacts'));
        }

        return view('admin.contacts.index', compact('contacts'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        if (!$contact->read_at) {
            $contact->update(['read_at' => now()]);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    public function reply(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $validated = $request->validate([
            'reply_message' => 'required|string',
        ]);

        try {
            Mail::html($validated['reply_message'], function ($message) use ($contact) {
                $message->to($contact->email, $contact->name)
                    ->subject('Re: ' . ($contact->subject ?? 'Your Inquiry'));
            });

            $contact->update([
                'replied_at' => now(),
                'read_at' => $contact->read_at ?? now(),
            ]);

            return redirect()->back()->with('success', 'Reply sent successfully.');
        } catch (\Exception $e) {
            \Log::error("Contact reply failed: " . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to send reply. Please try again.');
        }
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact inquiry deleted successfully.');
    }
}
