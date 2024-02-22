<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Traits\CjToken;
use App\Traits\ApiResponse;
use App\Traits\ManagesFiles;

class Controller extends BaseController
{
    use ManagesFiles, ApiResponse, AuthorizesRequests, DispatchesJobs, ValidatesRequests, CjToken;
}
