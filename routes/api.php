<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PersonController;

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

Route::get('/people', [PersonController::class, 'index']);
Route::post('/people/{person}/like', [PersonController::class, 'like']);
Route::post('/people/{person}/dislike', [PersonController::class, 'dislike']);
Route::get('/people/{person}/liked', [PersonController::class, 'likedList']);
Route::get('/people/{person}/liked-list', [PersonController::class, 'likedList']);