<!-- Menu Group 1: Manage Kos -->
<div>
    <p class="px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-2">KELOLA PROPERTI</p>
    <div class="space-y-1">
        <a href="{{ route('owner.dashboard') }}" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-bold text-xs transition {{ request()->routeIs('owner.dashboard') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-layout-dashboard class="w-4 h-4" />
                <span>Dashboard</span>
            </div>
        </a>
        <a href="#" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->is('owner/properties*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-building-2 class="w-4 h-4 text-slate-400" />
                <span>Kos Saya</span>
            </div>
            <span class="px-2 py-0.5 rounded-full bg-slate-700 text-slate-300 text-[10px]">3 Kos</span>
        </a>
        <a href="#" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->is('owner/create-kos*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-plus-circle class="w-4 h-4 text-[#f99d18]" />
                <span>Tambah Kos Baru</span>
            </div>
        </a>
    </div>
</div>

<!-- Menu Group 2: Tenant & Sewa -->
<div>
    <p class="px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-2">PENGHUNI & SEWA</p>
    <div class="space-y-1">
        <a href="#" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->is('owner/rent-requests*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-inbox class="w-4 h-4 text-slate-400" />
                <span>Pengajuan Sewa</span>
            </div>
            <span class="px-2 py-0.5 rounded-full bg-[#f99d18] text-white text-[10px] font-bold">2 Baru</span>
        </a>
        <a href="#" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->is('owner/tenants*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-users class="w-4 h-4 text-slate-400" />
                <span>Daftar Penghuni</span>
            </div>
        </a>
        <a href="#" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->is('owner/incomes*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-wallet class="w-4 h-4 text-slate-400" />
                <span>Laporan Pemasukan</span>
            </div>
        </a>
    </div>
</div>

<!-- Menu Group 3: Account -->
<div>
    <p class="px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-2">PENGATURAN OWNER</p>
    <div class="space-y-1">
        <a href="#" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->is('owner/profile*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-user class="w-4 h-4 text-slate-400" />
                <span>Profil Owner</span>
            </div>
        </a>
    </div>
</div>
