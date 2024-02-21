<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Product extends Model
{
    use HasFactory;
    const PathToStoredImages = 'products/images';
    protected $fillable = [
        'name',
        'description',
        'main_image',
        'price',
        'category_id',
    ];



    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
