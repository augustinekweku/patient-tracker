<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientController;

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

Route::prefix('app')->group(function(){
    Route::post('/delete_patient',[PatientController::class, 'deletePatient']);
    Route::post('/edit_patient',[PatientController::class, 'editPatient']);
    Route::get('/get_patients',[PatientController::class, 'getPatients']);
    Route::post('/add_patient',[PatientController::class, 'addPatient']);

    Route::post('/register',[AuthController::class, 'register']);
    Route::post('/login',[AuthController::class, 'login']);

});

Route::get('/logout',[AuthController::class, 'logout']);
Route::get('/',[HomeController::class, 'index']);
Route::any('{slug}', [HomeController::class, 'index'])->where('slug', '([A-z\d\-\/_.]+)?');

