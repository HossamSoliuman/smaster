<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class ApiCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return $this->apiResponse(CategoryResource::collection($categories));
    }
    public function products(Category $category)
    {
        $category->load('products');

        return $this->apiResponse(CategoryResource::make($category));
    }
}
