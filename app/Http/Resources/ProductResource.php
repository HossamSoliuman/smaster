<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'main_image' => $this->main_image,
            'price' => $this->price,
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
            'videos' => ProductImageResource::collection($this->whenLoaded('videos')),
        ];
    }
}
