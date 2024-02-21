<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Hossam\Licht\Controllers\LichtBaseController;

class CategoryController extends LichtBaseController
{

    public function index()
    {
        $categories = Category::all();
        $categories = CategoryResource::collection($categories);
        return view('categories', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return redirect()->route('categories.index');
    }

    public function show(Category $category)
    {
        return $this->successResponse(CategoryResource::make($category));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index');
    }
}
