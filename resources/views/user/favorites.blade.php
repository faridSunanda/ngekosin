@extends('layouts.dashboard')

@section('title', 'Favorit Saya')
@section('portal_name', 'User Portal')
@section('breadcrumb_current', 'Favorit Saya')

@section('content')
    <div class="space-y-6">
        <!-- Header Banner -->
        <div class="relative bg-gradient-to-r from-[#20344c] via-[#1a2d42] to-[#142334] text-white p-6 sm:p-8 rounded-lg shadow-xl overflow-hidden border border-[#2c4361]">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight flex items-center gap-2.5">
                        <span>Daftar Kos Favorit Saya</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl leading-relaxed">
                        Kumpulan properti kos yang telah Anda simpan saat menjelajah di Ngekosin. Bandingkan dan hubungi pemilik kos kapan saja.
                    </p>
                </div>

                <a href="{{ route('home') }}" class="bg-[#f99d18] hover:bg-[#e08b0f] text-white px-5 py-3 rounded-md text-xs font-extrabold transition shadow-lg flex items-center gap-2 shrink-0">
                    <x-lucide-search class="w-4 h-4" />
                    <span>Cari Kos Lainnya</span>
                </a>
            </div>
        </div>

        <!-- Main Container: Title Header & Saved Kos Grid -->
        <div class="bg-white rounded-lg border border-slate-200/80 p-5 sm:p-6 shadow-xs space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div>
                        <h2 class="text-base font-extrabold text-[#20344c]">Properti Kos Tersimpan</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar kos yang ditandai disimpan oleh Anda.</p>
                    </div>
                </div>

                <span id="saved-count-badge" class="px-3 py-1 rounded-[3px] bg-rose-100 text-rose-700 text-xs font-extrabold shrink-0">
                    0 Tersimpan
                </span>
            </div>

            <!-- Saved Kos Grid Container -->
            <div id="favoritesGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Rendered dynamically via JavaScript from localStorage -->
            </div>

            <!-- Empty State Container (Hidden by default) -->
            <div id="emptyFavoritesState" class="hidden py-8 text-center space-y-4">
                <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto">
                    <x-lucide-heart-off class="w-8 h-8" />
                </div>
                <div>
                    <h3 class="text-lg font-extrabold text-[#20344c]">Belum Ada Kos Favorit</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto leading-relaxed">
                        Anda belum menyimpan properti kos manapun. Jelajahi katalog kos dan klik ikon <strong>"Simpan"</strong> untuk memasukkannya ke daftar favorit ini!
                    </p>
                </div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-[#f99d18] hover:bg-[#e08b0f] text-white font-extrabold text-xs rounded-md transition shadow-md">
                    <x-lucide-search class="w-4 h-4" />
                    <span>Jelajahi Kos Sekarang</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Dynamic Favorites Rendering Script -->
    <script>
        const ALL_KOS_DATA = {!! json_encode($allKoses) !!};

        function renderFavorites() {
            const grid = document.getElementById('favoritesGrid');
            const emptyState = document.getElementById('emptyFavoritesState');
            const badge = document.getElementById('saved-count-badge');

            // Find all saved items in localStorage
            const savedItems = ALL_KOS_DATA.filter(item => {
                return localStorage.getItem(`saved_kos_${item.id}`) === 'true';
            });

            badge.textContent = `${savedItems.length} Tersimpan`;

            if (savedItems.length === 0) {
                grid.classList.add('hidden');
                emptyState.classList.remove('hidden');
                return;
            }

            grid.classList.remove('hidden');
            emptyState.classList.add('hidden');

            grid.innerHTML = savedItems.map(item => `
                <div class="bg-white rounded-lg border border-slate-200/80 shadow-xs hover:shadow-md transition overflow-hidden flex flex-col justify-between">
                    <div>
                        <!-- Image & Badge -->
                        <div class="relative h-44 bg-slate-200">
                            <img src="${item.thumbnail}" class="w-full h-full object-cover" alt="${item.name}">
                            
                            <span class="absolute top-3 right-3 px-2.5 py-1 text-white font-bold text-[10px] rounded-[4px] uppercase tracking-wider shadow-md ${
                                item.type === 'putra' ? 'bg-blue-600' : (item.type === 'putri' ? 'bg-pink-600' : 'bg-purple-600')
                            }">
                                Kos ${item.type}
                            </span>

                            <button onclick="removeFavorite(${item.id})" class="absolute top-3 left-3 bg-white/90 hover:bg-white text-rose-600 p-2 rounded-full shadow-md transition" title="Hapus dari favorit">
                                <svg class="w-4 h-4 fill-rose-600 stroke-rose-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                            </button>
                        </div>

                        <!-- Info Content -->
                        <div class="p-4 space-y-3">
                            <div>
                                <h3 class="font-extrabold text-[#20344c] text-base truncate">${item.name}</h3>
                                <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span class="truncate">${item.location}</span>
                                </p>
                            </div>

                            <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-100">
                                <span class="text-slate-500 font-medium">Pemilik: <strong>${item.owner}</strong></span>
                                <span class="text-emerald-600 font-bold">Sisa ${item.available_rooms} Kamar</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-2">
                        <span class="font-extrabold text-[#f99d18] text-sm">${item.priceStr}</span>
                        <div class="flex items-center gap-2">
                            <button onclick="contactOwnerWa('${item.owner}', '${item.ownerPhone}', '${item.name}')" class="px-3 py-1.5 bg-[#25D366] hover:bg-[#20ba5a] text-white font-bold text-xs rounded transition flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                <span>WA</span>
                            </button>
                            <a href="/#kos-${item.id}" target="_blank" class="px-3 py-1.5 bg-[#20344c] hover:bg-[#182739] text-white font-bold text-xs rounded transition">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function removeFavorite(id) {
            localStorage.setItem(`saved_kos_${id}`, 'false');
            renderFavorites();
        }

        function contactOwnerWa(ownerName, ownerPhone, kosName) {
            const defaultMsg = `Halo ${ownerName}, saya mendapatkan informasi ${kosName} dari Favorit Saya di Ngekosin. Apakah masih ada kamar yang tersedia?`;
            const phone = ownerPhone ? ownerPhone.replace(/[^0-9]/g, '') : '6281234567890';
            window.open(`https://wa.me/${phone}?text=${encodeURIComponent(defaultMsg)}`, '_blank');
        }

        document.addEventListener('DOMContentLoaded', renderFavorites);
    </script>
@endsection
