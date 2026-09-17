@extends('layouts.dashboard')

@section('title', 'Edit Properti Kos')
@section('portal_name', 'Admin Panel')
@section('breadcrumb_current', 'Edit Kos')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-extrabold text-[#20344c]">Edit Properti Kos</h1>
                <p class="text-xs text-slate-500 mt-1">Ubah data properti kos "{{ $ko->name }}".</p>
            </div>
            <a href="{{ route('admin.kos.index') }}" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-md transition flex items-center gap-1.5">
                <x-lucide-arrow-left class="w-4 h-4" />
                <span>Kembali</span>
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-md border border-slate-200 p-6 shadow-xs">
            <form action="{{ route('admin.kos.update', $ko->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Info & Pricing Section -->
                <div>
                    <h3 class="font-bold text-[#20344c] text-sm mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                        <x-lucide-info class="w-4 h-4 text-[#f99d18]" />
                        Informasi Utama & Skema Harga
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Nama Kos <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $ko->name) }}" required
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                            @error('name') <span class="text-[11px] text-red-500 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Pemilik Kos (Owner)</label>
                            <select name="user_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                                <option value="">-- Pilih Owner (Atau Admin Default) --</option>
                                @foreach ($owners as $owner)
                                    <option value="{{ $owner->id }}" {{ old('user_id', $ko->user_id) == $owner->id ? 'selected' : '' }}>
                                        {{ $owner->name }} ({{ $owner->phone }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Tipe Penghuni Kos <span class="text-red-500">*</span></label>
                            <select name="type" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                                <option value="campur" {{ old('type', $ko->type) == 'campur' ? 'selected' : '' }}>Campur</option>
                                <option value="putra" {{ old('type', $ko->type) == 'putra' ? 'selected' : '' }}>Khusus Putra</option>
                                <option value="putri" {{ old('type', $ko->type) == 'putri' ? 'selected' : '' }}>Khusus Putri</option>
                            </select>
                        </div>

                        <!-- Pricing Details Box -->
                        <div class="md:col-span-2 bg-amber-50/50 p-4 rounded-md border border-amber-200/80 space-y-4">
                            <h4 class="text-xs font-extrabold text-[#20344c] uppercase tracking-wider flex items-center gap-1.5">
                                <x-lucide-coins class="w-4 h-4 text-[#f99d18]" />
                                Rincian Skema Harga & Kapasitas
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-[#20344c] mb-1">Harga / Bulan (1 Orang) <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2 text-xs font-bold text-slate-400">Rp</span>
                                        <input type="number" name="price_per_month" value="{{ old('price_per_month', $ko->price_per_month) }}" required
                                               class="w-full pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-[#20344c] mb-1">Sewa Harian (Opsional)</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2 text-xs font-bold text-slate-400">Rp</span>
                                        <input type="number" name="price_per_day" value="{{ old('price_per_day', $ko->price_per_day) }}" placeholder="Contoh: 150000"
                                               class="w-full pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                                    </div>
                                    <span class="text-[10px] text-slate-400 mt-0.5 block">Kosongkan jika tidak ada</span>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-[#20344c] mb-1">Sewa Mingguan (Opsional)</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2 text-xs font-bold text-slate-400">Rp</span>
                                        <input type="number" name="price_per_week" value="{{ old('price_per_week', $ko->price_per_week) }}" placeholder="Contoh: 600000"
                                               class="w-full pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                                    </div>
                                    <span class="text-[10px] text-slate-400 mt-0.5 block">Kosongkan jika tidak ada</span>
                                </div>
                            </div>

                            <!-- Occupancy 2 Persons Option -->
                            <div class="pt-3 border-t border-amber-200/60">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="allow_two_people" id="allowTwoPeople" value="1" {{ old('allow_two_people', $ko->allow_two_people) ? 'checked' : '' }} onchange="toggleTwoPeoplePrice()"
                                           class="rounded text-[#f99d18] focus:ring-0">
                                    <span class="text-xs font-bold text-[#20344c]">Boleh diisi 2 Orang dalam 1 Kamar?</span>
                                </label>

                                <div id="twoPeopleContainer" class="mt-3 {{ old('allow_two_people', $ko->allow_two_people) ? '' : 'hidden' }}">
                                    <label class="block text-xs font-bold text-[#20344c] mb-1">Harga Sewa / Bulan untuk 2 Orang (Rp)</label>
                                    <div class="relative max-w-sm">
                                        <span class="absolute left-3 top-2 text-xs font-bold text-slate-400">Rp</span>
                                        <input type="number" name="price_2_persons" value="{{ old('price_2_persons', $ko->price_2_persons) }}" placeholder="Contoh: 2000000"
                                               class="w-full pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                                    </div>
                                    <span class="text-[10px] text-slate-500 mt-0.5 block">Harga total sewa per bulan jika kamar dihuni oleh 2 orang</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location & Rooms Section -->
                <div>
                    <h3 class="font-bold text-[#20344c] text-sm mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                        <x-lucide-map-pin class="w-4 h-4 text-[#f99d18]" />
                        Lokasi & Kamar
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-3">
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Alamat Lengkap Kos <span class="text-red-500">*</span></label>
                            <textarea name="address" rows="2" required
                                      class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">{{ old('address', $ko->address) }}</textarea>
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Link Google Maps (URL)</label>
                            <input type="url" name="google_maps_url" value="{{ old('google_maps_url', $ko->google_maps_url) }}" placeholder="https://maps.app.goo.gl/xxx atau https://goo.gl/maps/xxx"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                            <span class="text-[10px] text-slate-400 mt-0.5 block">Paste link lokasi Google Maps kos agar calon penyewa bisa membuka langsung titik lokasinya</span>
                            @error('google_maps_url') <span class="text-[11px] text-red-500 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- Cascading Region Selectors -->
                        <div>
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Provinsi <span class="text-red-500">*</span></label>
                            <select id="provinceSelect" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                                <option value="">-- Memuat Provinsi... --</option>
                            </select>
                            <input type="hidden" name="province" id="provinceInput" value="{{ old('province', $ko->province ?? 'Jawa Tengah') }}">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Kota / Kabupaten <span class="text-red-500">*</span></label>
                            <select id="citySelect" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                                <option value="">-- Pilih Provinsi Dahulu --</option>
                            </select>
                            <input type="hidden" name="city" id="cityInput" value="{{ old('city', $ko->city) }}">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Kecamatan / Area</label>
                            <select id="districtSelect" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                                <option value="">-- Pilih Kota Dahulu --</option>
                            </select>
                            <input type="hidden" name="district" id="districtInput" value="{{ old('district', $ko->district) }}">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Kelurahan / Desa</label>
                            <select id="villageSelect" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                                <option value="">-- Pilih Kecamatan Dahulu --</option>
                            </select>
                            <input type="hidden" name="village" id="villageInput" value="{{ old('village', $ko->village) }}">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Total Kamar <span class="text-red-500">*</span></label>
                            <input type="number" name="total_rooms" value="{{ old('total_rooms', $ko->total_rooms) }}" required min="1"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Kamar Tersedia <span class="text-red-500">*</span></label>
                            <input type="number" name="available_rooms" value="{{ old('available_rooms', $ko->available_rooms) }}" required min="0"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                        </div>
                    </div>
                </div>

                <!-- Campus Proximity Section (Opsional) -->
                <div>
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100 mb-3">
                        <h3 class="font-bold text-[#20344c] text-sm flex items-center gap-2">
                            <x-lucide-graduation-cap class="w-4 h-4 text-[#f99d18]" />
                            Kampus Terdekat & Jarak (Opsional)
                        </h3>
                        <button type="button" onclick="addCampusRow()" class="px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-[#f99d18] font-bold text-xs rounded border border-amber-200 transition flex items-center gap-1">
                            <x-lucide-plus class="w-3.5 h-3.5" />
                            <span>Tambah Kampus</span>
                        </button>
                    </div>
                    <p class="text-[11px] text-slate-500 mb-3">Pilih kampus terdekat dari daftar master dan masukkan perkiraan jarak dalam meter untuk memudahkan filter pencarian pencari kos.</p>

                    <div id="campusContainer" class="space-y-3">
                        <!-- Dynamic campus rows populated by JS -->
                    </div>
                </div>

                <!-- Facilities & Description -->
                <div>
                    <h3 class="font-bold text-[#20344c] text-sm mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                        <x-lucide-check-square class="w-4 h-4 text-[#f99d18]" />
                        Fasilitas & Media
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-bold text-[#20344c]">Fasilitas Kos</label>
                                <a href="{{ route('admin.facilities.index') }}" target="_blank" class="text-[11px] text-[#f99d18] hover:underline font-semibold flex items-center gap-1">
                                    + Kelola Master Fasilitas
                                </a>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs text-slate-700">
                                @php
                                    $currentFac = old('facilities', $ko->facilities ?? []);
                                @endphp
                                @forelse ($facilities as $fac)
                                    <label class="flex items-center gap-2 p-2 rounded-md bg-slate-50 border border-slate-200 cursor-pointer hover:border-[#f99d18] transition">
                                        <input type="checkbox" name="facilities[]" value="{{ $fac->name }}" {{ in_array($fac->name, $currentFac) ? 'checked' : '' }} class="rounded text-[#f99d18] focus:ring-0">
                                        <span>{{ $fac->name }}</span>
                                    </label>
                                @empty
                                    <p class="col-span-3 text-xs text-slate-400 italic">Belum ada data fasilitas. Silakan tambah di Master Fasilitas.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Cover Image Upload (Max 5MB) -->
                        <div>
                            <label class="block text-xs font-bold text-[#20344c] mb-1">
                                Cover Image / Foto Utama (Thumbnail)
                                <span class="text-slate-400 font-normal ml-1">(Kosongkan jika tidak diubah, Max: 5 MB)</span>
                            </label>

                            <div class="flex items-start gap-4">
                                <div class="flex-1">
                                    <input type="file" name="thumbnail" id="thumbnailInput" accept="image/*" onchange="previewThumbnail(event)"
                                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c] file:mr-3 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-[#20344c] file:text-white hover:file:bg-[#182739]">
                                    @error('thumbnail') 
                                        <span class="text-[11px] text-red-500 font-medium mt-1 block">{{ $message }}</span> 
                                    @enderror
                                </div>
                                <div id="previewContainer" class="w-24 h-24 rounded-md border border-slate-200 bg-slate-50 overflow-hidden shrink-0 relative">
                                    <img id="thumbnailPreview" src="{{ asset($ko->thumbnail) }}" alt="Foto Kos" class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>

                        <!-- Gallery Images Management (Max 6, 5MB each) -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Galeri Foto Kos (Maksimal 6 Foto)</label>
                            <span class="text-[10px] text-slate-500 mb-2 block">Upload foto galeri tambahan (max 6 foto, max 5MB per file). Centang foto lama untuk menghapusnya.</span>
                            
                            @if(!empty($ko->images) && is_array($ko->images) && count($ko->images) > 0)
                                <div class="grid grid-cols-3 sm:grid-cols-6 gap-2 mb-3">
                                    @foreach($ko->images as $index => $img)
                                        <div class="relative group rounded-md border border-slate-200 overflow-hidden bg-slate-100">
                                            <img src="{{ asset($img) }}" class="w-full h-20 object-cover" alt="Galeri {{ $index+1 }}">
                                            <label class="absolute inset-0 bg-red-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer text-white text-[10px] font-bold gap-1">
                                                <input type="checkbox" name="delete_images[]" value="{{ $img }}" class="accent-red-600">
                                                <span>Hapus</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <input type="file" name="images[]" multiple accept="image/*"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c] file:mr-3 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-[#20344c] file:text-white hover:file:bg-[#182739]">
                            @error('images') 
                                <span class="text-[11px] text-red-500 font-medium mt-1 block">{{ $message }}</span> 
                            @enderror
                            @error('images.*') 
                                <span class="text-[11px] text-red-500 font-medium mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Deskripsi Lengkap Kos</label>
                            <textarea name="description" rows="4"
                                      class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">{{ old('description', $ko->description) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#20344c] mb-1">Status Publikasi <span class="text-red-500">*</span></label>
                            <select name="status" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                                <option value="active" {{ old('status', $ko->status) == 'active' ? 'selected' : '' }}>Aktif (Tayang)</option>
                                <option value="pending" {{ old('status', $ko->status) == 'pending' ? 'selected' : '' }}>Pending Verifikasi</option>
                                <option value="inactive" {{ old('status', $ko->status) == 'inactive' ? 'selected' : '' }}>Non-Aktif (Draft)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Submit Button Bar -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.kos.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-md transition">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-[#f99d18] hover:bg-[#e08b0f] text-white font-bold text-xs rounded-md transition shadow-md flex items-center gap-1.5">
                        <x-lucide-save class="w-4 h-4" />
                        <span>Update Properti Kos</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Master Campus Options Template for JS -->
    <template id="campusSelectTemplate">
        <option value="">-- Pilih Kampus --</option>
        @foreach($campuses as $campus)
            <option value="{{ $campus->id }}">{{ $campus->name }} {{ $campus->abbreviation ? '('.$campus->abbreviation.')' : '' }} - {{ $campus->city }}</option>
        @endforeach
    </template>

    <script>
        function toggleTwoPeoplePrice() {
            const checkbox = document.getElementById('allowTwoPeople');
            const container = document.getElementById('twoPeopleContainer');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }

        // Cascading Indonesian Wilayah API Handler
        const REGION_API = 'https://www.emsifa.com/api-wilayah-indonesia/api';

        const provSelect = document.getElementById('provinceSelect');
        const citySelect = document.getElementById('citySelect');
        const distSelect = document.getElementById('districtSelect');
        const villageSelect = document.getElementById('villageSelect');

        const provInput = document.getElementById('provinceInput');
        const cityInput = document.getElementById('cityInput');
        const distInput = document.getElementById('districtInput');
        const villageInput = document.getElementById('villageInput');

        async function initRegionCascade(initialProvName = 'Jawa Tengah', initialCityName = 'Kota Semarang', initialDistName = 'Tembalang', initialVillageName = '') {
            try {
                const res = await fetch(`${REGION_API}/provinces.json`);
                const provinces = await res.json();

                provSelect.innerHTML = '<option value="">-- Pilih Provinsi --</option>';
                let selectedProvId = '';

                provinces.forEach(p => {
                    const option = document.createElement('option');
                    option.value = p.id;
                    option.dataset.name = p.name;
                    option.textContent = p.name;
                    if (initialProvName && p.name.toLowerCase() === initialProvName.toLowerCase()) {
                        option.selected = true;
                        selectedProvId = p.id;
                        provInput.value = p.name;
                    }
                    provSelect.appendChild(option);
                });

                if (selectedProvId) {
                    await loadCities(selectedProvId, initialCityName, initialDistName, initialVillageName);
                }
            } catch (err) {
                console.error("Gagal memuat daftar provinsi:", err);
            }
        }

        async function loadCities(provId, targetCityName = '', targetDistName = '', targetVillageName = '') {
            citySelect.innerHTML = '<option value="">-- Memuat Kota/Kabupaten... --</option>';
            distSelect.innerHTML = '<option value="">-- Pilih Kota Dahulu --</option>';
            villageSelect.innerHTML = '<option value="">-- Pilih Kecamatan Dahulu --</option>';
            cityInput.value = targetCityName;
            distInput.value = '';
            villageInput.value = '';

            try {
                const res = await fetch(`${REGION_API}/regencies/${provId}.json`);
                const cities = await res.json();

                citySelect.innerHTML = '<option value="">-- Pilih Kota / Kabupaten --</option>';
                let selectedCityId = '';

                cities.forEach(c => {
                    const option = document.createElement('option');
                    option.value = c.id;
                    option.dataset.name = c.name;
                    option.textContent = c.name;
                    if (targetCityName && c.name.toLowerCase() === targetCityName.toLowerCase()) {
                        option.selected = true;
                        selectedCityId = c.id;
                        cityInput.value = c.name;
                    }
                    citySelect.appendChild(option);
                });

                if (selectedCityId) {
                    await loadDistricts(selectedCityId, targetDistName, targetVillageName);
                }
            } catch (err) {
                console.error("Gagal memuat kota:", err);
            }
        }

        async function loadDistricts(cityId, targetDistName = '', targetVillageName = '') {
            distSelect.innerHTML = '<option value="">-- Memuat Kecamatan... --</option>';
            villageSelect.innerHTML = '<option value="">-- Pilih Kecamatan Dahulu --</option>';
            distInput.value = targetDistName;
            villageInput.value = '';

            try {
                const res = await fetch(`${REGION_API}/districts/${cityId}.json`);
                const districts = await res.json();

                distSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                let selectedDistId = '';

                districts.forEach(d => {
                    const option = document.createElement('option');
                    option.value = d.id;
                    option.dataset.name = d.name;
                    option.textContent = d.name;
                    if (targetDistName && d.name.toLowerCase() === targetDistName.toLowerCase()) {
                        option.selected = true;
                        selectedDistId = d.id;
                        distInput.value = d.name;
                    }
                    distSelect.appendChild(option);
                });

                if (selectedDistId) {
                    await loadVillages(selectedDistId, targetVillageName);
                }
            } catch (err) {
                console.error("Gagal memuat kecamatan:", err);
            }
        }

        async function loadVillages(distId, targetVillageName = '') {
            villageSelect.innerHTML = '<option value="">-- Memuat Kelurahan/Desa... --</option>';
            villageInput.value = targetVillageName;

            try {
                const res = await fetch(`${REGION_API}/villages/${distId}.json`);
                const villages = await res.json();

                villageSelect.innerHTML = '<option value="">-- Pilih Kelurahan / Desa --</option>';

                villages.forEach(v => {
                    const option = document.createElement('option');
                    option.value = v.id;
                    option.dataset.name = v.name;
                    option.textContent = v.name;
                    if (targetVillageName && v.name.toLowerCase() === targetVillageName.toLowerCase()) {
                        option.selected = true;
                        villageInput.value = v.name;
                    }
                    villageSelect.appendChild(option);
                });
            } catch (err) {
                console.error("Gagal memuat kelurahan:", err);
            }
        }

        provSelect.addEventListener('change', function() {
            const selectedOpt = this.options[this.selectedIndex];
            if (selectedOpt && selectedOpt.value) {
                provInput.value = selectedOpt.dataset.name || selectedOpt.textContent;
                loadCities(selectedOpt.value);
            } else {
                provInput.value = '';
                citySelect.innerHTML = '<option value="">-- Pilih Provinsi Dahulu --</option>';
                distSelect.innerHTML = '<option value="">-- Pilih Kota Dahulu --</option>';
                villageSelect.innerHTML = '<option value="">-- Pilih Kecamatan Dahulu --</option>';
            }
        });

        citySelect.addEventListener('change', function() {
            const selectedOpt = this.options[this.selectedIndex];
            if (selectedOpt && selectedOpt.value) {
                cityInput.value = selectedOpt.dataset.name || selectedOpt.textContent;
                loadDistricts(selectedOpt.value);
            } else {
                cityInput.value = '';
                distSelect.innerHTML = '<option value="">-- Pilih Kota Dahulu --</option>';
                villageSelect.innerHTML = '<option value="">-- Pilih Kecamatan Dahulu --</option>';
            }
        });

        distSelect.addEventListener('change', function() {
            const selectedOpt = this.options[this.selectedIndex];
            if (selectedOpt && selectedOpt.value) {
                distInput.value = selectedOpt.dataset.name || selectedOpt.textContent;
                loadVillages(selectedOpt.value);
            } else {
                distInput.value = '';
                villageSelect.innerHTML = '<option value="">-- Pilih Kecamatan Dahulu --</option>';
            }
        });

        villageSelect.addEventListener('change', function() {
            const selectedOpt = this.options[this.selectedIndex];
            if (selectedOpt && selectedOpt.value) {
                villageInput.value = selectedOpt.dataset.name || selectedOpt.textContent;
            } else {
                villageInput.value = '';
            }
        });

        let campusRowIndex = 0;

        function addCampusRow(campusId = '', distance = '') {
            const container = document.getElementById('campusContainer');
            const template = document.getElementById('campusSelectTemplate').innerHTML;
            
            const row = document.createElement('div');
            row.className = "flex items-center gap-3 bg-slate-50 p-3 rounded-md border border-slate-200";
            row.id = `campusRow_${campusRowIndex}`;

            row.innerHTML = `
                <div class="flex-1">
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Nama Kampus</label>
                    <select name="campuses[${campusRowIndex}][campus_id]" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                        ${template}
                    </select>
                </div>
                <div class="w-40">
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Jarak (Meter)</label>
                    <input type="number" name="campuses[${campusRowIndex}][distance_meters]" value="${distance}" placeholder="Contoh: 500" min="0" step="10"
                           class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-md text-xs focus:outline-none focus:border-[#f99d18] text-[#20344c]">
                </div>
                <div class="pt-5">
                    <button type="button" onclick="removeCampusRow('campusRow_${campusRowIndex}')" class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded transition" title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            `;

            container.appendChild(row);

            if (campusId) {
                row.querySelector(`select[name="campuses[${campusRowIndex}][campus_id]"]`).value = campusId;
            }

            campusRowIndex++;
        }

        function removeCampusRow(rowId) {
            const row = document.getElementById(rowId);
            if (row) row.remove();
        }

        function previewThumbnail(event) {
            const input = event.target;
            const preview = document.getElementById('thumbnailPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            initRegionCascade("{{ old('province', $ko->province ?? 'JAWA TENGAH') }}", "{{ old('city', $ko->city) }}", "{{ old('district', $ko->district) }}", "{{ old('village', $ko->village) }}");

            const existingCampuses = @json($ko->campuses);
            if (existingCampuses && existingCampuses.length > 0) {
                existingCampuses.forEach(campus => {
                    addCampusRow(campus.id, campus.pivot.distance_meters);
                });
            } else {
                addCampusRow();
            }
        });
    </script>
@endsection
