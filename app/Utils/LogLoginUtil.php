<?php

namespace App\Utils;

use App\Models\LogLogin;
use Carbon\Carbon;

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
            'operator_name' => self::operatorName($data),
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
 
    /**
     * check name of operator.
     * 
     * @param array $data
     */
    private static function operatorName(array $data) {
        if (isset($data['operator_last_name']) && isset($data['operator_first_name'])) {
            return $data['operator_last_name']. " ". $data['operator_first_name'];
        }
        return null;
    }
}