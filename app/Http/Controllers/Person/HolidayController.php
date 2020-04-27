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

    /**
     * Holiday Vacation Page.
     *
     * @param Request $request
     * @return view
     */
    public function index(Request $request)
    {
        try {
            $paidVacationDays = $this->holidayRepository->getPaidVacationDays();
            $paidLeave = 0;
            $balanceLeft = 0;
            if (count($paidVacationDays) > 0) {
                $daysOff = $this->holidayRepository->getDaysOff(
                    $paidVacationDays[0]->target_start,
                    $paidVacationDays[0]->target_end
                );
                $paidLeave = $paidVacationDays[0]->grant_days - $daysOff[0]->cnt;
            }
            
            $holidayLeave = $this->holidayRepository->getHolidayLeaveDays();
            
            if (count($holidayLeave)) {
                $numberDaysOff = $this->holidayRepository->getNumberOfDaysOff(
                    $holidayLeave[0]->target_start,
                    $holidayLeave[0]->target_end
                );
                $balanceLeft = $holidayLeave[0]->grant_days - $numberDaysOff[0]->cnt;
            }
           
            $vacationList = $this->holidayRepository->getVacationList();

            // Log action
            $dataLog = [
                'operation_timestamp' => Carbon::now()->timestamp,
                'ip_address' => \Request::ip(),
                'operator_cd' => session('user')->operator_cd,
                'operator_name' => Common::operatorName((array) session('user')),
                'screen_id' => 'H000001',
                'screen_name' => Common::getScreenName('H000001'),
                'operation' => '初期処理',
                'contents' => 'なし',
            ];
            LogActionUtil::logAction($dataLog);

            $currentDate = Carbon::now()->format('Y/m/d');
            return view('person.holiday', compact('balanceLeft', 'vacationList', 'paidLeave', 'currentDate'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Regist a vacation.
     *
     * @param StoreHolidayRequest $request
     * @return view
     */
    public function store(StoreHolidayRequest $request)
    {
        try {
            $dateRegister = $request->date;
            if($this->isOverApplicationDatePast($dateRegister)) {
                $holidayAppPast = Common::getSystemConfig('HOLIDAY_APP_PAST_MM');
                return back()->withInput($request->input())->withErrors($holidayAppPast . config('messages.010015'));
            };

            if($this->isOverApplicationDateFuture($dateRegister)) {
                $holidayAppFuture = Common::getSystemConfig('HOLIDAY_APP_FU_MM');
                return back()->withInput()->withErrors($holidayAppFuture . config('messages.010016'));
            };

            if($this->doubleCheck($dateRegister)) {
                return back()->withInput()->withErrors(config('messages.010005'));
            };
            
            if (!$this->holidayRepository->registHoliday($request->all())) {
                return back()->withInput()->withErrors(config('messages.000009'));
            };

            // Log action
            $dataLog = [
                'operation_timestamp' => Carbon::now()->timestamp,
                'ip_address' => \Request::ip(),
                'operator_cd' => session('user')->operator_cd,
                'operator_name' => Common::operatorName((array) session('user')),
                'screen_id' => 'H000001',
                'screen_name' => Common::getScreenName('H000001'),
                'operation' => '休暇申請',
                'contents' => "休暇形態：$request->type, 休暇種別: $request->type_day, 休暇申請日: $dateRegister",
            ];
            LogActionUtil::logAction($dataLog);

            return back()->withInput()->with('message', config('messages.000004'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Check if the registration date has passed the allowed past date
     *
     * @param string $dateRegister
     * @return boolean
     */
    private function isOverApplicationDatePast(string $dateRegister)
    {
        $dateRegister = Carbon::parse($dateRegister)->format('Y-m-d');
        return $dateRegister < Carbon::now()->subMonth(Common::getSystemConfig('HOLIDAY_APP_PAST_MM'))->format('Y-m-d');
    }

    /**
     * Check if the registration date has passed the allowed future date
     *
     * @param string $dateRegister
     * @return boolean
     */
    private function isOverApplicationDateFuture(string $dateRegister)
    {
        $dateRegister = Carbon::parse($dateRegister)->format('Y-m-d');
        return $dateRegister > Carbon::now()->addMonth(Common::getSystemConfig('HOLIDAY_APP_FU_MM'))->format('Y-m-d');
    }

    /**
     * Check if registration date already exists 
     *
     * @param string $dateRegister
     * @return boolean
     */
    private function doubleCheck(string $dateRegister)
    {
        return $this->holidayRepository->checkExistRegisterDate($dateRegister);
    }
}
