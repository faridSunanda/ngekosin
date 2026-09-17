<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    /**
     * Display a listing of the campuses.
     */
    public function index(Request $request)
    {
        $query = Campus::withCount('koses')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('abbreviation', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $campuses = $query->get();

        return view('admin.campus.index', compact('campuses'));
    }

    /**
     * Store a newly created campus in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:100',
        ]);

        Campus::create($validated);

        return redirect()->route('admin.campuses.index')->with('success', 'Master Kampus berhasil ditambahkan!');
    }

    /**
     * Update the specified campus in storage.
     */
    public function update(Request $request, Campus $campus)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:100',
        ]);

        $campus->update($validated);

        return redirect()->route('admin.campuses.index')->with('success', 'Data Master Kampus berhasil diperbarui!');
    }

    /**
     * Remove the specified campus from storage.
     */
    public function destroy(Campus $campus)
    {
        $campus->delete();
        return redirect()->route('admin.campuses.index')->with('success', 'Master Kampus berhasil dihapus!');
    }
}
