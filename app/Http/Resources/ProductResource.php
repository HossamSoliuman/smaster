<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
			'name' => $this->name,
			'description' => $this->description,
			'main_image' => $this->main_image,
			'price' => $this->price,
			'category' => CategoryResource::make($this->whenLoaded('category')),
            'created_at' => $this->created_at,
            'last_update' => $this->updated_at,
        ];
    }
}
