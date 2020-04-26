<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Utils\Formula;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\AdminWorkRepositoryInterface;

class AdminWorkRepository implements AdminWorkRepositoryInterface
{
    public function getPostCD()
    {
        $query = "
            select post.post_cd, post.post_name
            from mst_post post
            where post.delete_flg = 0
            order by post.post_cd";
        return DB::select($query);
    }
    
    public function getTimeListByCondition(array $validatedData)
    {
        $currentYearMonth = Carbon::now()->format('Ym');
        $currentTimeTarget = Formula::calculateClosingDate($currentYearMonth);
        $targetYm = Carbon::parse($currentTimeTarget[0])->format('Ym');
        $query = "
            select
                ope.emp_no,
                ope.post_cd,
                post.post_name,
                ope.operator_cd,
                ope.operator_last_name || ope.operator_first_name as operator_name,
                cl.target_ym,
                coalesce (sum(att.working_time), 0.00) as sum_working_time,
                coalesce (sum(att.over_time), 0.00) as sum_over_time,
                coalesce (sum(att.late_over_time), 0.00) as late_over_time,
                coalesce (count(att.working_time), 0) as att_date,
                coalesce (paid_vacation.cnt, 0.00) as paid_vacation_cnt,
                coalesce (exchange_day.cnt, 0.00) as exchange_day_cnt,
                coalesce (special_leave.cnt, 0.00) as special_leave_cnt
            from
                mst_calendar cl
                
                inner join mst_operator ope
                    on ope.delete_flg = 0
                
                inner join mst_post post
                    on ope.post_cd = post.post_cd
                    and post.delete_flg =0
                
                left outer join trn_attendance att
                    on cl.calendar_ymd = att.regi_date
                    and ope.operator_cd = att.operator_cd
                    and att.delete_flg = 0
                
                left outer join (
                    select
                        hl.operator_cd,
                        hl.target_ym,
                        sum(hl.acquisition_num) as cnt
                    from
                        trn_holiday hl
                    where
                        hl.delete_flg = 0
                        and hl.withdrawal_kbn = 0
                        and hl.holiday_form = 1
                    group by
                        hl.operator_cd,
                        hl.target_ym
                ) paid_vacation
                    on ope.operator_cd = paid_vacation.operator_cd
                    and cl.target_ym = paid_vacation.target_ym
                
                left outer join (
                    select
                        hl.operator_cd,
                        hl.target_ym,
                        sum(hl.acquisition_num) as cnt
                    from
                        trn_holiday hl
                    where
                        hl.delete_flg = 0
                        and hl.withdrawal_kbn = 0
                        and hl.holiday_form = 2
                    group by
                        hl.operator_cd,
                        hl.target_ym
                ) exchange_day
                    on ope.operator_cd = exchange_day.operator_cd
                    and cl.target_ym = exchange_day.target_ym
                
                left outer join (
                    select
                        hl.operator_cd,
                        hl.target_ym,
                        sum(hl.acquisition_num) as cnt
                    from
                        trn_holiday hl
                    where
                        hl.delete_flg = 0
                        and hl.withdrawal_kbn = 0
                        and hl.holiday_form = 3
                    group by
                        hl.operator_cd,
                        hl.target_ym
                ) special_leave
                    on ope.operator_cd = special_leave.operator_cd
                    and cl.target_ym = special_leave.target_ym
            where
                cl.delete_flg = 0
                and cl.target_ym = ?";

        if (isset($validatedData['emp_num'])) {
            $empNum = $validatedData['emp_num'];
            $query .= " and to_number (ope.emp_no, '999999999999999') = $empNum";
        };

        if (isset($validatedData['department_id'])) {
            $departmentId = $validatedData['department_id'];
            $query .= " and ope.post_cd =  $departmentId";
        };

        if (isset($validatedData['name'])) {
            $fullname = $validatedData['name'];
            $query .= " and ope.operator_last_name || ope.operator_first_name like '%$fullname%'";
        }

        if (isset($validatedData['from_month'])) {
            $fromMonth = Carbon::create(
                Str::substr($validatedData['from_month'], 0, 4),
                Str::substr($validatedData['from_month'], 5, 2)
                )->format('Ym');
            $query .= " and cl.target_ym >= $fromMonth";
        };

        if (isset($validatedData['to_month'])) {
            $toMonth = Carbon::create(
                Str::substr($validatedData['to_month'], 0, 4),
                Str::substr($validatedData['to_month'], 5, 2)
                )->format('Ym');
            $query .= " and cl.target_ym <= $toMonth";
        };

        $query .= " group by
            ope.operator_cd,
            ope.post_cd,
            ope.emp_no,
            cl.target_ym,
            ope.operator_last_name,
            ope.operator_first_name,
            post.post_name,
            paid_vacation.cnt,
            exchange_day.cnt,
            special_leave.cnt";

        if (
            isset($validatedData['ot_min']) || isset($validatedData['ot_max']) ||
            isset($validatedData['on_min']) || isset($validatedData['on_max'])
        ) {
            $query .= " having ";
        };

        if (isset($validatedData['ot_min'])) {
            $otMin = $validatedData['ot_min'];
            $query .= " COALESCE(SUM(ATT.OVER_TIME), '0.00') >= $otMin";
            if (isset($validatedData['ot_max']) || isset($validatedData['on_min']) || isset($validatedData['on_max'])) {
                $query .= " and ";
            }
        };

        if (isset($validatedData['ot_max'])) {
            $otMax = $validatedData['ot_max'];
            $query .= " SUM (ATT.OVER_TIME) <= $otMax";
            if (isset($validatedData['on_min']) || isset($validatedData['on_max'])) {
                $query .= " and ";
            }
        };

        if (isset($validatedData['on_min'])) {
            $onMin = $validatedData['on_min'];
            $query .= " COALESCE(SUM(ATT.LATE_OVER_TIME), '0.00') >= $onMin";
            if (isset($validatedData['on_max'])) {
                $query .= " and ";
            }
        };

        if (isset($validatedData['on_max'])) {
            $onMax = $validatedData['on_max'];
            $query .= " SUM (ATT.LATE_OVER_TIME) <= $onMax";
        };
        
        $query .= " order by
            cl.target_ym,
            ope.emp_no;";
        return DB::select($query, [$targetYm]);
    }
    
