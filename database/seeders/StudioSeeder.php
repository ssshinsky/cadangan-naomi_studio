<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Studio;
use App\Models\StudioFacility;
use Illuminate\Database\Seeder;

class StudioSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::first();

        // Studio Besar
        $studioBesar = Studio::create([
            'created_by'            => $admin->id,
            'name'                  => 'Studio Besar',
            'slug'                  => 'studio-besar',
            'description'           => 'Studio utama dengan akustik terbaik dan ruang yang sangat luas. Rp 60.000/jam (penggunaan lebih dari 20 orang dikenai tarif Rp 70.000/jam, maksimal 25 orang).',
            'price_per_hour'        => 60000,
            'extra_price_per_hour'  => 70000,
            'extra_price_threshold' => 20,
            'min_dp_amount'         => 30000,
            'capacity'              => 25,
            'size_sqm'              => '65m² (6,5 x 10 m)',
            'floor_type'            => 'Vinyl',
            'is_available'          => true,
        ]);

        $fasilitasBesar = [
            ['name' => 'Lantai Vinyl',        'icon' => 'layers'],
            ['name' => 'Cermin',              'icon' => 'crop_portrait'],
            ['name' => 'Bluetooth Speaker',   'icon' => 'speaker'],
            ['name' => 'Tripod',              'icon' => 'videocam'],
            ['name' => 'AC Central',          'icon' => 'ac_unit'],
            ['name' => 'Ruang Ganti',         'icon' => 'door_front'],
        ];

        foreach ($fasilitasBesar as $f) {
            StudioFacility::create([
                'studio_id' => $studioBesar->id,
                'name'      => $f['name'],
                'icon'      => $f['icon'],
            ]);
        }

        // Studio Kecil
        $studioKecil = Studio::create([
            'created_by'            => $admin->id,
            'name'                  => 'Studio Kecil',
            'slug'                  => 'studio-kecil',
            'description'           => 'Ruang latihan intim untuk kelompok kecil atau solo. Rp 40.000/jam (penggunaan lebih dari 10 orang dikenai tarif Rp 50.000/jam, maksimal 15 orang).',
            'price_per_hour'        => 40000,
            'extra_price_per_hour'  => 50000,
            'extra_price_threshold' => 10,
            'min_dp_amount'         => 20000,
            'capacity'              => 15,
            'size_sqm'              => '35m² (6,25 x 6 m)',
            'floor_type'            => 'Vinyl',
            'is_available'          => true,
        ]);

        $fasilitasKecil = [
            ['name' => 'Lantai Vinyl',        'icon' => 'layers'],
            ['name' => 'Cermin',              'icon' => 'crop_portrait'],
            ['name' => 'Bluetooth Speaker',   'icon' => 'speaker'],
            ['name' => 'Tripod',              'icon' => 'videocam'],
            ['name' => 'AC Split',            'icon' => 'ac_unit'],
        ];

        foreach ($fasilitasKecil as $f) {
            StudioFacility::create([
                'studio_id' => $studioKecil->id,
                'name'      => $f['name'],
                'icon'      => $f['icon'],
            ]);
        }
    }
}
