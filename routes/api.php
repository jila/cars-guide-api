<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//car-make like toyota
Route::post('/car-make', [\App\Http\Controllers\CarMakeController::class, 'addCarMake']);
Route::get('/car-make', [\App\Http\Controllers\CarMakeController::class, 'getCarMakes']);

// car-model like corolla
Route::post('/car-model', [\App\Http\Controllers\CarModelController::class, 'addCarModel']);
Route::get('/car-model', [\App\Http\Controllers\CarModelController::class, 'getCarModel']);

Route::post('/car', [\App\Http\Controllers\CarController::class, 'addCar']);
Route::get('/car', [\App\Http\Controllers\CarController::class, 'getCars']);
Route::patch('/car/{key}', [\App\Http\Controllers\CarController::class, 'editCar']);
Route::delete('/car/{key}', [\App\Http\Controllers\CarController::class, 'deleteCar']);
