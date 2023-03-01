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
    return view('employee');
});
Route::group(['namespace' => 'App\Http\Controllers'], function()
{ 
    Route::get('/employee', 'EmployeeController@employeeList')->name('list'); 
    Route::post('/createEmployee', 'EmployeeController@createEmployee')->name('createEmployee');  
    Route::get('/deleteEmployee/{id}', 'EmployeeController@deleteEmployee')->name('deleteEmployee');
    Route::get('/editEmployee/{id}', 'EmployeeController@editEmployee')->name('editEmployee');    
});