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
                <div class="h-8 w-8 bg-blue-300 text-blue-600 rounded-xs">
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#20344c]">124</h3>
            <p class="text-[11px] text-emerald-600 font-semibold mt-1.5 flex items-center gap-1">
                <x-lucide-trending-up class="w-3.5 h-3.5" /> +12 kos baru bulan ini
            </p>
        </div>

        <div class="p-5 rounded-md bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Pemilik Kos (Owner)</span>
                <div class="h-8 w-8 bg-amber-300 text-[#f99d18] rounded-xs">
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#20344c]">48</h3>
            <p class="text-[11px] text-[#f99d18] font-bold mt-1.5 flex items-center gap-1">
            </p>
        </div>

        <div class="p-5 rounded-md bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Pencari Kos (User)</span>
                <div class="h-8 w-8 bg-purple-300 text-purple-600 rounded-xs">
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#20344c]">1,420</h3>
            <p class="text-[11px] text-emerald-600 font-semibold mt-1.5 flex items-center gap-1">
                <x-lucide-trending-up class="w-3.5 h-3.5" /> +85 user minggu ini
            </p>
        </div>

        <div class="p-5 rounded-md bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Inquiry/Klik</span>
                <div class="h-8 w-8 bg-emerald-300 text-emerald-600 rounded-xs">
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#20344c]">312/764</h3>
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
                    <p class="text-xs text-slate-500 mt-0.5">Statistik pencarian dan interaksi user (anonim & terdaftar) terhadap properti kos.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-[#20344c] font-bold uppercase text-[10px] tracking-wider border-y border-slate-200">
                        <tr>
                            <th class="py-3 px-3">Properti Kos</th>
                            <th class="py-3 px-3">Pemilik Kos</th>
                            <th class="py-3 px-3 text-center">Total Lihat (Anonim / Member)</th>
                            <th class="py-3 px-3 text-center">Klik WA / Inquiry</th>
                            <th class="py-3 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="py-3.5 px-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-slate-200 overflow-hidden shrink-0">
                                        <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover" alt="Kos">
                                    </div>
                                    <div>
                                        <p class="font-bold text-[#20344c]">Kos Griya Executive</p>
                                        <p class="text-[10px] text-slate-400">Tembalang, Semarang • Rp 1.5jt/bln</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-3">
                                <p class="font-bold text-[#20344c]">Ibu Hesty</p>
                                <span class="text-[10px] text-slate-400">089876543210</span>
                            </td>
                            <td class="py-3.5 px-3 text-center font-bold text-[#20344c]">
                                1,420 <span class="text-[10px] font-normal text-slate-400">(890 / 530)</span>
                            </td>
                            <td class="py-3.5 px-3 text-center">
                                <span class="px-2.5 py-1 rounded-[3px] bg-emerald-100 text-emerald-800 font-extrabold text-[11px]">
                                    142 Klik
                                </span>
                            </td>
                            <td class="py-3.5 px-3 text-right">
                                <button class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-[#20344c] font-bold rounded-[3px] transition">Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3.5 px-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-slate-200 overflow-hidden shrink-0">
                                        <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover" alt="Kos">
                                    </div>
                                    <div>
                                        <p class="font-bold text-[#20344c]">Kos Putri Melati</p>
                                        <p class="text-[10px] text-slate-400">Banyumanik, Semarang • Rp 1.2jt/bln</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-3">
                                <p class="font-bold text-[#20344c]">Ibu Hesty</p>
                                <span class="text-[10px] text-slate-400">089876543210</span>
                            </td>
                            <td class="py-3.5 px-3 text-center font-bold text-[#20344c]">
                                980 <span class="text-[10px] font-normal text-slate-400">(610 / 370)</span>
                            </td>
                            <td class="py-3.5 px-3 text-center">
                                <span class="px-2.5 py-1 rounded-[3px] bg-emerald-100 text-emerald-800 font-extrabold text-[11px]">
                                    95 Klik
                                </span>
                            </td>
                            <td class="py-3.5 px-3 text-right">
                                <button class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-[#20344c] font-bold rounded-[3px] transition">Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3.5 px-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-slate-200 overflow-hidden shrink-0">
                                        <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover" alt="Kos">
                                    </div>
                                    <div>
                                        <p class="font-bold text-[#20344c]">Kos Executive Cempaka</p>
                                        <p class="text-[10px] text-slate-400">Pleburan, Semarang • Rp 1.8jt/bln</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-3">
                                <p class="font-bold text-[#20344c]">Pak Ahmad Subagyo</p>
                                <span class="text-[10px] text-slate-400">081122334455</span>
                            </td>
                            <td class="py-3.5 px-3 text-center font-bold text-[#20344c]">
                                754 <span class="text-[10px] font-normal text-slate-400">(480 / 274)</span>
                            </td>
                            <td class="py-3.5 px-3 text-center">
                                <span class="px-2.5 py-1 rounded-[3px] bg-amber-100 text-amber-800 font-extrabold text-[11px]">
                                    75 Klik
                                </span>
                            </td>
                            <td class="py-3.5 px-3 text-right">
                                <button class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-[#20344c] font-bold rounded-[3px] transition">Detail</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Aktivitas Klik Terbaru (1 col) -->
        <div class="bg-white rounded-md border border-slate-200/80 p-6 shadow-xs">
            <h3 class="font-extrabold text-[#20344c] text-base mb-4 flex items-center gap-2">
                Aktivitas Klik Terbaru
            </h3>
            <div class="space-y-3.5 text-xs text-slate-600">
                <div class="flex items-start gap-3 p-3 rounded-md bg-slate-50 border border-slate-100 hover:bg-slate-100/70 transition">
                    <div>
                        <p class="font-bold text-[#20344c]">Kos Griya Executive</p>
                        <p class="text-[11px] text-slate-500 mt-0.5"><span class="font-semibold text-emerald-700">Pengunjung (Anonim)</span> menekan tombol Klik WhatsApp Owner.</p>
                        <span class="text-[10px] text-slate-400 mt-1 block">2 menit yang lalu</span>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-3 rounded-md bg-slate-50 border border-slate-100 hover:bg-slate-100/70 transition">
                    <div>
                        <p class="font-bold text-[#20344c]">Kos Putri Melati</p>
                        <p class="text-[11px] text-slate-500 mt-0.5"><span class="font-semibold text-blue-700">Budi Santoso (Member)</span> membuka halaman detail kos.</p>
                        <span class="text-[10px] text-slate-400 mt-1 block">8 menit yang lalu</span>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-3 rounded-md bg-slate-50 border border-slate-100 hover:bg-slate-100/70 transition">
                    <div>
                        <p class="font-bold text-[#20344c]">Kos Executive Cempaka</p>
                        <p class="text-[11px] text-slate-500 mt-0.5"><span class="font-semibold text-amber-700">Pengunjung (Anonim)</span> membuka halaman detail kos.</p>
                        <span class="text-[10px] text-slate-400 mt-1 block">15 menit yang lalu</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
