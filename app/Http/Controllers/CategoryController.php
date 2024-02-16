<?php

namespace App\Http\Controllers;

use App\Http\Resources\TestCategoryResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return $this->apiResponse(
            TestCategoryResource::collection(Category::with('products')->get())
        );
    }
    public function products()
    {
        $products = Product::all();
        return $this->apiResponse($products);
    }
}
