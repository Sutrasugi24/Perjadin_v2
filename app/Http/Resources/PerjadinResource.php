<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PerjadinResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'leave_date'    => date('Y-m-d', strtotime($this->leave_date)),
            'return_date'   => date('Y-m-d', strtotime($this->return_date)),
            'plan'          => $this->plan,
            'destination'   => $this->destination,
            'destination_two'   => $this->destination_two,
            'destination_three'   => $this->destination_three,
            'description'   => $this->description,
            'transport'     => $this->transport,
            'coordinator'   => $this->coordinator,
            'created_at'    => date('d-m-Y H:i:s', strtotime($this->created_at)),
            'updated_at'    => date('d-m-Y H:i:s', strtotime($this->updated_at))
        ];
    }
}
