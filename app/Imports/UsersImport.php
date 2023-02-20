<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $randStr = Hash::make(11);

            User::create([
                'name' => $row['nama'],
                'email' => $row['nama'].'@gmail.com',
                'nip' => $row['nip'],
                'nips' => $row['nips'],
                'jabatan' => $row['jabatan'],
                'golongan' => $row['golongan'],
                'password' => $randStr,
    
            ]);
        }
    }
}
