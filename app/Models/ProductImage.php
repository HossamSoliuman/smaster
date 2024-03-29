<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class ProductImage extends Model
{
    use HasFactory;
    const PathToStoredImages = 'product image/images/paths';
    protected $fillable = [
        'product_id',
        'path',
        'type',
    ];



    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
