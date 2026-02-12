<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'amount_invested',
        'units',
        'expected_roi',
        'status',
        'payment_reference',
    ];

    protected $casts = [
        'amount_invested' => 'decimal:2',
        'expected_roi' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
