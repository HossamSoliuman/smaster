<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CjAuthResource extends JsonResource
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
            'id'=> $this->id,
			'email' => $this->email,
			'key' => $this->key,
			'access_token' => $this->access_token,
			'access_token_expiry_date' => $this->access_token_expiry_date,
			'refresh_token' => $this->refresh_token,
            'created_at' => $this->created_at,
            'last_update' => $this->updated_at,
        ];
    }
}
