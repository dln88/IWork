<?php

namespace App\Utils;

use Carbon\Carbon;
use App\Models\LogLogin;
use App\Utils\OperatorName;

/**
 * Class Common
 * @package App\Utils
 */
class LogLoginUtil
{
    /**
     * Log Login failed.
     * 
     * @param array $data
     * 
     */
    public static function logLoginFail(array $data) {
        LogLogin::create([
            'operation_timestamp' => Carbon::now()->timestamp,
            'ip_address' => \Request::ip(),
            'user_id' => $data['user_id'],
            'operator_cd' => $data['operator_cd'] ?? null,
            'operator_name' => OperatorName::operatorName((array) $data),
            'operation_type' => config('define.operation_type.login'),
            'contents' => 'ログイン失敗',
        ]);
    }

    /**
     * Log Login successfully.
     * 
     */
    public static function logLoginSuccess() {
        LogLogin::create([
            'operation_timestamp' => Carbon::now()->timestamp,
            'ip_address' => \Request::ip(),
            'user_id' => session('user')->user_id,
            'operator_cd' => session('user')->operator_cd,
            'operator_name' =>  session('user')->operator_last_name. " " . session('user')->operator_first_name,
            'operation_type' => config('define.operation_type.login'),
            'contents' => 'ログイン成功',
        ]);
    }
}