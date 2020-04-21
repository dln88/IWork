<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Utils\Common;
use App\Utils\Formula;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\WorkDatesRepositoryInterface;

class WorkDatesRepository implements WorkDatesRepositoryInterface
{
   /**
    * Get start time and end time of the post which post_cd given function
    *
    * @param int $postCd
    * @return collection
    */
   public function getTimePost(int $postCd)
   {
      $query = "select po.post_start_time, po.post_end_time
         from mst_post po where po.post_cd = ?";

      return DB::select($query, [$postCd]);
   }

  /**
    * Get work dates of user which operator_cd given.
    *
    * @param int $operatorCd
    * @param string $firstDayofMonth
    * @param string $lastDayofMonth
    * @return collection
    */
    public function getWorkDates(int $operatorCd, $firstDayofMonth, $lastDayofMonth)
   {
      $query = "select 
         cl.calendar_ymd,
         att.regi_date,
         att.start_time,
         att.end_time,
         att.break_time,
         att.working_time,
         att.over_time,
         att.late_over_time,
         att.ex_statutory_wk_time,
         att.interval_time,
         coalesce(hl_paid_vacation.acquisition_num, 0.00) paid_vacation_cnt,
         coalesce(hl_exchange_day.acquisition_num, 0.00) exchange_day_cnt,
         coalesce(hl_special_leave.acquisition_num, 0.00) special_leave_cnt
      from
         mst_calendar cl
         left outer join trn_attendance att
         on cl.calendar_ymd = att.regi_date
         and att.operator_cd = ?
         and att.delete_flg = 0
         
         left outer join trn_holiday hl_paid_vacation
            on hl_paid_vacation.operator_cd = ?
            and hl_paid_vacation.acquisition_ymd = cl.calendar_ymd
            and hl_paid_vacation.holiday_form = 1
            and hl_paid_vacation.withdrawal_kbn = 0
            and hl_paid_vacation.delete_flg = 0
            
         left outer join trn_holiday hl_exchange_day
            on hl_exchange_day.operator_cd = ?
            and hl_exchange_day.acquisition_ymd = cl.calendar_ymd
            and hl_exchange_day.holiday_form = 2
            and hl_exchange_day.withdrawal_kbn = 0
            and hl_exchange_day.delete_flg = 0
         
         left outer join trn_holiday hl_special_leave
            on hl_special_leave.operator_cd = ?
            and hl_special_leave.acquisition_ymd = cl.calendar_ymd
            and hl_special_leave.holiday_form = 3
            and hl_special_leave.withdrawal_kbn = 0
            and hl_special_leave.delete_flg = 0
      where
         cl.delete_flg = 0
         and cl.calendar_ymd between ? and ?
      order by
         cl.calendar_ymd";

      return DB::select($query, [$operatorCd, $operatorCd, $operatorCd, $operatorCd, $firstDayofMonth, $lastDayofMonth]);
   }

    /**
     * Whether the total overtime hours exceeds the warning overtime hours limit.
     *
     * @param int $operatorCd
     * @param string $firstDayofMonth
     * @param string $lastDayofMonth
     * @return boolean
     */
    public function isOverTime(int $operatorCd, $firstDayofMonth, $lastDayofMonth)
   {
      $query = "select sum(over_time) 
         from trn_attendance 
         where operator_cd = ?
         and regi_date between ? and ?";

      $sumOverTime = DB::select($query, [$operatorCd, $firstDayofMonth, $lastDayofMonth]);
      $overTimeMax = Common::getSystemConfig('ALERT_OVER_TIME');
      return intval($sumOverTime[0]->sum) >= $overTimeMax;
   }

   /**
     * Get attendance information of current user.
     *
     * @param integer $operatorCd
     * @return boolean
     */
   public function checkAttendanceTime(int $operatorCd)
   {
      $currentDate = Carbon::now()->toDateString();
      $query = "select
            att.regi_date,
            att.target_ym,
            att.att_time,
            att.leav_time,
            att.start_time,
            att.end_time,
            att.break_time,
            att.working_time,
            att.over_time,
            att.late_over_time,
            att.ex_statutory_wk_time,
            att.interval_time
         from trn_attendance att
         where
            att.delete_flg = 0
            and att.operator_cd = ?
            and att.regi_date = ?";

      $attendanceTime = DB::select($query, [$operatorCd, $currentDate]);

      if(count($attendanceTime) > 0) {
         return true;
      }
      return false;
   }

