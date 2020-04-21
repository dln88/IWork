<?php

namespace App\Http\Controllers\Person;

use Carbon\Carbon;
use App\Utils\Common;
use Illuminate\Support\Str;
use App\Utils\LogActionUtil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\WorkDatesRepositoryInterface;
use App\Utils\Formula;

class WorkDatesController extends Controller
{
    protected $workDatesRepository;

    /**
     * Create a new controller instance function.
     *
     * @param WorkDatesRepositoryInterface $workDatesRepository
     * @return void
     */
    public function __construct(WorkDatesRepositoryInterface $workDatesRepository)
    {
        $this->middleware('person');

        $this->workDatesRepository = $workDatesRepository;
    }

    public function index(Request $request){
        if (!session('user')) {
            return redirect(route('login'));
        }
        
        // Log action
        $dataLog = [
            'operation_timestamp' => Carbon::now()->timestamp,
            'ip_address' => \Request::ip(),
            'operator_cd' => session('user')->operator_cd,
            'operator_name' => Common::operatorName((array) session('user')),
            'screen_id' => 'W000001',
            'screen_name' => Common::getScreenName('W000001'),
            'operation' => '初期処理',
            'contents' => 'なし',
        ];
        LogActionUtil::logAction($dataLog);

        $intialTime = $this->getTimePost();
        $yearMonth = $this->getYearMonth($request);
        $workDates = $this->getWorkDates($yearMonth);
        $overTime = $this->checkOverTime($yearMonth);

        $attendance = $this->workDatesRepository->getStartTimeandEndTime(session('user')->operator_cd, Carbon::now()->format('Y-m-d'));
        if (count($attendance) > 0) {
            if (!is_null($attendance[0]->start_time)) {
                $intialTime['start_time'] =  $attendance[0]->start_time;
            }
            if (!is_null($attendance[0]->end_time)) {
                $intialTime['end_time'] =  $attendance[0]->end_time;
            }
        }
        return view('person.work', compact('intialTime', 'workDates', 'yearMonth', 'overTime'));
    }

    /**
     * Get attendance time and leave time of the post which belongs to current user.
     *
     * @return array
     */
    private function getTimePost()
    {
        $timePost = $this->workDatesRepository->getTimePost(session('user')->post_cd);
        return [
            'start_time' => Carbon::parse($timePost[0]->post_start_time)->format('H:i'),
            'end_time' => Carbon::parse($timePost[0]->post_end_time)->format('H:i')
        ];
    }

    /**
     * Get month and year of current time.
     *
     * @param Request $request
     * @return string
     */
    private function getYearMonth($request)
    {
        if (isset($request->yearMonth)) {
            return $request->yearMonth;
        }
        return Carbon::now()->format('Ym');
    }

    /**
     * Check if the current user has an overtime time that exceeds the allowed time
     *
     * @param string $yearMonth
     * @return boolean
     */
    private function checkOverTime($yearMonth)
    {
        $currentTimeTarget = Formula::calculateClosingDate($yearMonth);

        return $this->workDatesRepository->isOverTime(
            session('user')->operator_cd,
            $currentTimeTarget[0],
            $currentTimeTarget[1]
        );
    }

    /**
     * Get work dates of current user in given month.
     *
     * @param string $yearMonth
     * @return collection
     */
    private function getWorkDates($yearMonth)
    {
        $currentTimeTarget = Formula::calculateClosingDate($yearMonth);

        return $this->workDatesRepository->getWorkDates(
            session('user')->operator_cd,
            $currentTimeTarget[0],
            $currentTimeTarget[1]
        );
    }

    public function registerAttendanceTime(Request $request){
        if (!session('user')) {
            return redirect(route('login'));
        }
        $user = session('user');
        $validatedData = $request->validate([
            'start_time' => ['required', 'date_format:H:i'],
        ]);
        
        // Check attendance time registered
        if($this->workDatesRepository->checkAttendanceTime($user->operator_cd)) {
            return back()->withInput()->withErrors('出席時間は既に登録されています。変更する必要がある場合は、管理者に連絡してください。');
        };

        // register attendance time
        if(!$this->workDatesRepository->registerAttendanceTime(
            $user->operator_cd, 
            $validatedData['start_time']
        )) {
            return back()->withInput()->withErrors('情報の登録に失敗しました');
        }

        // Log action
        $dataLog = [
            'operation_timestamp' => Carbon::now()->timestamp,
            'ip_address' => \Request::ip(),
            'operator_cd' => $user->operator_cd,
            'operator_name' => Common::operatorName((array) $user),
            'screen_id' => 'W000001',
            'screen_name' => Common::getScreenName('W000001'),
            'operation' => '出勤登録',
            'contents' => '出勤時間: ' . $validatedData['start_time'],
        ];
        LogActionUtil::logAction($dataLog);

        // Displays a processing completion message.
        $request->session()->flash('message', '登録しました。');
        $request->flash();
        return redirect()->action('Person\WorkDatesController@index');
    }

    public function registerLeaveTime(Request $request){
        if (!session('user')) {
            return redirect(route('login'));
        }
        $user = session('user');
        $validatedData = $request->validate([
            'end_time' => ['required', 'regex:/^[0-9][0-9]:[0-5][0|5]$/'],
        ]);
        
        if (intval(Str::substr($validatedData['end_time'], 0, 2)) >= 24) {
            $currentDate = Carbon::yesterday()->toDateString();
        } else {
            $currentDate = Carbon::now()->toDateString();
        }

        // Check leave time registered.
        if(!$this->workDatesRepository->checkAttendanceTime($user->operator_cd)) {
            return back()->withInput()->withErrors('出勤時間が登録されていないため、退勤時間の登録ができません。');
        };

        // Check work time and leave time
        if(!$this->workDatesRepository->checkEndTimeGreaterStartTime(
            $user->operator_cd, 
            $validatedData['end_time']
        )) {
            return back()->withInput()->withErrors('出勤時間より前の時間は登録できません。');
        };
        
         // Check leave time registered.
        if($this->workDatesRepository->checkLeaveTime($user->operator_cd)) {
            return back()->withInput()->withErrors('休暇時間は既に登録されています。 変更する必要がある場合は、管理者に連絡してください。');
        };

        // Checking the maximum time to leave
        if($validatedData['end_time'] > intval(Common::getSystemConfig('MAX_LEAVE_TIME'))) {
            return back()->withInput()->withErrors('退勤時間最大値を超えています。');
        }

        if(!$this->workDatesRepository->registLeaveTime(
            $user->operator_cd, 
            $validatedData['end_time'],
            $currentDate
        )) {
            return back()->withInput()->withErrors('情報の登録に失敗しました');
        }
        
        // Caculate working time, break time, overtime, late night overtime 
        $this->workDatesRepository->caculateAndRegistTime($user->operator_cd, $currentDate);

        // Log action
        $dataLog = [
            'operation_timestamp' => Carbon::now()->timestamp,
            'ip_address' => \Request::ip(),
            'operator_cd' => $user->operator_cd,
            'operator_name' => Common::operatorName((array) $user),
            'screen_id' => 'W000001',
            'screen_name' => Common::getScreenName('W000001'),
            'operation' => '退勤登録',
            'contents' => '退勤時間: ' .$validatedData['end_time'],
        ];
        LogActionUtil::logAction($dataLog);

        // Displays a processing completion message.
        $request->session()->flash('message', '登録しました。');
        $request->flash();
        return redirect()->action('Person\WorkDatesController@index');
    }
}
