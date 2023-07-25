<?php

use App\Http\Controllers\TrackController;
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

//* **  Public routes Auxona ** *//
//* ** Prefix: auxona        ** *//
Route::prefix('auxona')->group(function () {
    Route::get('/tracks/{id}', [TrackController::class, 'findByIdDeezer'])->name('tracks.findByIdDeezer');
    Route::post('/tracks', [TrackController::class, 'save'])->name('tracks.save');
});
