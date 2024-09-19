<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = Role::create([
            'name'          => 'superadmin',
            'guard_name'    => 'web'
        ]);
        $superadmin->givePermissionTo([
            'filemanager',
            'read module',
            'delete setting',
            'update setting',
            'read setting',
            'create setting',
            'delete user',
            'update user',
            'read user',
            'create user',
            'delete role',
            'update role',
            'read role',
            'create role',
            'delete permission',
            'update permission',
            'read permission',
            'create permission',
            'delete perjadin',
            'update perjadin',
            'read perjadin',
            'create perjadin',
            'delete surat',
            'update surat',
            'read surat',
            'create surat',
            'delete biaya',
            'update biaya',
            'read biaya',
            'create biaya',
            'delete kuitansi',
            'update kuitansi',
            'read kuitansi',
            'create kuitansi',
        ]);

        $admin = Role::create([
            'name'          => 'admin',
            'guard_name'    => 'web'
        ]);
        $admin->givePermissionTo([
            'delete setting',
            'update setting',
            'read setting',
            'create setting',
            'delete user',
            'update user',
            'read user',
            'create user',
            'delete perjadin',
            'update perjadin',
            'read perjadin',
            'create perjadin',
            'delete surat',
            'update surat',
            'read surat',
            'create surat',
            'delete biaya',
            'update biaya',
            'read biaya',
            'create biaya',
            'delete kuitansi',
            'update kuitansi',
            'read kuitansi',
            'create kuitansi',
        ]);


        $operator = Role::create([
            'name'          => 'operator',
            'guard_name'    => 'web'
        ]);
        $operator->givePermissionTo([
            'delete perjadin',
            'update perjadin',
            'read perjadin',
            'create perjadin',
            'delete surat',
            'update surat',
            'read surat',
            'create surat',
        ]);

        $guest = Role::create([
            'name'          => 'guest',
            'guard_name'    => 'web'
        ]);
        $guest->givePermissionTo([
            'read user',
        ]);
    }
}
