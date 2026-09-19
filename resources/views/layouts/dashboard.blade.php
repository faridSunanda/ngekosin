<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Ngekosin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-transition {
            transition: transform 0.3s ease-in-out, width 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-[#F4F6F9] text-[#20344c] antialiased min-h-screen flex flex-col">

    <div class="flex flex-1 min-h-screen relative overflow-x-hidden">

        <!-- Sidebar -->
        <aside id="sidebar" class="flex w-64 bg-[#182739] text-white flex-col fixed inset-y-0 left-0 z-40 sidebar-transition shadow-xl border-r border-[#20344c] -translate-x-full md:translate-x-0">
            <!-- Sidebar Header / Brand Logo -->
            <div class="h-16 px-5 flex items-center justify-between border-b border-[#24374e] bg-[#142131]">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 font-bold text-lg text-white">
                    <div class="w-9 h-9 text-white rounded-md flex items-center justify-center font-extrabold shadow-md">
                       <img src="{{asset('images/logo.png')}}" alt="" class="rounded-md">
                    </div>
                    <div class="leading-tight">
                        <span class="block font-black text-white text-base tracking-tight mb-[-5px]">Ngekosin</span>
                        <span class="text-[10px] text-[#f99d18] uppercase tracking-wider font-semibold">@yield('portal_name', 'Backoffice')</span>
                    </div>
                </a>
                <button id="close-sidebar-mobile" class="md:hidden text-gray-400 hover:text-white p-1 focus:outline-none">
                    <x-lucide-x class="w-5 h-5" />
                </button>
            </div>

            <!-- Sidebar Navigation List -->
            <div class="flex-1 overflow-y-auto py-5 px-3 space-y-6 scrollbar-thin">
                @if (View::hasSection('sidebar_menu'))
                    @yield('sidebar_menu')
                @elseif (Auth::check() && View::exists('layouts.partials.sidebar-' . Auth::user()->role))
                    @include('layouts.partials.sidebar-' . Auth::user()->role)
                @endif
            </div>

            <!-- Sidebar Footer / Quick User Info -->
            <div class="p-3 border-t border-[#24374e] bg-[#142131]">
                <div class="flex items-center justify-between p-2 rounded-md bg-[#1c2d43]">
                    <div class="flex items-center gap-2.5 overflow-hidden">
                        <div class="w-8 h-8 rounded-full bg-[#f99d18]/20 text-[#f99d18] border border-[#f99d18]/30 flex items-center justify-center font-bold text-xs shrink-0">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="truncate text-xs">
                            <p class="font-bold text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-gray-400 capitalize">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" title="Logout" class="p-1.5 text-red-400 hover:text-white hover:bg-red-500/20 rounded-lg transition">
                            <x-lucide-door-open class="w-4 h-4" />
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Sidebar Overlay Mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden"></div>

        <!-- Main Wrapper Content (Shifted right for fixed sidebar on desktop) -->
        <div id="main-content" class="flex-1 flex flex-col md:ml-64 transition-all duration-300 min-w-0">

            <!-- Top Header Navbar -->
            <header class="bg-white border-b border-slate-200 h-16 sticky top-0 z-20 flex items-center justify-between px-4 sm:px-6 shadow-sm">
                <!-- Left: Toggle Sidebar + Breadcrumb -->
                <div class="flex items-center gap-3">
                    <button id="toggle-sidebar" class="p-2 rounded-md text-slate-600 hover:bg-slate-100 hover:text-[#20344c] transition focus:outline-none" aria-label="Toggle Sidebar">
                        <x-lucide-menu class="w-5 h-5" />
                    </button>
                    
                    <a href="{{ route('home') }}" class="md:hidden flex items-center gap-2 font-extrabold text-sm text-[#20344c]">
                        <img src="{{ asset('images/logo.png') }}" class="w-7 h-7 rounded" alt="Logo">
                        <span>Ngekosin</span>
                    </a>

                    <nav class="hidden sm:flex items-center gap-2 text-xs text-slate-500 font-medium">
                        <a href="{{ route('home') }}" class="hover:text-[#f99d18] flex items-center gap-1 transition">
                            <x-lucide-home class="w-3.5 h-3.5" />
                            <span>Home</span>
                        </a>
                        <x-lucide-chevron-right class="w-3.5 h-3.5 text-slate-300" />
                        <span class="text-[#20344c] font-bold">@yield('breadcrumb_current', 'Dashboard')</span>
                    </nav>
                </div>

                <!-- Right: Quick User Info & Logout Button -->
                <div class="md:hidden flex items-center gap-3">
                    @if (Auth::check())
                        <div class="flex items-center gap-2">
                            <div class="text-right text-xs hidden sm:block">
                                <p class="font-bold text-[#20344c]">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-slate-400 capitalize">{{ Auth::user()->role }}</p>
                            </div>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition flex items-center gap-1.5 text-xs font-bold" title="Logout">
                                    <x-lucide-door-open class="w-4 h-4" />
                                    <span class="text-xs">Keluar</span>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </header>

            <!-- Main Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>

            <!-- Bottom Footer -->
            <footer class="bg-white border-t border-slate-200 py-4 px-6 text-center md:text-left text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-2">
                <div>
                    © Ngekosin 2026 By SagaraCreative. Hak cipta dilindungi undang-undang.
                </div>
            </footer>
        </div>

    </div>

    <!-- Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleBtn = document.getElementById('toggle-sidebar');
            const closeBtn = document.getElementById('close-sidebar-mobile');
            const overlay = document.getElementById('sidebar-overlay');

            let isCollapsed = false;

            function toggleSidebar() {
                if (window.innerWidth < 768) {
                    sidebar.style.transform = '';
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                } else {
                    isCollapsed = !isCollapsed;
                    if (isCollapsed) {
                        sidebar.style.transform = 'translateX(-100%)';
                        mainContent.classList.remove('md:ml-64');
                        mainContent.classList.add('md:ml-0');
                    } else {
                        sidebar.style.transform = 'translateX(0)';
                        mainContent.classList.remove('md:ml-0');
                        mainContent.classList.add('md:ml-64');
                    }
                }
            }

            toggleBtn?.addEventListener('click', toggleSidebar);
            closeBtn?.addEventListener('click', toggleSidebar);
            overlay?.addEventListener('click', toggleSidebar);

            sidebar?.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 768 && !sidebar.classList.contains('-translate-x-full')) {
                        sidebar.classList.add('-translate-x-full');
                        overlay.classList.add('hidden');
                    }
                });
            });
        });
    </script>
</body>
</html>
