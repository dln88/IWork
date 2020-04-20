<?php

namespace App\Repositories;

use Carbon\Carbon;
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

    public function getTimeList($page = 1)
    {
        if ($page == 0) {
            $offset = 0;
        } else {
            $offset = ($page - 1) * config('define.work_admin_rows.max');
        }
        $query = "
            select
                ope.emp_no,
                ope.post_cd,
                post.post_name,
                ope.operator_cd,
                ope.operator_last_name || ope.operator_first_name as operator_name,
                att.target_ym,
                coalesce (sum (att.working_time), 0.00) as sum_working_time,
                coalesce (sum (att.over_time), 0.00) as sum_over_time,
                coalesce (sum (att.late_over_time), 0.00) as late_over_time,
                coalesce (count (att.working_time), 0) as att_date,
                coalesce (paid_vacation.cnt, 0.00) as paid_vacation_cnt,
                coalesce (exchange_day.cnt, 0.00) as exchange_day_cnt,
                coalesce (special_leave.cnt, 0.00) as special_leave_cnt
            from
                mst_calendar cl
                inner join mst_operator ope
                    on ope.delete_flg = 0
                inner join mst_post post
                    on ope.post_cd = post.post_cd
                    and post.delete_flg = 0
                left outer join trn_attendance att
                    on cl.calendar_ymd = att.regi_date
                    and ope.operator_cd = att.operator_cd
                    and att.delete_flg = 0
                left outer join (
                    select
                        hl.operator_cd,
                        hl.target_ym,
                        sum (hl.acquisition_num) as cnt
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
                    on ope.operator_cd = att.operator_cd
                    and att.target_ym = paid_vacation.target_ym					
                left outer join (
                    select
                        hl.operator_cd,
                        hl.target_ym,
                        sum (hl.acquisition_num) as cnt
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
                    and att.target_ym = exchange_day.target_ym
                left outer join (
                    select
                        hl.operator_cd,
                        hl.target_ym,
                        sum (hl.acquisition_num) as cnt
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
                    and att.target_ym = special_leave.target_ym
            where
                cl.delete_flg = 0
                and att.target_ym = ?
            group by
                ope.operator_cd,
                ope.post_cd,
                ope.emp_no,
                att.target_ym,
                ope.operator_last_name,
                ope.operator_first_name,
                post.post_name,
                paid_vacation.cnt,
                exchange_day.cnt,
                special_leave.cnt
            order by
                att.target_ym,
                ope.emp_no
            limit ?
            offset ?";
        
        $condition = [
            Carbon::now()->format('Ym'),
            config('define.work_admin_rows.max'),
            $offset
        ];
        return DB::select($query, $condition);
    }
    
    public function getTimeListByCondition($page = 1, array $validatedData)
    {
        $validatedData['from_month'] = Carbon::create(
            Str::substr($validatedData['from_month'], 0, 4),
            Str::substr($validatedData['from_month'], 5, 2)
            )->format('Ym');
        $validatedData['to_month'] = Carbon::create(
            Str::substr($validatedData['to_month'], 0, 4),
            Str::substr($validatedData['to_month'], 5, 2)
            )->format('Ym');
        if ($page == 0) {
            $offset = 0;
        } else {
            $offset = ($page - 1) * config('define.work_admin_rows.max');
        }
        $query = "
            select
                ope.emp_no,
                ope.post_cd,
                post.post_name,
                ope.operator_cd,
                ope.operator_last_name || ope.operator_first_name as operator_name,
                att.target_ym,
                coalesce (sum (att.working_time), 0.00) as sum_working_time,
                coalesce (sum (att.over_time), 0.00) as sum_over_time,
                coalesce (sum (att.late_over_time), 0.00) as late_over_time,
                coalesce (count (att.working_time), 0) as att_date,
                coalesce (paid_vacation.cnt, 0.00) as paid_vacation_cnt,
                coalesce (exchange_day.cnt, 0.00) as exchange_day_cnt,
                coalesce (special_leave.cnt, 0.00) as special_leave_cnt
            from
                mst_calendar cl
                inner join mst_operator ope
                    on ope.delete_flg = 0
                inner join mst_post post
                    on ope.post_cd = post.post_cd
                    and post.delete_flg = 0
                left outer join trn_attendance att
                    on cl.calendar_ymd = att.regi_date
                    and ope.operator_cd = att.operator_cd
                    and att.delete_flg = 0
                left outer join (
                    select
                        hl.operator_cd,
                        hl.target_ym,
                        sum (hl.acquisition_num) as cnt
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
                    on ope.operator_cd = att.operator_cd
                    and att.target_ym = paid_vacation.target_ym					
                left outer join (
                    select
                        hl.operator_cd,
                        hl.target_ym,
                        sum (hl.acquisition_num) as cnt
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
                    and att.target_ym = exchange_day.target_ym
                left outer join (
                    select
                        hl.operator_cd,
                        hl.target_ym,
                        sum (hl.acquisition_num) as cnt
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
                    and att.target_ym = special_leave.target_ym
            where
                cl.delete_flg = 0
                and att.target_ym >= ?
                and att.target_ym <= ?";
        if(!is_null($validatedData['emp_num'])) {
            $empNum = $validatedData['emp_num'];
            $query .= " and to_number (ope.emp_no, '999999999999999') = $empNum";
        };

        if(!is_null($validatedData['department_id'])) {
            $departmentId = $validatedData['department_id'];
            $query .= " and ope.post_cd =  $departmentId";
        };

        if(!is_null($validatedData['name'])) {
            $fullname = $validatedData['name'];
            $query .= " and ope.operator_last_name || ope.operator_first_name like '%$fullname%'";
        }

        $query .= " group by
                ope.operator_cd,
                ope.post_cd,
                ope.emp_no,
                att.target_ym,
                ope.operator_last_name,
                ope.operator_first_name,
                post.post_name,
                paid_vacation.cnt,
                exchange_day.cnt,
                special_leave.cnt
            order by
                att.target_ym,
                ope.emp_no
            limit ?
            offset ?";
        
        $condition = [
            $validatedData['from_month'],
            $validatedData['to_month'],
            config('define.work_admin_rows.max'),
            $offset
        ];
        return DB::select($query, $condition);
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

    public function getMonthlyReport($id, $yearMonth = '202004')
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
                    and hl_exchange_day.holiday_form = 1
                    and hl_exchange_day.withdrawal_kbn = 0
                    and hl_exchange_day.delete_flg = 0
                left outer join trn_holiday hl_special_leave
                    on hl_special_leave.operator_cd = ?
                    and hl_special_leave.acquisition_ymd = cl.calendar_ymd
                    and hl_special_leave.holiday_form = 1
                    and hl_special_leave.withdrawal_kbn = 0
                    and hl_special_leave.delete_flg = 0
            where
                cl.delete_flg = 0 and att.target_ym = ?
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
}