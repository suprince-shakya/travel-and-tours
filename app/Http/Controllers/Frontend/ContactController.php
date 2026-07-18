<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        $companyInfo = [
            'address' => Setting::getValue('company_address'),
            'phone' => Setting::getValue('company_phone'),
            'email' => Setting::getValue('company_email'),
            'working_hours' => Setting::getValue('company_working_hours'),
        ];

        return view('frontend.contact.index', compact('companyInfo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
        ]);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }
}
