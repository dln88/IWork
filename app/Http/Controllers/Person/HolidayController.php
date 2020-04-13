<?php

namespace App\Http\Controllers\Person;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

    public function index()
    {
        return view('person.holiday');
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
