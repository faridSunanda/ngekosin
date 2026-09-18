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
    </div>
</div>

<!-- Menu Group 3: Account -->
<!-- <div>
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
</div> -->
