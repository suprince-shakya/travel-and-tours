<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuideController extends Controller
{
    public function index(Request $request)
    {
        $query = Guide::with('user');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status === 'active');
        }

        $guides = $query->latest()->paginate(15);

        return view('admin.guides.index', compact('guides'));
    }

    public function create()
    {
        $users = User::where('role', 'guide')->orWhere('role', 'admin')->get();

        return view('admin.guides.form', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:guides,email',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'bio' => 'nullable|string',
            'experience' => 'nullable|integer|min:0',
            'languages' => 'nullable|string|max:500',
            'certifications' => 'nullable|string',
            'specialties' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('guides', 'public');
        }

        Guide::create($validated);

        return redirect()->route('admin.guides.index')
            ->with('success', 'Guide created successfully.');
    }

    public function edit($id)
    {
        $guide = Guide::findOrFail($id);
        $users = User::where('role', 'guide')->orWhere('role', 'admin')->get();

        return view('admin.guides.form', compact('guide', 'users'));
    }

    public function update(Request $request, $id)
    {
        $guide = Guide::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', \Illuminate\Validation\Rule::unique('guides', 'email')->ignore($guide->id)],
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'bio' => 'nullable|string',
            'experience' => 'nullable|integer|min:0',
            'languages' => 'nullable|string|max:500',
            'certifications' => 'nullable|string',
            'specialties' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('photo')) {
            if ($guide->photo) {
                \Storage::disk('public')->delete($guide->photo);
            }
            $validated['photo'] = $request->file('photo')->store('guides', 'public');
        }

        $guide->update($validated);

        return redirect()->route('admin.guides.index')
            ->with('success', 'Guide updated successfully.');
    }

    public function destroy($id)
    {
        $guide = Guide::findOrFail($id);

        if ($guide->tours()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete guide with assigned tours.');
        }

        if ($guide->photo) {
            \Storage::disk('public')->delete($guide->photo);
        }

        $guide->delete();

        return redirect()->route('admin.guides.index')
            ->with('success', 'Guide deleted successfully.');
    }
}
