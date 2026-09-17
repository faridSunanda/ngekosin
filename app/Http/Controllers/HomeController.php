<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Facility;
use App\Models\Kos;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the public landing page with real database data.
     */
    public function index()
    {
        $koses = Kos::with(['owner', 'campuses'])
            ->where('status', 'active')
            ->latest()
            ->get();

        $facilities = Facility::orderBy('name')->get();
        $campuses = Campus::orderBy('name')->get();
        $cities = Kos::where('status', 'active')
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city');

        $maxPrice = Kos::where('status', 'active')->max('price_per_month') ?: 5000000;

        $kosFormatted = $koses->map(function ($kos) {
            $category = 'Kos ' . ucfirst($kos->type);

            $benefits = [];
            $campusList = [];
            foreach ($kos->campuses as $campus) {
                $dist = $campus->pivot->distance_meters ?? 0;
                $distStr = $dist >= 1000 ? round($dist / 1000, 1) . ' km' : $dist . ' meter';
                $benefits[] = 'Dekat ' . $campus->name . ' (' . $distStr . ')';
                $campusList[] = [
                    'id' => $campus->id,
                    'name' => $campus->name,
                    'distance_meters' => $dist,
                    'distance_str' => $distStr,
                ];
            }
            if (empty($benefits)) {
                $benefits[] = 'Lokasi strategis di ' . $kos->city;
            }

            if ($kos->allow_two_people && $kos->price_2_persons) {
                $benefits[] = 'Boleh 2 orang (Rp ' . number_format($kos->price_2_persons, 0, ',', '.') . '/bulan)';
            }

            if ($kos->price_per_day) {
                $benefits[] = 'Bisa Harian (Rp ' . number_format($kos->price_per_day, 0, ',', '.') . '/hari)';
            }
            if ($kos->price_per_week) {
                $benefits[] = 'Bisa Mingguan (Rp ' . number_format($kos->price_per_week, 0, ',', '.') . '/minggu)';
            }

            $facilitiesArr = is_array($kos->facilities) ? $kos->facilities : json_decode($kos->facilities ?? '[]', true);
            if (!is_array($facilitiesArr)) {
                $facilitiesArr = [];
            }

            $galleryArr = is_array($kos->images) ? $kos->images : json_decode($kos->images ?? '[]', true);
            if (!is_array($galleryArr)) $galleryArr = [];

            $formattedGallery = array_map(function($img) {
                return asset($img);
            }, $galleryArr);

            if (empty($formattedGallery)) {
                $formattedGallery = [
                    asset($kos->thumbnail ?: 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=600&q=80'),
                ];
            }

            return [
                'id' => $kos->id,
                'slug' => $kos->slug,
                'title' => $kos->name,
                'owner' => $kos->owner ? $kos->owner->name : 'Pemilik Kos',
                'ownerPhone' => $kos->owner ? $kos->owner->phone : '',
                'logo' => asset($kos->thumbnail ?: 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=600&q=80'),
                'images' => array_slice($formattedGallery, 0, 6),
                'category' => $category,
                'rawType' => $kos->type,
                'system' => 'Sisa ' . $kos->available_rooms . ' Kamar',
                'location' => $kos->city,
                'address' => $kos->address . ($kos->village ? ', Kel. ' . $kos->village : '') . ($kos->district ? ', Kec. ' . $kos->district : '') . ', ' . $kos->city,
                'priceVal' => (int) $kos->price_per_month,
                'priceStr' => 'Rp ' . number_format($kos->price_per_month, 0, ',', '.') . ' / bulan',
                'roomSize' => 'Total ' . $kos->total_rooms . ' Kamar',
                'postDate' => $kos->created_at ? $kos->created_at->format('d M Y') : 'Terbaru',
                'date' => $kos->created_at ? $kos->created_at->format('Y-m-d') : date('Y-m-d'),
                'created_at_ts' => $kos->created_at ? $kos->created_at->timestamp : $kos->id,
                'facilities' => $facilitiesArr,
                'description' => $kos->description ?: 'Kos nyaman dan strategis dengan fasilitas lengkap.',
                'requirements' => !empty($facilitiesArr) ? $facilitiesArr : ['Fasilitas standar kos'],
                'benefits' => $benefits,
                'google_maps_url' => $kos->google_maps_url ?: 'https://maps.google.com/?q=' . urlencode($kos->name . ' ' . $kos->city),
                'lastUpdate' => $kos->updated_at ? $kos->updated_at->diffForHumans() : 'Baru saja',
                'updatedAtStr' => $kos->updated_at ? $kos->updated_at->format('d M Y, H:i') : 'Terbaru',
                'campuses' => $campusList,
                'ownerAbout' => $kos->owner ? $kos->owner->name . ' adalah pemilik kos terverifikasi Ngekosin.' : 'Pemilik kos terverifikasi.',
            ];
        });

        return view('welcome', compact('kosFormatted', 'facilities', 'campuses', 'cities', 'maxPrice'));
    }

    /**
     * Increment views count when user views kos details.
     */
    public function incrementView(Kos $kos)
    {
        $kos->increment('views_count');
        return response()->json(['success' => true, 'views_count' => $kos->views_count]);
    }

    /**
     * Increment clicks/inquiry count when user clicks to contact owner.
     */
    public function incrementClick(Kos $kos)
    {
        $kos->increment('clicks_count');
        return response()->json(['success' => true, 'clicks_count' => $kos->clicks_count]);
    }
}
