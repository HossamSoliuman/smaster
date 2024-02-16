<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Hossam\Licht\Traits\ApiResponse;

class CategoryController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $categories = $this->getCategories();
        return $this->successResponse($categories);
    }

    public function products(Request $request)
    {
        $pageNum = $request->input('pageNum', 1);
        $pageSize = $request->input('pageSize', 20);
        $categoryId = $request->input('categoryId');

        $response = Http::withHeaders([
            'CJ-Access-Token' => $this->getToken(),
        ])->get('https://developers.cjdropshipping.com/api2.0/v1/product/list', [
            'pageNum' => $pageNum,
            'pageSize' => $pageSize,
            'categoryId' => $categoryId,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return $this->successResponse($data);
        } else {
            return $this->errorResponse('Failed to fetch products', $response->status());
        }
    }

    private function getCategories()
    {
        $response = Http::withHeaders([
            'CJ-Access-Token' => $this->getToken(),
        ])->get('https://developers.cjdropshipping.com/api2.0/v1/product/getCategory');
        
        if ($response->successful()) {
            $data = $response->json();

            $categories = collect($data['data'])->map(function ($category) {
                return [
                    'categoryFirstName' => $category['categoryFirstName'],
                    'categoryFirstList' => collect($category['categoryFirstList'])->map(function ($firstList) {
                        return [
                            'categorySecondName' => $firstList['categorySecondName'],
                            'categorySecondList' => collect($firstList['categorySecondList'])->map(function ($secondList) {
                                return [
                                    'categoryId' => $secondList['categoryId'],
                                    'categoryName' => $secondList['categoryName']
                                ];
                            })->all()
                        ];
                    })->all()
                ];
            })->all();

            return $categories;
        } else {
            return [];
        }
    }
}
