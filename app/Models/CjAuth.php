<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class CjAuth extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'email',
        'key',
        'access_token',
        'access_token_expiry_date',
        'refresh_token',
        'refresh_token_expiry_date'
    ];
}
