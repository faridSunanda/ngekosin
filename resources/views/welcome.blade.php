<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cari Kos Impian - Ngekosin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom scrollbar for listing panel & details */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Pulse Animation for modal success */
        @keyframes success-pulse {
            0% { transform: scale(0.9); opacity: 0; }
            50% { transform: scale(1.05); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-success {
            animation: success-pulse 0.4s ease-out forwards;
        }
    </style>
</head>
<body class="bg-[#F8F9FA] text-[#20344c] antialiased min-h-screen flex flex-col">

    <!-- Navbar Section -->
    <nav class="border-b border-[#162537] sticky top-0 bg-[#20344c] z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Left side -->
                <div class="flex items-center space-x-8">
                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-2.5 group">
                        <div class="h-10 w-10 group-hover:bg-[#f99d18]/30 transition">
                            <img src="{{ asset('images/logo.png') }}" alt="Ngekosin" class="rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xl font-bold tracking-tight text-white flex items-center gap-1">
                                Ngekosin<span class="text-[#f99d18]">.</span>
                            </span>
                            <span class="text-[10px] text-gray-300 -mt-1 font-medium tracking-wide">Cari kos, Nggak pake ribet</span>
                        </div>
                    </a>

                    <!-- Nav Links -->
                    <div class="hidden md:flex space-x-6 text-sm font-medium text-gray-300 h-16">
                        <a href="/" class="text-white flex items-center border-b-[3px] border-[#f99d18]">Beranda</a>
                        <a href="#" class="hover:text-white flex items-center border-b-[3px] border-transparent transition-colors">Cari Kos</a>
                        <a href="#" class="hover:text-white flex items-center border-b-[3px] border-transparent transition-colors">Tipe Kos</a>
                        <a href="#" class="hover:text-white flex items-center border-b-[3px] border-transparent transition-colors">Sewa & Mitra</a>
                    </div>
                </div>

                <!-- Right side -->
                <div class="flex items-center gap-2 sm:gap-3 text-xs sm:text-sm font-medium">
                    <button class="hidden md:flex items-center text-gray-300 hover:text-white text-xs">
                        ID <i data-lucide="chevron-down" class="w-3.5 h-3.5 ml-0.5"></i>
                    </button>
                    <div class="hidden md:block w-px h-4 bg-slate-600"></div>

                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isOwner() ? route('owner.dashboard') : route('user.dashboard')) }}" 
                           class="text-white hover:text-[#f99d18] font-bold transition-colors flex items-center justify-center p-2 sm:px-3 sm:py-1.5 rounded-[3px] sm:rounded-full border border-white/20 bg-white/10 shrink-0" 
                           title="{{ auth()->user()->name }}">
                            <i data-lucide="user" class="w-4 h-4 text-[#f99d18] shrink-0"></i>
                            <span class="hidden sm:inline truncate text-xs ml-1.5 max-w-[160px]">{{ auth()->user()->name }}</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors text-xs sm:text-sm px-1.5 py-1">Masuk</a>
                        <a href="{{ route('register') }}" class="text-gray-300 hover:text-white transition-colors text-xs sm:text-sm px-1.5 py-1">Daftar</a>
                    @endauth

                    <a href="{{ auth()->check() && auth()->user()->isOwner() ? route('owner.dashboard') : route('register', ['role' => 'owner']) }}" 
                       class="bg-[#f99d18] text-white p-2 sm:px-4 sm:py-2 rounded-[3px] sm:rounded-full hover:bg-[#e08b0f] shadow-sm transition-colors font-bold border border-[#f99d18] text-xs shrink-0 flex items-center gap-1.5" 
                       title="Pasang Iklan Kos">
                        <i data-lucide="plus-circle" class="w-4 h-4 shrink-0"></i>
                        <span class="hidden sm:inline">Pasang Iklan Kos</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Search Hero Section -->
    <section class="bg-gradient-to-r from-[#20344c] to-[#162537] text-white py-12 relative z-30 shadow-inner">
        
        <!-- Decorative abstract shapes (Isolated overflow wrapper) -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute -top-12 -right-12 w-64 h-64 bg-[#f99d18]/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-12 -left-12 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-2">Temukan Kos Impian Anda</h1>
                <p class="text-gray-300 text-sm md:text-base font-medium">Temukan ribuan pilihan kost terbaik, nyaman, dan strategis di seluruh Indonesia</p>
            </div>

            <!-- Floating Search Card -->
            <div class="bg-white rounded-lg p-4 md:p-6 shadow-xl text-[#20344c] max-w-5xl mx-auto border border-white/20">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                    <!-- Search Input -->
                    <div class="md:col-span-4 relative">
                        <i data-lucide="search" class="w-5 h-5 text-slate-400 absolute left-4 top-3.5"></i>
                        <input type="text" id="searchKeyword" oninput="handleSearch()" placeholder="Cari nama kos atau lokasi..." class="w-full bg-[#F8F9FA] border border-gray-200 rounded-md py-3 pl-12 pr-4 text-sm focus:outline-none focus:border-[#f99d18] focus:ring-1 focus:ring-[#f99d18] text-[#20344c] font-medium transition-all">
                    </div>

                    <!-- Searchable Campus Select -->
                    <div class="md:col-span-3 relative" id="campusDropdownWrapper">
                        <input type="hidden" id="searchCampus" value="">
                        <button type="button" id="campusDropdownBtn" onclick="toggleCustomDropdown('campus')" class="w-full bg-[#F8F9FA] border border-gray-200 rounded-md py-3 pl-12 pr-10 text-sm focus:outline-none focus:border-[#f99d18] focus:ring-1 focus:ring-[#f99d18] text-[#20344c] font-medium text-left truncate transition-all flex items-center justify-between">
                            <i data-lucide="graduation-cap" class="w-5 h-5 text-slate-400 absolute left-4 top-3.5"></i>
                            <span id="campusSelectedLabel" class="truncate">Semua Kampus</span>
                            <i data-lucide="chevron-down" id="campusChevron" class="w-4 h-4 text-slate-400 absolute right-4 top-4 pointer-events-none transition-transform duration-200"></i>
                        </button>

                        <div id="campusDropdown" class="absolute left-0 right-0 top-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl z-[100] hidden overflow-hidden transition-all duration-200">
                            <div class="p-2 border-b border-gray-100 relative bg-slate-50">
                                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-4 top-3.5"></i>
                                <input type="text" id="campusSearchInput" onkeyup="filterDropdownOptions('campus')" placeholder="Cari nama kampus..." class="w-full bg-white border border-slate-200 rounded-md py-1.5 pl-9 pr-3 text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                            </div>
                            <div id="campusOptionsList" class="max-h-56 overflow-y-auto custom-scrollbar p-1">
                                <div onclick="selectCustomOption('campus', '', 'Semua Kampus')" class="dropdown-option px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-amber-50 hover:text-[#f99d18] rounded-md cursor-pointer transition-colors flex items-center justify-between">
                                    <span>Semua Kampus</span>
                                </div>
                                @foreach ($campuses as $campus)
                                    <div onclick="selectCustomOption('campus', '{{ $campus->name }}', '{{ $campus->name }}')" class="dropdown-option px-3 py-2 text-xs font-medium text-slate-700 hover:bg-amber-50 hover:text-[#f99d18] rounded-md cursor-pointer transition-colors flex items-center justify-between" data-text="{{ strtolower($campus->name) }}">
                                        <span class="truncate">{{ $campus->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Searchable Location Select -->
                    <div class="md:col-span-3 relative" id="locationDropdownWrapper">
                        <input type="hidden" id="searchLocation" value="">
                        <button type="button" id="locationDropdownBtn" onclick="toggleCustomDropdown('location')" class="w-full bg-[#F8F9FA] border border-gray-200 rounded-md py-3 pl-12 pr-10 text-sm focus:outline-none focus:border-[#f99d18] focus:ring-1 focus:ring-[#f99d18] text-[#20344c] font-medium text-left truncate transition-all flex items-center justify-between">
                            <i data-lucide="map-pin" class="w-5 h-5 text-slate-400 absolute left-4 top-3.5"></i>
                            <span id="locationSelectedLabel" class="truncate">Lokasi</span>
                            <i data-lucide="chevron-down" id="locationChevron" class="w-4 h-4 text-slate-400 absolute right-4 top-4 pointer-events-none transition-transform duration-200"></i>
                        </button>

                        <div id="locationDropdown" class="absolute left-0 right-0 top-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl z-[100] hidden overflow-hidden transition-all duration-200">
                            <div class="p-2 border-b border-gray-100 relative bg-slate-50">
                                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-4 top-3.5"></i>
                                <input type="text" id="locationSearchInput" onkeyup="filterDropdownOptions('location')" placeholder="Cari nama kota/lokasi..." class="w-full bg-white border border-slate-200 rounded-md py-1.5 pl-9 pr-3 text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                            </div>
                            <div id="locationOptionsList" class="max-h-56 overflow-y-auto custom-scrollbar p-1">
                                <div onclick="selectCustomOption('location', '', 'Lokasi')" class="dropdown-option px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-amber-50 hover:text-[#f99d18] rounded-md cursor-pointer transition-colors flex items-center justify-between">
                                    <span>Semua Lokasi</span>
                                </div>
                                @foreach ($cities as $city)
                                    <div onclick="selectCustomOption('location', '{{ $city }}', '{{ $city }}')" class="dropdown-option px-3 py-2 text-xs font-medium text-slate-700 hover:bg-amber-50 hover:text-[#f99d18] rounded-md cursor-pointer transition-colors flex items-center justify-between" data-text="{{ strtolower($city) }}">
                                        <span class="truncate">{{ $city }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Category Select -->
                    <div class="md:col-span-2 relative">
                        <i data-lucide="home" class="w-5 h-5 text-slate-400 absolute left-4 top-3.5"></i>
                        <select id="searchCategory" onchange="handleSearch()" class="w-full bg-[#F8F9FA] border border-gray-200 rounded-md py-3 pl-12 pr-4 text-sm focus:outline-none focus:border-[#f99d18] focus:ring-1 focus:ring-[#f99d18] text-[#20344c] font-medium appearance-none cursor-pointer transition-all">
                            <option value="">Tipe Kos</option>
                            <option value="Kos Putri">Kos Putri</option>
                            <option value="Kos Putra">Kos Putra</option>
                            <option value="Kos Campur">Kos Campur</option>
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 absolute right-4 top-4 pointer-events-none"></i>
                    </div>

                    <!-- Search Button -->
                    <!-- <div class="md:col-span-1">
                        <button onclick="handleSearch()" class="w-full bg-[#20344c] hover:bg-[#162537] text-white py-3 px-4 rounded-md font-bold shadow-md transition-all flex items-center justify-center gap-2">
                            <i data-lucide="search" class="w-5 h-5 md:hidden"></i>
                            <span class="hidden md:inline">Cari</span>
                            <span class="md:hidden">Cari</span>
                        </button>
                    </div> -->
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Area -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col lg:flex-row gap-8 relative z-10">
        
        <!-- COLUMN 1: SIDEBAR FILTERS (20% width on lg) -->
        <aside class="w-full lg:w-[22%] lg:sticky lg:top-[88px] h-fit bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                <h3 class="font-bold text-[#20344c] flex items-center gap-2">
                    Filter
                </h3>
                <button onclick="resetFilters()" class="text-xs font-bold text-[#f99d18] hover:text-[#e08b0f] transition-colors">
                    Reset
                </button>
            </div>

            <!-- Filter Tipe Kos -->
            <div class="mb-6">
                <h4 class="font-bold text-sm text-[#20344c] mb-3">Tipe Kos</h4>
                <div class="space-y-2.5">
                    <label class="flex items-center gap-3 text-sm text-slate-600 cursor-pointer hover:text-[#20344c] transition-colors">
                        <input type="checkbox" name="kosType" value="Kos Putri" class="w-4 h-4 rounded text-[#f99d18] focus:ring-[#f99d18] border-gray-300 accent-[#f99d18]" onchange="updateFilters()">
                        <span>Kos Putri</span>
                    </label>
                    <label class="flex items-center gap-3 text-sm text-slate-600 cursor-pointer hover:text-[#20344c] transition-colors">
                        <input type="checkbox" name="kosType" value="Kos Putra" class="w-4 h-4 rounded text-[#f99d18] focus:ring-[#f99d18] border-gray-300 accent-[#f99d18]" onchange="updateFilters()">
                        <span>Kos Putra</span>
                    </label>
                    <label class="flex items-center gap-3 text-sm text-slate-600 cursor-pointer hover:text-[#20344c] transition-colors">
                        <input type="checkbox" name="kosType" value="Kos Campur" class="w-4 h-4 rounded text-[#f99d18] focus:ring-[#f99d18] border-gray-300 accent-[#f99d18]" onchange="updateFilters()">
                        <span>Kos Campur</span>
                    </label>
                </div>
            </div>

            <!-- Filter Fasilitas Utama -->
            <div class="mb-6 border-t border-gray-100 pt-6">
                <h4 class="font-bold text-sm text-[#20344c] mb-3">Fasilitas Utama</h4>
                <div class="space-y-2.5 max-h-48 overflow-y-auto custom-scrollbar pr-1">
                    @foreach ($facilities as $fac)
                        <label class="flex items-center gap-3 text-sm text-slate-600 cursor-pointer hover:text-[#20344c] transition-colors">
                            <input type="checkbox" name="facility" value="{{ $fac->name }}" class="w-4 h-4 rounded text-[#f99d18] focus:ring-[#f99d18] border-gray-300 accent-[#f99d18]" onchange="updateFilters()">
                            <span>{{ $fac->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Filter Sewa Min -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="font-bold text-sm text-[#20344c] mb-3">Estimasi Sewa Maksimal</h4>
                <div class="space-y-2">
                    <input type="range" id="priceRange" min="0" max="{{ $maxPrice }}" step="100000" value="0" class="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#f99d18]" oninput="updateSalaryLabel(this.value)">
                    <div class="flex justify-between text-xs text-slate-500 font-medium">
                        <span>Rp 0</span>
                        <span id="priceLabel" class="text-[#f99d18] font-bold">Semua Harga</span>
                        <span>Rp {{ number_format($maxPrice / 1000000, 1) }}jt+</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- COLUMN 2: KOS CARDS LIST (33% width on lg) -->
        <section class="w-full lg:w-[33%] flex flex-col gap-4">
            <!-- Results Counter & Info -->
            <div class="flex justify-between items-center px-1">
                <p class="text-sm text-slate-500 font-medium">Menampilkan <span id="resultsCount" class="text-[#20344c] font-bold">0</span> Pilihan Kos</p>
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                    <i data-lucide="arrow-up-down" class="w-3.5 h-3.5"></i>
                    <span>Urutan:</span>
                    <select id="sortBy" onchange="handleSortChange(this.value)" class="bg-transparent border-none text-[#20344c] font-bold focus:outline-none cursor-pointer pr-1">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="highest-price">Harga Tertinggi</option>
                        <option value="lowest-price">Harga Terendah</option>
                    </select>
                </div>
            </div>

            <!-- Cards Container -->
            <div id="kosListContainer" class="flex flex-col gap-4 max-h-[calc(100vh-200px)] overflow-y-auto custom-scrollbar pr-1">
                <!-- Dynamic Kos Cards will be injected here -->
            </div>
        </section>

        <!-- COLUMN 3: DETAILED VIEW (45% width on lg, sticky) -->
        <section id="kosDetailContainer" class="hidden lg:block w-full lg:w-[45%] lg:sticky lg:top-[88px] h-[calc(100vh-120px)] bg-white border border-gray-200 rounded-lg shadow-sm overflow-y-auto custom-scrollbar p-8">
            <!-- Dynamic Kos Details will be injected here -->
        </section>

    </main>

    <!-- Mobile Kos Details Sheet (Slide up drawer for mobile users) -->
    <div id="mobileDetailDrawer" onclick="if(event.target === this) closeMobileDrawer()" class="fixed inset-0 bg-[#20344c]/60 z-[100] transition-opacity duration-300 opacity-0 pointer-events-none flex items-end justify-center">
        <div class="w-full h-[90vh] max-h-[92vh] bg-white rounded-t-3xl shadow-2xl flex flex-col translate-y-full transition-transform duration-300 ease-out overflow-hidden">
            <!-- Pull Indicator -->
            <div class="w-full pt-2.5 pb-1 flex justify-center items-center bg-white rounded-t-3xl cursor-pointer" onclick="closeMobileDrawer()">
                <div class="w-12 h-1.5 bg-slate-300 rounded-full"></div>
            </div>
            <!-- Drawer Header -->
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-3 bg-white shrink-0">
                <div class="flex items-center gap-2.5 min-w-0">
                    <img id="drawerCompLogo" src="/images/kos_room_1.jpg" class="w-8 h-8 rounded-lg object-cover shrink-0" alt="Kos Photo">
                    <span id="drawerCompName" class="font-bold text-sm text-[#20344c] truncate">Kos Detail</span>
                </div>
                <button onclick="closeMobileDrawer()" class="p-1.5 text-slate-500 hover:bg-slate-100 rounded-full transition-colors shrink-0">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <!-- Drawer Content (Scrollable) -->
            <div id="mobileDrawerBody" class="flex-grow overflow-y-auto p-5 custom-scrollbar pb-12"></div>
        </div>
    </div>

    <!-- Login Required Auth Modal -->
    <div id="authModal" onclick="if(event.target === this) closeAuthModal()" class="fixed inset-0 bg-[#20344c]/60 z-[100] flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white rounded-md max-w-sm w-full p-6 text-center shadow-2xl transform scale-95 transition-transform duration-300 relative border border-gray-100">
            <button onclick="closeAuthModal()" class="absolute right-4 top-4 text-slate-400 hover:text-slate-600 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
            <div class="w-14 h-14 bg-amber-50 text-[#f99d18] rounded-full flex items-center justify-center mx-auto mb-4 border border-amber-200/60 shadow-sm">
                <i data-lucide="bookmark-check" class="w-7 h-7"></i>
            </div>
            <h3 class="font-extrabold text-lg text-[#20344c] mb-1">Simpan Kos Impian</h3>
            <p class="text-xs text-slate-500 font-medium leading-relaxed mb-6">
                Silakan masuk ke akun Anda terlebih dahulu untuk menyimpan favorit kos dan mengaksesnya kapan saja.
            </p>
            <div class="space-y-2.5">
                <a href="{{ route('login') }}" class="w-full bg-[#f99d18] hover:bg-[#e08b0f] text-white py-2.5 px-4 rounded-md font-bold text-xs shadow-md transition-all flex items-center justify-center gap-2">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    <span>Masuk Ke Akun Saya</span>
                </a>
                <a href="{{ route('register') }}" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 py-2.5 px-4 rounded-md font-bold text-xs transition-all flex items-center justify-center gap-2">
                    <span>Belum Punya Akun? Daftar</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white pt-12 pb-8 border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-center items-center gap-x-6 gap-y-4 text-[13px] text-[#20344c] font-medium mb-8">
                <a href="#" class="hover:text-[#f99d18] transition-colors">Tentang Ngekosin</a>
                <span class="hidden md:inline text-gray-300">|</span>
                <a href="#" class="hover:text-[#f99d18] transition-colors flex items-center">Partner Pemilik Kos <i data-lucide="chevron-down" class="w-4 h-4 ml-1 text-slate-400"></i></a>
                <span class="hidden md:inline text-gray-300">|</span>
                <a href="#" class="hover:text-[#f99d18] transition-colors flex items-center">Layanan & Fitur <i data-lucide="chevron-down" class="w-4 h-4 ml-1 text-slate-400"></i></a>
                <span class="hidden md:inline text-gray-300">|</span>
                <a href="#" class="hover:text-[#f99d18] transition-colors">Keamanan</a>
                <span class="hidden md:inline text-gray-300">|</span>
                <a href="#" class="hover:text-[#f99d18] transition-colors">Privasi</a>
                <span class="hidden md:inline text-gray-300">|</span>
                <a href="#" class="hover:text-[#f99d18] transition-colors">Persyaratan & Ketentuan</a>
                <span class="hidden md:inline text-gray-300">|</span>
                <a href="#" class="hover:text-[#f99d18] transition-colors">Pusat Bantuan</a>
            </div>
            <div class="text-center text-[13px] text-slate-500">
                © Ngekosin 2026 By SagaraCreative. Hak cipta dilindungi undang-undang.
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Dynamic Kos Data from Database
        const KOS_LIST = @json($kosFormatted);

        // Check URL parameter for shared kos link (?kos=slug or ?id=1)
        const urlParams = new URLSearchParams(window.location.search);
        const sharedKosParam = urlParams.get('kos') || urlParams.get('id');
        let initialKos = null;
        if (sharedKosParam) {
            initialKos = KOS_LIST.find(k => k.slug === sharedKosParam || k.id == sharedKosParam);
        }

        // Active State Variables
        let activeKosId = initialKos ? initialKos.id : (KOS_LIST.length > 0 ? KOS_LIST[0].id : null);
        let activeFilters = {
            search: '',
            campus: '',
            location: '',
            category: '',
            types: [],
            facilities: [],
            maxPrice: 0,
            sortBy: 'newest'
        };

        // Initialize Page
        window.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            renderKos();
            if (initialKos && window.innerWidth < 1024) {
                openMobileDrawer(initialKos);
            }
        });

        // Format Currency Helper
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(number);
        }

        // Update Salary Slider Label
        function updateSalaryLabel(value) {
            const label = document.getElementById('priceLabel');
            activeFilters.maxPrice = parseInt(value);
            if (activeFilters.maxPrice === 0) {
                label.innerText = "Semua Harga";
            } else {
                label.innerText = `≤ Rp ${(activeFilters.maxPrice / 1000000).toFixed(1)}jt`;
            }
            renderKos();
        }

        // Handle Search Inputs (Kata Kunci, Kampus, Lokasi, Tipe)
        function handleSearch() {
            activeFilters.search = document.getElementById('searchKeyword').value.trim();
            activeFilters.campus = document.getElementById('searchCampus') ? document.getElementById('searchCampus').value : '';
            activeFilters.location = document.getElementById('searchLocation').value;
            activeFilters.category = document.getElementById('searchCategory').value;
            renderKos();
        }

        // Update filters from sidebar checkboxes
        function updateFilters() {
            const typeCheckboxes = document.querySelectorAll('input[name="kosType"]:checked');
            activeFilters.types = Array.from(typeCheckboxes).map(cb => cb.value);

            const facilityCheckboxes = document.querySelectorAll('input[name="facility"]:checked');
            activeFilters.facilities = Array.from(facilityCheckboxes).map(cb => cb.value);

            renderKos();
        }

        // Searchable Custom Dropdown Handlers
        window.toggleCustomDropdown = function(type) {
            const dropdown = document.getElementById(`${type}Dropdown`);
            const chevron = document.getElementById(`${type}Chevron`);
            const wrapper = document.getElementById(`${type}DropdownWrapper`);
            if (!dropdown) return;
            const isHidden = dropdown.classList.contains('hidden');

            // Close all custom dropdowns first
            ['campus', 'location'].forEach(t => {
                const d = document.getElementById(`${t}Dropdown`);
                const c = document.getElementById(`${t}Chevron`);
                const w = document.getElementById(`${t}DropdownWrapper`);
                if (d) d.classList.add('hidden');
                if (c) c.classList.remove('rotate-180');
                if (w) w.classList.remove('z-50');
            });

            if (isHidden) {
                dropdown.classList.remove('hidden');
                if (chevron) chevron.classList.add('rotate-180');
                if (wrapper) wrapper.classList.add('z-50');
                const searchInput = document.getElementById(`${type}SearchInput`);
                if (searchInput) {
                    searchInput.value = '';
                    filterDropdownOptions(type);
                    setTimeout(() => searchInput.focus(), 50);
                }
            }
        };

        window.filterDropdownOptions = function(type) {
            const searchInput = document.getElementById(`${type}SearchInput`);
            const filter = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const container = document.getElementById(`${type}OptionsList`);
            if (!container) return;

            const options = container.querySelectorAll('.dropdown-option');
            options.forEach(opt => {
                const text = opt.getAttribute('data-text');
                if (!text || text.includes(filter)) {
                    opt.classList.remove('hidden');
                } else {
                    opt.classList.add('hidden');
                }
            });
        };

        window.selectCustomOption = function(type, value, label) {
            const hiddenInput = document.getElementById(`search${type.charAt(0).toUpperCase() + type.slice(1)}`);
            const labelSpan = document.getElementById(`${type}SelectedLabel`);
            const dropdown = document.getElementById(`${type}Dropdown`);
            const chevron = document.getElementById(`${type}Chevron`);
            const wrapper = document.getElementById(`${type}DropdownWrapper`);

            if (hiddenInput) hiddenInput.value = value;
            if (labelSpan) labelSpan.innerText = label;
            if (dropdown) dropdown.classList.add('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
            if (wrapper) wrapper.classList.remove('z-50');

            handleSearch();
        };

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            ['campus', 'location'].forEach(type => {
                const wrapper = document.getElementById(`${type}DropdownWrapper`);
                const dropdown = document.getElementById(`${type}Dropdown`);
                const chevron = document.getElementById(`${type}Chevron`);
                if (wrapper && !wrapper.contains(e.target)) {
                    if (dropdown) dropdown.classList.add('hidden');
                    if (chevron) chevron.classList.remove('rotate-180');
                    wrapper.classList.remove('z-50');
                }
            });
        });

        // Reset All Filters
        function resetFilters() {
            document.getElementById('searchKeyword').value = '';
            if (document.getElementById('searchCampus')) document.getElementById('searchCampus').value = '';
            if (document.getElementById('campusSelectedLabel')) document.getElementById('campusSelectedLabel').innerText = 'Semua Kampus';
            if (document.getElementById('searchLocation')) document.getElementById('searchLocation').value = '';
            if (document.getElementById('locationSelectedLabel')) document.getElementById('locationSelectedLabel').innerText = 'Lokasi';
            document.getElementById('searchCategory').value = '';
            activeFilters.search = '';
            activeFilters.campus = '';
            activeFilters.location = '';
            activeFilters.category = '';

            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(cb => cb.checked = false);
            activeFilters.types = [];
            activeFilters.facilities = [];

            const slider = document.getElementById('priceRange');
            slider.value = 0;
            updateSalaryLabel(0);

            document.getElementById('sortBy').value = 'newest';
            activeFilters.sortBy = 'newest';

            renderKos();
        }

        // Handle Sort Change
        window.handleSortChange = function(value) {
            activeFilters.sortBy = value;
            renderKos();
        };

        // Render Filtered Kos Cards
        function renderKos() {
            const container = document.getElementById('kosListContainer');
            
            // Filter Logic
            const filteredKos = KOS_LIST.filter(item => {
                if (activeFilters.search) {
                    const kw = activeFilters.search.toLowerCase();
                    const matchTitle = item.title.toLowerCase().includes(kw);
                    const matchAddr = item.address.toLowerCase().includes(kw);
                    const matchDesc = item.description.toLowerCase().includes(kw);
                    const matchCampusKw = item.campuses && item.campuses.some(c => c.name.toLowerCase().includes(kw));
                    if (!matchTitle && !matchAddr && !matchDesc && !matchCampusKw) return false;
                }
                if (activeFilters.campus) {
                    const matchCampus = item.campuses && item.campuses.some(c => c.name === activeFilters.campus);
                    if (!matchCampus) return false;
                }
                if (activeFilters.location && item.location !== activeFilters.location) return false;
                if (activeFilters.category && item.category !== activeFilters.category) return false;
                if (activeFilters.types.length > 0 && !activeFilters.types.includes(item.category)) return false;
                if (activeFilters.facilities.length > 0) {
                    const hasAll = activeFilters.facilities.every(f => item.facilities.includes(f));
                    if (!hasAll) return false;
                }
                if (activeFilters.maxPrice > 0 && item.priceVal > activeFilters.maxPrice) return false;

                return true;
            });

            // Sorting logic
            if (activeFilters.sortBy === 'highest-price') {
                filteredKos.sort((a, b) => b.priceVal - a.priceVal);
            } else if (activeFilters.sortBy === 'lowest-price') {
                filteredKos.sort((a, b) => a.priceVal - b.priceVal);
            } else if (activeFilters.sortBy === 'oldest') {
                filteredKos.sort((a, b) => (a.created_at_ts || a.id) - (b.created_at_ts || b.id));
            } else if (activeFilters.sortBy === 'newest') {
                filteredKos.sort((a, b) => (b.created_at_ts || b.id) - (a.created_at_ts || a.id));
            } else if (activeFilters.campus) {
                filteredKos.sort((a, b) => {
                    const cA = a.campuses ? a.campuses.find(c => c.name === activeFilters.campus) : null;
                    const cB = b.campuses ? b.campuses.find(c => c.name === activeFilters.campus) : null;
                    const dA = cA ? cA.distance_meters : 999999;
                    const dB = cB ? cB.distance_meters : 999999;
                    return dA - dB;
                });
            }

            // Update Counter
            document.getElementById('resultsCount').innerText = filteredKos.length;

            if (filteredKos.length === 0) {
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center p-8 bg-white border border-gray-200 rounded-lg text-center shadow-sm">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-slate-500 mb-3"><i data-lucide="info" class="w-6 h-6"></i></div>
                        <p class="text-sm font-bold text-[#20344c]">Tidak ada kos ditemukan</p>
                        <p class="text-xs text-slate-500 mt-1 max-w-xs leading-relaxed">Coba ubah kata kunci atau hapus beberapa filter untuk melihat kos lainnya.</p>
                    </div>
                `;
                document.getElementById('kosDetailContainer').innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full text-center text-slate-500">
                        <i data-lucide="home" class="w-12 h-12 mb-3 stroke-1 text-gray-300"></i>
                        <p class="text-sm font-bold">Pilih kos untuk melihat detail</p>
                    </div>
                `;
                lucide.createIcons();
                return;
            }

            // Ensure active kos is in the filtered list
            const ids = filteredKos.map(k => k.id);
            if (!ids.includes(activeKosId)) {
                activeKosId = filteredKos[0].id;
            }

            // Render list
            container.innerHTML = filteredKos.map(item => {
                const isActive = item.id === activeKosId;
                const isApplied = localStorage.getItem(`applied_kos_${item.id}`) === 'true';
                
                const typeBadgeColor = item.category === 'Kos Putri' ? 'bg-pink-50 text-pink-600 border-pink-100' :
                                       item.category === 'Kos Putra' ? 'bg-blue-50 text-blue-600 border-blue-100' :
                                       'bg-purple-50 text-purple-600 border-purple-100';

                // Determine campus distance badge
                let campusBadgeHtml = '';
                if (item.campuses && item.campuses.length > 0) {
                    let targetCampus = null;
                    if (activeFilters.campus) {
                        targetCampus = item.campuses.find(c => c.name === activeFilters.campus);
                    }
                    if (!targetCampus) {
                        targetCampus = [...item.campuses].sort((a, b) => a.distance_meters - b.distance_meters)[0];
                    }
                    if (targetCampus) {
                        const isHighlighted = activeFilters.campus && targetCampus.name === activeFilters.campus;
                        const badgeClass = isHighlighted
                            ? 'bg-emerald-50 text-emerald-700 border-emerald-200 font-bold'
                            : 'bg-emerald-50/60 text-emerald-600 border-emerald-100 font-medium';
                        campusBadgeHtml = `<span class="px-2 py-0.5 rounded-md text-[11px] border ${badgeClass} flex items-center gap-1 shrink-0">${targetCampus.distance_str} ke ${targetCampus.name}</span>`;
                    }
                }

                return `
                    <div onclick="selectKos(${item.id})" class="bg-white border rounded-lg p-5 shadow-sm hover:shadow-md cursor-pointer transition-all relative overflow-hidden flex flex-col gap-3 group shrink-0 ${isActive ? 'border-[#f99d18] ring-1 ring-[#f99d18]' : 'border-gray-200'}">
                        ${isActive ? '<div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#f99d18]"></div>' : ''}
                        
                        <!-- Top Row: Photo & Title -->
                        <div class="flex items-start gap-4">
                            <img src="${item.logo}" alt="${item.title}" class="w-14 h-14 rounded-md object-cover border border-gray-100 shadow-sm shrink-0">
                            <div class="flex-grow min-w-0">
                                <h4 class="font-bold text-[#20344c] text-base leading-snug group-hover:text-[#f99d18] transition-colors truncate">${item.title}</h4>
                                <p class="text-xs font-semibold text-slate-500 mt-0.5 truncate">${item.address}</p>
                            </div>
                        </div>

                        <!-- Info Badges -->
                        <div class="flex flex-wrap gap-1.5 text-xs">
                            <span class="px-2.5 py-0.5 rounded-md font-medium border ${typeBadgeColor}">${item.category}</span>
                            <span class="px-2.5 py-0.5 rounded-md font-medium border border-amber-200 bg-amber-50 text-[#f99d18]">${item.system}</span>
                            <span class="px-2.5 py-0.5 rounded-md font-medium border border-gray-100 text-slate-500 flex items-center gap-1"><i data-lucide="map-pin" class="w-3.5 h-3.5"></i> ${item.location}</span>
                            ${campusBadgeHtml}
                        </div>

                        <!-- Bottom Row: Price & Booking Status -->
                        <div class="flex justify-between items-center border-t border-gray-50 pt-3 mt-1">
                            <div class="text-[13px] font-extrabold text-[#f99d18]">${item.priceStr}</div>
                            <div class="flex items-center gap-1.5 text-[0.7rem] text-slate-500">
                                ${isApplied ? '<span class="bg-amber-50 text-[#f99d18] px-2 py-0.5 rounded-full border border-amber-200 font-bold flex items-center gap-1"><i data-lucide="check" class="w-3 h-3"></i> Diajukan</span>' : `<span title="Terakhir diperbarui: ${item.updatedAtStr}" class="flex items-center gap-1"><i data-lucide="clock" class="w-3 h-3 text-slate-400"></i> Update ${item.lastUpdate}</span>`}
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            // Render Detail Pane
            const selectedKos = KOS_LIST.find(k => k.id === activeKosId);
            renderDetailPanel(selectedKos);
            lucide.createIcons();
        }

        // Select Kos Click
        function selectKos(id) {
            activeKosId = id;

            // Track view count
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (csrfToken) {
                fetch('/kos/' + id + '/view', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                }).catch(() => {});
            }

            if (window.innerWidth < 1024) {
                const item = KOS_LIST.find(k => k.id === id);
                openMobileDrawer(item);
            } else {
                renderKos();
            }
        }

        // Render Desktop Detail Panel
        function renderDetailPanel(item) {
            const panel = document.getElementById('kosDetailContainer');
            if (!item) return;

            const isApplied = localStorage.getItem(`applied_kos_${item.id}`) === 'true';
            const isSaved = localStorage.getItem(`saved_kos_${item.id}`) === 'true';

            const galleryPhotos = (item.images || []).filter(img => img && img !== item.logo);
            const photos = [item.logo, ...galleryPhotos];
            const mainPhoto = photos[0];
            const thumbnailsHtml = photos.map((img, idx) => `
                <button type="button" onclick="switchDetailPhoto(this, '${img}')" class="w-14 h-14 rounded-md overflow-hidden border-2 transition-all shrink-0 ${idx === 0 ? 'border-[#f99d18] ring-1 ring-[#f99d18]' : 'border-gray-200 opacity-70 hover:opacity-100'}">
                    <img src="${img}" alt="Foto Galeri ${idx+1}" class="w-full h-full object-cover">
                </button>
            `).join('');

            panel.innerHTML = `
                <div class="flex flex-col gap-6">
                    <!-- Photo Gallery Header -->
                    <div class="flex flex-col gap-2">
                        <div class="relative rounded-lg overflow-hidden group border border-gray-100 shadow-sm cursor-pointer" onclick="openLightboxImage(document.getElementById('mainDetailPhoto').src)">
                            <img id="mainDetailPhoto" src="${mainPhoto}" alt="${item.title}" class="w-full h-60 object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute bottom-2 right-2 bg-[#20344c]/80 text-white text-[11px] font-bold px-2.5 py-1 rounded-md flex items-center gap-1.5 backdrop-blur-sm shadow-md">
                                <i data-lucide="camera" class="w-3.5 h-3.5 text-[#f99d18]"></i>
                                <span>${photos.length} Foto</span>
                            </div>
                        </div>
                        ${photos.length > 1 ? `
                            <div class="flex items-center gap-2 overflow-x-auto py-1 custom-scrollbar">
                                ${thumbnailsHtml}
                            </div>
                        ` : ''}
                    </div>

                    <div class="border-b border-gray-100 pb-4">
                        <h2 class="font-extrabold text-2xl text-[#20344c] leading-tight">${item.title}</h2>
                        <div class="flex flex-wrap items-center justify-between gap-2 mt-1">
                            <p class="font-bold text-[#f99d18] text-sm">Pemilik: ${item.owner} (Terverifikasi Ngekosin)</p>
                            <span class="text-[11px] font-medium text-slate-400 flex items-center gap-1 bg-slate-50 px-2 py-0.5 rounded border border-slate-100">
                                <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i> Update ${item.lastUpdate}
                            </span>
                        </div>
                        <div class="text-xs text-slate-500 mt-2.5 flex flex-wrap items-center justify-between gap-2">
                            <span class="flex items-center gap-1.5 font-medium">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 shrink-0"></i>
                                ${item.address}
                            </span>
                            <a href="${item.google_maps_url}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-md border border-blue-200/70 transition-all shrink-0 shadow-sm">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-blue-600"></i>
                                <span>Buka Google Maps</span>
                                <i data-lucide="external-link" class="w-3 h-3 text-blue-500"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Highlights Box -->
                    <div class="grid grid-cols-3 gap-3 bg-[#F8F9FA] p-4 rounded-lg border border-gray-100 text-center">
                        <div>
                            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-500">Harga Sewa</span>
                            <p class="font-extrabold text-[#f99d18] text-sm mt-0.5">${item.priceStr}</p>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-500">Tipe Kos</span>
                            <p class="font-bold text-[#20344c] text-sm mt-0.5">${item.category}</p>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-500">Luas Kamar</span>
                            <p class="font-bold text-[#20344c] text-sm mt-0.5">${item.roomSize}</p>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="flex items-center gap-2.5">
                        <button onclick="sendWhatsAppInquiry(${item.id})" class="flex-1 bg-[#25D366] hover:bg-[#20ba5a] text-white py-2.5 px-3.5 rounded-md font-bold shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-1.5 text-xs whitespace-nowrap">
                            <svg class="w-4 h-4 shrink-0 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span>Pesan Via WhatsApp</span>
                        </button>
                        <button onclick="toggleSaveKos(${item.id})" class="border border-gray-200 text-[#20344c] px-3.5 py-2.5 rounded-md font-bold hover:bg-gray-50 transition-colors flex items-center justify-center gap-1.5 text-xs shrink-0 whitespace-nowrap">
                            <i data-lucide="bookmark" class="w-4 h-4 ${isSaved ? 'fill-[#f99d18] text-[#f99d18]' : 'text-slate-400'}"></i>
                            <span>${isSaved ? 'Tersimpan' : 'Simpan'}</span>
                        </button>
                        <button onclick="shareKos(${item.id}, '${item.title}')" class="border border-gray-200 text-[#20344c] px-3.5 py-2.5 rounded-md font-bold hover:bg-gray-50 transition-colors flex items-center justify-center gap-1.5 text-xs shrink-0 whitespace-nowrap">
                            <i data-lucide="share-2" class="w-4 h-4 text-slate-400"></i>
                            <span>Share</span>
                        </button>
                    </div>

                    <!-- Kos Details -->
                    <div class="space-y-6 pt-2">
                        <div>
                            <h3 class="font-extrabold text-base text-[#20344c] mb-2.5">Deskripsi Kos</h3>
                            <p class="text-sm text-slate-600 leading-relaxed font-medium">${item.description}</p>
                        </div>

                        ${item.campuses && item.campuses.length > 0 ? `
                        <div>
                            <h3 class="font-extrabold text-base text-[#20344c] mb-2.5 flex items-center gap-2">
                                <span>Akses Kampus Terdekat</span>
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                ${item.campuses.map(c => `
                                    <div class="bg-emerald-50/60 border border-emerald-100 rounded-lg p-3 flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-md bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 font-bold">
                                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                                        </div>
                                        <div class="min-w-0 flex-grow">
                                            <p class="font-bold text-xs text-[#20344c] truncate">${c.name}</p>
                                            <p class="text-[11px] font-bold text-emerald-700 mt-0.5">${c.distance_str}</p>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        ` : ''}

                        <div>
                            <h3 class="font-extrabold text-base text-[#20344c] mb-2.5">Fasilitas Kamar & Bangunan</h3>
                            <ul class="list-disc pl-5 text-sm text-slate-600 leading-relaxed font-medium space-y-1.5">
                                ${item.requirements.map(req => `<li>${req}</li>`).join('')}
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-extrabold text-base text-[#20344c] mb-2.5">Keunggulan & Aturan Kos</h3>
                            <ul class="list-disc pl-5 text-sm text-slate-600 leading-relaxed font-medium space-y-1.5">
                                ${item.benefits.map(ben => `<li>${ben}</li>`).join('')}
                            </ul>
                        </div>

                        <!-- Tentang Pemilik -->
                        <div class="border-t border-gray-150 pt-6 mt-6">
                            <h3 class="font-extrabold text-base text-[#20344c] mb-4">Tentang Pemilik Kos</h3>
                            <div class="bg-[#F8F9FA] p-5 rounded-lg border border-gray-200/80 flex flex-col gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-md bg-amber-100 text-[#f99d18] flex items-center justify-center font-bold text-lg border border-amber-200 shadow-sm">
                                        ${item.owner.charAt(0)}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-[#20344c] text-sm">${item.owner}</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">Pemilik Terverifikasi &bull; ${item.location}</p>
                                    </div>
                                </div>
                                <p class="text-[13px] text-slate-600 leading-relaxed font-medium">${item.ownerAbout}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Open Drawer (Mobile)
        function openMobileDrawer(item) {
            const drawer = document.getElementById('mobileDetailDrawer');
            const drawerContent = drawer.querySelector('.translate-y-full');
            const isApplied = localStorage.getItem(`applied_kos_${item.id}`) === 'true';
            const isSaved = localStorage.getItem(`saved_kos_${item.id}`) === 'true';

            document.getElementById('drawerCompLogo').src = item.logo;
            document.getElementById('drawerCompName').innerText = item.title;

            const mobileGalleryPhotos = (item.images || []).filter(img => img && img !== item.logo);
            const mobilePhotos = [item.logo, ...mobileGalleryPhotos];
            const mobileMainPhoto = mobilePhotos[0];
            const mobileThumbnailsHtml = mobilePhotos.map((img, idx) => `
                <button type="button" onclick="switchMobileDetailPhoto(this, '${img}')" class="w-12 h-12 rounded-md overflow-hidden border-2 transition-all shrink-0 ${idx === 0 ? 'border-[#f99d18] ring-1 ring-[#f99d18]' : 'border-gray-200 opacity-70 hover:opacity-100'}">
                    <img src="${img}" alt="Foto Galeri ${idx+1}" class="w-full h-full object-cover">
                </button>
            `).join('');

            document.getElementById('mobileDrawerBody').innerHTML = `
                <div class="flex flex-col gap-6 text-left">
                    <!-- Mobile Photo Gallery Header -->
                    <div class="flex flex-col gap-2">
                        <div class="relative rounded-lg overflow-hidden group border border-gray-100 shadow-sm cursor-pointer" onclick="openLightboxImage(document.getElementById('mobileMainDetailPhoto').src)">
                            <img id="mobileMainDetailPhoto" src="${mobileMainPhoto}" alt="${item.title}" class="w-full h-52 object-cover">
                            <div class="absolute bottom-2 right-2 bg-[#20344c]/80 text-white text-[10px] font-bold px-2 py-0.5 rounded-md flex items-center gap-1 backdrop-blur-sm">
                                <i data-lucide="camera" class="w-3 h-3 text-[#f99d18]"></i>
                                <span>${mobilePhotos.length} Foto</span>
                            </div>
                        </div>
                        ${mobilePhotos.length > 1 ? `
                            <div class="flex items-center gap-1.5 overflow-x-auto py-1 custom-scrollbar">
                                ${mobileThumbnailsHtml}
                            </div>
                        ` : ''}
                    </div>
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                                <i data-lucide="clock" class="w-3 h-3"></i> Update ${item.lastUpdate}
                            </span>
                            <a href="${item.google_maps_url}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-[11px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-200/70">
                                <span>Maps</span>
                                <i data-lucide="external-link" class="w-3 h-3"></i>
                            </a>
                        </div>
                        <h2 class="font-extrabold text-xl text-[#20344c] leading-tight">${item.title}</h2>
                        <p class="text-xs text-slate-500 mt-1 flex items-center gap-1"><i data-lucide="map-pin" class="w-3.5 h-3.5"></i> ${item.address}</p>
                        <p class="font-bold text-[#f99d18] text-base mt-2">${item.priceStr}</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button onclick="sendWhatsAppInquiry(${item.id})" class="flex-1 bg-[#25D366] hover:bg-[#20ba5a] text-white py-2.5 px-3 rounded-md font-bold shadow-sm transition-all flex items-center justify-center gap-1.5 text-[11px] whitespace-nowrap">
                            <svg class="w-3.5 h-3.5 shrink-0 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span>Pesan Via WhatsApp</span>
                        </button>
                        <button onclick="toggleSaveKos(${item.id})" class="border border-gray-200 text-[#20344c] px-2.5 py-2.5 rounded-md font-bold hover:bg-gray-50 transition-colors flex items-center justify-center gap-1 text-[11px] shrink-0 whitespace-nowrap">
                            <i data-lucide="bookmark" class="w-3.5 h-3.5 ${isSaved ? 'fill-[#f99d18] text-[#f99d18]' : 'text-slate-400'}"></i>
                            <span>${isSaved ? 'Tersimpan' : 'Simpan'}</span>
                        </button>
                        <button onclick="shareKos(${item.id}, '${item.title}')" class="border border-gray-200 text-[#20344c] px-2.5 py-2.5 rounded-md font-bold hover:bg-gray-50 transition-colors flex items-center justify-center gap-1 text-[11px] shrink-0 whitespace-nowrap">
                            <i data-lucide="share-2" class="w-3.5 h-3.5 text-slate-400"></i>
                            <span>Share</span>
                        </button>
                    </div>

                    <div class="space-y-5 pt-2 border-t border-gray-100">
                        <div>
                            <h3 class="font-extrabold text-sm text-[#20344c] mb-2">Deskripsi Kos</h3>
                            <p class="text-xs text-slate-600 leading-relaxed font-medium">${item.description}</p>
                        </div>

                        ${item.campuses && item.campuses.length > 0 ? `
                        <div>
                            <h3 class="font-extrabold text-sm text-[#20344c] mb-2 flex items-center gap-1.5">
                                <span>Akses Kampus Terdekat</span>
                            </h3>
                            <div class="grid grid-cols-1 gap-2">
                                ${item.campuses.map(c => `
                                    <div class="bg-emerald-50/60 border border-emerald-100 rounded-lg p-2.5 flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-md bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 font-bold">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                        </div>
                                        <div class="min-w-0 flex-grow">
                                            <p class="font-bold text-xs text-[#20344c] truncate">${c.name}</p>
                                            <p class="text-[11px] font-bold text-emerald-700">${c.distance_str}</p>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        ` : ''}

                        <div>
                            <h3 class="font-extrabold text-sm text-[#20344c] mb-2">Fasilitas Kamar & Bangunan</h3>
                            <ul class="list-disc pl-5 text-xs text-slate-600 leading-relaxed font-medium space-y-1.5">
                                ${item.requirements.map(req => `<li>${req}</li>`).join('')}
                            </ul>
                        </div>

                        ${item.benefits && item.benefits.length > 0 ? `
                        <div>
                            <h3 class="font-extrabold text-sm text-[#20344c] mb-2">Keunggulan & Aturan Kos</h3>
                            <ul class="list-disc pl-5 text-xs text-slate-600 leading-relaxed font-medium space-y-1.5">
                                ${item.benefits.map(ben => `<li>${ben}</li>`).join('')}
                            </ul>
                        </div>
                        ` : ''}

                        <!-- Tentang Pemilik -->
                        <div class="border-t border-gray-150 pt-5 mt-4">
                            <h3 class="font-extrabold text-sm text-[#20344c] mb-3">Tentang Pemilik Kos</h3>
                            <div class="bg-[#F8F9FA] p-4 rounded-lg border border-gray-200/80 flex flex-col gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-md bg-amber-100 text-[#f99d18] flex items-center justify-center font-bold text-base border border-amber-200 shadow-sm shrink-0">
                                        ${item.owner.charAt(0)}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-[#20344c] text-xs sm:text-sm">${item.owner}</h4>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Pemilik Terverifikasi &bull; ${item.location}</p>
                                    </div>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed font-medium">${item.ownerAbout}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            drawer.classList.remove('pointer-events-none');
            drawer.classList.remove('opacity-0');
            drawer.classList.add('opacity-100');
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                drawerContent.classList.remove('translate-y-full');
            }, 50);

            lucide.createIcons();
        }

        // Close Drawer (Mobile)
        function closeMobileDrawer() {
            const drawer = document.getElementById('mobileDetailDrawer');
            const drawerContent = drawer.querySelector('.transition-transform');

            document.body.style.overflow = '';
            drawerContent.classList.add('translate-y-full');
            setTimeout(() => {
                drawer.classList.add('pointer-events-none');
                drawer.classList.remove('opacity-100');
                drawer.classList.add('opacity-0');
            }, 300);
        }

        const IS_LOGGED_IN = @json(auth()->check());

        // Send Inquiry via WhatsApp Direct & Record in DB
        window.sendWhatsAppInquiry = function(id) {
            const item = KOS_LIST.find(k => k.id === id);
            if (!item) return;

            // Increment inquiry click count in DB
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (csrfToken && id) {
                fetch('/kos/' + id + '/click', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                }).catch(() => {});
            }

            const defaultMsg = `Halo ${item.owner}, saya mendapatkan informasi ${item.title} dari Aplikasi Ngekosin. Apakah masih ada kamar yang tersedia?`;
            const phone = item.ownerPhone ? item.ownerPhone.replace(/[^0-9]/g, '') : '6281234567890';
            const waUrl = `https://wa.me/${phone}?text=${encodeURIComponent(defaultMsg)}`;

            window.open(waUrl, '_blank');
        };

        // Gallery Helper Functions
        window.switchDetailPhoto = function(btn, src) {
            const mainImg = document.getElementById('mainDetailPhoto');
            if (mainImg) mainImg.src = src;
            if (btn && btn.parentElement) {
                btn.parentElement.querySelectorAll('button').forEach(b => {
                    b.classList.remove('border-[#f99d18]', 'ring-1', 'ring-[#f99d18]', 'opacity-100');
                    b.classList.add('border-gray-200', 'opacity-70');
                });
                btn.classList.remove('border-gray-200', 'opacity-70');
                btn.classList.add('border-[#f99d18]', 'ring-1', 'ring-[#f99d18]', 'opacity-100');
            }
        };

        window.switchMobileDetailPhoto = function(btn, src) {
            const mainImg = document.getElementById('mobileMainDetailPhoto');
            if (mainImg) mainImg.src = src;
            if (btn && btn.parentElement) {
                btn.parentElement.querySelectorAll('button').forEach(b => {
                    b.classList.remove('border-[#f99d18]', 'ring-1', 'ring-[#f99d18]', 'opacity-100');
                    b.classList.add('border-gray-200', 'opacity-70');
                });
                btn.classList.remove('border-gray-200', 'opacity-70');
                btn.classList.add('border-[#f99d18]', 'ring-1', 'ring-[#f99d18]', 'opacity-100');
            }
        };

        window.openLightboxImage = function(src) {
            let modal = document.getElementById('lightboxModal');
            if (!modal) {
                modal = document.createElement('div');
                modal.id = 'lightboxModal';
                modal.onclick = function(e) { if (e.target === this) this.classList.add('hidden'); };
                modal.className = 'fixed inset-0 bg-black/90 z-[150] flex items-center justify-center p-4 transition-all duration-300 hidden';
                modal.innerHTML = `
                    <div class="relative max-w-4xl w-full max-h-[90vh] flex items-center justify-center">
                        <button onclick="document.getElementById('lightboxModal').classList.add('hidden')" class="absolute -top-10 right-0 text-white hover:text-[#f99d18] p-2 text-sm font-bold flex items-center gap-1">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                        <img id="lightboxImage" src="" class="max-w-full max-h-[85vh] rounded-lg object-contain shadow-2xl">
                    </div>
                `;
                document.body.appendChild(modal);
            }
            document.getElementById('lightboxImage').src = src;
            modal.classList.remove('hidden');
            lucide.createIcons();
        };

        // Auth Modal Helper Functions
        window.openAuthModal = function() {
            const modal = document.getElementById('authModal');
            if (!modal) return;
            const content = modal.querySelector('div');
            modal.classList.remove('pointer-events-none', 'opacity-0');
            modal.classList.add('opacity-100');
            if (content) {
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }
        };

        window.closeAuthModal = function() {
            const modal = document.getElementById('authModal');
            if (!modal) return;
            const content = modal.querySelector('div');
            if (content) {
                content.classList.remove('scale-100');
                content.classList.add('scale-95');
            }
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
        };

        // Toggle Save Kos (Requires Auth)
        window.toggleSaveKos = function(id) {
            if (!IS_LOGGED_IN) {
                openAuthModal();
                return;
            }
            const key = `saved_kos_${id}`;
            const wasSaved = localStorage.getItem(key) === 'true';
            localStorage.setItem(key, wasSaved ? 'false' : 'true');
            renderKos();
            showToast(wasSaved ? 'Kos dihapus dari daftar simpan' : 'Kos berhasil disimpan!');
        };

        // Share Kos link (SEO Friendly URL with Web Share API / Clipboard Fallback)
        window.shareKos = function(id, title) {
            const item = KOS_LIST.find(k => k.id === id || k.slug === id);
            const slug = item ? item.slug : id;
            const shareUrl = `${window.location.origin}${window.location.pathname}?kos=${slug}`;
            const shareTitle = title || (item ? item.title : 'Kos Ngekosin');

            if (navigator.share) {
                navigator.share({
                    title: shareTitle,
                    text: `Lihat kos "${shareTitle}" di Ngekosin:`,
                    url: shareUrl
                }).catch(() => {
                    copyShareUrl(shareUrl, shareTitle);
                });
            } else {
                copyShareUrl(shareUrl, shareTitle);
            }
        };

        function copyShareUrl(url, title) {
            navigator.clipboard.writeText(url).then(() => {
                showToast(`Tautan kos "${title}" berhasil disalin!`);
            }).catch(err => {
                console.error("Gagal menyalin: ", err);
            });
        }

        // Toast Notification System
        function showToast(message) {
            let toast = document.getElementById('toastNotification');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'toastNotification';
                toast.className = 'fixed bottom-5 right-5 bg-[#20344c] text-white px-5 py-3.5 rounded-md shadow-2xl z-[110] text-sm font-semibold flex items-center gap-2 transition-all duration-300 transform translate-y-10 opacity-0';
                document.body.appendChild(toast);
            }
            toast.innerHTML = `<i data-lucide="info" class="w-4 h-4 text-[#f99d18]"></i> <span>${message}</span>`;
            lucide.createIcons();
            
            toast.classList.remove('translate-y-10', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
            
            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-10', 'opacity-0');
            }, 2500);
        }
    </script>
</body>
</html>
