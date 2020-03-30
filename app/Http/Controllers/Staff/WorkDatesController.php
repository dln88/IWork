<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\WorkDate;
use App\Repositories\Repository;
use App\Repositories\WorkDateRepository;
use App\Utils\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkDatesController extends Controller
{
    protected $repository;
    public function __construct(WorkDateRepository $repository)
    {
        $this->middleware('staff');

        $this->repository = $repository;
    }

    public function index(Request $request){
        $date = $this->repository->findWhere(['work_date' => date('Y/m/d')])->first();

        $headers = ['日付', '曜日', '開始', '終了', '休憩時間', '実働時間　（00.00）', '残業時間　（00.00）', '深夜残業　（00.00）', 'インターバル', '有休', '振休', '特休'];

        for ($i = 1; $i<= 30; $i++) {
            $data[] = [
                '2020/04/'. $i ,Common::getDateOfWeek('2020/04/'. $i), '9:00', '18:00', '1.00', '8.00', '0.00', '0.00', '15.00', '0.0', '0.0', '0.0'
            ];
        }
        return view('staff.work', ['date' => $date, 'data' => $data, 'headers' => $headers]);
    }

    public function holiday(Request $request){
        return view('staff.holiday');
    }

    public function register(Request $request){

        $this->validate($request, [
            'start_time' => 'nullable|date_format:H:i',
            'start_end' => 'nullable|date_format:H:i'
        ]);
        $user = Auth::user();
        $uid = $user->id;
        $dates = $this->repository->findWhere(['work_date' => date('Y/m/d')]);

        if (count($dates) > 0) {
            $date = $dates[0];
            $data = [];
            if ( $request->get('start_time')) {
                $data['start_time'] = $request->get('start_time');
            }
            if ( $request->get('end_time')) {
                $data['end_time'] = $request->get('end_time');
            }

            $this->repository->update($data, $date->id);
            return redirect(route('staff.work.dates'))->with('message', 'Add Successful');
        }
        else {
            if ( $request->get('start_time')) {
                $data['start_time'] = $request->get('start_time');
                $this->repository->create([
                    'user_id' => $user->id,
                    'work_date' => date('Y/m/d'),
                    'start_time' => $request->get('start_time') ]);
            }
        }
        return redirect(route('staff.work.dates'))->with('message', 'Add Successful');

    }
    public function add_holiday(Request $request){

    }

}
