<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/attendance', [AttendanceController::class, 'index']);
Route::post('/attendance/store', [AttendanceController::class, 'store']);
Route::get('/employee/attendance/{employee_id}', [AttendanceController::class, 'AttendanceInformation']);

Route::post('attendance/upload', [AttendanceController::class, 'store'] );

Route::get('/group-by-owners', [AttendanceController::class, 'groupByOwners']);


// Add other routes as needed