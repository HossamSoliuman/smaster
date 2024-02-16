<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Clothing',
            'Home and Furniture',
            'Books and Literature',
            'Beauty and Personal Care',
            'Sports and Outdoors',
            'Toys and Games',
            'Automotive',
            'Health and Wellness',
            'Jewelry and Accessories'
        ];

        foreach ($categories as $categoryName) {
            Category::create([
                'name' => $categoryName
            ]);
        }
    }
}
