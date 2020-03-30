<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Utils\Common;
use App\Utils\Csv;
use Illuminate\Http\Request;

class WorkDatesController extends Controller
{
    /**
     * WorkDatesController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('admin.work');
    }

    /**
     * @param Request $request
     * @param $uid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function personal(Request $request, $uid){
        return view('admin.work_personal', ['uid' => $uid]);
    }

    /**
     * @param Request $request
     */
    public function workCSV(Request $request){
        $data[] = [
            '社員番号', '部門', '氏名', '対象年月', '実働時間（合計）', '残業時間（合計）', '深夜残業（合計）', '出勤日数', '有休', '振休', '特休'
        ];

        for ($i = 1; $i< 10; $i++) {
            $data[] = [
                '00000'. $i, '設計部', '山田太郎', '2020年4月', '160.00', '20.00', '5.00', '20', '2.0', '1.5', '0.0'
            ];
        }
        Csv::downloadCSV($data,'work');
        return ;
    }

    /**
     * @param Request $request
     * @param $uid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function personalCSV(Request $request, $uid){
        $data[] = [
            "社員番号", "部門",	"氏名",	"日付", "曜日", "開始",	"終了", "休憩時間", "実働時間　（00.00）",	"残業時間　（00.00）", "深夜残業　（00.00）",
            "インターバル", "有休","振休",	"特休",	"備考"
        ];

        for ($i = 1; $i<= 30; $i++) {
            $data[] = [
                "$uid", '設計部', '山田太郎', '2020/04/'. $i ,Common::getDateOfWeek('2020/04/'. $i), '9:00', '18:00', '1.00', '8.00', '0.00', '0.00', '15.00', '0.0', '0.0', '0.0', '○○○○○○○○○○○○○○○○'
            ];
        }

        Csv::downloadCSV($data, $uid . '_dates');

        return ;
    }

    /**
     * @param Request $request
     * @param $uid
     * @param $date
     * @return false|string
     */
    function ajaxLoadPersonalDate(Request $request, $uid, $date) {
        $data = [
            'user_id' => 10,
            'name' => '山田太郎 Test',
            'work_date' => '2020/04/01',
            'start_time' => '9:00',
            'end_time' => '18:00',
            'break_time' => '1:00',
            'working_time' => '8:00',
            'over_time' => '0:00',
            'over_night' => '0:00'
        ];
        return response()->json(array('data'=> $data), 200);
    }

    public function ajaxUpdatePersonalDate(Request $request, $uid) {
        // TODO Update Data

        return response()->json(array('success'=> true), 200);
    }

}
