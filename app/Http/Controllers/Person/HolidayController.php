<?php

namespace App\Http\Controllers\Person;

use Carbon\Carbon;
use App\Utils\Common;
use App\Utils\LogActionUtil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHolidayRequest;
use App\Repositories\Interfaces\HolidayRepositoryInterface;

class HolidayController extends Controller
{
    protected $holidayRepository;

    /**
     * Create a new controller instance function.
     *
     * @param HolidayRepositoryInterface $holidayRepository
     * @return void
     */
    public function __construct(HolidayRepositoryInterface $holidayRepository)
    {
        $this->middleware('person');

        $this->holidayRepository = $holidayRepository;
    }

    public function index(Request $request)
    {
        $paidVacationDays = $this->holidayRepository->getPaidVacationDays();
        $daysOff = $this->holidayRepository->getDaysOff(
            $paidVacationDays[0]->target_start,
            $paidVacationDays[0]->target_end
        );
        $paidLeave = $paidVacationDays[0]->grant_days - $daysOff[0]->cnt;
        $holidayLeave = $this->holidayRepository->getHolidayLeaveDays();
        $numberDaysOff = $this->holidayRepository->getNumberOfDaysOff(
            $holidayLeave[0]->target_start,
            $holidayLeave[0]->target_end
        );

        $balanceLeft = $holidayLeave[0]->grant_days - $numberDaysOff[0]->cnt;
        $vacationList = $this->holidayRepository->getVacationList();
        
        // Log action
        $dataLog = [
            'operation_timestamp' => Carbon::now()->timestamp,
            'ip_address' => \Request::ip(),
            'operator_cd' => session('user')->operator_cd,
            'operator_name' => Common::operatorName((array) session('user')),
            'screen_id' => 'H000001',
            'screen_name' => '休暇登録',
            'operation' => '初期処理',
            'contents' => 'なし',
        ];
        LogActionUtil::logAction($dataLog);

        return view('person.holiday', compact('balanceLeft', 'vacationList', 'paidVacationDays'));
    }

    public function store(StoreHolidayRequest $request)
    {
        $dateRegister = $request->date;

        // if(!$this->checkApplicationDatePast($dateRegister)) {
        //     return back()->withErrors('');
        // };

        // if(!$this->checkApplicationDateFuture($dateRegister)) {
        //     return back()->withErrors('');
        // };

        // if(!$this->doubleCheck($dateRegister)) {
        //     return back()->withErrors('');
        // };
        $this->holidayRepository->registHoliday($request->all());

        // Log action
        $dataLog = [
            'operation_timestamp' => Carbon::now()->timestamp,
            'ip_address' => \Request::ip(),
            'operator_cd' => session('user')->operator_cd,
            'operator_name' => Common::operatorName((array) session('user')),
            'screen_id' => 'H000001',
            'screen_name' => '休暇登録',
            'operation' => '休暇申請',
            'contents' => '休暇形態：vacation form, 休暇種別: vacation type, 休暇申請日: date',
        ];
        LogActionUtil::logAction($dataLog);

        return back()->with('message', '登録しました。');
    }

    private function checkApplicationDatePast($dateRegister)
    {
        $currentTime = Carbon::now()->format('Ym');
        $dateRegister = Carbon::parse($dateRegister)->format('Ym');
        if ($dateRegister >= $currentTime - config('define.holiday_app_past_mm.max')) {
            return true;
        }
        return false;
    }

    private function checkApplicationDateFuture($dateRegister)
    {
        $currentTime = Carbon::now()->format('Ym');
        $dateRegister = Carbon::parse($dateRegister)->format('Ym');
        if ($dateRegister <= $currentTime + config('define.holiday_app_fu_mm.max')) {
            return true;
        }
        return false;
    }

    private function doubleCheck($dateRegister)
    {
        return true;
    }
}
