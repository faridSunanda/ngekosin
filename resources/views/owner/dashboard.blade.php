@extends('layouts.dashboard')

@section('title', 'Dashboard Pemilik Kos')
@section('portal_name', 'Owner Portal')
@section('breadcrumb_current', 'Dashboard Pemilik Kos')



@section('content')
    <!-- Welcome Banner (Matching Reference Card Layout) -->
    <div class="relative bg-gradient-to-r from-[#20344c] via-[#1a2d42] to-[#142334] text-white p-6 sm:p-8 rounded-lg shadow-xl overflow-hidden mb-8 border border-[#2c4361]">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Halo, {{ strtoupper($user->name) }}!</h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl leading-relaxed">
                    Kelola ketersediaan kamar kos Anda, setujui pengajuan sewa dari calon penyewa, dan pantau pemasukan bulanan secara real-time.
                </p>
            </div>

            <button class="bg-[#f99d18] hover:bg-[#e08b0f] text-white px-5 py-3 rounded-md text-xs font-extrabold transition shadow-lg flex items-center gap-2 shrink-0">
                <x-lucide-plus-circle class="w-4 h-4" />
                <span>Daftarkan Kos Baru</span>
            </button>
        </div>
    </div>

    <!-- Stats Overview Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        <div class="p-5 rounded-md bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Properti Kos</span>
                <div class="h-8 w-8 bg-blue-300 rounded-md">
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#20344c]">3 Kos</h3>
            <p class="text-[11px] text-emerald-600 font-semibold mt-1.5 flex items-center gap-1">
                <x-lucide-check-circle-2 class="w-3.5 h-3.5" /> Semua aktif tayang
            </p>
        </div>

        <div class="p-5 rounded-md bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Kamar Terisi</span>
                <div class="h-8 w-8 bg-emerald-300 rounded-md">
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#20344c]">18 / 20</h3>
            <p class="text-[11px] text-emerald-600 font-semibold mt-1.5">Okupansi 90%</p>
        </div>

        <div class="p-5 rounded-md bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Inquiry/klik</span>
                <div class="h-8 w-8 bg-amber-300 rounded-md">
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#20344c]">21/32</h3>
            <p class="text-[11px] text-[#f99d18] font-bold mt-1.5">Rata-rata minggu ini</p>
        </div>
    </div>

    <!-- Management Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Pengajuan Sewa Pending Table (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200/80 p-6 shadow-xs">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-extrabold text-[#20344c] text-base flex items-center gap-2">
                        Permintaan Sewa Menunggu Konfirmasi
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Calon penyewa yang ingin menyewa kos Anda.</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#20344c] text-white flex items-center justify-center font-bold text-sm">
                            BS
                        </div>
                        <div>
                            <p class="font-bold text-[#20344c] text-sm">Budi Santoso</p>
                            <p class="text-xs text-slate-500">Mulai Sewa: <span class="font-medium text-slate-700">1 Oktober 2026 (6 Bulan)</span></p>
                            <span class="inline-block px-2 py-0.5 mt-1 rounded-md bg-blue-100 text-blue-800 text-[10px] font-bold">Kos Griya Executive • Kamar 104</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button class="flex-1 sm:flex-none px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition">Setujui</button>
                        <button class="flex-1 sm:flex-none px-3.5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs rounded-xl transition">Tolak</button>
                    </div>
                </div>

                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-600 text-white flex items-center justify-center font-bold text-sm">
                            AP
                        </div>
                        <div>
                            <p class="font-bold text-[#20344c] text-sm">Anisa Putri</p>
                            <p class="text-xs text-slate-500">Mulai Sewa: <span class="font-medium text-slate-700">25 September 2026 (1 Tahun)</span></p>
                            <span class="inline-block px-2 py-0.5 mt-1 rounded-md bg-purple-100 text-purple-800 text-[10px] font-bold">Kos Putri Melati • Kamar 02</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button class="flex-1 sm:flex-none px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition">Setujui</button>
                        <button class="flex-1 sm:flex-none px-3.5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs rounded-xl transition">Tolak</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Properti Kos List (1 col) -->
        <div class="bg-white rounded-lg border border-slate-200/80 p-6 shadow-xs">
            <h3 class="font-extrabold text-[#20344c] text-base mb-4 flex items-center gap-2">
                Kos Saya
            </h3>
            <div class="space-y-3">
                <div class="p-3 rounded-xl border border-slate-200 hover:border-[#f99d18] transition flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg bg-slate-200 overflow-hidden shrink-0">
                        <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=150&q=80" class="w-full h-full object-cover" alt="Kos">
                    </div>
                    <div class="truncate">
                        <p class="font-bold text-[#20344c] text-xs truncate">Kos Griya Executive</p>
                        <p class="text-[11px] text-slate-500">Tembalang, Semarang</p>
                        <span class="text-[10px] font-bold text-emerald-600">Terisi 10/10 Kamar</span>
                    </div>
                </div>

                <div class="p-3 rounded-xl border border-slate-200 hover:border-[#f99d18] transition flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg bg-slate-200 overflow-hidden shrink-0">
                        <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=150&q=80" class="w-full h-full object-cover" alt="Kos">
                    </div>
                    <div class="truncate">
                        <p class="font-bold text-[#20344c] text-xs truncate">Kos Putri Melati</p>
                        <p class="text-[11px] text-slate-500">Banyumanik, Semarang</p>
                        <span class="text-[10px] font-bold text-amber-600">Sisa 2 Kamar Kosong</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
