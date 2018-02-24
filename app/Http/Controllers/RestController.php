<?php

namespace App\Http\Controllers;

use App\Utility\ApiHelper;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class RestController extends BaseController
{

    public function loadTestUrl()
    {
        return ApiHelper::test();
    }
}