    public function getUserByKey($id)
    {
        $query = "
            select
                ope.post_cd,
                po.post_name,
                ope.emp_no,
                ope.operator_cd,
                ope.operator_last_name || ope.operator_first_name as operator_name
            from
                mst_operator ope
                inner join mst_post po
                    on ope.post_cd = po.post_cd
                    and po.delete_flg = 0
            where
                ope.delete_flg = 0
                and ope.operator_cd = ?";

        return DB::select($query, [$id]);
    }

    public function getMonthlyReport($id, $yearMonth)
    {
        $query = "
            select
                cl.calendar_ymd,
                att.operator_cd,
                att.regi_date,
                att.start_time,
                att.end_time,
                att.break_time,
                att.working_time,
                att.over_time,
                att.late_over_time,
                att.ex_statutory_wk_time,
                att.interval_time,
                coalesce (hl_paid_vacation.acquisition_num, 0.00) paid_vacation_cnt,
                coalesce (hl_exchange_day.acquisition_num, 0.00) exchange_day_cnt,
                coalesce (hl_special_leave.acquisition_num, 0.00) special_leave_cnt,
                att.memo
            from mst_calendar cl
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
                cl.delete_flg = 0 and cl.target_ym = ?
            order by cl.calendar_ymd";

        return DB::select($query, [$id, $id, $id, $id, $yearMonth]);
    }

    public function getAttendanceByDate($id, $date)
    {
        $query = "
            select
                att.start_time,
                att.end_time,
                att.memo
            from trn_attendance att
            where
            att.delete_flg = 0
            and att.operator_cd = ?
            and att.regi_date = ?";
        return DB::select($query, [$id, $date]);
    }

