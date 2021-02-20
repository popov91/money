<?php

use App\Http\Controllers\CalculateController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\IndexController;
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

Route::get('/', [IndexController::class, 'index']);

Route::get('/calculate', [CalculateController::class, 'index']);
Route::post('/calculate/send-to-calculate', [CalculateController::class, 'sendToCalculate']);
Route::post('/calculate/save-result', [CalculateController::class, 'saveResult']);

Route::get('/history', [HistoryController::class, 'index']);
Route::post('/history/get-result', [HistoryController::class, 'getResult']);
Route::post('/history/update-comment', [HistoryController::class, 'updateComment']);
