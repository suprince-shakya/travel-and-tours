<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $query = User::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role = $request->get('role')) {
            $query->where('role', $role);
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status === 'active' ? 'active' : 'inactive');
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return view('admin.users._table', compact('users'));
        }

        return view('admin.users.index', compact('users'));
    }

    public function customers(Request $request)
    {
        $query = User::where('role', 'customer');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status === 'active' ? 'active' : 'inactive');
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return view('admin.customers._table', compact('users'));
        }

        return view('admin.customers.index', compact('users'));
    }

    public function create()
    {
        if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        return view('admin.users.form');
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,staff,customer,guide',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $user = User::findOrFail($id);

        return view('admin.users.form', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,staff,customer,guide',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
