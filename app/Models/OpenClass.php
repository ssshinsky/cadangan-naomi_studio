<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenClass extends Model
{
    protected $fillable = [
        'created_by',
        'title',
        'slug',
        'instructor_name',
        'instructor_photo',
        'description',
        'price',
        'thumbnail',
        'song_title',
        'whatsapp_link',
        'day_of_week',
        'time_start',
        'time_end',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
