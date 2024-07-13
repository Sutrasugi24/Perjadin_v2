<?php

namespace Database\Seeders;

use App\Models\Perjadin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PerjadinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perjadin = Perjadin::create([
            'leave_date'      => '2023-01-10',
            'return_date'     => '2023-01-10',
            'coordinator'  => 1,
            'plan'       => 'Perjalanan Dinas ke Kota Garut',
            'destination'      => 'Kota Garut',
            'transport'   => 'darat',
            'description'  => 'Keberangkatan ke Garut'
        ]);
    }
}
