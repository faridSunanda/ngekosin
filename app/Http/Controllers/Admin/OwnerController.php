<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class OwnerController extends Controller
{
    /**
     * Display a listing of owners.
     */
    public function index()
    {
        $owners = User::where('role', 'owner')
            ->withCount('koses')
            ->latest()
            ->get();

        return view('admin.owner.index', compact('owners'));
    }

    /**
     * Store a newly created owner in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        $validated['role'] = 'owner';
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.owners.index')->with('success', 'Data Owner baru berhasil ditambahkan!');
    }

    /**
     * Update the specified owner in storage.
     */
    public function update(Request $request, User $owner)
    {
        if ($owner->role !== 'owner') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($owner->id)],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $owner->update($validated);

        return redirect()->route('admin.owners.index')->with('success', 'Data Owner berhasil diperbarui!');
    }

    /**
     * Remove the specified owner from storage.
     */
    public function destroy(User $owner)
    {
        if ($owner->role !== 'owner') {
            abort(404);
        }

        $owner->delete();

        return redirect()->route('admin.owners.index')->with('success', 'Data Owner berhasil dihapus!');
    }
}
