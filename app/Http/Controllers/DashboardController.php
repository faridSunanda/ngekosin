<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Kos;
use App\Models\User;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403, 'Akses khusus Administrator.');
        }

        $totalKos = Kos::count();
        $newKosThisMonth = Kos::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $totalOwners = User::where('role', 'owner')->count();
        $newOwnersThisMonth = User::where('role', 'owner')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $totalUsers = User::where('role', 'user')->count();
        $newUsersThisWeek = User::where('role', 'user')
            ->where('created_at', '>=', now()->startOfWeek())
            ->count();

        $totalViews = (int) Kos::sum('views_count');
        $totalClicks = (int) Kos::sum('clicks_count');

        $popularKoses = Kos::with('owner')
            ->orderByDesc('views_count')
            ->orderByDesc('clicks_count')
            ->take(5)
            ->get();

        $recentKoses = Kos::with('owner')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'user',
            'totalKos',
            'newKosThisMonth',
            'totalOwners',
            'newOwnersThisMonth',
            'totalUsers',
            'newUsersThisWeek',
            'totalViews',
            'totalClicks',
            'popularKoses',
            'recentKoses'
        ));
    }

    public function ownerDashboard()
    {
        $user = Auth::user();
        if (!$user || !$user->isOwner()) {
            abort(403, 'Akses khusus Pemilik Kos.');
        }

        $ownerKoses = Kos::where('user_id', $user->id)
            ->with(['campuses'])
            ->latest()
            ->get();

        $totalKos = $ownerKoses->count();
        $totalRooms = (int) $ownerKoses->sum('total_rooms');
        $availableRooms = (int) $ownerKoses->sum('available_rooms');
        $occupiedRooms = max(0, $totalRooms - $availableRooms);
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

        $totalViews = (int) $ownerKoses->sum('views_count');
        $totalClicks = (int) $ownerKoses->sum('clicks_count');

        return view('owner.dashboard', compact(
            'user',
            'ownerKoses',
            'totalKos',
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'occupancyRate',
            'totalViews',
            'totalClicks'
        ));
    }

    public function userDashboard()
    {
        $user = Auth::user();
        if (!$user || !$user->isUser()) {
            abort(403, 'Akses khusus Pencari Kos.');
        }

        $recommendedKoses = Kos::with(['owner', 'campuses'])
            ->where('status', 'active')
            ->orderByDesc('clicks_count')
            ->orderByDesc('views_count')
            ->take(6)
            ->get();

        return view('user.dashboard', compact('user', 'recommendedKoses'));
    }
}
