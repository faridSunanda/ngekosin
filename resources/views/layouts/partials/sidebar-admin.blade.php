<!-- Menu Group 1: Navigation -->
<div>
    <p class="px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-2">MENU UTAMA</p>
    <div class="space-y-1">
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-bold text-xs transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-layout-dashboard class="w-4 h-4" />
                <span>Dashboard</span>
            </div>
        </a>
        <a href="{{ route('admin.kos.index') }}" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->routeIs('admin.kos.*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-building-2 class="w-4 h-4 text-slate-400" />
                <span>Data Properti Kos</span>
            </div>
        </a>
        <a href="{{ route('admin.campuses.index') }}" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->routeIs('admin.campuses.*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-graduation-cap class="w-4 h-4 text-slate-400" />
                <span>Master Kampus</span>
            </div>
        </a>
        <a href="{{ route('admin.facilities.index') }}" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->routeIs('admin.facilities.*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-sparkles class="w-4 h-4 text-slate-400" />
                <span>Master Fasilitas</span>
            </div>
        </a>
        <a href="{{ route('admin.owners.index') }}" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->routeIs('admin.owners.*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-users class="w-4 h-4 text-slate-400" />
                <span>Daftar Owner</span>
            </div>
        </a>
    </div>
</div>

<div>
    <p class="px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-2">LAPORAN & ANALITIK</p>
    <div class="space-y-1">
        <a href="{{ route('admin.analytics') }}" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->routeIs('admin.analytics') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-bar-chart-3 class="w-4 h-4 text-slate-400" />
                <span>Analitik</span>
            </div>
        </a>
    </div>
</div>

<!-- Menu Group 2: Transactions -->
<!-- <div>
    <p class="px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-2">TRANSAKSI & SEWA</p>
    <div class="space-y-1">
        <a href="#" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->is('admin/transactions*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-receipt class="w-4 h-4 text-slate-400" />
                <span>Riwayat Transaksi</span>
            </div>
        </a>
        <a href="#" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->is('admin/reports*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-bar-chart-3 class="w-4 h-4 text-slate-400" />
                <span>Laporan Keuangan</span>
            </div>
        </a>
    </div>
</div> -->

<!-- Menu Group 3: Account & System -->
<div>
    <p class="px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-2">AKUN & SISTEM</p>
    <div class="space-y-1">
        <a href="{{ route('admin.users.index') }}" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->routeIs('admin.users.*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-users class="w-4 h-4 text-slate-400" />
                <span>Kelola Pengguna</span>
            </div>
        </a>
        <!-- <a href="#" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->is('admin/settings*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-settings class="w-4 h-4 text-slate-400" />
                <span>Pengaturan Sistem</span>
            </div>
        </a> -->
    </div>
</div>
