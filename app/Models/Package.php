<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_per_unit',
        'roi_percentage',
        'duration_months',
        'status',
        'image_path',
    ];

    protected $casts = [
        'price_per_unit' => 'decimal:2',
        'roi_percentage' => 'decimal:2',
    ];

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
