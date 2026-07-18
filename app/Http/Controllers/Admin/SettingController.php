<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_tagline' => 'nullable|string|max:500',
            'site_description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,svg|max:1024',
            'admin_email' => 'nullable|email|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_address' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|url|max:500',
            'twitter_url' => 'nullable|url|max:500',
            'instagram_url' => 'nullable|url|max:500',
            'linkedin_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'currency' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:5',
            'timezone' => 'nullable|string|max:100',
            'date_format' => 'nullable|string|max:20',
            'pagination_per_page' => 'nullable|integer|min:5|max:100',
            'maintenance_mode' => 'nullable|boolean',
            'booking_auto_confirm' => 'nullable|boolean',
            'review_auto_approve' => 'nullable|boolean',
            'google_analytics_id' => 'nullable|string|max:100',
            'google_maps_key' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'logo'], ['value' => $path, 'group' => 'general']);

            $oldLogo = Setting::where('key', 'logo')->where('value', '!=', $path)->first();
            if ($oldLogo && $oldLogo->value) {
                \Storage::disk('public')->delete($oldLogo->value);
            }
        }

        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'favicon'], ['value' => $path, 'group' => 'general']);

            $oldFavicon = Setting::where('key', 'favicon')->where('value', '!=', $path)->first();
            if ($oldFavicon && $oldFavicon->value) {
                \Storage::disk('public')->delete($oldFavicon->value);
            }
        }

        foreach ($validated as $key => $value) {
            if (in_array($key, ['logo', 'favicon'])) {
                continue;
            }

            $group = 'general';
            if (in_array($key, ['facebook_url', 'twitter_url', 'instagram_url', 'linkedin_url', 'youtube_url'])) {
                $group = 'social';
            } elseif (in_array($key, ['meta_title', 'meta_description', 'meta_keywords'])) {
                $group = 'seo';
            } elseif (in_array($key, ['currency', 'currency_symbol', 'timezone', 'date_format', 'pagination_per_page'])) {
                $group = 'localization';
            } elseif (in_array($key, ['maintenance_mode', 'booking_auto_confirm', 'review_auto_approve'])) {
                $group = 'config';
            } elseif (in_array($key, ['google_analytics_id', 'google_maps_key'])) {
                $group = 'integration';
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '', 'group' => $group]
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
