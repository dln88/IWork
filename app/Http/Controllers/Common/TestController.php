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
        $dbconn=pg_connect( "dbname=" . env('DB_DATABASE')." host=" . env('DB_HOST'). " port=" . env('DB_PORT') . "  
user=" . env('DB_USERNAME') . " password=" . env('DB_PASSWORD') );
        if ( ! $dbconn ) {
            echo "Error connecting to the database !<br> " ;
            printf("%s", pg_errormessage( $dbconn ) );
            exit(); 
        }
        else {
            echo "Connect Successful"; die;
        }
        dd(MstOperator::all());
    }
}