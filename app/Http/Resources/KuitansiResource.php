<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KuitansiResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'kuitansi_number'   => $this->kuitansi_number,
            'kuitansi_date'     => $this->kuitansi_date,
            'cost_total'        => $this->cost_total,
            'perjadin_id'       =>  $this->perjadin_id,
            'biaya_id'          =>  $this->biaya_id,
            'created_at'        => date('d-m-Y H:i:s', strtotime($this->created_at)),
            'updated_at'        => date('d-m-Y H:i:s', strtotime($this->updated_at))
        ];
    }
}
