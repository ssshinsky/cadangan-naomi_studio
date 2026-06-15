<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudioClosure extends Model
{
    protected $fillable = [
        'studio_id',
        'created_by',
        'date',
        'start_time',
        'end_time',
        'reason',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    /**
     * Scope: hanya closure hari ini atau masa depan.
     */
    public function scopeActive(Builder $query): void
    {
        $query->whereDate('date', '>=', today());
    }

    /**
     * Relasi ke Studio.
     */
    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }

    /**
     * Relasi ke Admin via kolom created_by.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
