<?php

namespace App\Utils;

use Carbon\Carbon;
use App\Utils\Common;
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
    * @param string $attTime
    * @param string $dateAttendanceTime
    * @param int $operatorCd
    * @return integer
    */
   public static function calculateIntervalTime($attTime, $dateAttendanceTime, $operatorCd)
   {
      $dateAttendanceTime = Carbon::parse($dateAttendanceTime)->format('Y-m-d');
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
            $operatorCd,
            $dateAttendanceTime
         ]
      );
      if (count($attendance) < 1 || is_null($attendance[0]->regi_date) || is_null($attendance[0]->end_time)) {
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
      $attDate = Carbon::create(
         Str::substr($dateAttendanceTime, 0, 4),
         Str::substr($dateAttendanceTime, 5, 2),
         Str::substr($dateAttendanceTime, 8, 2),
         Str::substr($attTime, 0, 2),
         Str::substr($attTime, 3, 2)
      );
      $interval = $attDate->diffInHours($endTime);
      if ($interval > 99.99) {
         return 99.99;
      }
      return $interval;
   }

   /**
    * Calculate closing date.
    *
    * @param string $yearMonth
    * @return array
    */
   public static function calculateClosingDate(string $yearMonth)
   {
      $closingdate = Common::getSystemConfig('CLOSING_DATE');
      $currentYear = Str::substr($yearMonth, 0, 4);
      $currentMonth = Str::substr($yearMonth, 4, 2);
      $currentDate = Carbon::now()->format('d');
      $currentEndDate = Carbon::createFromFormat('m', $currentMonth)->lastOfMonth()->format('d');
      $startDateCurrentMonth = '';
      $endDateCurrentMonth = '';
      switch ($closingdate) {
         case '1':
            if ($currentDate > $closingdate) {
               $startDateCurrentMonth = Carbon::create($currentYear, $currentMonth, $closingdate + 1)->format('Y-m-d');
               $endDateCurrentMonth = Carbon::create($currentYear, $currentMonth + 1, $closingdate)->format('Y-m-d');
            } else {
               $startDateCurrentMonth = Carbon::create($currentYear, $currentMonth - 1, $closingdate + 1)->format('Y-m-d');
               $endDateCurrentMonth = Carbon::create($currentYear, $currentMonth, $closingdate)->format('Y-m-d');
            }
            break;
         case '10':
            if ($currentDate > $closingdate) {
               $startDateCurrentMonth = Carbon::create($currentYear, $currentMonth, $closingdate + 1)->format('Y-m-d');
               $endDateCurrentMonth = Carbon::create($currentYear, $currentMonth +1, $closingdate)->format('Y-m-d');
            } else {
               $startDateCurrentMonth = Carbon::create($currentYear, $currentMonth - 1, $closingdate + 1)->format('Y-m-d');
               $endDateCurrentMonth = Carbon::create($currentYear, $currentMonth, $closingdate)->format('Y-m-d');
            }
            break;
         case '15':
            if ($currentDate > $closingdate) {
               $startDateCurrentMonth = Carbon::create($currentYear, $currentMonth, $closingdate + 1)->format('Y-m-d');
               $endDateCurrentMonth = Carbon::create($currentYear, $currentMonth +1, $closingdate)->format('Y-m-d');
            } else {
               $startDateCurrentMonth = Carbon::create($currentYear, $currentMonth - 1, $closingdate + 1)->format('Y-m-d');
               $endDateCurrentMonth = Carbon::create($currentYear, $currentMonth, $closingdate)->format('Y-m-d');
            }
            break;
         case '20':
            if ($currentDate > $closingdate) {
               $startDateCurrentMonth = Carbon::create($currentYear, $currentMonth, $closingdate + 1)->format('Y-m-d');
               $endDateCurrentMonth = Carbon::create($currentYear, $currentMonth + 1, $closingdate)->format('Y-m-d');
            } else {
               $startDateCurrentMonth = Carbon::create($currentYear, $currentMonth - 1, $closingdate + 1)->format('Y-m-d');
               $endDateCurrentMonth = Carbon::create($currentYear, $currentMonth, $closingdate)->format('Y-m-d');
            }
            break;
         case '25':
            if ($currentDate > $closingdate) {
               $startDateCurrentMonth = Carbon::create($currentYear, $currentMonth, $closingdate + 1)->format('Y-m-d');
               $endDateCurrentMonth = Carbon::create($currentYear, $currentMonth + 1, $closingdate)->format('Y-m-d');
            } else {
               $startDateCurrentMonth = Carbon::create($currentYear, $currentMonth - 1, $closingdate + 1)->format('Y-m-d');
               $endDateCurrentMonth = Carbon::create($currentYear, $currentMonth, $closingdate)->format('Y-m-d');
            }
            break;
         default:
            $startDateCurrentMonth = Carbon::create($currentYear, $currentMonth, 1)->format('Y-m-d');
            $endDateCurrentMonth = Carbon::create($currentYear, $currentMonth, $currentEndDate)->format('Y-m-d');
      }
      return [$startDateCurrentMonth, $endDateCurrentMonth];
   }

   /**
    * Calculte target year month.
    * 
    * @param string $date
    * @return string
    */
    public static function calculateTargetYearMonth(string $date)
    {
        $date = Str::replaceFirst('-', '/', $date);
        $date = Str::replaceFirst('-', '/', $date);
        $currentTimeTarget = Formula::calculateClosingDate(Carbon::parse($date)->format('Ym'));
        if ($date < Carbon::parse($currentTimeTarget[0])->format('Y/m/d')) {
            return Carbon::parse($date)->subMonth()->format('Ym');
        } else if ($date > Carbon::parse($currentTimeTarget[1])->format('Y/m/d')) {
            return Carbon::parse($date)->addMonth()->format('Ym');
        } else {
            return Carbon::parse($date)->format('Ym');
        }
    }
}
