@extends('layouts.dashboard')

@section('title', 'Daftar Owner Kos')
@section('portal_name', 'Admin Panel')
@section('breadcrumb_current', 'Daftar Owner')

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
                <h1 class="text-2xl font-extrabold text-[#20344c]">Daftar Data Owner</h1>
                <p class="text-xs text-slate-500 mt-1">Kelola data pemilik/pengelola properti kos yang terdaftar di platform Ngekosin.</p>
            </div>
            <button onclick="openCreateModal()" class="px-4 py-2.5 bg-[#f99d18] hover:bg-[#e08b0f] text-white font-bold text-xs rounded-md transition shadow-md flex items-center justify-center gap-2">
                <x-lucide-user-plus class="w-4 h-4" />
                <span>Tambah Owner Baru</span>
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

        @if ($errors->any())
            <div class="p-4 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold rounded-md space-y-1">
                @foreach ($errors->all() as $error)
                    <div class="flex items-center gap-2">
                        <x-lucide-alert-circle class="w-4 h-4 text-red-600" />
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Table Card -->
        <div class="bg-white rounded-md border border-slate-200 shadow-xs overflow-hidden p-5">
            <div class="overflow-x-auto">
                <table id="ownerTable" class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-3 w-10 text-center">#</th>
                            <th class="py-3.5 px-4">Nama Owner</th>
                            <th class="py-3.5 px-4">Email</th>
                            <th class="py-3.5 px-4" style="text-align: left;">No. Telepon / WA</th>
                            <th class="py-3.5 px-4 text-center">Jumlah Properti Kos</th>
                            <th class="py-3.5 px-4 text-center" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                        @foreach ($owners as $index => $owner)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-3 text-center text-slate-400 font-bold">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="py-3.5 px-4 font-bold text-[#20344c]">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-[#20344c]/10 text-[#20344c] flex items-center justify-center font-extrabold text-xs shrink-0">
                                            {{ strtoupper(substr($owner->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $owner->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-slate-600">
                                    <span class="text-slate-600">{{ $owner->email }}</span>
                                </td>
                                <td class="py-3.5 px-4 font-medium text-slate-600" style="text-align: left;">
                                    @if($owner->phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $owner->phone) }}" target="_blank" class="inline-flex items-center gap-1.5 text-emerald-600 font-semibold hover:underline">
                                            <x-lucide-phone class="w-3.5 h-3.5" />
                                            <span>{{ $owner->phone }}</span>
                                        </a>
                                    @else
                                        <span class="text-slate-400 font-normal italic">Belum diisi</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center font-bold text-[#20344c]" style="text-align: center;">
                                    <span class="px-2.5 py-1 rounded-[3px] bg-amber-50 text-[#f99d18] border border-amber-200 text-[11px]">
                                        {{ $owner->koses_count }} Kos
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="openEditModal({{ json_encode($owner) }})" 
                                                class="p-1.5 text-slate-600 hover:text-[#f99d18] hover:bg-amber-50 rounded transition" 
                                                title="Edit Owner">
                                            <x-lucide-pencil class="w-4 h-4" />
                                        </button>
                                        <form action="{{ route('admin.owners.destroy', $owner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data owner {{ $owner->name }}?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded transition" title="Hapus Owner">
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
    <div id="ownerModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg border border-slate-200 max-w-md w-full p-6 shadow-xl relative animate-success">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 id="modalTitle" class="font-extrabold text-base text-[#20344c]">Tambah Owner Baru</h3>
                <button onclick="closeOwnerModal()" class="text-slate-400 hover:text-slate-600">
                    <x-lucide-x class="w-5 h-5" />
                </button>
            </div>

            <form id="ownerForm" action="{{ route('admin.owners.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" id="methodField" name="_method" value="POST">

                <div>
                    <label class="block text-xs font-bold text-[#20344c] mb-1">Nama Lengkap Owner <span class="text-red-500">*</span></label>
                    <input type="text" id="ownerName" name="name" placeholder="Contoh: Ibu Hesty" required
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#20344c] mb-1">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" id="ownerEmail" name="email" placeholder="Contoh: owner@ngekosin.com" required
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#20344c] mb-1">Nomor HP / WhatsApp</label>
                    <input type="text" id="ownerPhone" name="phone" placeholder="Contoh: 081234567890"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#20344c] mb-1">
                        Password <span id="passwordRequired" class="text-red-500">*</span>
                        <span id="passwordHelp" class="text-slate-400 font-normal hidden">(Kosongkan jika tidak diubah)</span>
                    </label>
                    <input type="password" id="ownerPassword" name="password" placeholder="Minimal 6 karakter"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeOwnerModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-md transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-[#f99d18] hover:bg-[#e08b0f] text-white font-bold text-xs rounded-md transition shadow-md">
                        Simpan Owner
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTables Script -->
    <script>
        function openCreateModal() {
            document.getElementById('modalTitle').innerText = 'Tambah Owner Baru';
            document.getElementById('ownerForm').action = "{{ route('admin.owners.store') }}";
            document.getElementById('methodField').value = "POST";
            document.getElementById('ownerName').value = '';
            document.getElementById('ownerEmail').value = '';
            document.getElementById('ownerPhone').value = '';
            document.getElementById('ownerPassword').value = '';
            document.getElementById('ownerPassword').required = true;
            document.getElementById('passwordRequired').classList.remove('hidden');
            document.getElementById('passwordHelp').classList.add('hidden');
            document.getElementById('ownerModal').classList.remove('hidden');
        }

        function openEditModal(owner) {
            document.getElementById('modalTitle').innerText = 'Edit Data Owner';
            document.getElementById('ownerForm').action = "/admin/owners/" + owner.id;
            document.getElementById('methodField').value = "PUT";
            document.getElementById('ownerName').value = owner.name || '';
            document.getElementById('ownerEmail').value = owner.email || '';
            document.getElementById('ownerPhone').value = owner.phone || '';
            document.getElementById('ownerPassword').value = '';
            document.getElementById('ownerPassword').required = false;
            document.getElementById('passwordRequired').classList.add('hidden');
            document.getElementById('passwordHelp').classList.remove('hidden');
            document.getElementById('ownerModal').classList.remove('hidden');
        }

        function closeOwnerModal() {
            document.getElementById('ownerModal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (window.jQuery && window.jQuery.fn.dataTable) {
                window.jQuery.fn.dataTable.ext.errMode = 'none';
            }

            if (window.DataTable && document.getElementById('ownerTable')) {
                const table = new DataTable('#ownerTable', {
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
                        searchPlaceholder: "Nama owner, email, no telp...",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data owner",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data owner",
                        zeroRecords: "Tidak ada data owner yang sesuai",
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
