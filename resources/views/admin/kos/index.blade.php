@extends('layouts.dashboard')

@section('title', 'Manajemen Data Kos')
@section('portal_name', 'Admin Panel')
@section('breadcrumb_current', 'Data Properti Kos')

@section('content')
    <style>
        /* Custom DataTables Tailwind Theme Styling */
        .dt-container {
            font-size: 0.75rem;
            color: #20344c;
        }
        .dt-container .dt-layout-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .dt-container .dt-length select {
            padding: 0.35rem 0.6rem;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            color: #20344c;
            outline: none;
            margin: 0 0.25rem;
            font-weight: 600;
        }
        .dt-container .dt-search {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            color: #20344c;
        }
        .dt-container .dt-search input {
            padding: 0.4rem 0.75rem;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            color: #20344c;
            outline: none;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }
        .dt-container .dt-search input:focus, 
        .dt-container .dt-length select:focus {
            border-color: #f99d18;
            background-color: #ffffff;
            box-shadow: 0 0 0 2px rgba(249, 157, 24, 0.15);
        }
        .dt-container .dt-paging .dt-paging-button {
            padding: 0.3rem 0.65rem !important;
            margin: 0 2px !important;
            border-radius: 0.375rem !important;
            border: 1px solid #e2e8f0 !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            color: #20344c !important;
            background: #ffffff !important;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
        }
        .dt-container .dt-paging .dt-paging-button.current {
            background: #f99d18 !important;
            color: #ffffff !important;
            border-color: #f99d18 !important;
            box-shadow: 0 1px 3px rgba(249, 157, 24, 0.3);
        }
        .dt-container .dt-paging .dt-paging-button:hover:not(.current) {
            background: #f1f5f9 !important;
            color: #20344c !important;
        }
        .dt-container .dt-info {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 600;
            margin-top: 0.5rem;
        }
    </style>

    <!-- Top Action Bar & Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-[#20344c]">Manajemen Data Kos</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola seluruh listing properti kos, ketersediaan kamar, dan status publikasi.</p>
        </div>
        <a href="{{ route('admin.kos.create') }}" class="bg-[#f99d18] hover:bg-[#e08b0f] text-white px-4 py-2.5 rounded-md text-xs font-bold transition shadow-sm flex items-center gap-2">
            <x-lucide-plus-circle class="w-4 h-4" />
            <span>Tambah Kos Baru</span>
        </a>
    </div>

    <!-- Alert Success Notification -->
    @if (session('success'))
        <div class="mb-6 p-4 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-lucide-check-circle-2 class="w-4 h-4 text-emerald-600 shrink-0" />
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 p-1">
                <x-lucide-x class="w-4 h-4" />
            </button>
        </div>
    @endif

    <!-- Single Combined Card (Filter & Table) -->
    <div class="bg-white rounded-md border border-slate-200 shadow-xs p-5">
        <!-- Filter Bar Form -->
        <form action="{{ route('admin.kos.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3 pb-5 mb-5 border-b border-slate-100">
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Tipe Kos</label>
                <select name="type" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                    <option value="">Semua Tipe Kos</option>
                    <option value="putra" {{ request('type') == 'putra' ? 'selected' : '' }}>Khusus Putra</option>
                    <option value="putri" {{ request('type') == 'putri' ? 'selected' : '' }}>Khusus Putri</option>
                    <option value="campur" {{ request('type') == 'campur' ? 'selected' : '' }}>Campur</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Status Publikasi</label>
                <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif (Tayang)</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Verifikasi</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-[#20344c] hover:bg-[#162537] text-white py-2 rounded-md text-xs font-bold transition flex items-center justify-center gap-1.5">
                    <x-lucide-filter class="w-3.5 h-3.5" />
                    <span>Terapkan Filter</span>
                </button>
                @if (request()->hasAny(['type', 'status']))
                    <a href="{{ route('admin.kos.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-md text-xs font-bold transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Kos Listing Data Table -->
        <div class="overflow-x-auto">
            <table id="kosTable" class="w-full text-left text-xs text-slate-600 border-collapse">
                <thead class="bg-slate-50 text-[#20344c] font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-3 text-center w-10">#</th>
                        <th class="py-3.5 px-4">Properti Kos</th>
                        <th class="py-3.5 px-4">Tipe & Lokasi</th>
                        <th class="py-3.5 px-4">Pemilik Kos</th>
                        <th class="py-3.5 px-4">Harga / Bln</th>
                        <th class="py-3.5 px-4 text-center">Ketersediaan Kamar</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($koses as $index => $kos)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-3 text-center font-bold text-slate-400">
                                {{ $loop->iteration }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-md bg-slate-200 overflow-hidden shrink-0 border border-slate-200">
                                        <img src="{{ asset($kos->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $kos->name }}">
                                    </div>
                                    <div>
                                        <p class="font-bold text-[#20344c] text-xs">{{ $kos->name }}</p>
                                        <p class="text-[10px] text-slate-400 mt-0.5 truncate max-w-xs">{{ $kos->address }}</p>
                                        @if($kos->campuses->isNotEmpty())
                                            <div class="flex flex-wrap gap-1 mt-1.5">
                                                @foreach($kos->campuses as $campus)
                                                    <span class="px-1.5 py-0.5 bg-amber-50 border border-amber-200 text-[#f99d18] text-[10px] font-semibold rounded inline-flex items-center gap-1" title="{{ $campus->name }}: {{ $campus->pivot->distance_meters }} meter">
                                                        <span>{{ $campus->abbreviation ?? $campus->name }} ({{ $campus->pivot->distance_meters }}m)</span>
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="py-3.5 px-4">
                                @if ($kos->type === 'putri')
                                    <span class="px-2 py-0.5 rounded-[3px] bg-rose-100 text-rose-700 font-extrabold text-[10px]">Putri</span>
                                @elseif($kos->type === 'putra')
                                    <span class="px-2 py-0.5 rounded-[3px] bg-blue-100 text-blue-700 font-extrabold text-[10px]">Putra</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-[3px] bg-purple-100 text-purple-700 font-extrabold text-[10px]">Campur</span>
                                @endif
                                <span class="block text-[11px] text-slate-500 font-medium mt-1">{{ $kos->district ? $kos->district . ', ' : '' }}{{ $kos->city }}</span>
                            </td>

                            <td class="py-3.5 px-4">
                                <p class="font-bold text-[#20344c] text-xs">{{ $kos->owner->name ?? 'Admin System' }}</p>
                                <span class="text-[10px] text-slate-400">{{ $kos->owner->phone ?? '-' }}</span>
                            </td>

                            <td class="py-3.5 px-4">
                                <p class="font-bold text-[#20344c] text-xs">{{ $kos->formatted_price }} <span class="text-[10px] font-normal text-slate-400">/Bln</span></p>
                                @if($kos->allow_two_people)
                                    <span class="inline-block mt-1 px-1.5 py-0.5 rounded bg-blue-50 text-blue-700 text-[10px] font-bold border border-blue-200">
                                        Bisa 2 Orang {{ $kos->formatted_price_2_persons ? '('.$kos->formatted_price_2_persons.')' : '' }}
                                    </span>
                                @endif
                                @if($kos->price_per_day || $kos->price_per_week)
                                    <div class="text-[10px] text-slate-500 font-medium mt-1">
                                        @if($kos->price_per_day) <span>Harian: {{ $kos->formatted_price_day }}</span> @endif
                                        @if($kos->price_per_week) <span class="ml-1">Mingguan: {{ $kos->formatted_price_week }}</span> @endif
                                    </div>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center justify-center gap-1 bg-slate-50 p-1 rounded-md border border-slate-200">
                                    <button type="button" id="decBtn_{{ $kos->id }}" onclick="adjustRooms({{ $kos->id }}, 'decrement')"
                                            class="w-6 h-6 rounded bg-white hover:bg-slate-200 text-slate-700 font-extrabold flex items-center justify-center transition border border-slate-200 disabled:opacity-30 disabled:cursor-not-allowed shadow-xs"
                                            {{ $kos->available_rooms <= 0 ? 'disabled' : '' }} title="Kurangi 1 Kamar Tersedia">
                                        -
                                    </button>

                                    <div class="px-1.5 text-center leading-tight">
                                        <span class="font-extrabold text-[#20344c] text-xs" id="availCount_{{ $kos->id }}">{{ $kos->available_rooms }}</span>
                                        <span class="text-slate-400 text-[10px] block font-medium">/ {{ $kos->total_rooms }} Kamar</span>
                                    </div>

                                    <button type="button" id="incBtn_{{ $kos->id }}" onclick="adjustRooms({{ $kos->id }}, 'increment')"
                                            class="w-6 h-6 rounded bg-white hover:bg-slate-200 text-slate-700 font-extrabold flex items-center justify-center transition border border-slate-200 disabled:opacity-30 disabled:cursor-not-allowed shadow-xs"
                                            {{ $kos->available_rooms >= $kos->total_rooms ? 'disabled' : '' }} title="Tambah 1 Kamar Tersedia">
                                        +
                                    </button>
                                </div>
                            </td>

                            <td class="py-3.5 px-4 text-center">
                                @if ($kos->status === 'active')
                                    <span class="px-2.5 py-1 rounded-[3px] bg-emerald-100 text-emerald-800 font-extrabold text-[10px]">Aktif</span>
                                @elseif($kos->status === 'pending')
                                    <span class="px-2.5 py-1 rounded-[3px] bg-amber-100 text-amber-800 font-extrabold text-[10px]">Pending</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-[3px] bg-slate-200 text-slate-700 font-extrabold text-[10px]">Non-Aktif</span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.kos.edit', $kos->id) }}" title="Edit Kos" 
                                       class="p-1.5 bg-slate-100 hover:bg-amber-100 hover:text-amber-800 text-slate-600 rounded-[3px] transition">
                                        <x-lucide-edit-3 class="w-4 h-4" />
                                    </a>

                                    <form action="{{ route('admin.kos.destroy', $kos->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kos ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Kos" class="p-1.5 bg-slate-100 hover:bg-red-100 hover:text-red-700 text-slate-600 rounded-[3px] transition">
                                            <x-lucide-trash-2 class="w-4 h-4" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- DataTables Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.jQuery && window.jQuery.fn.dataTable) {
                window.jQuery.fn.dataTable.ext.errMode = 'none';
            }

            if (window.DataTable && document.getElementById('kosTable')) {
                const table = new DataTable('#kosTable', {
                    paging: true,
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                    info: true,
                    searching: true,
                    columnDefs: [
                        { searchable: false, orderable: false, targets: 0 }, // # column
                        { orderable: false, targets: -1 } // Aksi column
                    ],
                    order: [[1, 'asc']],
                    language: {
                        search: "Cari Cepat:",
                        searchPlaceholder: "Nama kos, kota, alamat...",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data kos",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data kos",
                        zeroRecords: "Tidak ada data kos yang sesuai",
                        paginate: {
                            first: "«",
                            previous: "‹",
                            next: "›",
                            last: "»"
                        }
                    }
                });

                table.on('order.dt search.dt page.dt', function () {
                    let i = 1;
                    table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                        this.data(i++);
                    });
                }).draw();
            }
        });

        async function adjustRooms(kosId, action) {
            const decBtn = document.getElementById(`decBtn_${kosId}`);
            const incBtn = document.getElementById(`incBtn_${kosId}`);
            const availCount = document.getElementById(`availCount_${kosId}`);

            if (decBtn) decBtn.disabled = true;
            if (incBtn) incBtn.disabled = true;

            try {
                const res = await fetch(`/admin/kos/${kosId}/quick-update-rooms`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ action: action })
                });

                const data = await res.json();

                if (data.success) {
                    if (availCount) availCount.textContent = data.available_rooms;
                    if (decBtn) decBtn.disabled = (data.available_rooms <= 0);
                    if (incBtn) incBtn.disabled = (data.available_rooms >= data.total_rooms);
                } else {
                    alert(data.message || 'Gagal mengubah ketersediaan kamar');
                    if (decBtn) decBtn.disabled = false;
                    if (incBtn) incBtn.disabled = false;
                }
            } catch (err) {
                console.error('Error updating rooms:', err);
                alert('Terjadi kesalahan saat memperbarui kamar.');
                if (decBtn) decBtn.disabled = false;
                if (incBtn) incBtn.disabled = false;
            }
        }
    </script>
@endsection
