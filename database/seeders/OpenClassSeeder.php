<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Mentor;
use App\Models\OpenClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OpenClassSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::first();

        $classes = [
            [
                'title'           => 'Ladies with LINTANG',
                'mentor_name'     => 'LINTANG',
                'description'     => 'Choreography class yang empowering. Fokus pada ekspresi dan kepercayaan diri melalui gerakan tari modern.',
                'price'           => 150000,
                'early_bird_price' => 120000,
                'class_date'      => '2026-06-12',
                'song_title'      => 'Flowers - Miley Cyrus',
                'whatsapp_link'   => 'https://wa.me/628123456789',
                'day_of_week'     => 'Sabtu',
                'time_start'      => '19:00',
                'time_end'        => '20:30',
            ],
            [
                'title'           => 'Contemporary Flow',
                'mentor_name'     => 'DARA',
                'description'     => 'Jelajahi gerakan cair dan ekspresi emosional melalui tari kontemporer. Cocok untuk semua level.',
                'price'           => 120000,
                'early_bird_price' => 90000,
                'class_date'      => '2026-06-14',
                'song_title'      => 'As it Was - Harry Styles',
                'whatsapp_link'   => 'https://wa.me/628234567890',
                'day_of_week'     => 'Minggu',
                'time_start'      => '10:00',
                'time_end'        => '11:30',
            ],
            [
                'title'           => 'Hip Hop Foundation',
                'mentor_name'     => 'DYO',
                'description'     => 'Pelajari dasar-dasar hip hop dance. Fokus pada rhythm, bounce, dan groove khas urban dance.',
                'price'           => 100000,
                'early_bird_price' => 80000,
                'class_date'      => '2026-06-16',
                'song_title'      => 'Yeah! - Usher',
                'whatsapp_link'   => 'https://wa.me/628345678901',
                'day_of_week'     => 'Selasa',
                'time_start'      => '20:00',
                'time_end'        => '21:30',
            ],
        ];

        foreach ($classes as $class) {
            $mentor = Mentor::where('name', 'like', '%' . $class['mentor_name'] . '%')->first();

            if ($mentor) {
                OpenClass::create([
                    'created_by'      => $admin->id,
                    'title'           => $class['title'],
                    'slug'            => Str::slug($class['title']),
                    'mentor_id'       => $mentor->id,
                    'instructor_name' => $mentor->name,
                    'description'     => $class['description'],
                    'price'           => $class['price'],
                    'early_bird_price' => $class['early_bird_price'] ?? 0,
                    'class_date'      => $class['class_date'] ?? null,
                    'song_title'      => $class['song_title'],
                    'whatsapp_link'   => $class['whatsapp_link'],
                    'day_of_week'     => $class['day_of_week'],
                    'time_start'      => $class['time_start'],
                    'time_end'        => $class['time_end'],
                    'is_active'       => true,
                ]);
            }
        }
    }
}

