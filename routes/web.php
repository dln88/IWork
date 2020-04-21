<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/test', 'Common\TestController@test')->name('test');
Route::get('/login', 'Common\AuthController@showLogin')->name('login');
Route::post('/doLogin', 'Common\AuthController@doLogin')->name('login.post');
Route::post('/doLoginAdmin', 'Common\AuthController@doLoginAdmin')->name('admin.login.post');
Route::get('/logout', 'Common\AuthController@logout')->name('logout');

Route::group(['prefix' => 'admin',  'middleware' => 'admin', 'namespace' => 'Admin'], function()
{
    Route::get('work_dates', 'WorkDatesController@index')
        ->name('admin.work_dates');
    
    Route::get('work/csv', 'WorkDatesController@workCSV')
        ->name('admin.work_csv');

    Route::get('work_personal/{id}', 'WorkDatesController@personal')
        ->name('admin.work_personal');

    Route::get('work/personal_csv/{id}', 'WorkDatesController@personalCSV')
        ->name('admin.personal_csv');

    Route::post('/work/personal/update/{id}', 'WorkDatesController@updateWorkDate')
        ->name('admin.work_personal.update');
});

Route::group([ 'middleware' => 'person'], function()
{    
    Route::get('work/dates', 'Person\WorkDatesController@index')
        ->name('person.work.dates');

    Route::post('work/register-attendance-time', 'Person\WorkDatesController@registerAttendanceTime')
        ->name('person.work.register_attendance_time');

    Route::post('work/register-leave-time', 'Person\WorkDatesController@registerLeaveTime')
        ->name('person.work.register_leave_time');

    Route::get('holiday', 'Person\HolidayController@index')
        ->name('person.holiday');

    Route::post('add_holiday', 'Person\HolidayController@store')
        ->name('person.add_holiday');

});

