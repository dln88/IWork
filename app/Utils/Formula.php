<?php

namespace App\Utils;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Formula
{
     /**
     * Calculte total working time.
     * 
     * @param string $startTime
     * @param string $endTime
     * @return int
     */
   public static function calculateWorkingTime(string $startTime, string $endTime)
   {
      $startHour = Str::substr($startTime, 0, 2);
      $endHour = Str::substr($endTime, 0, 2);
      $startMinute = Str::substr($startTime, 3, 2);
      $endMinute = Str::substr($endTime, 3, 2);
      
      $totalMinute = intval($endMinute) - intval($startMinute);
      if ($totalMinute < 0) {
         $startHour += 1;
         if ($totalMinute == -30) {
            $minute = 0.5;
         } else {
            $minute = (60 + $totalMinute)/100; 
         }
      } elseif ($totalMinute > 0) {
         if ($totalMinute == 30) {
            $minute = 0.5;
         } else {
            $minute = $totalMinute/100; 
         }
      } else {
         return $endHour - $startHour;
      }
      
      return ($endHour - $startHour) + $minute;
   }

   /**
    * Calculte break time.
    * 
    * @param int $workingTime
    */
   public static function calculateBreakTime(int $workingTime)
   {
      if ($workingTime >= 6) {
         return 1;
      }
      return 0;
   }

   /**
    * Calculte overtime.
    * 
    * @param number $workingTime
    */
   public static function calculateOverTime($workingTime)
   {
      if ($workingTime > 8) {
         return $workingTime - 8;
      }
      return 0;
   }

   /**
    * Calculte Midnight overtime.
    * 
    * @param int $workingTime
    * @param string $leavTime
    */
   public static function calculateLateNightOverTime($workingTime, $leavTime)
   {
      if ($workingTime > 8) {
         if ($leavTime > '22:00') {
            $latenightOvertimeHour = Str::substr($leavTime, 0, 2) - 22;
            $latenightOvertimeMinute = Str::substr($leavTime, 3, 2);
            if ($latenightOvertimeMinute == 30) {
               return $latenightOvertimeHour + 0.5;
            }

            if ($latenightOvertimeHour + $latenightOvertimeMinute/100 > 7.0) {
               return 7.0;
            }
            return $latenightOvertimeHour + $latenightOvertimeMinute/100;
         }
      }
      return 0;
   }

   /**
    * Calculation of interval time
    *
    * @return void
    */
   public static function calculateIntervalTime($attTime)
   {
      $attTime =  Carbon::parse($attTime);
      $query = "select att.regi_date, att.end_time
         from trn_attendance att
         where
            att.delete_flg = 0
            and att.operator_cd = ?
            and att.regi_date < ?
         order by att.regi_date desc
         limit 1";
      $attendance = DB::select($query,
         [
            session('user')->operator_cd,
            Carbon::parse($attTime)->format('Y-m-d')
         ]
      );
      if (count($attendance) == 0 || is_null($attendance[0]->regi_date) || is_null($attendance[0]->end_time)) {
         return 0.00;
      }
      $previousDate = $attendance[0]->regi_date;
      $previousEndTime = $attendance[0]->end_time;
      $year = Str::substr($previousDate, 0, 4);
      $month = Str::substr($previousDate, 5, 2);
      $day = Str::substr($previousDate, 8, 2);
      $hour = Str::substr($previousEndTime, 0, 2);
      $minute = Str::substr($previousEndTime, 3, 2);
      $endTime = Carbon::create($year, $month, $day, $hour, $minute);
      $interval = $attTime->diffInHours($endTime);
      if ($interval > 99.99) {
         return 99.99;
      }
      return $interval;
   }
}