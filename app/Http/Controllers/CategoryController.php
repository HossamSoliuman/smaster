<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return $this->apiResponse(Category::with('products')->get());
    }
    public function products()
    {
        $products = Product::all();
        return $this->apiResponse($products);
    }
}
