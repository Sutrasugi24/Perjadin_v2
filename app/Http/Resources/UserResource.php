<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
   
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'nip'           => $this->nip,
            'nips'          => $this->nips,
            'jabatan'       => $this->jabatan,
            'pangkat'       => $this->pangkat,
            'golongan'      => $this->golongan,
            'role'          => implode(",", $this->getRoleNames()->toArray()),
            'created_at'    => date('d-m-Y H:i:s', strtotime($this->created_at)),
            'updated_at'    => date('d-m-Y H:i:s', strtotime($this->updated_at))
        ];
    }
}
