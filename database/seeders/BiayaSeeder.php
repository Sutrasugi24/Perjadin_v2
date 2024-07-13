<?php

namespace Database\Seeders;

use App\Models\Biaya;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BiayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Biaya::create([
            'type'      => 'Kegiatan half day',
            'cost'      => 105000,
        ]);
        Biaya::create([
            'type'          => 'Kegiatan fullboard di dalam kota',
            'cost'    => 150000
        ]);
        Biaya::create([
            'type'          => 'Kegiatan fullboard di luar kota',
            'cost'    => 430000
        ]);
        Biaya::create([
            'type'          => 'Transport',
            'cost'    => 0
        ]);
        Biaya::create([
            'type'          => 'Uang Saku',
            'cost'    => 105000
        ]);
    }
}