   /**
    * Regist start time of current user.
    *
    * @param integer $operatorCd
    * @param string $startTime
    * @return collection
    */
   public function registerAttendanceTime(int $operatorCd, string $startTime)
   {
      return DB::table('trn_attendance')->insert([
         'operator_cd' => $operatorCd,
         'regi_date' => Carbon::now()->toDateString(),
         'post_cd' =>  session('user')->post_cd,
         'emp_no' => session('user')->emp_no,
         'target_ym' => 0,
         'att_time' => Carbon::now()->toDateTimeString(),
         'start_time' => $startTime,
         'break_time' => 0.00,
         'working_time' => 0.00,
         'over_time' => 0.00,
         'late_over_time' => 0.00,
         'ex_statutory_wk_time' => 0.00,
         'interval_time' => 0,
         'creater_cd' => $operatorCd,
         'create_date' => Carbon::now()->toDateTimeString(),
         'updater_cd' => $operatorCd,
         'update_date' => Carbon::now()->toDateTimeString(),
         'update_app' => 0,
      ]);
   }

   /**
    * whether leave time greater than attendance time
    *
    * @param integer $operatorCd
    * @param string $endTime
    * @return boolean
    */
   public function checkEndTimeGreaterStartTime(int $operatorCd, string $endTime)
   {
      $currentDate = Carbon::now()->toDateString();
      $query = "select start_time
         from trn_attendance 
         where operator_cd = ?
         and regi_date = ?";

      $startTime = DB::select($query, [$operatorCd, $currentDate]);
      
      if (
         (intval(Str::substr($endTime, 0, 2)) > intval(Str::substr($startTime[0]->start_time, 0, 2)) ) or 
         (
            intval(Str::substr($endTime, 0, 2)) === intval(Str::substr($startTime[0]->start_time, 0, 2)) and
            intval(Str::substr($endTime, 2, 2)) > intval(Str::substr($startTime[0]->start_time, 2, 2))
         )
      ) {
         return true;
      }
      return false;
   }

   /**
    * Check leave information of current user.
    *
    * @param integer $operatorCd
    * @return boolean
    */
   public function checkLeaveTime(int $operatorCd)
   {
      $currentDate = Carbon::now()->toDateString();
      $query = "select att.leav_time
         from trn_attendance att
         where
            att.delete_flg = 0
            and att.operator_cd = ?
            and att.regi_date = ?";

      $leaveTime = DB::select($query, [$operatorCd, $currentDate]);
      if(!is_null($leaveTime[0]->leav_time)) {
         return true;
      }
      return false;
   }

   /**
    * Regist leave time of current user.
    *
    * @param integer $operatorCd
    * @param string $endTime
    * @param string $currentDate
    * @return collection
    */
   public function registLeaveTime(int $operatorCd, string $endTime, string $currentDate)
   {
      return DB::table('trn_attendance')->where([
            'operator_cd' => $operatorCd,
            'regi_date' => $currentDate,
         ])->update([
            'target_ym' => Carbon::parse($currentDate)->format('Ym'),
            'leav_time' => Carbon::now()->toDateTimeString(),
            'end_time' => $endTime,
            'break_time' => 0.00,
            'working_time' => 0.00,
            'over_time' => 0.00,
            'late_over_time' => 0.00,
            'ex_statutory_wk_time' => 0.00,
            'memo' => '',
            'updater_cd' => $operatorCd,
            'update_date' => Carbon::now()->toDateTimeString(),
         ]);
   }

   /**
     *  Caculate working time, break time, overtime, late night overtime and save them to db.
     *
     * @param int $operatorCd
     * @return boolean
     */
   public function caculateAndRegistTime(int $operatorCd)
   {
      $currentDate = Carbon::now()->toDateString();
      $time = $this->getStartTimeandEndTime($operatorCd);
      $startTime = $time[0]->start_time;
      $endTime = $time[0]->end_time;
      $totalWorkingTime = Formula::calculateWorkingTime($startTime, $endTime);
      $breakTime = Formula::calculateBreakTime($totalWorkingTime);
      $actualWorkingTime = $totalWorkingTime - $breakTime;
      $overTime = Formula::calculateOverTime($actualWorkingTime);
      $lateNightOverTime = Formula::calculateLateNightOverTime($actualWorkingTime, $endTime);
      $intervalTime = Formula::calculateIntervalTime($startTime);
      
      return DB::table('trn_attendance')->where([
            'operator_cd' => $operatorCd,
            'regi_date' => $currentDate,
         ])->update([
            'break_time' => $breakTime,
            'working_time' => $actualWorkingTime,
            'over_time' => $overTime,
            'late_over_time' => $lateNightOverTime,
            'interval_time' => $intervalTime,
            'updater_cd' => $operatorCd,
            'update_date' => Carbon::now()->toDateTimeString(),
         ]);
   }

   /**
    * Get start time and end time of current user.
    *
    * @param integer $operatorCd
    * @return collection
    */
   public function getStartTimeandEndTime(int $operatorCd)
   {
      $currentDate = Carbon::now()->toDateString();
      $query = "select att.start_time, att.end_time
         from trn_attendance att
         where
            att.delete_flg = 0
            and att.operator_cd = ?
            and att.regi_date = ?";

      return DB::select($query, [$operatorCd, $currentDate]);
   }
}
