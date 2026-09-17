<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403, 'Akses khusus Administrator.');
        }

        return view('admin.dashboard', compact('user'));
    }

    public function ownerDashboard()
    {
        $user = Auth::user();
        if (!$user || !$user->isOwner()) {
            abort(403, 'Akses khusus Pemilik Kos.');
        }

        return view('owner.dashboard', compact('user'));
    }

    public function userDashboard()
    {
        $user = Auth::user();
        if (!$user || !$user->isUser()) {
            abort(403, 'Akses khusus Pencari Kos.');
        }

        return view('user.dashboard', compact('user'));
    }
}