    public function getVacationInformationByDate($id, $date)
    {
        $query = "
            select
                hl.holiday_form,
                coalesce (hl.acquisition_num, 0.00) cnt
            from trn_holiday hl
            where
                hl.delete_flg = 0
                and hl.operator_cd = ?
                and hl.holiday_form in (1,2,3)
                and hl.withdrawal_kbn = 0
                and hl.acquisition_ymd = ?";
        
        return DB::select($query, [$id, $date]);
    }

    public function findWorkDate($id, $date)
    {
        $query = "
            select post_cd, emp_no, att_time, leav_time, start_time, end_time
            from trn_attendance
            where operator_cd = ?
            and regi_date = ?
        ";

        return DB::select($query, [$id, $date]);
    }

    public function updateWorkDate($id, $data)
    {
        $startTime = $data['start'];
        $endTime = $data['end'];
        $totalWorkingTime = Formula::calculateWorkingTime($startTime, $endTime);
        $breakTime = Formula::calculateBreakTime($totalWorkingTime);
        $actualWorkingTime = $totalWorkingTime - $breakTime;
        $overTime = Formula::calculateOverTime($actualWorkingTime);
        $lateNightOverTime = Formula::calculateLateNightOverTime($actualWorkingTime, $endTime);
        $intervalTime = Formula::calculateIntervalTime($startTime, $data['date'], $id);
        return DB::table('trn_attendance')->where([
            'operator_cd' => $id,
            'regi_date' => $data['date'],
        ])->update([
            'start_time' => $startTime,
            'end_time' => $endTime,
            'break_time' => $breakTime,
            'working_time' => $actualWorkingTime,
            'over_time' => $overTime,
            'late_over_time' => $lateNightOverTime,
            'interval_time' => $intervalTime,
            'memo' => $data['memo'],
            'updater_cd' => $id,
            'update_date' => Carbon::now()->toDateTimeString(),
        ]);
    }

    public function insertWorkDate($id, $data)
    {
        $startTime = $data['start'];
        $endTime = $data['end'];
        $totalWorkingTime = Formula::calculateWorkingTime($startTime, $endTime);
        $breakTime = Formula::calculateBreakTime($totalWorkingTime);
        $actualWorkingTime = $totalWorkingTime - $breakTime;
        $overTime = Formula::calculateOverTime($actualWorkingTime);
        $lateNightOverTime = Formula::calculateLateNightOverTime($actualWorkingTime, $endTime);
        $intervalTime = Formula::calculateIntervalTime($startTime, $data['date'], $id);
        $targetYm = Formula::calculateTargetYearMonth($data['date']);
        return DB::table('trn_attendance')->insert([
            'operator_cd' => $id,
            'regi_date' => $data['date'],
            'post_cd' =>  session('user')->post_cd,
            'emp_no' => session('user')->emp_no,
            'target_ym' => $targetYm,
            'att_time' => Carbon::now()->toDateTimeString(),
            'start_time' => $startTime,
            'leav_time' => Carbon::now()->toDateTimeString(),
            'end_time' => $endTime,
            'break_time' => $breakTime,
            'working_time' => $actualWorkingTime,
            'over_time' => $overTime,
            'late_over_time' => $lateNightOverTime,
            'interval_time' => $intervalTime,
            'memo' => $data['memo'],
            'creater_cd' => $id,
            'create_date' => Carbon::now()->toDateTimeString(),
            'updater_cd' => $id,
            'update_date' => Carbon::now()->toDateTimeString(),
            'update_app' => '',
        ]);
    }

    public function updateVacation($id, $data)
    {
        return DB::table('trn_holiday')->where([
            'operator_cd' => $id,
            'acquisition_ymd' => $data['date'],
            'delete_flg' => 0
        ])->update([
            'update_date' => Carbon::now()->toDateTimeString(),
            'delete_flg' => 1
        ]);
    }

    public function existUserID($id)
    {
        return DB::table('mst_operator')->where('operator_cd', $id)->exists();
    }
}