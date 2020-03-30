<?php


namespace App\Utils;

/**
 * Class Common
 * @package App\Utils
 */
class Common
{
    /**
     * Get Date Of Week Japanese
     * @param $date
     */
    public static function getDateOfWeek($date){
        $dayofweeks = ['日', '月', '火', '水', '木', '金', '土'];
        $w = date('w', strtotime($date));
        return $dayofweeks[$w];
    }
}