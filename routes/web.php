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

Route::get('/login', 'Common\AuthController@showLogin')->name('login');
Route::post('/login/user', 'Common\AuthController@doLogin')->name('login.post');
Route::post('/login/admin', 'Common\AuthController@doLoginAdmin')->name('admin.login.post');
Route::get('/logout', 'Common\AuthController@logout')->name('logout');

Route::group([ 'middleware' => 'person', 'namespace' => 'Person'], function()
{    
    Route::get('pages/work/', 'WorkDatesController@index')
        ->name('person.work.dates');

    Route::post('pages/work/regist-start-time', 'WorkDatesController@registerAttendanceTime')
        ->name('person.work.register_attendance_time');

    Route::post('pages/work/regist-end-time', 'WorkDatesController@registerLeaveTime')
        ->name('person.work.register_leave_time');

    Route::get('pages/holiday', 'HolidayController@index')
        ->name('person.holiday');

    Route::post('pages/add_holiday', 'HolidayController@store')
        ->name('person.add_holiday');

});

Route::group(['middleware' => 'admin', 'namespace' => 'Admin'], function()
{
    Route::get('pages/work_admin', 'WorkDatesController@index')
        ->name('admin.work_dates');
    
    Route::get('pages/work_admin/csv', 'WorkDatesController@workCSV')
        ->name('admin.work_csv');

    Route::get('pages/work_admin_personal', 'WorkDatesController@personalError');

    Route::get('pages/work_admin_personal/{var}', 'WorkDatesController@personalError');

    Route::get('pages/work_admin_personal//{var}', 'WorkDatesController@personalError');

    Route::get('pages/work_admin_personal/{id}/{date}', 'WorkDatesController@personal')
        ->name('admin.work_personal');

    Route::get('pages/admin_personal/csv', 'WorkDatesController@personalCSV')
        ->name('admin.work_personal_csv');

    Route::post('pages/work_admin_personal/{id}', 'WorkDatesController@updateWorkDate')
        ->where('id', '[0-9]+')
        ->name('admin.work_personal.update');
});



