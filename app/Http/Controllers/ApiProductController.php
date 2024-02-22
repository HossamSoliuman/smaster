<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ApiProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load('productImages');
        return $this->apiResponse(ProductResource::make($product));
    }
}
