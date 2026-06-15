<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'avatar',
        'is_super_admin',
    ];

    protected function casts(): array
    {
        return [
            'is_super_admin' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studios()
    {
        return $this->hasMany(Studio::class, 'created_by');
    }

    public function openClasses()
    {
        return $this->hasMany(OpenClass::class, 'created_by');
    }

    public function operationalCosts()
    {
        return $this->hasMany(OperationalCost::class, 'created_by');
    }

    public function verifiedPayments()
    {
        return $this->hasMany(Payment::class, 'verified_by');
    }

    public function closures()
    {
        return $this->hasMany(StudioClosure::class, 'created_by');
    }
}
