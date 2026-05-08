<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationalCost extends Model
{
    protected $fillable = [
        'created_by',
        'cost_code',
        'category',
        'description',
        'amount',
        'period_month',
        'period_year',
        'payment_date',
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'date',
        ];
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    // Generate kode otomatis: MNT-YYYYMM-XXX
    public static function generateCode(int $month, int $year): string
    {
        $period = $year . str_pad($month, 2, '0', STR_PAD_LEFT);
        $last = static::where('period_month', $month)->where('period_year', $year)->count() + 1;
        return 'MNT-' . $period . '-' . str_pad($last, 3, '0', STR_PAD_LEFT);
    }
}
