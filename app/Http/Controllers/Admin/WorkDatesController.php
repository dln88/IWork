<?php

namespace App\Http\Controllers\Admin;

use App\Utils\Csv;
use Carbon\Carbon;
use App\Utils\Common;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Utils\LogActionUtil;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateWorkDateRequest;
use App\Http\Requests\SearchWorkDatesRequest;
use App\Repositories\Interfaces\AdminWorkRepositoryInterface;
class WorkDatesController extends Controller
{
    protected $adminWorkRepository;

    /**
     * Create a new controller instance function.
     *
     * @param AdminWorkRepositoryInterface $adminWorkRepository
     * @return void
     */
    public function __construct(AdminWorkRepositoryInterface $adminWorkRepository)
    {
        $this->middleware('admin');

        $this->adminWorkRepository = $adminWorkRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(SearchWorkDatesRequest $request)
    {
        $page = 1;
        if (isset($request->page) && $request->page > 1) {
            $page = intval($request->page);
        }
        $comboBoxChoice = $this->getPostCD();
        $timeList = $this->adminWorkRepository->getTimeList($page);
        // Log action
        $dataLog = [
            'operation_timestamp' => Carbon::now()->timestamp,
            'ip_address' => \Request::ip(),
            'operator_cd' => session('user')->operator_cd,
            'operator_name' => Common::operatorName((array) session('user')),
            'screen_id' => 'W000002',
            'screen_name' => Common::getScreenName('W000002'),
            'operation' => '初期処理',
            'contents' => 'なし',
        ];
        LogActionUtil::logAction($dataLog);

        return view('admin.work', compact('timeList', 'page', 'comboBoxChoice'));
    }

    public function search(SearchWorkDatesRequest $request)
    {
        $validatedData = $request->all();
        $comboBoxChoice = $this->getPostCD();

        $page = 1;
        if (isset($request->page) && $request->page > 1) {
            $page = intval($request->page);
        }

        $timeList = $this->adminWorkRepository->getTimeListByCondition($page, $validatedData);
        // Log action
        $dataLog = [
            'operation_timestamp' => Carbon::now()->timestamp,
            'ip_address' => \Request::ip(),
            'operator_cd' => session('user')->operator_cd,
            'operator_name' => Common::operatorName((array) session('user')),
            'screen_id' => 'W000002',
            'screen_name' => Common::getScreenName('W000002'),
            'operation' => '検索処理',
            'contents' =>
                '社員番号: ' . $validatedData['emp_num'] . ', ' .
                '部門: ' .  $validatedData['department_id'] . ', ' .
                '氏名: ' .  $validatedData['name'] . ', ' .
                '対象年月: ' .
                    $validatedData['from_month'] . ' ~ ' .
                    $validatedData['to_month'] . ', ' .
                '残業時間（合計）: ' .
                    $validatedData['ot_min'] . ' ~ ' .
                    $validatedData['ot_max'] . ', ' .
                '深夜時間（合計）: ' .
                    $validatedData['on_min'] . ' ~ ' .
                    $validatedData['on_max']
        ];
        LogActionUtil::logAction($dataLog);

        return view('admin.work', compact('timeList', 'page', 'comboBoxChoice'));
    }

    private function getPostCD()
    {
        return $this->adminWorkRepository->getPostCD();
    }

    /**
     * @param Request $request
     * @param int $id
     * @param string $yearMonth
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function personal(Request $request, int $id)
    {
        if(is_null($id)) {
            session()->flash('message', '前画面からの情報が不正です。管理者へ連絡してください。'); 
        }
        $user = $this->adminWorkRepository->getUserByKey($id);
        $user = $user[0];
        $monthlyReport = $this->adminWorkRepository->getMonthlyReport($id);
        
        // Log action
        $dataLog = [
            'operation_timestamp' => Carbon::now()->timestamp,
            'ip_address' => \Request::ip(),
            'operator_cd' => session('user')->operator_cd,
            'operator_name' => Common::operatorName((array) session('user')),
            'screen_id' => 'W000003',
            'screen_name' => Common::getScreenName('W000003'),
            'operation' => '初期処理',
            'contents' => 'なし',
        ];
        LogActionUtil::logAction($dataLog);

        return view('admin.work_personal', compact('user', 'monthlyReport'));
    }

    public function updateWorkDate(UpdateWorkDateRequest $request, $id)
    {
        if(!$this->checkEndTimeGreaterThanStartTime($request->start, $request->end)) {
            return back()->withInput()->withErrors('終了時間は開始時間より後の時間を設定してください。');
        };

        $data['date'] = $request->date;
        $data['start']= $request->start;
        $data['end'] = $request->end;
        $data['memo'] = $request->memo;
        $data['paid'] = $request->paid;
        $data['exchange'] = $request->exchange;
        $data['special'] = $request->special;
        
        $workDate = $this->adminWorkRepository->findWorkDate($id, $request->date);
        if (count($workDate) > 0) {
            $this->adminWorkRepository->updateWorkDate($id, $data);
        } else {
            $this->adminWorkRepository->insertWorkDate($id, $data);
        }

        $this->adminWorkRepository->updateVacation($id, $data);
        
         // Log action
         $dataLog = [
            'operation_timestamp' => Carbon::now()->timestamp,
            'ip_address' => \Request::ip(),
            'operator_cd' => session('user')->operator_cd,
            'operator_name' => Common::operatorName((array) session('user')),
            'screen_id' => 'W000003',
            'screen_name' => Common::getScreenName('W000003'),
            'operation' => '勤怠修正',
            'contents' => '日付: ' . $data['date'] . ', ' .
                '開始: ' .  $data['start'] . ', ' .
                '終了: ' .  $data['end'] . ',' .
                '備考: ' .  $data['memo']
        ];
        LogActionUtil::logAction($dataLog);
        $request->session()->flash('message', '更新しました。');
        return redirect()->route('admin.work_personal', $id);
    }

    private function checkEndTimeGreaterThanStartTime($startTime, $endTime)
    {
        if (
            (intval(Str::substr($endTime, 0, 2)) > intval(Str::substr($startTime, 0, 2)) ) or 
            (
                intval(Str::substr($endTime, 0, 2)) === intval(Str::substr($startTime, 0, 2)) and
                intval(Str::substr($endTime, 2, 2)) > intval(Str::substr($startTime, 2, 2))
            )
        ) {
            return true;
        }
        return false;
    }

    /**
     * @param Request $request
     * @param $uid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function personalCSV(Request $request, $uid){
        // $data[] = [
        //     "社員番号", "部門",	"氏名",	"日付", "曜日", "開始",	"終了", "休憩時間", "実働時間　（00.00）",	"残業時間　（00.00）", "深夜残業　（00.00）",
        //     "インターバル", "有休","振休",	"特休",	"備考"
        // ];

        // for ($i = 1; $i<= 30; $i++) {
        //     $data[] = [
        //         "$uid", '設計部', '山田太郎', '2020/04/'. $i ,Common::getDateOfWeek('2020/04/'. $i), '9:00', '18:00', '1.00', '8.00', '0.00', '0.00', '15.00', '0.0', '0.0', '0.0', '○○○○○○○○○○○○○○○○'
        //     ];
        // }

        // Csv::downloadCSV($data, $uid . '_dates');

        // return ;
    }

    /**
     * @param Request $request
     */
    public function workCSV(Request $request){
        $nameCSV = 'work' . Carbon::now()->format('Ymd_His');
        $data[] = [
            '社員番号', '部門', '氏名', '対象年月', '実働時間（合計）', '残業時間（合計）', '深夜残業（合計）', '出勤日数', '有休', '振休', '特休'
        ];

        for ($i = 1; $i< 10; $i++) {
            $data[] = [
                '00000'. $i, '設計部', '山田太郎', '2020年4月', '160.00', '20.00', '5.00', '20', '2.0', '1.5', '0.0'
            ];
        }
        Csv::downloadCSV($data, $nameCSV);
        
        return back()->with('message', 'ダウンロード成功');
    }

}
