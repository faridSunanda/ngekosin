@extends('layouts.dashboard')

@section('title', 'Profil Saya')
@section('portal_name', ucfirst($user->role) . ' Portal')
@section('breadcrumb_current', 'Profil Saya')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header Banner -->
        <div class="relative bg-gradient-to-r from-[#20344c] via-[#1a2d42] to-[#142334] text-white p-6 sm:p-8 rounded-lg shadow-xl overflow-hidden border border-[#2c4361]">
            <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-[#f99d18]/20 border-2 border-[#f99d18] text-[#f99d18] flex items-center justify-center font-extrabold text-2xl shrink-0 shadow-lg">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold text-white tracking-tight">{{ $user->name }}</h1>
                        <p class="text-xs text-slate-300 mt-0.5 flex items-center gap-2">
                            <span>{{ $user->email }}</span>
                            <span>•</span>
                            <span class="capitalize px-2 py-0.5 bg-[#f99d18] text-white text-[10px] font-extrabold rounded-[3px]">
                                {{ $user->role === 'admin' ? 'Administrator' : ($user->role === 'owner' ? 'Pemilik Kos' : 'Pencari Kos') }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Notification -->
        @if (session('success'))
            <div class="p-4 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2 shadow-xs">
                <x-lucide-check-circle-2 class="w-4 h-4 text-emerald-600 shrink-0" />
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Profile Form Card -->
        <div class="bg-white rounded-lg border border-slate-200/80 p-6 sm:p-8 shadow-xs">
            <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Section 1: Information Details -->
                <div>
                    <h3 class="text-sm font-extrabold text-[#20344c] uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2 mb-4">
                        <x-lucide-user class="w-4 h-4 text-[#f99d18]" />
                        <span>Informasi Data Diri</span>
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c] font-medium">
                            @error('name') <span class="text-[11px] text-rose-500 font-medium block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Alamat Email <span class="text-rose-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c] font-medium">
                            @error('email') <span class="text-[11px] text-rose-500 font-medium block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Nomor WhatsApp / HP <span class="text-rose-500">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890" required
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c] font-medium">
                            @error('phone') <span class="text-[11px] text-rose-500 font-medium block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Security & Password Update -->
                <div>
                    <h3 class="text-sm font-extrabold text-[#20344c] uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2 mb-4">
                        <x-lucide-lock class="w-4 h-4 text-[#f99d18]" />
                        <span>Keamanan & Ubah Kata Sandi</span>
                    </h3>

                    <div class="p-4 rounded-md bg-amber-50/60 border border-amber-200/80 mb-4 text-xs text-amber-800 flex items-start gap-2">
                        <x-lucide-info class="w-4 h-4 text-[#f99d18] shrink-0 mt-0.5" />
                        <span>Kosongkan bidang kata sandi di bawah jika Anda tidak ingin mengubah kata sandi akun Anda saat ini.</span>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" placeholder="Masukkan kata sandi saat ini jika ingin diubah"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                            @error('current_password') <span class="text-[11px] text-rose-500 font-medium block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-[#20344c] mb-1">Kata Sandi Baru</label>
                                <input type="password" name="password" placeholder="Minimal 8 karakter"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                                @error('password') <span class="text-[11px] text-rose-500 font-medium block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[#20344c] mb-1">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation" placeholder="Ketik ulang kata sandi baru"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-[#f99d18] hover:bg-[#e08b0f] text-white font-extrabold text-xs rounded-md transition shadow-md flex items-center gap-2">
                        <span>Simpan Perubahan Profil</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
