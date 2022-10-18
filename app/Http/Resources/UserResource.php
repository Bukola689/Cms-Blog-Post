<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => (string)$this->id,
            'type' => 'Users',
            'attributes' => [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'avatar' => $this->avatar,
                'username' => $this->username,
                'gender' => $this->gender,
                'occupation' => $this->occupation,
                'country' => $this->country,
                'state' => $this->state,
                'city' => $this->city,
                'phone_number' => $this->phone_number,
                'address' => $this->address,
                'email' => $this->email,
                'password' => $this->password,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]
        ];
    }
}
