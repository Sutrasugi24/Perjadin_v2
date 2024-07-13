<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SuratResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'document_number'   => $this->document_number,
            'document_date'     => date('Y-m-d', strtotime($this->document_date)),
            'perjadin_id'     => $this->perjadin_id,
            'created_at'        => date('d-m-Y H:i:s', strtotime($this->created_at)),
            'updated_at'        => date('d-m-Y H:i:s', strtotime($this->updated_at))
        ];
    }
}
