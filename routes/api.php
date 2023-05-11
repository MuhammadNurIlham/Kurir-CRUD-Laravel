<?php

use App\Http\Controllers\KurirController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// // Route for Programs
Route::get('/v1/kurirs', [KurirController::class, 'index']);
Route::get('/v1/kurir/{id}', [KurirController::class, 'show']);
Route::post('/v1/kurir', [KurirController::class, 'store']);
Route::patch('/v1/kurir/{id}', [KurirController::class, 'update']);
Route::delete('/v1/kurir/{id}', [KurirController::class, 'destroy']);
