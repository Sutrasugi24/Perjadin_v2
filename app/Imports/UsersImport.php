<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $randStr = Str::random(10);
            $randGmail = Str::random(8);

            User::create([
                'name' => $row['nama'],
                'email' => $randGmail.'@gmail.com',
                'password' => $randStr,
                'nip' => $row['nip'],
                'nips' => $row['nips'],
                'jabatan' => $row['jabatan'],
                'pangkat' => $row['pangkat'],
                'golongan' => $row['golongan'],
            ])->assignRole('guest');
        }
    }
}
