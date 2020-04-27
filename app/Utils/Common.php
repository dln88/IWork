<?php

namespace App\Utils;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Common
{
    /**
     * Get full name of operator.
     * 
     * @param array $data
     */
    public static function operatorName(array $data) {
        if (isset($data['operator_last_name']) && isset($data['operator_first_name'])) {
            return $data['operator_last_name'] . $data['operator_first_name'];
        }
        return null;
    }
    
    /**
     * Get acquisition number.
     * 
     * @param int $typeVacationDate
     */
    public static function acquisitionNumber(int $typeVacationDate) {
        if ($typeVacationDate == 1) {
            return 1;
        }
        return 0.5;
    }

    /**
     * Get name of screen function
     *
     * @param string $systemConfigName
     * @return string
     */
    public static function getSystemConfig(string $systemConfigName)
    {
        $query = "select m_conf.systemconf_value
            from mst_systemconfig m_conf
            where m_conf.delete_flg = 0
                and m_conf.systemconf_name = ?";

        $systemConfig =  DB::select($query, [$systemConfigName]);
        return $systemConfig[0]->systemconf_value;
    }

    /**
     * Get name of screen function
     *
     * @param string $screenId
     * @return string
     */
    public static function getScreenName(string $screenId)
    {
        $query = "select m_s.screen_name
            from mst_screen m_s
            where m_s.delete_flg = 0
                and m_s.screen_id = ?";
        $screen =  DB::select($query, [$screenId]);
        return $screen[0]->screen_name;
    }

    /**
     * Convert date to day of week.
     *
     * @param string $date
     * @return string
     */
    public static function convertToDayOfWeek(string $date)
    {
        switch (Carbon::parse($date)->dayOfWeek) {
            case 1:
                return  '月';
                break;
            case 2:
                return  '火';
                break;
            case 3:
                return  '水';
                break;
            case 4:
                return  '木';
                break;
            case 5:
                return  '金';
                break;
            case 6:
                return  '土';
                break;
           default:
               return '日';
               break;
       }
    }
}
