<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Utils\Csv;
use App\Utils\Common;
use App\Utils\Formula;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Utils\LogActionUtil;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateWorkDateRequest;
use App\Http\Requests\SearchWorkDatesRequest;
use Illuminate\Pagination\LengthAwarePaginator;
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
     * Show work dates page.
     *
     * @param SearchWorkDatesRequest $request
     * @return view
     */
    public function index(SearchWorkDatesRequest $request)
    {
        try {
            $operatorName = Common::operatorName((array) session('user'));
            $departmentName = session('user')->post_name;

            $dataLog = [
                'operation_timestamp' => Carbon::now()->timestamp,
                'ip_address' => \Request::ip(),
                'operator_cd' => session('user')->operator_cd,
                'operator_name' => $operatorName,
                'screen_id' => 'W000002',
                'screen_name' => Common::getScreenName('W000002'),
                'operation' => '初期処理',
                'contents' => 'なし',
            ];
            LogActionUtil::logAction($dataLog);

            $validatedData = $request->validated();
            if (
                isset($validatedData['emp_num']) ||
                isset($validatedData['department_id']) ||
                isset($validatedData['name']) ||
                isset($validatedData['ot_min']) ||
                isset($validatedData['ot_max']) ||
                isset($validatedData['on_min']) ||
                isset($validatedData['on_max'])
            ){
                // Log action
                $dataLog = [
                    'operation_timestamp' => Carbon::now()->timestamp,
                    'ip_address' => \Request::ip(),
                    'operator_cd' => session('user')->operator_cd,
                    'operator_name' => Common::operatorName((array) session('user')),
                    'screen_id' => 'W000002',
                    'screen_name' => Common::getScreenName('W000002'),
                    'operation' => '検索処理',
                    'contents' => ''
                ];
                
                if (isset($validatedData['emp_num'])) {
                    $dataLog['contents'] .= '社員番号: ' . $validatedData['emp_num'];
                }
                if (isset($validatedData['department_id'])) {
                    $dataLog['contents'] .= ', ' . '部門: ' .  $validatedData['department_id'];
                }
                if (isset($validatedData['name'])) {
                    $dataLog['contents'] .= ', ' .  '氏名: ' .  $validatedData['name'];
                }
                if (isset($validatedData['from_month'])) {
                    $dataLog['contents'] .= ', ' . '対象年月: ' . $validatedData['from_month'];
                }
                if (isset($validatedData['to_month'])) {
                    $dataLog['contents'] .= '~ ' . $validatedData['to_month'];
                }
                if (isset($validatedData['ot_min'])) {
                    $dataLog['contents'] .= ', ' . '残業時間（合計）: ' . $validatedData['ot_min'];
                }
                if (isset($validatedData['ot_max'])) {
                    $dataLog['contents'] .= '~ ' . $validatedData['ot_max'];
                }
                if (isset($validatedData['on_min'])) {
                    $dataLog['contents'] .= ', ' . '深夜時間（合計）: ' . $validatedData['on_min'];
                }
                if (isset($validatedData['on_max'])) {
                    $dataLog['contents'] .= '~ ' . $validatedData['on_max'];
                }
                LogActionUtil::logAction($dataLog);
            }

            $page = 1;
            if (isset($request->page) && $request->page > 1) {
                $page = intval($request->page);
            }

            $comboBoxChoice = $this->getPostCD();
            $timeListArray = $this->adminWorkRepository->getTimeListByCondition($validatedData);
            $timeList = $this->arrayPaginator($timeListArray, $page, $request);

            // save param query to search
            session([
                'emp_num' => $validatedData['emp_num'] ?? null,
                'department_id' => $validatedData['department_id'] ?? null,
                'name' => $validatedData['name'] ?? null,
                'from_month' => $validatedData['from_month'] ?? null,
                'to_month' => $validatedData['to_month'] ?? null,
                'ot_min' => $validatedData['ot_min'] ?? null,
                'ot_max' => $validatedData['ot_max'] ?? null,
                'on_min' => $validatedData['on_min'] ?? null,
                'on_max' => $validatedData['on_max'] ?? null
            ]);

            if (isset($validatedData['from_month']) && !is_null($validatedData['from_month'])) {
                $fromMonth = $validatedData['from_month'];
            } else if (!is_null($request->old('from_month'))) {
                $fromMonth = $request->old('from_month');
            } else {
                $fromMonth = Carbon::now()->format('Y/m');
            }
            
            if (isset($validatedData['to_month']) && !is_null($validatedData['to_month'])) {
                $toMonth = $validatedData['to_month'];
            } else if (!is_null($request->old('to_month'))) {
                $toMonth = $request->old('to_month');
            } else {
                $toMonth = Carbon::now()->format('Y/m');
            }
            
            return view('admin.work', compact('timeList', 'page', 'comboBoxChoice', 'operatorName', 'departmentName',
                'fromMonth', 'toMonth'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * pagination for the given data
     *
     * @param array $array
     * @param int $page
     * @param Request $request
     * @return LengthAwarePaginator
     */
    private function arrayPaginator(array $array, int $page, Request $request)
    {
        $perPage = Common::getSystemConfig('WORK_ADMIN_ROWS');
        $offset = ($page * $perPage) - $perPage;
    
        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]);
    }

    /**
     * Get all departments.
     *
     * @return collection
     */
    private function getPostCD()
    {
        return $this->adminWorkRepository->getPostCD();
    }

    /**
     * Displays all working day information of current user in a month.
     * 
     * @param Request $request
     * @param int $id
     * @param string $yearMonth
     * @return View
     */
    public function personal(Request $request, int $id, string $date)
    {
        session([
            'operatorId' => $id,
            'yearMonth' => $date
        ]);
        if (is_null($id) || !$this->checkId($id) || is_null($date)) {
            session()->flash('errorOperator', config('messages.010017'));
            $disableCSV = false;
            return view('admin.work_personal', compact('disableCSV'));
        }
        $user = $this->adminWorkRepository->getUserByKey($id);
        $user = $user[0];
        $monthlyReport = $this->adminWorkRepository->getMonthlyReport($id, $date);

        $operatorName = Common::operatorName((array) session('user'));
        $departmentName = session('user')->post_name;

        // Log action
        $dataLog = [
            'operation_timestamp' => Carbon::now()->timestamp,
            'ip_address' => \Request::ip(),
            'operator_cd' => session('user')->operator_cd,
            'operator_name' => $operatorName,
            'screen_id' => 'W000003',
            'screen_name' => Common::getScreenName('W000003'),
            'operation' => '初期処理',
            'contents' => 'なし',
        ];
        LogActionUtil::logAction($dataLog);

        return view('admin.work_personal', compact('user', 'monthlyReport', 'operatorName', 'departmentName'));
    }

    private function checkId($id)
    {
        return $this->adminWorkRepository->existUserID($id);
    }

    public function personalError()
    {
        $operatorName = Common::operatorName((array) session('user'));
        $departmentName = session('user')->post_name;
        return view('admin.work_personal', compact('operatorName', 'departmentName'));
    }

    /**
     * Updates to working days for specific users with a given date.
     *
     * @param UpdateWorkDateRequest $request
     * @param int $id
     * @return View
     */
    public function updateWorkDate(UpdateWorkDateRequest $request, int $id)
    {
        try {
            if (!$this->isEndTimeGreaterThanStartTime($request->start, $request->end)) {
                return back()->withInput()->withErrors(config('messages.010007'));
            };
            $start = $request->start;
            $end = $request->end;
            $data['date'] = $request->date;
            $data['start'] = strlen($start) == 5 ? $start : '0'. $start;
            $data['end'] = strlen($end) == 5 ? $end : '0'. $end;
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
            if (is_null($data['paid']) || is_null($data['exchange']) || is_null($data['special'])) {
                $this->adminWorkRepository->updateVacation($id, $data);
            }
            
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
            $yearMonth = Formula::calculateTargetYearMonth($data['date']);
            $request->session()->flash('message', config('messages.000012'));
            return redirect()->route('admin.work_personal', [$id, $yearMonth]);
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Check end time is greater than start time.
     *
     * @param string $startTime
     * @param string $endTime
     * @return boolean
     */
    private function isEndTimeGreaterThanStartTime(string $startTime, string $endTime)
    {
        if (
            (intval(Str::substr($endTime, 0, 2)) >= intval(Str::substr($startTime, 0, 2)) ) or 
            (
                intval(Str::substr($endTime, 0, 2)) === intval(Str::substr($startTime, 0, 2)) and
                intval(Str::substr($endTime, 2, 2)) >= intval(Str::substr($startTime, 2, 2))
            )
        ) {
            return true;
        }
        return false;
    }

    /**
     * CSV export of all user information for a month.
     *
     * @return View
     */
    public function workCSV()
    {
        try {
            $data['emp_num'] = session('emp_num');
            $data['department_id'] = session('department_id');
            $data['name'] = session('name');
            $data['from_month'] = session('from_month');
            $data['to_month'] = session('to_month');
            $data['ot_min'] = session('ot_min');
            $data['ot_max'] = session('ot_max');
            $data['on_min'] = session('on_min');
            $data['on_max'] = session('on_max');
            
            $timeListArray = $this->adminWorkRepository->getTimeListByCondition($data);
            if (count($timeListArray) < 1) {
                return back()->withInput()->withErrors(config('messages.000016'));
            }

            // Log action
            $dataLog = [
                'operation_timestamp' => Carbon::now()->timestamp,
                'ip_address' => \Request::ip(),
                'operator_cd' => session('user')->operator_cd,
                'operator_name' => Common::operatorName((array) session('user')),
                'screen_id' => 'W000002',
                'screen_name' => Common::getScreenName('W000002'),
                'operation' => 'CSV出力',
                'contents' => 'なし'
            ];
            LogActionUtil::logAction($dataLog);
            
            // name file of csv
            $nameCSV = '勤怠一覧'. '_' . Carbon::now()->format('YmdHis');
            
            // Header of csv
            $header = [
                '社員番号', '部門', '氏名', '対象年月', '実働時間（合計）', '残業時間（合計）', '深夜残業（合計）', '出勤日数', '有休', '振休', '特休'
            ];

            foreach ($timeListArray as $timeList) {
                unset($timeList->post_cd);
                unset($timeList->operator_cd);

                $dataCSV[] = (array) $timeList;
            }

            // Prepend header
            array_unshift($dataCSV, $header);

            Csv::downloadCSV($dataCSV, $nameCSV);

            session()->flash('message', 'ダウンロード成功');
            return back()->withInput();
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(config('messages.000002'));
        }
    }

    /**
     * CSV export of all users' specific working days for the month.
     *
     * @return View
     */
    public function personalCSV()
    {
        try {
            $operatorCd = session('operatorId');
            $yearMonth = session('yearMonth');
            $monthlyReportArray = $this->adminWorkRepository->getMonthlyReport($operatorCd, $yearMonth);

            if (count($monthlyReportArray) < 1) {
                return back()->withInput()->withErrors(config('messages.000016'));
            }

            // Log action
            $dataLog = [
                'operation_timestamp' => Carbon::now()->timestamp,
                'ip_address' => \Request::ip(),
                'operator_cd' => session('user')->operator_cd,
                'operator_name' => Common::operatorName((array) session('user')),
                'screen_id' => 'W000003',
                'screen_name' => Common::getScreenName('W000003'),
                'operation' => 'CSV出力',
                'contents' => 'なし'
            ];
            LogActionUtil::logAction($dataLog);
            
            // name file of csv
            $nameCSV = '月報一覧'. '_' . $operatorCd . '_' . Carbon::now()->format('YmdHis');
            
            // Header of csv
            $header = [
                '社員番号', '部門', '氏名', '日付', '曜日', '開始', '終了', '休憩時間', '実働時間　（00.00）',
                '残業時間　（00.00）', '深夜残業　（00.00）', 'インターバル', '有休', '振休', '特休', '備考'
            ];
            
            foreach ($monthlyReportArray as $monthlyReport) {
                unset($monthlyReport->calendar_ymd);
                unset($monthlyReport->ex_statutory_wk_time);
                unset($monthlyReport->operator_cd);
                
                $monthlyReport = array(
                    'emp_no' => session('user')->emp_no,
                    'post_name' => session('user')->post_name,
                    'operator_name' => Common::operatorName((array) session('user')),
                    'date' => $monthlyReport->regi_date,
                    'day_of_week' => $monthlyReport->regi_date ? Common::convertToDayOfWeek($monthlyReport->regi_date) : '',
                ) + (array) $monthlyReport;
                
                unset($monthlyReport['regi_date']);
                
                $dataCSV[] = $monthlyReport;
            }

            // Prepend header
            array_unshift($dataCSV, $header);

            Csv::downloadCSV($dataCSV, $nameCSV);

            session()->flash('message', 'ダウンロード成功');
            return back()->withInput();
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(config('messages.000002'));
        }
    }
}
