<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'key'       => 'app_name',
            'value'     => 'SMAN 6 Cimahi',
            'name'      => 'Nama Sekolah',
            'type'      => 'text',
            'category'  => 'information'
        ]);
        // Setting::create([
        //     'key'       => 'app_short_name',
        //     'value'     => 'SMAN 6 Cimahi',
        //     'name'      => 'Nama Sekolah',
        //     'type'      => 'text',
        //     'category'  => 'information'
        // ]);
        Setting::create([
            'key'       => 'app_plt',
            'value'     => 'false',
            'name'      => 'Plt',
            'type'      => 'checkbox',
            'category'  => 'information'
        ]);
        Setting::create([
            'key'       => 'app_headmaster',
            'value'     => 'Drs. Deden Musa',
            'name'      => 'Kepala Sekolah',
            'type'      => 'text',
            'category'  => 'information'
        ]);
        Setting::create([
            'key'       => 'app_nip',
            'value'     => '196409211988031003',
            'name'      => 'NIP Kepala Sekolah',
            'type'      => 'text',
            'category'  => 'information'
        ]);
        Setting::create([
            'key'       => 'app_treasurer',
            'value'     => 'Mulyadi', 
            'name'      => 'Bendahara',
            'type'      => 'text',
            'category'  => 'information'
        ]);
        Setting::create([
            'key'       => 'app_treasurer_nip',
            'value'     => '198209142010011001',
            'name'      => 'NIP Bendahara',
            'type'      => 'text',
            'category'  => 'information'
        ]);
        Setting::create([
            'key'       => 'app_logo',
            'value'     => 'storage/sman6.png',
            'name'      => 'Application Logo',
            'type'      => 'file',
            'ext'       => 'png',
            'category'  => 'information'
        ]);
        Setting::create([
            'key'       => 'app_favicon',
            'value'     => 'storage/sman6.png',
            'name'      => 'Application Favicon',
            'type'      => 'file',
            'ext'       => 'png'
        ]);
        Setting::create([
            'key'       => 'app_loading_gif',
            'value'     => 'storage/loading.gif',
            'name'      => 'Application Loading Image',
            'type'      => 'file',
            'ext'       => 'gif',
            'category'  => 'information'
        ]);
        Setting::create([
            'key'       => 'app_map_location',
            'value'     => 'https://www.google.com/maps/place/SMA+Negeri+6+Cimahi/@-6.9244285,107.5628454,15z/data=!4m2!3m1!1s0x0:0x3664e0b526e78036?sa=X&ved=2ahUKEwiV_ZDL97D8AhW-0nMBHSTrBokQ_BJ6BAhCEAg&hl=id',
            'name'      => 'Application Map Location',
            'type'      => 'textarea',
            'category'  => 'information'
        ]);
    }
}
