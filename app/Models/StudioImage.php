<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudioImage extends Model
{
    protected $fillable = [
        'studio_id',
        'image_url',
        'is_primary',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
        ];
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }
}
