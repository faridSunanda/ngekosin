<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun - Ngekosin</title>

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
                <div class="w-9 h-9 flex items-center justify-center bg-[#f99d18]/20 text-[#f99d18] rounded-xl border border-[#f99d18]/30">
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
        <div class="w-full max-w-md">
            
            <!-- Auth Card -->
            <div class="bg-white rounded-lg p-8 shadow-xl border border-gray-200/80">
                <div class="flex items-center justify-center gap-2.5">
                    <div class="w-12 h-12 flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Ngekosin" class="rounded-md">
                    </div>
                </div>
                
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-extrabold text-[#20344c]">Masuk ke Akun Anda</h1>
                    <p class="text-xs text-slate-500 font-medium mt-1">Pilih role atau masukkan email & password Anda</p>
                </div>

                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 rounded-md text-emerald-800 text-xs font-semibold flex items-center gap-2">
                        <x-lucide-check-circle-2 class="w-4 h-4 text-emerald-600 shrink-0" />
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('info'))
                    <div class="mb-5 p-3.5 bg-blue-50 border border-blue-200 rounded-md text-blue-800 text-xs font-semibold flex items-center gap-2">
                        <x-lucide-info class="w-4 h-4 text-blue-600 shrink-0" />
                        <span>{{ session('info') }}</span>
                    </div>
                @endif

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

                <!-- Demo Quick Login Buttons for 3 Roles -->
                <div class="mb-6 p-3.5 bg-slate-50 border border-slate-200/80 rounded-md">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2 text-center">Uji Coba Demo Auto Login</span>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" onclick="fillQuickLogin('user@ngekosin.com', 'password')" class="py-2 px-1 text-[11px] font-bold bg-white border border-gray-200 hover:border-[#f99d18] hover:text-[#f99d18] text-[#20344c] rounded-md shadow-xs transition text-center flex flex-col items-center gap-1">
                            <x-lucide-user class="w-4 h-4 text-[#f99d18]" />
                            <span>Pencari Kos</span>
                        </button>
                        <button type="button" onclick="fillQuickLogin('owner@ngekosin.com', 'password')" class="py-2 px-1 text-[11px] font-bold bg-white border border-gray-200 hover:border-[#f99d18] hover:text-[#f99d18] text-[#20344c] rounded-md shadow-xs transition text-center flex flex-col items-center gap-1">
                            <x-lucide-home class="w-4 h-4 text-[#f99d18]" />
                            <span>Pemilik Kos</span>
                        </button>
                        <button type="button" onclick="fillQuickLogin('admin@ngekosin.com', 'password')" class="py-2 px-1 text-[11px] font-bold bg-white border border-gray-200 hover:border-[#f99d18] hover:text-[#f99d18] text-[#20344c] rounded-md shadow-xs transition text-center flex flex-col items-center gap-1">
                            <x-lucide-shield-check class="w-4 h-4 text-[#f99d18]" />
                            <span>Admin</span>
                        </button>
                    </div>
                </div>

                <!-- Login Form -->
                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-xs font-bold text-[#20344c] uppercase tracking-wider mb-2">Alamat Email</label>
                        <div class="relative">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="contoh@ngekosin.com" class="w-full bg-[#F8F9FA] border border-gray-200 rounded-md py-3 pl-10 pr-4 text-sm focus:outline-none focus:border-[#f99d18] focus:ring-1 focus:ring-[#f99d18] font-medium transition-all">
                            <x-lucide-mail class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" />
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-xs font-bold text-[#20344c] uppercase tracking-wider">Kata Sandi</label>
                            <a href="#" class="text-xs text-[#f99d18] hover:underline font-semibold">Lupa Password?</a>
                        </div>
                        <div class="relative">
                            <input type="password" id="password" name="password" required placeholder="••••••••" class="w-full bg-[#F8F9FA] border border-gray-200 rounded-md py-3 pl-10 pr-10 text-sm focus:outline-none focus:border-[#f99d18] focus:ring-1 focus:ring-[#f99d18] font-medium transition-all">
                            <x-lucide-lock class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" />
                            <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3.5 top-3.5 text-slate-400 hover:text-slate-600">
                                <x-lucide-eye id="eye-icon" class="w-4 h-4" />
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 text-xs text-slate-600 font-medium cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-[#f99d18] focus:ring-[#f99d18] border-gray-300 accent-[#f99d18]">
                            <span>Ingat Saya</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-[#f99d18] hover:bg-[#e08b0f] text-white py-3.5 px-6 rounded-md font-bold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 text-sm mt-2">
                        <span>Masuk Sekarang</span>
                    </button>
                </form>

                <!-- Footer Link -->
                <div class="mt-8 text-center pt-6 border-t border-gray-100">
                    <p class="text-xs text-slate-500 font-medium">
                        Belum memiliki akun Ngekosin?
                        <a href="{{ route('register') }}" class="text-[#f99d18] font-bold hover:underline ml-1">Daftar Sekarang</a>
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
        function togglePasswordVisibility() {
            const field = document.getElementById('password');
            if (field.type === 'password') {
                field.type = 'text';
            } else {
                field.type = 'password';
            }
        }

        function fillQuickLogin(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</body>
</html>
