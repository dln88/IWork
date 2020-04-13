<?php

namespace App\Utils;

use Carbon\Carbon;
use App\Models\LogAction;

/**
 * Class Common
 * @package App\Utils
 */
class LogActionUtil
{
    /**
     * Log Action.
     * 
     * @param array $data
     * 
     */
    public static function logAction(array $data) {
        LogAction::create([
            'operation_timestamp' => Carbon::now()->timestamp,
            'ip_address' => \Request::ip(),
            'operator_cd' => $data['operator_cd'] ?? null,
            'operator_name' => $data['operator_name'] ?? null,
            'screen_id' => $data['screen_id'] ?? null,
            'screen_name' => $data['screen_name'] ?? null,
            'operation' => $data['operation'] ?? null,
            'contents' => $data['contents'] ?? null,
        ]);
    }
}