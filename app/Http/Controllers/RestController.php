<?php

namespace App\Http\Controllers;

use App\Utility\Utility;
use Illuminate\Http\Request;

class RestController extends BaseController
{
    public function loadTestUrl()
    {
        return  response(Utility::test()->getBody())->j;
    }
}
