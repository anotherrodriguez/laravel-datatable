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

Route::get('/siteData', 'SiteController@getData')->name('site.getData');

Route::get('/departmentData', 'DepartmentController@getData')->name('department.getData');

Route::get('/statusData', 'StatusController@getData')->name('status.getData');

Route::get('/patientData', 'PatientController@getData')->name('patient.getData');

Route::post('/validatePatient', 'PatientController@validatePatient');

Route::get('/UserData', 'UserController@getData')->name('user.getData');

Route::post('/getDepartments', 'DepartmentController@getDepartments');

Route::post('/getStatuses', 'StatusController@getStatuses');

Route::resources([
    'sites' => 'SiteController',
    'departments' => 'DepartmentController',
    'statuses' => 'StatusController',
    'patients' => 'PatientController',
    'users' => 'UserController'
]);

//Route::get('/', 'Auth\LoginController@showLoginForm');
Route::get('/', 'PatientController@create');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index');