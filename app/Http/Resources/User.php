<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => 200,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'country' => $this->adress->country->name,
            'city' => $this->adress->city->name,
            'street' => $this->adress->street->name,
        ];
    }
}
