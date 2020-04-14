<?php

namespace App\Http\Controllers\Common;

use App\Utils\LogLoginUtil;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Models\MstOperator;

/**
 * Auth Class : Login/Logout
 * Class AuthController
 * @package App\Http\Controllers\Common
 */
class TestController extends Controller
{
    function test(){
        dd(MstOperator::all());
    }
}