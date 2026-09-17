<?php

namespace Database\Seeders;

use App\Models\Campus;
use App\Models\Facility;
use App\Models\Kos;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@ngekosin.com'],
            [
                'name' => 'Administrator Ngekosin',
                'phone' => '081234567890',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]
        );

        $owner = User::updateOrCreate(
            ['email' => 'owner@ngekosin.com'],
            [
                'name' => 'Ibu Hesty (Owner Kos)',
                'phone' => '089876543210',
                'role' => 'owner',
                'password' => bcrypt('password'),
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'user@ngekosin.com'],
            [
                'name' => 'Budi Pencari Kos',
                'phone' => '085511223344',
                'role' => 'user',
                'password' => bcrypt('password'),
            ]
        );

        // Seed Master Fasilitas
        $facilities = [
            ['name' => 'AC', 'icon' => 'lucide-wind'],
            ['name' => 'WiFi 100Mbps', 'icon' => 'lucide-wifi'],
            ['name' => 'Kamar Mandi Dalam', 'icon' => 'lucide-bath'],
            ['name' => 'Kasur Springbed', 'icon' => 'lucide-bed'],
            ['name' => 'Meja Belajar', 'icon' => 'lucide-laptop'],
            ['name' => 'Lemari Pakaian', 'icon' => 'lucide-archive'],
            ['name' => 'Dapur Bersama', 'icon' => 'lucide-utensils'],
            ['name' => 'Parkir Mobil', 'icon' => 'lucide-car'],
            ['name' => 'CCTV 24 Jam', 'icon' => 'lucide-video'],
            ['name' => 'Water Heater', 'icon' => 'lucide-thermometer-sun'],
            ['name' => 'Kulkas Bersama', 'icon' => 'lucide-refrigerator'],
            ['name' => 'Jemuran', 'icon' => 'lucide-sun'],
        ];

        foreach ($facilities as $fac) {
            Facility::updateOrCreate(
                ['name' => $fac['name']],
                ['icon' => $fac['icon']]
            );
        }

        // Seed Master Kampus Initial Data
        $undip = Campus::updateOrCreate(
            ['name' => 'Universitas Diponegoro'],
            ['abbreviation' => 'UNDIP', 'city' => 'Semarang']
        );

        $unnes = Campus::updateOrCreate(
            ['name' => 'Universitas Negeri Semarang'],
            ['abbreviation' => 'UNNES', 'city' => 'Semarang']
        );

        $ugm = Campus::updateOrCreate(
            ['name' => 'Universitas Gadjah Mada'],
            ['abbreviation' => 'UGM', 'city' => 'Yogyakarta']
        );

        $itb = Campus::updateOrCreate(
            ['name' => 'Institut Teknologi Bandung'],
            ['abbreviation' => 'ITB', 'city' => 'Bandung']
        );

        $ui = Campus::updateOrCreate(
            ['name' => 'Universitas Indonesia'],
            ['abbreviation' => 'UI', 'city' => 'Depok']
        );

        // Seed Sample Kos Properti
        $kos1 = Kos::updateOrCreate(
            ['slug' => 'kos-griya-executive-tembalang'],
            [
                'user_id' => $owner->id,
                'name' => 'Kos Griya Executive Tembalang',
                'type' => 'campur',
                'address' => 'Jl. Professor Soedarto No. 12, Tembalang',
                'city' => 'Semarang',
                'district' => 'Tembalang',
                'price_per_month' => 1500000,
                'price_per_day' => 150000,
                'price_per_week' => 600000,
                'allow_two_people' => true,
                'price_2_persons' => 2000000,
                'total_rooms' => 12,
                'available_rooms' => 3,
                'description' => 'Kos eksklusif dekat kampus UNDIP Tembalang dengan fasilitas kamar mandi dalam, AC, WiFi cepat 100Mbps, dan dapur bersama.',
                'facilities' => ['AC', 'WiFi', 'Kamar Mandi Dalam', 'Kasur Springbed', 'Meja Belajar', 'Dapur Bersama', 'Parkir Mobil'],
                'thumbnail' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=600&q=80',
                'status' => 'active',
                'views_count' => 1420,
                'clicks_count' => 312,
            ]
        );
        $kos1->campuses()->sync([
            $undip->id => ['distance_meters' => 350],
        ]);

        $kos2 = Kos::updateOrCreate(
            ['slug' => 'kos-putri-melati-banyumanik'],
            [
                'user_id' => $owner->id,
                'name' => 'Kos Putri Melati Banyumanik',
                'type' => 'putri',
                'address' => 'Jl. Sukun Raya No. 45, Banyumanik',
                'city' => 'Semarang',
                'district' => 'Banyumanik',
                'price_per_month' => 1200000,
                'price_per_day' => null,
                'price_per_week' => null,
                'allow_two_people' => false,
                'price_2_persons' => null,
                'total_rooms' => 10,
                'available_rooms' => 2,
                'description' => 'Kos khusus putri dengan keamanan CCTV 24 jam, suasana tenang, nyaman untuk mahasiswi dan pekerja.',
                'facilities' => ['AC', 'WiFi', 'Kamar Mandi Dalam', 'CCTV 24 Jam', 'Kasur', 'Lemari Pakaian'],
                'thumbnail' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=600&q=80',
                'status' => 'active',
                'views_count' => 980,
                'clicks_count' => 195,
            ]
        );
        $kos2->campuses()->sync([
            $undip->id => ['distance_meters' => 1200],
            $unnes->id => ['distance_meters' => 2500],
        ]);

        $kos3 = Kos::updateOrCreate(
            ['slug' => 'kos-executive-cempaka-pleburan'],
            [
                'user_id' => $owner->id,
                'name' => 'Kos Executive Cempaka Pleburan',
                'type' => 'putra',
                'address' => 'Jl. Cempaka No. 8, Pleburan',
                'city' => 'Semarang',
                'district' => 'Semarang Selatan',
                'price_per_month' => 1800000,
                'price_per_day' => 200000,
                'price_per_week' => 750000,
                'allow_two_people' => true,
                'price_2_persons' => 2300000,
                'total_rooms' => 15,
                'available_rooms' => 5,
                'description' => 'Kos putra modern dekat pusat kota dan Simpang Lima, lokasi strategis dan bebas banjir.',
                'facilities' => ['AC', 'WiFi 100Mbps', 'Smart TV', 'Kamar Mandi Dalam', 'Water Heater', 'Parkir Luas'],
                'thumbnail' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=600&q=80',
                'status' => 'active',
                'views_count' => 754,
                'clicks_count' => 150,
            ]
        );
        $kos3->campuses()->sync([
            $undip->id => ['distance_meters' => 800],
        ]);
    }
}
