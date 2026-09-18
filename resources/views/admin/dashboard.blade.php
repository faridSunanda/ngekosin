@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('portal_name', 'Admin Panel')
@section('breadcrumb_current', 'Dashboard Admin')

@section('content')
    <!-- Welcome Banner (Matching Reference Card Layout) -->
    <div class="relative bg-gradient-to-r from-[#20344c] via-[#1a2d42] to-[#142334] text-white p-6 sm:p-8 rounded-lg shadow-xl overflow-hidden mb-8 border border-[#2c4361]">

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Halo, {{ strtoupper($user->name) }}!</h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl leading-relaxed">
                    Selamat datang di Backoffice Administrator Ngekosin. Pantau verifikasi pemilik kos, kelola katalog properti, dan setujui transaksi sewa.
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Grid Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="p-5 rounded-md bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Properti Kos</span>
                <div class="h-8 w-8 bg-blue-100 text-blue-600 rounded-md flex items-center justify-center">
                    <x-lucide-home class="w-4 h-4" />
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#20344c]">{{ number_format($totalKos) }}</h3>
            <p class="text-[11px] text-emerald-600 font-semibold mt-1.5 flex items-center gap-1">
                <x-lucide-trending-up class="w-3.5 h-3.5" /> +{{ number_format($newKosThisMonth) }} kos baru bulan ini
            </p>
        </div>

        <div class="p-5 rounded-md bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Pemilik Kos (Owner)</span>
                <div class="h-8 w-8 bg-amber-100 text-[#f99d18] rounded-md flex items-center justify-center">
                    <x-lucide-users class="w-4 h-4" />
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#20344c]">{{ number_format($totalOwners) }}</h3>
            <p class="text-[11px] text-[#f99d18] font-bold mt-1.5 flex items-center gap-1">
                <x-lucide-user-check class="w-3.5 h-3.5" /> +{{ number_format($newOwnersThisMonth) }} owner baru bulan ini
            </p>
        </div>

        <div class="p-5 rounded-md bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Pencari Kos (User)</span>
                <div class="h-8 w-8 bg-purple-100 text-purple-600 rounded-md flex items-center justify-center">
                    <x-lucide-user-check class="w-4 h-4" />
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#20344c]">{{ number_format($totalUsers) }}</h3>
            <p class="text-[11px] text-emerald-600 font-semibold mt-1.5 flex items-center gap-1">
                <x-lucide-trending-up class="w-3.5 h-3.5" /> +{{ number_format($newUsersThisWeek) }} user minggu ini
            </p>
        </div>

        <div class="p-5 rounded-md bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Inquiry / Klik</span>
                <div class="h-8 w-8 bg-emerald-100 text-emerald-600 rounded-md flex items-center justify-center">
                    <x-lucide-mouse-pointer-click class="w-4 h-4" />
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#20344c]">{{ number_format($totalClicks) }} / {{ number_format($totalViews) }}</h3>
            <p class="text-[11px] text-slate-500 font-medium mt-1.5 flex items-center gap-1">
                <x-lucide-eye class="w-3.5 h-3.5 text-slate-400" /> {{ number_format($totalClicks) }} Klik WA • {{ number_format($totalViews) }} Dilihat
            </p>
        </div>
    </div>

    <!-- Management Tables & Activity Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kos Terpopuler / Paling Banyak Dilihat (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-md border border-slate-200/80 p-6 shadow-xs">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-extrabold text-[#20344c] text-base flex items-center gap-2">
                        Properti Kos Paling Banyak Dilihat & Dikliki
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Statistik pencarian dan interaksi user terhadap properti kos.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-[#20344c] font-bold uppercase text-[10px] tracking-wider border-y border-slate-200">
                        <tr>
                            <th class="py-3 px-3">Properti Kos</th>
                            <th class="py-3 px-3">Pemilik Kos</th>
                            <th class="py-3 px-3 text-center">Total Dilihat</th>
                            <th class="py-3 px-3 text-center">Klik WA / Inquiry</th>
                            <th class="py-3 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($popularKoses as $kos)
                            <tr>
                                <td class="py-3.5 px-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-slate-200 overflow-hidden shrink-0">
                                            @if ($kos->thumbnail)
                                                <img src="{{ asset($kos->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $kos->name }}">
                                            @else
                                                <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400">
                                                    <x-lucide-building class="w-5 h-5" />
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-[#20344c]">{{ $kos->name }}</p>
                                            <p class="text-[10px] text-slate-400">
                                                {{ $kos->district ? $kos->district . ', ' : '' }}{{ $kos->city }} • {{ $kos->formatted_price }}/bln
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-3">
                                    <p class="font-bold text-[#20344c]">{{ $kos->owner ? $kos->owner->name : 'N/A' }}</p>
                                    <span class="text-[10px] text-slate-400">{{ $kos->owner ? ($kos->owner->phone ?? '-') : '-' }}</span>
                                </td>
                                <td class="py-3.5 px-3 text-center font-bold text-[#20344c]">
                                    {{ number_format($kos->views_count) }} <span class="text-[10px] font-normal text-slate-400">dilihat</span>
                                </td>
                                <td class="py-3.5 px-3 text-center">
                                    <span class="px-2.5 py-1 rounded-[3px] bg-emerald-100 text-emerald-800 font-extrabold text-[11px]">
                                        {{ number_format($kos->clicks_count) }} Klik
                                    </span>
                                </td>
                                <td class="py-3.5 px-3 text-right">
                                    <a href="{{ route('admin.kos.edit', $kos->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-[#20344c] font-bold rounded-[3px] transition inline-block">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400">
                                    Belum ada data properti kos.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Properti Kos Terbaru (1 col) -->
        <div class="bg-white rounded-md border border-slate-200/80 p-6 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-extrabold text-[#20344c] text-base flex items-center gap-2">
                    Properti Kos Terbaru
                </h3>
                <a href="{{ route('admin.kos.index') }}" class="text-xs text-amber-600 hover:underline font-bold">Lihat Semua</a>
            </div>
            <div class="space-y-3.5 text-xs text-slate-600">
                @forelse ($recentKoses as $kos)
                    <div class="flex items-start gap-3 p-3 rounded-md bg-slate-50 border border-slate-100 hover:bg-slate-100/70 transition">
                        <div class="w-9 h-9 rounded-md bg-slate-200 overflow-hidden shrink-0">
                            @if ($kos->thumbnail)
                                <img src="{{ asset($kos->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $kos->name }}">
                            @else
                                <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400">
                                    <x-lucide-building class="w-4 h-4" />
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-[#20344c] truncate">{{ $kos->name }}</p>
                            <p class="text-[11px] text-slate-500 mt-0.5 truncate">
                                Pemilik: <span class="font-semibold text-slate-700">{{ $kos->owner ? $kos->owner->name : 'N/A' }}</span>
                            </p>
                            <span class="text-[10px] text-slate-400 mt-1 block">
                                {{ $kos->created_at ? $kos->created_at->diffForHumans() : 'Baru saja' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-slate-400 text-xs">
                        Belum ada properti kos terbaru.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

