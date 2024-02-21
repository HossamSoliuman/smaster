<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Hossam\Licht\Controllers\LichtBaseController;

class ProductController extends LichtBaseController
{

    public function index()
    {
        $products = Product::all();
        $products = ProductResource::collection($products);
        return view('products', compact('products'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return redirect()->route('products.index');
    }

    public function show(Product $product)
    {
        return $this->successResponse(ProductResource::make($product));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
