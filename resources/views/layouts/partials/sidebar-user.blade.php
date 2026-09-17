<!-- Menu Group 1: User Menu -->
<div>
    <p class="px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-2">MENU PENCAK</p>
    <div class="space-y-1">
        <a href="{{ route('user.dashboard') }}" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-bold text-xs transition {{ request()->routeIs('user.dashboard') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-layout-dashboard class="w-4 h-4" />
                <span>Dashboard</span>
            </div>
        </a>
        <a href="{{ route('home') }}" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition text-slate-300 hover:bg-[#20344c] hover:text-white">
            <div class="flex items-center gap-3">
                <x-lucide-search class="w-4 h-4 text-[#f99d18]" />
                <span>Cari Kos Impian</span>
            </div>
        </a>
        <a href="#" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->is('user/my-kos*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-home class="w-4 h-4 text-slate-400" />
                <span>Kos Saya</span>
            </div>
            <span class="px-2 py-0.5 rounded-full bg-emerald-600 text-white text-[10px] font-bold">1 Aktif</span>
        </a>
        <a href="#" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->is('user/favorites*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-heart class="w-4 h-4 text-rose-400" />
                <span>Favorit Saya</span>
            </div>
        </a>
    </div>
</div>

<!-- Menu Group 2: History & Billing -->
<div>
    <p class="px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-2">RIWAYAT & TAGIHAN</p>
    <div class="space-y-1">
        <a href="#" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->is('user/transactions*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-receipt class="w-4 h-4 text-slate-400" />
                <span>Riwayat Transaksi</span>
            </div>
        </a>
        <a href="#" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->is('user/bills*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-credit-card class="w-4 h-4 text-slate-400" />
                <span>Tagihan Bulanan</span>
            </div>
        </a>
    </div>
</div>

<!-- Menu Group 3: Settings -->
<div>
    <p class="px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-2">AKUN SAYA</p>
    <div class="space-y-1">
        <a href="#" 
           class="flex items-center justify-between px-3 py-2.5 rounded-md font-medium text-xs transition {{ request()->is('user/profile*') ? 'bg-[#f99d18] text-white shadow-md' : 'text-slate-300 hover:bg-[#20344c] hover:text-white' }}">
            <div class="flex items-center gap-3">
                <x-lucide-user class="w-4 h-4 text-slate-400" />
                <span>Profil Saya</span>
            </div>
        </a>
    </div>
</div>
