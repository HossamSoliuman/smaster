<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Navicon extends Model
{
    use HasFactory;
    const PathToStoredImages='navicon/images/images';
    protected $fillable=[
			'url',
			'image',
    ];



}
