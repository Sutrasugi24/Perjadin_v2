<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'filemanager']);
        Permission::create(['name' => 'read module']);

        Permission::create(['name' => 'delete setting']);
        Permission::create(['name' => 'update setting']);
        Permission::create(['name' => 'read setting']);
        Permission::create(['name' => 'create setting']);

        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'read user']);
        Permission::create(['name' => 'create user']);

        Permission::create(['name' => 'delete role']);
        Permission::create(['name' => 'update role']);
        Permission::create(['name' => 'read role']);
        Permission::create(['name' => 'create role']);

        Permission::create(['name' => 'delete permission']);
        Permission::create(['name' => 'update permission']);
        Permission::create(['name' => 'read permission']);
        Permission::create(['name' => 'create permission']);

        Permission::create(['name' => 'delete perjadin']);
        Permission::create(['name' => 'update perjadin']);
        Permission::create(['name' => 'read perjadin']);
        Permission::create(['name' => 'create perjadin']);

        Permission::create(['name' => 'delete surat']);
        Permission::create(['name' => 'update surat']);
        Permission::create(['name' => 'read surat']);
        Permission::create(['name' => 'create surat']);

        Permission::create(['name' => 'delete biaya']);
        Permission::create(['name' => 'update biaya']);
        Permission::create(['name' => 'read biaya']);
        Permission::create(['name' => 'create biaya']);


        Permission::create(['name' => 'delete kuitansi']);
        Permission::create(['name' => 'update kuitansi']);
        Permission::create(['name' => 'read kuitansi']);
        Permission::create(['name' => 'create kuitansi']);
    }
}
