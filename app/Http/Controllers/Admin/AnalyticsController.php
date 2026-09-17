<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Facility;
use App\Models\Kos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display the admin analytics dashboard.
     */
    public function index()
    {
        // General Totals
        $totalKos = Kos::count();
        $activeKos = Kos::where('status', 'active')->count();
        $totalOwners = User::where('role', 'owner')->count();
        $totalUsers = User::where('role', 'user')->count();
        $totalCampuses = Campus::count();
        $totalFacilities = Facility::count();

        // Performance & Engagement Metrics
        $totalViews = Kos::sum('views_count') ?? 0;
        $totalClicks = Kos::sum('clicks_count') ?? 0;
        $conversionRate = $totalViews > 0 ? round(($totalClicks / $totalViews) * 100, 1) : 0;

        // Room Occupancy Statistics
        $totalRooms = Kos::sum('total_rooms') ?? 0;
        $availableRooms = Kos::sum('available_rooms') ?? 0;
        $occupiedRooms = max(0, $totalRooms - $availableRooms);
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100, 1) : 0;

        // Kos Type Breakdown (Putra, Putri, Campur)
        $typeBreakdown = Kos::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        $typeData = [
            'putra' => $typeBreakdown['putra'] ?? 0,
            'putri' => $typeBreakdown['putri'] ?? 0,
            'campur' => $typeBreakdown['campur'] ?? 0,
        ];

        // Top 5 Most Inquired Kos (by clicks)
        $topKosByClicks = Kos::with('owner')
            ->orderByDesc('clicks_count')
            ->take(5)
            ->get();

        // Top 5 Most Viewed Kos
        $topKosByViews = Kos::with('owner')
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        // City Distribution
        $cityBreakdown = Kos::select('city', DB::raw('count(*) as count'))
            ->groupBy('city')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        return view('admin.analytics.index', compact(
            'totalKos',
            'activeKos',
            'totalOwners',
            'totalUsers',
            'totalCampuses',
            'totalFacilities',
            'totalViews',
            'totalClicks',
            'conversionRate',
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'occupancyRate',
            'typeData',
            'topKosByClicks',
            'topKosByViews',
            'cityBreakdown'
        ));
    }
}
