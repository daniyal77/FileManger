<?php

use App\Http\Controllers\DiskSpaceController;
use App\Http\Controllers\FileMangerFolderController;
use App\Http\Controllers\MediaController;
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
    Route::get('trash', [FileMangerFolderController::class, 'trash']);
    Route::get('/show/{slug}', [FileMangerFolderController::class, 'show']);
    Route::post('/create', [FileMangerFolderController::class, 'store']);
    Route::put('/update', [FileMangerFolderController::class, 'update']);
    Route::delete('/delete/{folderId}', [FileMangerFolderController::class, 'delete']);
    Route::delete('/force/{folderId}', [FileMangerFolderController::class, 'trash']);
    Route::get('/restore/{folderId}', [FileMangerFolderController::class, 'restore']);
});


Route::prefix('/v1/media')->group(function () {
    Route::post('/create', [MediaController::class, 'store']);
    Route::put('/update', [MediaController::class, 'update']);
    Route::get('/show/length/{media_id}', [MediaController::class, 'showLength']);
    Route::delete('/delete/{media_id}', [MediaController::class, 'delete']);
    Route::delete('/force-delete/{media_id}', [MediaController::class, 'forceDelete']);
    Route::get('/filter/{media_id}', [MediaController::class, 'filter']);

    Route::get('/restore/{media_id}', [MediaController::class, 'restore']);
    Route::get('/trash', [MediaController::class, 'trash']);
});


Route::get('/v1/disk-space', [DiskSpaceController::class, 'index']);
