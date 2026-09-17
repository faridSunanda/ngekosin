@extends('layouts.dashboard')

@section('title', 'Master Data Kampus')
@section('portal_name', 'Admin Panel')
@section('breadcrumb_current', 'Master Kampus')

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

    <div class="space-y-6">
        <!-- Header & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-[#20344c]">Master Data Kampus</h1>
                <p class="text-xs text-slate-500 mt-1">Kelola daftar kampus terdekat untuk acuan klaim lokasi & jarak properti kos.</p>
            </div>
            <button onclick="openCreateModal()" class="px-4 py-2.5 bg-[#f99d18] hover:bg-[#e08b0f] text-white font-bold text-xs rounded-md transition shadow-md flex items-center justify-center gap-2">
                <x-lucide-plus-circle class="w-4 h-4" />
                <span>Tambah Kampus Baru</span>
            </button>
        </div>

        <!-- Alert Success Message -->
        @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold rounded-md flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <x-lucide-check-circle-2 class="w-4 h-4 text-emerald-600" />
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <x-lucide-x class="w-4 h-4" />
                </button>
            </div>
        @endif

        <!-- Table Card -->
        <div class="bg-white rounded-md border border-slate-200 shadow-xs overflow-hidden p-5">
            <div class="overflow-x-auto">
                <table id="campusTable" class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-3 w-10 text-center">#</th>
                            <th class="py-3.5 px-4">Nama Kampus</th>
                            <th class="py-3.5 px-4">Singkatan / Kode</th>
                            <th class="py-3.5 px-4">Kota / Lokasi</th>
                            <th class="py-3.5 px-4 text-center">Jumlah Kos Terhubung</th>
                            <th class="py-3.5 px-4 text-center" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                        @foreach ($campuses as $index => $campus)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-3 text-center text-slate-400 font-bold">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="py-3.5 px-4 font-bold text-[#20344c]">
                                    <div class="flex items-center gap-2">
                                        <span>{{ $campus->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-slate-600">
                                    @if($campus->abbreviation)
                                        <span class="px-2 py-0.5 rounded bg-slate-100 border border-slate-200 text-[11px]">
                                            {{ $campus->abbreviation }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 font-normal">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-medium text-slate-600">
                                    {{ $campus->city ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-bold text-[#20344c]" style="text-align: left;">
                                    <span class="px-2.5 py-1 rounded-[3px] bg-amber-50 text-[#f99d18] border border-amber-200 text-[11px]">
                                        {{ $campus->koses_count }} Kos
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="openEditModal({{ json_encode($campus) }})" 
                                                class="p-1.5 text-slate-600 hover:text-[#f99d18] hover:bg-amber-50 rounded transition" 
                                                title="Edit Kampus">
                                            <x-lucide-pencil class="w-4 h-4" />
                                        </button>
                                        <form action="{{ route('admin.campuses.destroy', $campus->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kampus {{ $campus->name }}?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded transition" title="Hapus Kampus">
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
    </div>

    <!-- Create/Edit Modal -->
    <div id="campusModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg border border-slate-200 max-w-md w-full p-6 shadow-xl relative animate-success">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 id="modalTitle" class="font-extrabold text-base text-[#20344c]">Tambah Master Kampus</h3>
                <button onclick="closeCampusModal()" class="text-slate-400 hover:text-slate-600">
                    <x-lucide-x class="w-5 h-5" />
                </button>
            </div>

            <form id="campusForm" action="{{ route('admin.campuses.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" id="methodField" name="_method" value="POST">

                <div>
                    <label class="block text-xs font-bold text-[#20344c] mb-1">Nama Lengkap Kampus <span class="text-red-500">*</span></label>
                    <input type="text" id="campusName" name="name" placeholder="Contoh: Universitas Diponegoro" required
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#20344c] mb-1">Singkatan / Akronim (Opsional)</label>
                    <input type="text" id="campusAbbr" name="abbreviation" placeholder="Contoh: UNDIP"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#20344c] mb-1">Kota / Kabupaten (Opsional)</label>
                    <input type="text" id="campusCity" name="city" placeholder="Contoh: Semarang"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeCampusModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-md transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-[#f99d18] hover:bg-[#e08b0f] text-white font-bold text-xs rounded-md transition shadow-md">
                        Simpan Kampus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTables Script -->
    <script>
        function openCreateModal() {
            document.getElementById('modalTitle').innerText = 'Tambah Master Kampus';
            document.getElementById('campusForm').action = "{{ route('admin.campuses.store') }}";
            document.getElementById('methodField').value = "POST";
            document.getElementById('campusName').value = '';
            document.getElementById('campusAbbr').value = '';
            document.getElementById('campusCity').value = 'Semarang';
            document.getElementById('campusModal').classList.remove('hidden');
        }

        function openEditModal(campus) {
            document.getElementById('modalTitle').innerText = 'Edit Master Kampus';
            document.getElementById('campusForm').action = "/admin/campuses/" + campus.id;
            document.getElementById('methodField').value = "PUT";
            document.getElementById('campusName').value = campus.name || '';
            document.getElementById('campusAbbr').value = campus.abbreviation || '';
            document.getElementById('campusCity').value = campus.city || '';
            document.getElementById('campusModal').classList.remove('hidden');
        }

        function closeCampusModal() {
            document.getElementById('campusModal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (window.jQuery && window.jQuery.fn.dataTable) {
                window.jQuery.fn.dataTable.ext.errMode = 'none';
            }

            if (window.DataTable && document.getElementById('campusTable')) {
                const table = new DataTable('#campusTable', {
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
                        searchPlaceholder: "Nama kampus, akronim, kota...",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data kampus",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data kampus",
                        zeroRecords: "Tidak ada data kampus yang sesuai",
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
    </script>
@endsection
