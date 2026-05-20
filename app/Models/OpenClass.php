<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'early_bird_price',
        'class_date',
        'thumbnail',
        'song_title',
        'whatsapp_link',
        'day_of_week',
        'time_start',
        'time_end',
        'is_active',
        'mentor_id',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'class_date' => 'date',
        ];
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Mentor::class);
    }
}
