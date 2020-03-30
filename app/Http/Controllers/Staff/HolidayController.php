<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Repositories\VacationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    protected $repository;
    public function __construct(VacationRepository $repository)
    {
        $this->middleware('staff');

        $this->repository = $repository;
    }

    public function index()
    {
        $user = Auth::user();
        $uid = $user->id;
        $holidays = $this->repository->findWhere(['user_id' => $uid]);
        return view('staff.holiday', ['holidays' => $holidays]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'nullable|date_format:Y/m/d',
            'type' => 'required|integer|min:1|max:3'
        ]);
        $data = $request->only('date', 'type', 'day_type');
        $user = Auth::user();
        $data['user_id'] = $user->id;
        // create record and pass in only fields that are fillable
        $this->repository->create($data);
        return back()->with('message', 'Create holiday successful');
    }

    public function show($id)
    {
        return $this->model->show($id);
    }

    public function update(Request $request, $id)
    {
        // update model and only pass in the fillable fields
        $this->model->update($request->only($this->model->getModel()->fillable), $id);

        return $this->model->find($id);
    }

    public function destroy($id)
    {
        return $this->model->delete($id);
    }
}
