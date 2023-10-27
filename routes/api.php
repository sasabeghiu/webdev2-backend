<?php

use App\Http\Controllers\ServicesController;
use App\Http\Controllers\AppointmentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/services', [ServicesController::class, 'index']);
Route::post('/services', [ServicesController::class, 'store']);
Route::get('/services/{id}', [ServicesController::class, 'show']);
Route::put('/services/{id}', [ServicesController::class, 'update']);
Route::delete('/services/{id}', [ServicesController::class, 'destroy']);

Route::get('/appointments', [AppointmentsController::class, 'index']);
Route::post('/appointments', [AppointmentsController::class, 'store']);
Route::get('/appointments/{id}', [AppointmentsController::class, 'show']);
Route::put('/appointments/{id}', [AppointmentsController::class, 'update']);
Route::delete('/appointments/{id}', [AppointmentsController::class, 'destroy']);
