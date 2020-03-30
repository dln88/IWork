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

Route::get('/login', 'AuthController@showLogin')->name('login');
Route::post('/doLoginAdmin', 'AuthController@doLoginAdmin')->name('admin.login.post');
Route::post('/doLogin', 'AuthController@doLogin')->name('login.post');
Route::get('/logout', 'AuthController@logout')->name('logout');

Route::group(['prefix' => 'admin',  'middleware' => 'admin', 'namespace' => 'Admin'], function()
{
    Route::get('/',  'HomeController@index')->name('admin.dashboard');
    Route::get('work_dates', 'WorkDatesController@index')
        ->name('admin.work_dates');
    Route::get('work/csv', 'WorkDatesController@workCSV')
        ->name('admin.work_csv');

    Route::get('work_personal/{uid}', 'WorkDatesController@personal')
        ->name('admin.work_personal');
    Route::get('work/personal_csv/{uid}', 'WorkDatesController@personalCSV')
        ->name('admin.personal_csv');

    Route::get('/work/personal/ajax_load/{uid}/{date}', 'WorkDatesController@ajaxLoadPersonalDate')->name('admin.ajax.load_personal_date');

    Route::post('/work/personal/update/{uid}', 'WorkDatesController@ajaxUpdatePersonalDate')->name('admin.ajax.update_personal_date');
});

Route::group([ 'middleware' => 'staff'], function()
{
    Route::get('/',  'Staff\HomeController@index')->name('staff.dashboard');
    Route::get('work/dates', 'Staff\WorkDatesController@index')
        ->name('staff.work.dates');

    Route::post('work/register', 'Staff\WorkDatesController@register')
        ->name('staff.work.register_date');

    Route::get('holiday', 'Staff\HolidayController@index')
        ->name('staff.holiday');

    Route::post('add_holiday', 'Staff\HolidayController@store')
        ->name('staff.add_holiday');

});

