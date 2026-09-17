<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - Ngekosin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#F8F9FA] text-[#20344c] min-h-screen flex flex-col justify-between antialiased">

    <!-- Top Simple Header -->
    <header class="bg-[#20344c] py-4 px-6 shadow-md border-b border-[#162537]">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5">
                <div class="w-9 h-9 flex items-center justify-center bg-[#f99d18]/20 text-[#f99d18] rounded-md border border-[#f99d18]/30">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Ngekosin" class="rounded-md">
                </div>
                <span class="text-xl font-bold text-white tracking-tight">
                    Ngekosin<span class="text-[#f99d18]">.</span>
                </span>
            </a>
        </div>
    </header>

    <!-- Main Auth Container -->
    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-lg">
            
            <!-- Auth Card -->
            <div class="bg-white rounded-lg p-8 shadow-xl border border-gray-200/80">
                
                <div class="text-center mb-6">
                    <div class="flex items-center justify-center gap-2.5">
                        <div class="w-12 h-12 flex items-center justify-center">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Ngekosin" class="rounded-md">
                        </div>
                    </div>
                    <h1 class="text-2xl font-extrabold text-[#20344c]">Buat Akun Ngekosin</h1>
                    <p class="text-xs text-slate-500 font-medium mt-1">Daftar sebagai pencari kos atau pemilik kos</p>
                </div>

                <!-- Error Alerts -->
                @if ($errors->any())
                    <div class="mb-5 p-3.5 bg-red-50 border border-red-200 rounded-md text-red-700 text-xs font-semibold space-y-1">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-center gap-2">
                                <x-lucide-alert-circle class="w-4 h-4 text-red-500 shrink-0" />
                                <span>{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Register Form -->
                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Role Selection Cards -->
                    <div>
                        <label class="block text-xs font-bold text-[#20344c] uppercase tracking-wider mb-2">Daftar Sebagai <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-3">
                            <label id="role-label-user" onclick="selectRole('user')" class="p-3.5 rounded-md border-2 cursor-pointer transition flex items-center gap-3 border-[#f99d18] bg-amber-50/50">
                                <input type="radio" name="role" value="user" {{ old('role', $selectedRole) === 'user' ? 'checked' : '' }} class="hidden">
                                <div class="w-9 h-9 rounded-md bg-amber-100 text-[#f99d18] flex items-center justify-center shrink-0">
                                    <x-lucide-user class="w-5 h-5" />
                                </div>
                                <div class="min-w-0">
                                    <span class="block text-xs font-bold text-[#20344c]">Pencari Kos</span>
                                    <span class="block text-[10px] text-slate-500 truncate">Cari & sewa kos</span>
                                </div>
                            </label>

                            <label id="role-label-owner" onclick="selectRole('owner')" class="p-3.5 rounded-md border-2 cursor-pointer transition flex items-center gap-3 border-gray-200 bg-white">
                                <input type="radio" name="role" value="owner" {{ old('role', $selectedRole) === 'owner' ? 'checked' : '' }} class="hidden">
                                <div class="w-9 h-9 rounded-md bg-slate-100 text-slate-500 flex items-center justify-center shrink-0">
                                    <x-lucide-home class="w-5 h-5" />
                                </div>
                                <div class="min-w-0">
                                    <span class="block text-xs font-bold text-[#20344c]">Pemilik Kos</span>
                                    <span class="block text-[10px] text-slate-500 truncate">Sewakan properti</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-[#20344c] uppercase tracking-wider mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap" class="w-full bg-[#F8F9FA] border border-gray-200 rounded-md py-3 pl-10 pr-4 text-sm focus:outline-none focus:border-[#f99d18] focus:ring-1 focus:ring-[#f99d18] font-medium transition-all">
                            <x-lucide-user class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" />
                        </div>
                    </div>

                    <!-- Email & Phone Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label for="email" class="block text-xs font-bold text-[#20344c] uppercase tracking-wider mb-2">Email <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="email@domain.com" class="w-full bg-[#F8F9FA] border border-gray-200 rounded-md py-3 pl-10 pr-4 text-sm focus:outline-none focus:border-[#f99d18] focus:ring-1 focus:ring-[#f99d18] font-medium transition-all">
                                <x-lucide-mail class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" />
                            </div>
                        </div>

                        <div>
                            <label for="phone" class="block text-xs font-bold text-[#20344c] uppercase tracking-wider mb-2">No. WhatsApp <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx" class="w-full bg-[#F8F9FA] border border-gray-200 rounded-md py-3 pl-10 pr-4 text-sm focus:outline-none focus:border-[#f99d18] focus:ring-1 focus:ring-[#f99d18] font-medium transition-all">
                                <x-lucide-phone class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" />
                            </div>
                        </div>
                    </div>

                    <!-- Password Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label for="password" class="block text-xs font-bold text-[#20344c] uppercase tracking-wider mb-2">Kata Sandi <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required placeholder="••••••••" class="w-full bg-[#F8F9FA] border border-gray-200 rounded-md py-3 pl-10 pr-4 text-sm focus:outline-none focus:border-[#f99d18] focus:ring-1 focus:ring-[#f99d18] font-medium transition-all">
                                <x-lucide-lock class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" />
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-[#20344c] uppercase tracking-wider mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••" class="w-full bg-[#F8F9FA] border border-gray-200 rounded-md py-3 pl-10 pr-4 text-sm focus:outline-none focus:border-[#f99d18] focus:ring-1 focus:ring-[#f99d18] font-medium transition-all">
                                <x-lucide-shield-check class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" />
                            </div>
                        </div>
                    </div>

                    <!-- Terms Checkbox -->
                    <div class="pt-1">
                        <label class="flex items-start gap-2.5 text-xs text-slate-600 font-medium cursor-pointer">
                            <input type="checkbox" name="terms" value="1" required class="w-4 h-4 rounded text-[#f99d18] focus:ring-[#f99d18] border-gray-300 accent-[#f99d18] mt-0.5">
                            <span>Saya menyetujui <a href="#" class="text-[#f99d18] font-bold hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-[#f99d18] font-bold hover:underline">Kebijakan Privasi</a> Ngekosin.</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-[#f99d18] hover:bg-[#e08b0f] text-white py-3.5 px-6 rounded-md font-bold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 text-sm mt-2">
                        <x-lucide-user-plus class="w-4 h-4" />
                        <span>Daftar Akun Sekarang</span>
                    </button>
                </form>

                <!-- Footer Link -->
                <div class="mt-6 text-center pt-6 border-t border-gray-100">
                    <p class="text-xs text-slate-500 font-medium">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}" class="text-[#f99d18] font-bold hover:underline ml-1">Masuk di sini</a>
                    </p>
                </div>

            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white py-4 border-t border-gray-200 text-center text-xs text-slate-500 font-medium">
        © Ngekosin 2026. Hak cipta dilindungi undang-undang.
    </footer>

    <script>
        function selectRole(role) {
            const userLabel = document.getElementById('role-label-user');
            const ownerLabel = document.getElementById('role-label-owner');

            if (role === 'user') {
                userLabel.className = 'p-3.5 rounded-2xl border-2 cursor-pointer transition flex items-center gap-3 border-[#f99d18] bg-amber-50/50';
                ownerLabel.className = 'p-3.5 rounded-2xl border-2 cursor-pointer transition flex items-center gap-3 border-gray-200 bg-white';
                userLabel.querySelector('input').checked = true;
            } else {
                ownerLabel.className = 'p-3.5 rounded-2xl border-2 cursor-pointer transition flex items-center gap-3 border-[#f99d18] bg-amber-50/50';
                userLabel.className = 'p-3.5 rounded-2xl border-2 cursor-pointer transition flex items-center gap-3 border-gray-200 bg-white';
                ownerLabel.querySelector('input').checked = true;
            }
        }
    </script>
</body>
</html>
