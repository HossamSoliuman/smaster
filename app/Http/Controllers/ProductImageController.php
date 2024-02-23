<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Http\Requests\StoreProductImageRequest;
use App\Http\Requests\UpdateProductImageRequest;
use App\Http\Resources\ProductImageResource;
use Hossam\Licht\Controllers\LichtBaseController;

class ProductImageController extends Controller
{

    public function store(StoreProductImageRequest $request)
    {
        $validData = $request->validated();
        $validData['path'] = $this->uploadFile($validData['path'], ProductImage::PathToStoredImages);
        $productImage = ProductImage::create($validData);
        return $this->apiResponse(['path' => $productImage->path]);
    }


    public function destroy(ProductImage $productImage)
    {
        $this->deleteFile($productImage->path);
        $productImage->delete();
        return redirect()->back();
    }
}
