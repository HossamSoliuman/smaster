<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ApiProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load('productImages');

        $images = $product->productImages->where('type', 'image')->pluck('path')->toArray();
        $videos = $product->productImages->where('type', 'video')->pluck('path')->toArray();

        return $this->apiResponse([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'main_image' => $product->main_image,
            'price' => $product->price,
            'images' => $images,
            'videos' => $videos,
        ]);
    }
}
