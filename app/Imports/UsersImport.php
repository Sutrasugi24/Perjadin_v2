<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $randStr = Hash::make(5);
            $randGmail = Hash::make(1);

            User::create([
                'name' => $row['nama'],
                'email' => $randGmail.'@gmail.com',
                'nip' => $row['nip'],
                'nips' => $row['nips'],
                'jabatan' => $row['jabatan'],
                'golongan' => $row['golongan'],
                'password' => $randStr,
            ]);
        }
    }
}
