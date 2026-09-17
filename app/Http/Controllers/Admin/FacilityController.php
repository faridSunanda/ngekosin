<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of the facilities.
     */
    public function index(Request $request)
    {
        $query = Facility::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $facilities = $query->get();

        return view('admin.facility.index', compact('facilities'));
    }

    /**
     * Store a newly created facility in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:facilities,name',
            'icon' => 'nullable|string|max:50',
        ]);

        Facility::create($validated);

        return redirect()->route('admin.facilities.index')->with('success', 'Master Fasilitas berhasil ditambahkan!');
    }

    /**
     * Update the specified facility in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:facilities,name,' . $facility->id,
            'icon' => 'nullable|string|max:50',
        ]);

        $facility->update($validated);

        return redirect()->route('admin.facilities.index')->with('success', 'Data Master Fasilitas berhasil diperbarui!');
    }

    /**
     * Remove the specified facility from storage.
     */
    public function destroy(Facility $facility)
    {
        $facility->delete();
        return redirect()->route('admin.facilities.index')->with('success', 'Master Fasilitas berhasil dihapus!');
    }
}
