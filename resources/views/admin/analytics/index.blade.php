@extends('layouts.dashboard')

@section('title', 'Analitik & Laporan Performa')
@section('portal_name', 'Admin Panel')
@section('breadcrumb_current', 'Analitik & Laporan')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-[#20344c]">Analitik & Performa Platform</h1>
                <p class="text-xs text-slate-500 mt-1">Laporan statistik lalu lintas pencarian, tren inquiry/klik WA, ketersediaan kamar, dan statistik kos.</p>
            </div>  
        </div>

        <!-- 4 Top KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card 1: Total Views -->
            <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Total Views / Dilihat</p>
                    <h3 class="text-2xl font-extrabold text-[#20344c] mt-1">{{ number_format($totalViews, 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-emerald-600 font-bold flex items-center gap-1 mt-1">
                        <x-lucide-trending-up class="w-3 h-3" />
                        <span>Akumulasi pencarian</span>
                    </p>
                </div>
            </div>

            <!-- Card 2: Total Inquiry / Clicks -->
            <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Total Clicks / Inquiry</p>
                    <h3 class="text-2xl font-extrabold text-[#20344c] mt-1">{{ number_format($totalClicks, 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-emerald-600 font-bold flex items-center gap-1 mt-1">
                        <x-lucide-phone-call class="w-3 h-3" />
                        <span>Klik WhatsApp / Kontak</span>
                    </p>
                </div>
            </div>

            <!-- Card 3: Conversion Rate -->
            <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Rasio Konversi (Inquiry)</p>
                    <h3 class="text-2xl font-extrabold text-[#20344c] mt-1">{{ $conversionRate }}%</h3>
                    <p class="text-[11px] text-amber-600 font-bold flex items-center gap-1 mt-1">
                        <x-lucide-zap class="w-3 h-3 text-[#f99d18]" />
                        <span>(Klik ÷ Views) × 100</span>
                    </p>
                </div>
            </div>

            <!-- Card 4: Occupancy Rate -->
            <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Tingkat Keterisian Kamar</p>
                    <h3 class="text-2xl font-extrabold text-[#20344c] mt-1">{{ $occupancyRate }}%</h3>
                    <p class="text-[11px] text-purple-600 font-bold flex items-center gap-1 mt-1">
                        <x-lucide-bed-double class="w-3 h-3" />
                        <span>{{ $occupiedRooms }} terisi dari {{ $totalRooms }} kamar</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Charts Section: Line Chart & Doughnut Chart -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Line Chart: Trend Views vs Clicks (2 columns wide) -->
            <div class="lg:col-span-2 bg-white p-5 rounded-lg border border-slate-200 shadow-xs">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                    <div>
                        <h3 class="font-extrabold text-[#20344c] text-sm">Tren Kunjungan & Inquiry (Bulanan)</h3>
                        <p class="text-xs text-slate-400">Grafik perbandingan pencarian vs respon calon penyewa kos.</p>
                    </div>
                </div>
                <div class="h-64 relative">
                    <canvas id="trafficTrendChart"></canvas>
                </div>
            </div>

            <!-- Doughnut Chart: Komposisi Tipe Kos (1 column wide) -->
            <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                        <div>
                            <h3 class="font-extrabold text-[#20344c] text-sm">Kategori Tipe Kos</h3>
                            <p class="text-xs text-slate-400">Distribusi tipe kos terdaftar.</p>
                        </div>
                    </div>
                    <div class="h-52 relative flex items-center justify-center">
                        <canvas id="typeChart"></canvas>
                    </div>
                </div>

                <!-- Legend Summary Footer -->
                <div class="grid grid-cols-3 gap-2 pt-4 border-t border-slate-100 text-center mt-2">
                    <div class="p-2 bg-blue-50/60 rounded border border-blue-100">
                        <p class="text-[10px] text-blue-600 font-extrabold">PUTRA</p>
                        <p class="text-sm font-black text-blue-900 mt-0.5">{{ $typeData['putra'] }}</p>
                    </div>
                    <div class="p-2 bg-pink-50/60 rounded border border-pink-100">
                        <p class="text-[10px] text-pink-600 font-extrabold">PUTRI</p>
                        <p class="text-sm font-black text-pink-900 mt-0.5">{{ $typeData['putri'] }}</p>
                    </div>
                    <div class="p-2 bg-purple-50/60 rounded border border-purple-100">
                        <p class="text-[10px] text-purple-600 font-extrabold">CAMPUR</p>
                        <p class="text-sm font-black text-purple-900 mt-0.5">{{ $typeData['campur'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Chart & City Breakdown Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Bar Chart: Top 5 Inquired Kos -->
            <div class="lg:col-span-2 bg-white p-5 rounded-lg border border-slate-200 shadow-xs">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                    <div>
                        <h3 class="font-extrabold text-[#20344c] text-sm">Top 5 Kos Paling Banyak Di-Inquiry (Klik WA)</h3>
                        <p class="text-xs text-slate-400">Properti kos dengan respon minat penyewa tertinggi.</p>
                    </div>
                </div>
                <div class="h-64 relative">
                    <canvas id="topInquiredChart"></canvas>
                </div>
            </div>

            <!-- Distribution by City -->
            <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-xs space-y-4">
                <div class="pb-3 border-b border-slate-100">
                    <h3 class="font-extrabold text-[#20344c] text-sm">Distribusi Kos per Kota</h3>
                    <p class="text-xs text-slate-400">Sebaran lokasi properti kos terdaftar.</p>
                </div>

                <div class="space-y-3.5">
                    @forelse ($cityBreakdown as $c)
                        @php
                            $percentage = $totalKos > 0 ? round(($c->count / $totalKos) * 100) : 0;
                        @endphp
                        <div class="space-y-1">
                            <div class="flex justify-between text-xs font-bold text-[#20344c]">
                                <span>{{ $c->city }}</span>
                                <span class="text-slate-500 font-semibold">{{ $c->count }} Kos ({{ $percentage }}%)</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-[#f99d18] h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic">Belum ada data lokasi kos.</p>
                    @endforelse
                </div>

                <!-- Master Stats List -->
                <div class="pt-4 border-t border-slate-100 space-y-2">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 font-semibold">Total Owner Terdaftar</span>
                        <span class="font-extrabold text-[#20344c]">{{ $totalOwners }} Owner</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 font-semibold">Total Pencari Kos</span>
                        <span class="font-extrabold text-[#20344c]">{{ $totalUsers }} User</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 font-semibold">Master Kampus</span>
                        <span class="font-extrabold text-[#20344c]">{{ $totalCampuses }} Kampus</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500 font-semibold">Master Fasilitas</span>
                        <span class="font-extrabold text-[#20344c]">{{ $totalFacilities }} Fasilitas</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table: Detailed Top 5 Popular Kos -->
        <div class="bg-white rounded-lg border border-slate-200 shadow-xs p-5">
            <div class="pb-3 border-b border-slate-100 mb-4 flex items-center justify-between">
                <div>
                    <h3 class="font-extrabold text-[#20344c] text-sm">Rincian Detail Properti Kos Terpopuler</h3>
                    <p class="text-xs text-slate-400">Statistik lengkap views, clicks, dan rasio minat calon penyewa.</p>
                </div>
                <a href="{{ route('admin.kos.index') }}" class="text-xs font-bold text-[#f99d18] hover:underline flex items-center gap-1">
                    <span>Lihat Semua Kos</span>
                    <x-lucide-arrow-right class="w-3.5 h-3.5" />
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3 px-3 w-10 text-center">#</th>
                            <th class="py-3 px-4">Nama Properti Kos</th>
                            <th class="py-3 px-4">Pemilik (Owner)</th>
                            <th class="py-3 px-4">Kota</th>
                            <th class="py-3 px-4 text-center">Ketersediaan Kamar</th>
                            <th class="py-3 px-4 text-center">Total Views</th>
                            <th class="py-3 px-4 text-center">Inquiry (Klik WA)</th>
                            <th class="py-3 px-4 text-center">Konversi %</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                        @forelse ($topKosByClicks as $index => $k)
                            @php
                                $kConv = $k->views_count > 0 ? round(($k->clicks_count / $k->views_count) * 100, 1) : 0;
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-3 text-center text-slate-400 font-bold">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-3 px-4 font-bold text-[#20344c]">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full {{ $k->type === 'putra' ? 'bg-blue-500' : ($k->type === 'putri' ? 'bg-pink-500' : 'bg-purple-500') }}"></span>
                                        <span>{{ $k->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 font-medium text-slate-600">
                                    {{ $k->owner->name ?? '-' }}
                                </td>
                                <td class="py-3 px-4 font-medium text-slate-600">
                                    {{ $k->city }}
                                </td>
                                <td class="py-3 px-4 text-center font-bold">
                                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200 text-[11px]">
                                        {{ $k->available_rooms }} / {{ $k->total_rooms }} Sisa
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center font-bold text-sky-700">
                                    {{ number_format($k->views_count, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center font-bold text-emerald-700">
                                    {{ number_format($k->clicks_count, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center font-bold text-[#f99d18]">
                                    {{ $kConv }}%
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-4 text-center text-slate-400 italic">Belum ada data statistik kos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Line Chart: Views vs Inquiry Trend
            const ctxTrend = document.getElementById('trafficTrendChart').getContext('2d');
            new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: {!! json_encode($monthlyLabels) !!},
                    datasets: [
                        {
                            label: 'Views (Pencarian)',
                            data: {!! json_encode($monthlyViewsData) !!},
                            borderColor: '#38bdf8',
                            backgroundColor: 'rgba(56, 189, 248, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Inquiry / Klik WA',
                            data: {!! json_encode($monthlyClicksData) !!},
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: { size: 11, weight: 'bold' },
                                usePointStyle: true,
                                padding: 15
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        },
                        y: {
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });

            // 2. Doughnut Chart: Kos Type Breakdown
            const ctxType = document.getElementById('typeChart').getContext('2d');
            new Chart(ctxType, {
                type: 'doughnut',
                data: {
                    labels: ['Putra', 'Putri', 'Campur'],
                    datasets: [{
                        data: [{{ $typeData['putra'] }}, {{ $typeData['putri'] }}, {{ $typeData['campur'] }}],
                        backgroundColor: ['#3b82f6', '#ec4899', '#a855f7'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    cutout: '68%'
                }
            });

            // 3. Bar Chart: Top 5 Inquired Kos
            const topKosNames = [
                @foreach($topKosByClicks as $k)
                    "{{ Str::limit($k->name, 18) }}",
                @endforeach
            ];
            const topKosClicks = [
                @foreach($topKosByClicks as $k)
                    {{ $k->clicks_count }},
                @endforeach
            ];

            const ctxTop = document.getElementById('topInquiredChart').getContext('2d');
            new Chart(ctxTop, {
                type: 'bar',
                data: {
                    labels: topKosNames,
                    datasets: [{
                        label: 'Jumlah Klik WA / Inquiry',
                        data: topKosClicks,
                        backgroundColor: '#f99d18',
                        borderRadius: 6,
                        barThickness: 24
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11, weight: '600' } }
                        },
                        y: {
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });
        });
    </script>
@endsection
