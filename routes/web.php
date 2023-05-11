<?php

use App\Http\Controllers\KurirController;
use Illuminate\Support\Facades\Route;

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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/kurirs', [KurirController::class, 'index']);
Route::get('/kurir/{id}', [KurirController::class, 'show']);
Route::post('/kurir', [KurirController::class, 'store']);
Route::patch('/kurir/{id}', [KurirController::class, 'update']);
Route::delete('/kurir/{id}', [KurirController::class, 'delete']);
