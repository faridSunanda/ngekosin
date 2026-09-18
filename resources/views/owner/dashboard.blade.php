@extends('layouts.dashboard')

@section('title', 'Dashboard Pemilik Kos')
@section('portal_name', 'Owner Portal')
@section('breadcrumb_current', 'Dashboard Pemilik Kos')

@section('content')
    <!-- Meta CSRF Token for Quick Updates -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Welcome Banner (Matching Reference Card Layout) -->
    <div class="relative bg-gradient-to-r from-[#20344c] via-[#1a2d42] to-[#142334] text-white p-6 sm:p-8 rounded-lg shadow-xl overflow-hidden mb-8 border border-[#2c4361]">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Halo, {{ strtoupper($user->name) }}!</h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl leading-relaxed">
                    Kelola ketersediaan kamar kos Anda dengan mudah. Anda dapat langsung mengupdate sisa kamar kosong dan mengedit properti Anda langsung di bawah ini.
                </p>
            </div>

            <a href="{{ route('admin.kos.create') }}" class="bg-[#f99d18] hover:bg-[#e08b0f] text-white px-5 py-3 rounded-md text-xs font-extrabold transition shadow-lg flex items-center gap-2 shrink-0">
                <x-lucide-plus-circle class="w-4 h-4" />
                <span>Tambah Properti Kos Baru</span>
            </a>
        </div>
    </div>

    <!-- Stats Overview Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        <div class="p-5 rounded-md bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Properti Kos</span>
                <div class="h-8 w-8 bg-blue-100 text-blue-600 rounded-md flex items-center justify-center">
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#20344c]">{{ $totalKos }} Kos</h3>
            <p class="text-[11px] text-emerald-600 font-semibold mt-1.5 flex items-center gap-1">
                <x-lucide-check-circle-2 class="w-3.5 h-3.5" /> Properti terdaftar di Ngekosin
            </p>
        </div>

        <div class="p-5 rounded-md bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Kamar Terisi & Okupansi</span>
                <div class="h-8 w-8 bg-emerald-100 text-emerald-600 rounded-md flex items-center justify-center">
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#20344c]">{{ $occupiedRooms }} / {{ $totalRooms }}</h3>
            <p class="text-[11px] text-emerald-600 font-semibold mt-1.5">
                Tingkat Okupansi {{ $occupancyRate }}%
            </p>
        </div>

        <div class="p-5 rounded-md bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Inquiry & Views</span>
                <div class="h-8 w-8 bg-amber-100 text-[#f99d18] rounded-md flex items-center justify-center">
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-[#20344c]">{{ number_format($totalClicks) }} Klik WA</h3>
            <p class="text-[11px] text-slate-500 font-medium mt-1.5">
                {{ number_format($totalViews) }} kali dilihat pengunjung
            </p>
        </div>
    </div>

    <!-- Main Section: Quick Management of Kos Properties -->
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-5 rounded-lg border border-slate-200/80 shadow-xs">
            <div>
                <h2 class="text-lg font-extrabold text-[#20344c] flex items-center gap-2">
                    <span>Daftar Properti Kos Saya</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-bold border border-slate-200">
                        {{ $totalKos }} Properti
                    </span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Kelola ketersediaan kamar kosong dan perbarui informasi kos Anda dengan 1-klik sederhana.</p>
            </div>
            
            <a href="{{ route('admin.kos.create') }}" class="px-4 py-2.5 bg-[#20344c] hover:bg-[#182739] text-white text-xs font-bold rounded-md transition flex items-center gap-2 shrink-0">
                <x-lucide-plus class="w-4 h-4" />
                <span>Tambah Properti Baru</span>
            </a>
        </div>

        <!-- Kos List Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse ($ownerKoses as $kos)
                <div class="bg-white rounded-lg border border-slate-200/80 shadow-xs hover:shadow-md transition overflow-hidden flex flex-col justify-between">
                    <div>
                        <!-- Header & Thumbnail -->
                        <div class="relative h-44 bg-slate-200">
                            @if ($kos->thumbnail)
                                <img src="{{ asset($kos->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $kos->name }}">
                            @else
                                <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400">
                                    <x-lucide-building class="w-8 h-8" />
                                </div>
                            @endif

                            <div class="absolute top-3 left-3 flex items-center gap-2">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wider text-white shadow-md {{ $kos->type === 'putra' ? 'bg-blue-600' : ($kos->type === 'putri' ? 'bg-pink-600' : 'bg-purple-600') }}">
                                    Kos {{ ucfirst($kos->type) }}
                                </span>
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wider bg-emerald-500 text-white shadow-md">
                                    {{ ucfirst($kos->status) }}
                                </span>
                            </div>

                            <div class="absolute bottom-3 right-3 bg-slate-900/80 backdrop-blur-xs text-white px-3 py-1 rounded-md text-xs font-bold">
                                {{ $kos->formatted_price }} <span class="text-[10px] font-normal text-slate-300">/bln</span>
                            </div>
                        </div>

                        <!-- Info Content -->
                        <div class="p-5 space-y-4">
                            <div>
                                <h3 class="font-extrabold text-[#20344c] text-base truncate">{{ $kos->name }}</h3>
                                <p class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                                    <x-lucide-map-pin class="w-3.5 h-3.5 text-slate-400 shrink-0" />
                                    <span class="truncate">{{ $kos->address }}{{ $kos->district ? ', Kec. ' . $kos->district : '' }}, {{ $kos->city }}</span>
                                </p>
                            </div>

                            <!-- Quick Room Availability Control -->
                            <div class="p-3.5 rounded-lg bg-slate-50 border border-slate-200/80 flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Status Kamar Kosong</p>
                                    <p class="text-sm font-extrabold text-[#20344c] mt-0.5">
                                        <span id="available-count-{{ $kos->id }}" class="text-emerald-600 font-black text-base">{{ $kos->available_rooms }}</span>
                                        <span class="text-slate-500 font-medium text-xs"> dari {{ $kos->total_rooms }} Kamar Sisa</span>
                                    </p>
                                </div>

                                <div class="flex items-center gap-1 bg-white p-1 rounded-md border border-slate-200">
                                    <button onclick="updateRooms({{ $kos->id }}, 'decrement')" 
                                            class="w-7 h-7 rounded bg-slate-100 hover:bg-rose-100 hover:text-rose-600 text-slate-600 flex items-center justify-center font-extrabold transition"
                                            title="Kurangi sisa kamar (-1)">
                                        -
                                    </button>
                                    <span class="px-2 text-xs font-bold text-slate-700">Set</span>
                                    <button onclick="updateRooms({{ $kos->id }}, 'increment')" 
                                            class="w-7 h-7 rounded bg-slate-100 hover:bg-emerald-100 hover:text-emerald-600 text-slate-600 flex items-center justify-center font-extrabold transition"
                                            title="Tambah sisa kamar (+1)">
                                        +
                                    </button>
                                </div>
                            </div>

                            <!-- Interaksi Stats -->
                            <div class="grid grid-cols-2 gap-3 text-center text-xs">
                                <div class="p-2.5 rounded-md bg-slate-50 border border-slate-100">
                                    <p class="text-[10px] text-slate-400 font-bold uppercase">Dilihat</p>
                                    <p class="font-extrabold text-[#20344c] mt-0.5">{{ number_format($kos->views_count) }}x</p>
                                </div>
                                <div class="p-2.5 rounded-md bg-emerald-50/60 border border-emerald-100">
                                    <p class="text-[10px] text-emerald-600 font-bold uppercase">Klik WhatsApp</p>
                                    <p class="font-extrabold text-emerald-800 mt-0.5">{{ number_format($kos->clicks_count) }} Klik</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action Buttons -->
                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-3">
                        <a href="{{ url('/#kos-' . $kos->id) }}" target="_blank" class="text-xs font-bold text-slate-500 hover:text-[#20344c] flex items-center gap-1">
                            <x-lucide-external-link class="w-3.5 h-3.5" />
                            <span>Lihat di Web</span>
                        </a>

                        <a href="{{ route('admin.kos.edit', $kos->id) }}" class="px-4 py-2 bg-[#f99d18] hover:bg-[#e08b0f] text-white font-extrabold text-xs rounded-md transition shadow-xs flex items-center gap-1.5">
                            <x-lucide-edit-3 class="w-3.5 h-3.5" />
                            <span>Edit Detail Kos</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-lg border-2 border-dashed border-slate-200 p-8 text-center space-y-4">
                    <div class="w-16 h-16 bg-amber-50 text-[#f99d18] rounded-full flex items-center justify-center mx-auto">
                        <x-lucide-building-2 class="w-8 h-8" />
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-[#20344c]">Belum Ada Properti Kos Terdaftar</h3>
                        <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                            Anda belum mendaftarkan properti kos Anda. Mulai daftarkan kos pertama Anda sekarang untuk menjangkau calon penyewa di Ngekosin!
                        </p>
                    </div>
                    <a href="{{ route('admin.kos.create') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-[#f99d18] hover:bg-[#e08b0f] text-white font-extrabold text-xs rounded-md transition shadow-md">
                        <x-lucide-plus-circle class="w-4 h-4" />
                        <span>Daftarkan Kos Pertama Anda</span>
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Quick AJAX Script for Updating Available Rooms -->
    <script>
        async function updateRooms(kosId, action) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            try {
                const response = await fetch(`/admin/kos/${kosId}/quick-update-rooms`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ action: action })
                });

                const data = await response.json();
                if (data.success) {
                    const countElem = document.getElementById(`available-count-${kosId}`);
                    if (countElem) {
                        countElem.textContent = data.available_rooms;
                    }
                } else {
                    alert('Gagal mengupdate jumlah kamar.');
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan koneksi.');
            }
        }
    </script>
@endsection

