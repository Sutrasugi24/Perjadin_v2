<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::create([
            'name'      => 'Superadmin',
            'email'     => 'superadmin@superadmin.com',
            'password'  => bcrypt('superadmin'),
            'nip'       => '12345678',
            'nips'      => '12345678',
            'jabatan'   => 'Kepala TU',
            'pangkat'   => '-',
            'golongan'  => 'Karya'
        ]);
        $superadmin->assignRole('superadmin');

        $admin = User::create([
            'name'      => 'Admin',
            'email'     => 'admin@admin.com',
            'password'  => bcrypt('admin'),
            'nip'       => '123456781',
            'nips'      => '123456781',
            'jabatan'   => 'Wakil TU',
            'pangkat'   => '-',
            'golongan'  => 'Karya'
        ]);
        $admin->assignRole('admin');

        $operator = User::create([
            'name'      => 'Operator',
            'email'     => 'operator@operator.com',
            'password'  => bcrypt('operator'),
            'nip'       => '123456789',
            'nips'      => '123456789',
            'jabatan'   => 'Wakil Wakil Kepala TU',
            'pangkat'   => '-',
            'golongan'  => 'Karya'
        ]);
        $operator->assignRole('operator');
    }
}
