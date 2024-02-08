<?php

namespace App\Traits;

use App\Models\CjAuth;
use Illuminate\Support\Facades\File;

trait CjToken
{
    public function getToken()
    {
        $cjAuth = CjAuth::first();
        return $cjAuth->access_token;
    }
}
