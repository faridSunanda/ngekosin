@extends('layouts.dashboard')

@section('title', 'Dashboard Saya')
@section('portal_name', 'User Portal')
@section('breadcrumb_current', 'Dashboard Pencari Kos')

@section('content')
    <!-- Welcome Banner (Matching Reference Card Layout) -->
    <div class="relative bg-gradient-to-r from-[#20344c] via-[#1a2d42] to-[#142334] text-white p-6 sm:p-8 rounded-lg shadow-xl overflow-hidden mb-8 border border-[#2c4361]">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Halo, {{ strtoupper($user->name) }}!</h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl leading-relaxed">
                    Selamat datang di Ngekosin! Jelajahi kos terfavorit paling banyak diminati pencari kos lain dan temukan hunian terbaikmu.
                </p>
            </div>

            <a href="{{ route('home') }}" class="bg-[#f99d18] hover:bg-[#e08b0f] text-white px-5 py-3 rounded-md text-xs font-extrabold transition shadow-lg flex items-center gap-2 shrink-0">
                <x-lucide-search class="w-4 h-4" />
                <span>Cari Kos Sekarang</span>
            </a>
        </div>
    </div>

    <!-- Recommendations Grid (Top 6 Most Inquired Koses) -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-extrabold text-[#20344c] text-base flex items-center gap-2">
                    <span>Rekomendasi Kos Terfavorit & Paling Banyak Diminati</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Top 6 kos dengan statistik pencarian dan interaksi WhatsApp tertinggi.</p>
            </div>
            <a href="{{ route('home') }}" class="text-xs font-bold text-[#f99d18] hover:underline flex items-center gap-1 shrink-0">
                <span>Lihat Semua</span>
                <x-lucide-arrow-right class="w-3.5 h-3.5" />
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($recommendedKoses as $kos)
                <div class="bg-white rounded-md border border-slate-200/80 overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="h-44 bg-slate-200 relative">
                            @if ($kos->thumbnail)
                                <img src="{{ asset($kos->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $kos->name }}">
                            @else
                                <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400">
                                    <x-lucide-building class="w-8 h-8" />
                                </div>
                            @endif

                            <span class="absolute top-3 right-3 px-2.5 py-1 text-white font-bold text-[10px] rounded-[4px] uppercase tracking-wider shadow-md {{ $kos->type === 'putra' ? 'bg-blue-600' : ($kos->type === 'putri' ? 'bg-pink-600' : 'bg-purple-600') }}">
                                {{ ucfirst($kos->type) }}
                            </span>

                            <div class="absolute bottom-3 left-3 bg-slate-900/80 backdrop-blur-xs text-white px-2.5 py-1 rounded text-[10px] font-bold flex items-center gap-1">
                                <x-lucide-phone-call class="w-3 h-3 text-emerald-400" />
                                <span>{{ number_format($kos->clicks_count) }} Inquiry</span>
                            </div>
                        </div>

                        <div class="p-4 space-y-2">
                            <h4 class="font-bold text-[#20344c] text-sm truncate" title="{{ $kos->name }}">{{ $kos->name }}</h4>
                            <p class="text-xs text-slate-500 flex items-center gap-1">
                                <x-lucide-map-pin class="w-3.5 h-3.5 text-slate-400 shrink-0" />
                                <span class="truncate">{{ $kos->district ? $kos->district . ', ' : '' }}{{ $kos->city }}</span>
                            </p>
                            <p class="text-[11px] text-slate-400">
                                Sisa <span class="font-bold text-emerald-600">{{ $kos->available_rooms }} Kamar</span> dari {{ $kos->total_rooms }}
                            </p>
                        </div>
                    </div>

                    <div class="p-4 flex items-center justify-between border-t border-slate-100 mt-2">
                        <span class="font-extrabold text-[#f99d18] text-sm">
                            {{ $kos->formatted_price }} <span class="text-[10px] text-slate-400 font-normal">/ bln</span>
                        </span>
                        <a href="{{ url('/#kos-' . $kos->id) }}" class="px-3 py-1.5 bg-[#20344c] hover:bg-[#182739] text-white text-xs font-bold rounded-[4px] transition flex items-center gap-1">
                            <span>Detail</span>
                            <x-lucide-chevron-right class="w-3.5 h-3.5" />
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-md border border-slate-200 p-8 text-center text-slate-400 text-xs">
                    Belum ada rekomendasi kos saat ini.
                </div>
            @endforelse
        </div>
    </div>
@endsection
