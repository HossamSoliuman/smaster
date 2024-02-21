<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use Hossam\Licht\Controllers\LichtBaseController;

class ProductController extends LichtBaseController
{

    public function index()
    {
        $products = Product::with('category')->paginate(10);
        $categories = Category::all();
        $products = ProductResource::collection($products);
        return view('products', compact(['products', 'categories']));
    }
    public function store(StoreProductRequest $request)
    {
        $validData = $request->validated();
        $validData['main_image'] = $this->uploadFile($request->file('main_image'), Product::PathToStoredImages);
        Product::create($validData);
        return redirect()->route('product.index');
    }

    public function show(Product $banner)
    {
        return $this->successResponse(ProductResource::make($banner));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validData = $request->validated();
        // return $validData;
        if ($request->hasFile('main_image')) {
            $this->deleteFile($product->main_image);
            $validData['main_image'] = $this->uploadFile($request->file('main_image'), Product::PathToStoredImages);
        }
        $product->update($validData);
        return redirect()->route('product.index');
    }

    public function destroy(Product $product)
    {
        $this->deleteFile($product->main_image);
        $product->delete();
        return redirect()->route('product.index');
    }
}
