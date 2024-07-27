<?php

use App\Http\Controllers\FileMangerFolderController;
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

/**
 * ایجاد پوشه
 */
Route::prefix('/v1/folder')->group(function () {
    Route::get('/list', [FileMangerFolderController::class, 'index']);
    Route::get('/show/{slug}', [FileMangerFolderController::class, 'show']);
    Route::post('/create', [FileMangerFolderController::class, 'store']);
    Route::put('/rename', [FileMangerFolderController::class, 'rename']);
    Route::delete('/delete', [FileMangerFolderController::class, 'delete']);
});


