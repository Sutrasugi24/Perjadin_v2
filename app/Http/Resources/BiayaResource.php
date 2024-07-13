<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BiayaResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'type'          => $this->type,
            'cost'          => $this->cost,
            'created_at'    => date('d-m-Y H:i:s', strtotime($this->created_at)),
            'updated_at'    => date('d-m-Y H:i:s', strtotime($this->updated_at))
        ];
    }
}
