<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Surat;

class SuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Surat::create([
            'document_number'      => 'SMAN6CIMAHNI/12345/12345',
            'document_date'      => '2023-01-17',
            'perjadin_id' => 1
        ]);
    }
}
