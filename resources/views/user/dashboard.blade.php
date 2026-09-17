@extends('layouts.dashboard')

@section('title', 'Dashboard Saya')
@section('portal_name', 'User Portal')
@section('breadcrumb_current', 'Dashboard Pencari Kos')



@section('content')
    <!-- Welcome Banner (Matching Reference Card Layout) -->
    <div class="relative bg-gradient-to-r from-[#20344c] via-[#1a2d42] to-[#142334] text-white p-6 sm:p-8 rounded-3xl shadow-xl overflow-hidden mb-8 border border-[#2c4361]">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-[#f99d18]/20 text-[#f99d18] border border-[#f99d18]/30 mb-3">
                    <x-lucide-user-check class="w-3.5 h-3.5" /> Pencari Kos Portal
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Halo, {{ strtoupper($user->name) }}!</h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl leading-relaxed">
                    Selamat datang di Ngekosin! Pantau status sewa kos kamu, lihat riwayat pembayaran, dan temukan rekomendasi kos terbaik di sekitar kampus/kantor.
                </p>
            </div>

            <a href="{{ route('home') }}" class="bg-[#f99d18] hover:bg-[#e08b0f] text-white px-5 py-3 rounded-2xl text-xs font-extrabold transition shadow-lg flex items-center gap-2 shrink-0">
                <x-lucide-search class="w-4 h-4" />
                <span>Cari Kos Sekarang</span>
            </a>
        </div>
    </div>

    <!-- Active Rent Card (Kos Saya Yang Sedang Disewa) -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 mb-8 shadow-xs">
        <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-4">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                <h3 class="font-extrabold text-[#20344c] text-base">Kos Saya yang Sedang Disewa</h3>
            </div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 font-extrabold text-xs">Status: Aktif</span>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 items-start">
            <div class="w-full lg:w-48 h-36 rounded-2xl bg-slate-200 overflow-hidden shrink-0">
                <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=500&q=80" class="w-full h-full object-cover" alt="Kos Aktif">
            </div>

            <div class="flex-1 space-y-3">
                <div>
                    <span class="text-xs font-bold text-[#f99d18]">Kamar 104 • Lantai 1</span>
                    <h4 class="text-xl font-extrabold text-[#20344c]">Kos Griya Executive Tembalang</h4>
                    <p class="text-xs text-slate-500 flex items-center gap-1 mt-0.5">
                        <x-lucide-map-pin class="w-3.5 h-3.5 text-slate-400" />
                        Jl. Professor Soedarto No. 12, Tembalang, Semarang
                    </p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-2">
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[10px] text-slate-400 font-bold block uppercase">Batas Waktu Sewa</span>
                        <p class="text-xs font-bold text-[#20344c]">15 Oktober 2026</p>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[10px] text-slate-400 font-bold block uppercase">Harga Bulanan</span>
                        <p class="text-xs font-bold text-[#20344c]">Rp 1.500.000 / bln</p>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[10px] text-slate-400 font-bold block uppercase">Pemilik Kos</span>
                        <p class="text-xs font-bold text-[#20344c]">Ibu Hesty</p>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-auto flex flex-col gap-2 shrink-0">
                <button class="w-full bg-[#20344c] hover:bg-[#162537] text-white px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2">
                    <x-lucide-message-circle class="w-4 h-4 text-[#f99d18]" />
                    Hubungi Pemilik Kos
                </button>
                <button class="w-full bg-slate-100 hover:bg-slate-200 text-[#20344c] px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2">
                    <x-lucide-receipt class="w-4 h-4" />
                    Cetak Bukti Sewa
                </button>
            </div>
        </div>
    </div>

    <!-- Recommendations Grid -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-extrabold text-[#20344c] text-base flex items-center gap-2">
                <x-lucide-sparkles class="w-5 h-5 text-[#f99d18]" />
                Rekomendasi Kos Sekitar Tembalang
            </h3>
            <a href="{{ route('home') }}" class="text-xs font-bold text-[#f99d18] hover:underline">Lihat Semua</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-xs hover:shadow-md transition">
                <div class="h-40 bg-slate-200 relative">
                    <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover" alt="Kos">
                    <span class="absolute top-3 right-3 px-2.5 py-1 bg-[#20344c]/90 backdrop-blur-md text-white font-bold text-[10px] rounded-lg">Putri</span>
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-[#20344c] text-sm">Kos Putri Melati</h4>
                    <p class="text-xs text-slate-500 mt-1">Banyumanik, Semarang</p>
                    <div class="mt-3 flex items-center justify-between">
                        <span class="font-extrabold text-[#f99d18] text-sm">Rp 1.200.000 <span class="text-[10px] text-slate-400 font-normal">/ bln</span></span>
                        <a href="{{ route('home') }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-[#20344c] text-xs font-bold rounded-lg transition">Detail</a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-xs hover:shadow-md transition">
                <div class="h-40 bg-slate-200 relative">
                    <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover" alt="Kos">
                    <span class="absolute top-3 right-3 px-2.5 py-1 bg-[#f99d18] text-white font-bold text-[10px] rounded-lg">Campur</span>
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-[#20344c] text-sm">Kos Executive Cempaka</h4>
                    <p class="text-xs text-slate-500 mt-1">Pleburan, Semarang</p>
                    <div class="mt-3 flex items-center justify-between">
                        <span class="font-extrabold text-[#f99d18] text-sm">Rp 1.800.000 <span class="text-[10px] text-slate-400 font-normal">/ bln</span></span>
                        <a href="{{ route('home') }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-[#20344c] text-xs font-bold rounded-lg transition">Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
