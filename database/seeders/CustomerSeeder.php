<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'email' => 'raka@email.com',
                'name'  => 'Raka Aditama',
                'phone' => '081111111111',
                'gender' => 'male',
            ],
            [
                'email' => 'siska@email.com',
                'name'  => 'Siska Putri',
                'phone' => '082222222222',
                'gender' => 'female',
            ],
            [
                'email' => 'gabrielle@email.com',
                'name'  => 'Gabrielle Shinsky Hendarto',
                'phone' => '088878788787',
                'gender' => 'female',
            ],
        ];

        foreach ($customers as $data) {
            $user = User::create([
                'email'    => $data['email'],
                'password' => Hash::make('customer123'),
                'role'     => 'customer',
            ]);

            Customer::create([
                'user_id'   => $user->id,
                'name'      => $data['name'],
                'phone'     => $data['phone'],
                'gender'    => $data['gender'],
                'joined_at' => now(),
            ]);
        }
    }
}
