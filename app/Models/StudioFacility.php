<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudioFacility extends Model
{
    protected $fillable = [
        'studio_id',
        'name',
        'icon',
    ];

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }
}
