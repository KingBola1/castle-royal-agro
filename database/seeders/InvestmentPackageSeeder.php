<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvestmentPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\InvestmentPackage::create([
            'name' => 'Starter Pack',
            'amount' => 5000,
            'roi_percentage' => 15,
            'acres' => 0.5,
            'duration_months' => 12,
        ]);

        \App\Models\InvestmentPackage::create([
            'name' => 'Gold Tier',
            'amount' => 20000,
            'roi_percentage' => 25,
            'acres' => 2.0,
            'duration_months' => 12,
        ]);
    }
}
