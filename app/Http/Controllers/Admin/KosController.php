<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Facility;
use App\Models\Kos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kos::with(['owner', 'campuses'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $koses = $query->get();
        $owners = User::where('role', 'owner')->get();

        return view('admin.kos.index', compact('koses', 'owners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $owners = User::where('role', 'owner')->get();
        $campuses = Campus::orderBy('name')->get();
        $facilities = Facility::orderBy('name')->get();
        return view('admin.kos.create', compact('owners', 'campuses', 'facilities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'type' => 'required|in:putra,putri,campur',
            'address' => 'required|string',
            'google_maps_url' => 'nullable|url|max:500',
            'province' => 'nullable|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'village' => 'nullable|string|max:100',
            'price_per_month' => 'required|numeric|min:0',
            'price_per_day' => 'nullable|numeric|min:0',
            'price_per_week' => 'nullable|numeric|min:0',
            'allow_two_people' => 'nullable|boolean',
            'price_2_persons' => 'nullable|numeric|min:0',
            'total_rooms' => 'required|integer|min:1',
            'available_rooms' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'facilities' => 'nullable|array',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120', // Max 5MB
            'images' => 'nullable|array|max:6',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp,gif|max:5120', // Max 6 gallery images, each max 5MB
            'status' => 'required|in:active,pending,inactive',
            'campuses' => 'nullable|array',
            'campuses.*.campus_id' => 'nullable|exists:campuses,id',
            'campuses.*.distance_meters' => 'nullable|integer|min:0',
        ]);

        $validated['allow_two_people'] = $request->has('allow_two_people');

        if (!$validated['allow_two_people']) {
            $validated['price_2_persons'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('kos_thumbnails', 'public');
            $validated['thumbnail'] = 'storage/' . $path;
        } else {
            $validated['thumbnail'] = 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=600&q=80';
        }

        // Handle gallery images upload (max 6)
        $galleryImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if (count($galleryImages) < 6) {
                    $p = $file->store('kos_galleries', 'public');
                    $galleryImages[] = 'storage/' . $p;
                }
            }
        }
        $validated['images'] = $galleryImages;

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);

        $kos = Kos::create($validated);

        // Sync nearby campuses
        if (!empty($validated['campuses'])) {
            $syncData = [];
            foreach ($validated['campuses'] as $item) {
                if (!empty($item['campus_id'])) {
                    $syncData[$item['campus_id']] = ['distance_meters' => $item['distance_meters'] ?? 0];
                }
            }
            $kos->campuses()->sync($syncData);
        }

        return redirect()->route('admin.kos.index')->with('success', 'Properti Kos berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kos $ko)
    {
        $ko->load('campuses');
        $owners = User::where('role', 'owner')->get();
        $campuses = Campus::orderBy('name')->get();
        $facilities = Facility::orderBy('name')->get();
        return view('admin.kos.edit', compact('ko', 'owners', 'campuses', 'facilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kos $ko)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'type' => 'required|in:putra,putri,campur',
            'address' => 'required|string',
            'google_maps_url' => 'nullable|url|max:500',
            'province' => 'nullable|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'village' => 'nullable|string|max:100',
            'price_per_month' => 'required|numeric|min:0',
            'price_per_day' => 'nullable|numeric|min:0',
            'price_per_week' => 'nullable|numeric|min:0',
            'allow_two_people' => 'nullable|boolean',
            'price_2_persons' => 'nullable|numeric|min:0',
            'total_rooms' => 'required|integer|min:1',
            'available_rooms' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'facilities' => 'nullable|array',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120', // Max 5MB
            'images' => 'nullable|array|max:6',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp,gif|max:5120', // Max 6 gallery images, each max 5MB
            'status' => 'required|in:active,pending,inactive',
            'campuses' => 'nullable|array',
            'campuses.*.campus_id' => 'nullable|exists:campuses,id',
            'campuses.*.distance_meters' => 'nullable|integer|min:0',
        ]);

        $validated['allow_two_people'] = $request->has('allow_two_people');

        if (!$validated['allow_two_people']) {
            $validated['price_2_persons'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            if ($ko->thumbnail && Str::startsWith($ko->thumbnail, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $ko->thumbnail));
            }
            $path = $request->file('thumbnail')->store('kos_thumbnails', 'public');
            $validated['thumbnail'] = 'storage/' . $path;
        } else {
            unset($validated['thumbnail']);
        }

        // Manage existing & new gallery images
        $existingImages = is_array($ko->images) ? $ko->images : json_decode($ko->images ?? '[]', true);
        if (!is_array($existingImages)) $existingImages = [];

        if ($request->filled('delete_images') && is_array($request->delete_images)) {
            foreach ($request->delete_images as $delImg) {
                if (($key = array_search($delImg, $existingImages)) !== false) {
                    if (Str::startsWith($delImg, 'storage/')) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $delImg));
                    }
                    unset($existingImages[$key]);
                }
            }
            $existingImages = array_values($existingImages);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if (count($existingImages) < 6) {
                    $p = $file->store('kos_galleries', 'public');
                    $existingImages[] = 'storage/' . $p;
                }
            }
        }
        $validated['images'] = array_slice($existingImages, 0, 6);

        $ko->update($validated);

        // Sync nearby campuses
        $syncData = [];
        if (!empty($validated['campuses'])) {
            foreach ($validated['campuses'] as $item) {
                if (!empty($item['campus_id'])) {
                    $syncData[$item['campus_id']] = ['distance_meters' => $item['distance_meters'] ?? 0];
                }
            }
        }
        $ko->campuses()->sync($syncData);

        return redirect()->route('admin.kos.index')->with('success', 'Data Properti Kos berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kos $ko)
    {
        if ($ko->thumbnail && Str::startsWith($ko->thumbnail, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $ko->thumbnail));
        }
        $ko->delete();
        return redirect()->route('admin.kos.index')->with('success', 'Properti Kos berhasil dihapus!');
    }

    /**
     * Quick update for available rooms via AJAX.
     */
    public function quickUpdateRooms(Request $request, Kos $ko)
    {
        $validated = $request->validate([
            'action' => 'required|in:increment,decrement',
        ]);

        if ($validated['action'] === 'increment') {
            if ($ko->available_rooms < $ko->total_rooms) {
                $ko->increment('available_rooms');
            }
        } elseif ($validated['action'] === 'decrement') {
            if ($ko->available_rooms > 0) {
                $ko->decrement('available_rooms');
            }
        }

        $ko->refresh();

        return response()->json([
            'success' => true,
            'available_rooms' => $ko->available_rooms,
            'total_rooms' => $ko->total_rooms,
            'message' => 'Ketersediaan kamar berhasil diperbarui!'
        ]);
    }
}
