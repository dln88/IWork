<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Utils\Common;
use App\Utils\Formula;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\HolidayRepositoryInterface;

class HolidayRepository implements HolidayRepositoryInterface
{
    public function getVacationList()
    {
        $holidayRow = Common::getSystemConfig('HOLIDAY_ROWS');
        $holidayPassMM = Carbon::now()->subMonths(Common::getSystemConfig('HOLIDAY_PAST_MM') - 1)->toDateString();
        $query = "select 
            hl.acquisition_ymd,
            holiday_form_name.item_name as holiday_form,
            holiday_class_name.item_name as holiday_class,
            hl.withdrawal_kbn,
            case
                when hl.withdrawal_kbn = 1 then '取消'
                when hl.acquisition_ymd < CURRENT_TIMESTAMP then '取得済'		
                else '予定'		
                end acquisition_st,			
            hl.acquisition_num          
            from
                trn_holiday hl		    
                left outer join mst_itemname holiday_form_name			
                on holiday_form_name.item_name_cd = 1		
                and holiday_form_name.item_name_value = hl.holiday_form		
                and holiday_form_name.delete_flg = 0           
            left outer join mst_itemname holiday_class_name			
                on holiday_class_name.item_name_cd = 2		
                and holiday_class_name.item_name_value = hl.holiday_class		
                and holiday_class_name.delete_flg = 0            
            where				
                hl.delete_flg = 0			
                and hl.operator_cd = ?		
                and hl.acquisition_ymd >= ?		               
            order by				
                hl.acquisition_ymd desc,			
                hl.withdrawal_kbn asc,			
                hl.holiday_form asc,			
                hl.holiday_cd desc
            limit ?";

        $condition = [
            session('user')->operator_cd,
            $holidayPassMM,
            $holidayRow
        ];
        return DB::select($query, $condition);
    }

    public function getPaidVacationDays()
    {
        $currentDate = Carbon::now()->toDateString();
        $query = "select	
            pv.operator_cd,
            pv.grant_days,
            pv.target_start,
            pv.target_end
            from	
                mst_paid_vacation pv  
            where
                pv.delete_flg = 0
                and pv.operator_cd = ?
                and pv.target_start <= ?
                and pv.target_end >= ?";

        return DB::select($query, [session('user')->operator_cd, $currentDate, $currentDate]);
    }

    public function getDaysOff($targetStart, $targetEnd)
    {
        $currentDate = Carbon::now()->toDateString();
        $query = "select
            sum (hl.acquisition_num) as cnt
        from trn_holiday hl
        where
            hl.delete_flg = 0
            and hl.withdrawal_kbn = 0
            and hl.holiday_form = 1
            and hl.operator_cd = ?
            and hl.acquisition_ymd between ? and ?";
        return DB::select($query, [session('user')->operator_cd, $targetStart, $targetEnd]);
    }

    public function getHolidayLeaveDays()
    {
        $currentDate = Carbon::now()->toDateString();
        $query = "select
            ed.operator_cd,
            ed.grant_days,
            ed.target_start,
            ed.target_end
        from mst_exchange_day ed
        where
            ed.delete_flg = 0
            and ed.operator_cd = ?
            and ed.target_start <= ?
            and ed.target_end >= ?";
        return DB::select($query, [session('user')->operator_cd, $currentDate, $currentDate]);
    }

    public function getNumberOfDaysOff($targetStart, $targetEnd)
    {
        $query = "select
                sum (hl.acquisition_num) as cnt
            from trn_holiday hl
            where
                hl.delete_flg = 0
                and hl.withdrawal_kbn = 0
                and hl.holiday_form = 2
                and hl.operator_cd = ?
                and hl.acquisition_ymd between ? and ?
        ";
        return DB::select($query, [session('user')->operator_cd, $targetStart, $targetEnd]);
    }
    
    public function registHoliday(array $data)
    {
        $targetYm = Formula::calculateTargetYearMonth($data['date']);
        return DB::table('trn_holiday')->insert([
            'operator_cd' => session('user')->operator_cd,
            'acquisition_ymd' => $data['date'],
            'post_cd' => session('user')->post_cd,
            'holiday_form' => $data['type'],
            'holiday_class' => $data['day_type'],
            'acquisition_num' => Common::acquisitionNumber($data['day_type']),
            'target_ym' => $targetYm,
            'withdrawal_kbn' => 0,
            'creater_cd' => session('user')->operator_cd,
            'create_date' =>  Carbon::now()->toDateTimeString(),
            'updater_cd' => session('user')->operator_cd,
            'update_date' =>  Carbon::now()->toDateTimeString(),
            'update_app' => '',
        ]);
    }
    
    public function checkExistRegisterDate(string $dateRegister)
    {
        $query = "select hl.acquisition_num
            from trn_holiday hl
            where
                hl.delete_flg = 0
                and hl.operator_cd = ?
                and hl.acquisition_ymd = ?";
        $holiday = DB::select($query, [session('user')->operator_cd, $dateRegister]);
        if(count($holiday) > 0) {
            return true;
        }
        return false;
    }
}
