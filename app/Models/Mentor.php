<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mentor extends Model
{
    protected $fillable = [
        'name',
        'photo',
        'bio',
        'experience',
        'expertise',
    ];

    public function openClasses(): HasMany
    {
        return $this->hasMany(OpenClass::class);
    }
}
