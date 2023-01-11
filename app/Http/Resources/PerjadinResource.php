<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PerjadinResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'leave_date'    => date('d-m-Y', strtotime($this->leave_date)),
            'return_date'   => date('d-m-Y', strtotime($this->return_date)),
            'plan'          => $this->plan,
            'destination'   => $this->destination,
            'description'   => $this->description,
            'transport'     => $this->transport,
            'coordinator'   => $this->coordinator,
            'created_at'    => date('d-m-Y H:i:s', strtotime($this->created_at)),
            'updated_at'    => date('d-m-Y H:i:s', strtotime($this->updated_at))
        ];
    }
}
