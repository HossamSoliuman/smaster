<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Traits\CjToken;
use Hossam\Licht\Traits\ApiResponse;

class Controller extends BaseController
{
    use ApiResponse,AuthorizesRequests, DispatchesJobs, ValidatesRequests,CjToken;
}
