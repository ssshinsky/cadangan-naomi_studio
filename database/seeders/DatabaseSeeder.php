<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,    // 1. Admin dulu (dibutuhkan oleh Studio & OpenClass)
            CustomerSeeder::class, // 2. Customer
            StudioSeeder::class,   // 3. Studio + Fasilitas (butuh admin)
            OpenClassSeeder::class,// 4. Open Class (butuh admin)
            DemoDataSeeder::class, // 5. Data demo (booking, payment, biaya ops)
        ]);
    }
}
