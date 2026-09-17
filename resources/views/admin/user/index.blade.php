@extends('layouts.dashboard')

@section('title', 'Kelola Data Pengguna')
@section('portal_name', 'Admin Panel')
@section('breadcrumb_current', 'Kelola Pengguna')

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
                <h1 class="text-2xl font-extrabold text-[#20344c]">Kelola Data Pengguna</h1>
                <p class="text-xs text-slate-500 mt-1">Kelola seluruh data pengguna yang terdaftar di platform Ngekosin (Admin, Owner, & Pencari Kos).</p>
            </div>
            <button onclick="openCreateModal()" class="px-4 py-2.5 bg-[#f99d18] hover:bg-[#e08b0f] text-white font-bold text-xs rounded-md transition shadow-md flex items-center justify-center gap-2">
                <x-lucide-user-plus class="w-4 h-4" />
                <span>Tambah Pengguna Baru</span>
            </button>
        </div>

        <!-- Alert Success & Error Message -->
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

        @if (session('error'))
            <div class="p-4 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold rounded-md flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <x-lucide-alert-circle class="w-4 h-4 text-red-600" />
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
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
                <table id="userTable" class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-3 w-10 text-center">#</th>
                            <th class="py-3.5 px-4">Nama Pengguna</th>
                            <th class="py-3.5 px-4">Email</th>
                            <th class="py-3.5 px-4" style="text-align: left;">No. Telepon / WA</th>
                            <th class="py-3.5 px-4 text-center">Peran (Role)</th>
                            <th class="py-3.5 px-4 text-center">Terdaftar</th>
                            <th class="py-3.5 px-4 text-center" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                        @foreach ($users as $index => $u)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-3 text-center text-slate-400 font-bold">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="py-3.5 px-4 font-bold text-[#20344c]">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full {{ $u->role === 'admin' ? 'bg-purple-100 text-purple-700' : ($u->role === 'owner' ? 'bg-amber-100 text-amber-700' : 'bg-sky-100 text-sky-700') }} flex items-center justify-center font-extrabold text-xs shrink-0">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $u->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-slate-600">
                                    <span class="text-slate-600">{{ $u->email }}</span>
                                </td>
                                <td class="py-3.5 px-4 font-medium text-slate-600" style="text-align: left;">
                                    @if($u->phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $u->phone) }}" target="_blank" class="inline-flex items-center gap-1.5 text-emerald-600 font-semibold hover:underline">
                                            <x-lucide-phone class="w-3.5 h-3.5" />
                                            <span>{{ $u->phone }}</span>
                                        </a>
                                    @else
                                        <span class="text-slate-400 font-normal italic">Belum diisi</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center font-bold" style="text-align: center;">
                                    @if ($u->role === 'admin')
                                        <span class="px-2.5 py-1 rounded-[3px] bg-purple-50 text-purple-700 border border-purple-200 text-[11px] font-bold">
                                            Administrator
                                        </span>
                                    @elseif ($u->role === 'owner')
                                        <span class="px-2.5 py-1 rounded-[3px] bg-amber-50 text-[#f99d18] border border-amber-200 text-[11px] font-bold">
                                            Owner Kos
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-[3px] bg-sky-50 text-sky-700 border border-sky-200 text-[11px] font-bold">
                                            Pencari Kos
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center font-medium text-slate-500">
                                    {{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="openEditModal({{ json_encode($u) }})" 
                                                class="p-1.5 text-slate-600 hover:text-[#f99d18] hover:bg-amber-50 rounded transition" 
                                                title="Edit Pengguna">
                                            <x-lucide-pencil class="w-4 h-4" />
                                        </button>

                                        @if (auth()->id() !== $u->id)
                                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $u->name }}?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded transition" title="Hapus Pengguna">
                                                    <x-lucide-trash-2 class="w-4 h-4" />
                                                </button>
                                            </form>
                                        @else
                                            <span class="p-1.5 text-slate-300 cursor-not-allowed" title="Tidak dapat menghapus akun sendiri">
                                                <x-lucide-shield-check class="w-4 h-4" />
                                            </span>
                                        @endif
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
    <div id="userModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg border border-slate-200 max-w-md w-full p-6 shadow-xl relative animate-success">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 id="modalTitle" class="font-extrabold text-base text-[#20344c]">Tambah Pengguna Baru</h3>
                <button onclick="closeUserModal()" class="text-slate-400 hover:text-slate-600">
                    <x-lucide-x class="w-5 h-5" />
                </button>
            </div>

            <form id="userForm" action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" id="methodField" name="_method" value="POST">

                <div>
                    <label class="block text-xs font-bold text-[#20344c] mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="userName" name="name" placeholder="Contoh: Ahmad Subagyo" required
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#20344c] mb-1">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" id="userEmail" name="email" placeholder="Contoh: user@ngekosin.com" required
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#20344c] mb-1">Nomor HP / WhatsApp</label>
                    <input type="text" id="userPhone" name="phone" placeholder="Contoh: 081234567890"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#20344c] mb-1">Peran / Hak Akses (Role) <span class="text-red-500">*</span></label>
                    <select id="userRole" name="role" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                        <option value="user">Pencari Kos (User biasa)</option>
                        <option value="owner">Pemilik / Owner Kos</option>
                        <option value="admin">Administrator (Akses penuh)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#20344c] mb-1">
                        Password <span id="passwordRequired" class="text-red-500">*</span>
                        <span id="passwordHelp" class="text-slate-400 font-normal hidden">(Kosongkan jika tidak diubah)</span>
                    </label>
                    <input type="password" id="userPassword" name="password" placeholder="Minimal 6 karakter"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeUserModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-md transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-[#f99d18] hover:bg-[#e08b0f] text-white font-bold text-xs rounded-md transition shadow-md">
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTables Script -->
    <script>
        function openCreateModal() {
            document.getElementById('modalTitle').innerText = 'Tambah Pengguna Baru';
            document.getElementById('userForm').action = "{{ route('admin.users.store') }}";
            document.getElementById('methodField').value = "POST";
            document.getElementById('userName').value = '';
            document.getElementById('userEmail').value = '';
            document.getElementById('userPhone').value = '';
            document.getElementById('userRole').value = 'user';
            document.getElementById('userPassword').value = '';
            document.getElementById('userPassword').required = true;
            document.getElementById('passwordRequired').classList.remove('hidden');
            document.getElementById('passwordHelp').classList.add('hidden');
            document.getElementById('userModal').classList.remove('hidden');
        }

        function openEditModal(u) {
            document.getElementById('modalTitle').innerText = 'Edit Data Pengguna';
            document.getElementById('userForm').action = "/admin/users/" + u.id;
            document.getElementById('methodField').value = "PUT";
            document.getElementById('userName').value = u.name || '';
            document.getElementById('userEmail').value = u.email || '';
            document.getElementById('userPhone').value = u.phone || '';
            document.getElementById('userRole').value = u.role || 'user';
            document.getElementById('userPassword').value = '';
            document.getElementById('userPassword').required = false;
            document.getElementById('passwordRequired').classList.add('hidden');
            document.getElementById('passwordHelp').classList.remove('hidden');
            document.getElementById('userModal').classList.remove('hidden');
        }

        function closeUserModal() {
            document.getElementById('userModal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (window.jQuery && window.jQuery.fn.dataTable) {
                window.jQuery.fn.dataTable.ext.errMode = 'none';
            }

            if (window.DataTable && document.getElementById('userTable')) {
                const table = new DataTable('#userTable', {
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
                        searchPlaceholder: "Nama pengguna, email, no telp, role...",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data pengguna",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data pengguna",
                        zeroRecords: "Tidak ada data pengguna yang sesuai",
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
