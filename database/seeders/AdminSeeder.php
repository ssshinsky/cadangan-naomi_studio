<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'email'    => 'admin@naomistudio.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        Admin::create([
            'user_id'        => $user->id,
            'name'           => 'Admin Naomi Studio',
            'phone'          => '081234567890',
            'is_super_admin' => true,
        ]);
    }
}
