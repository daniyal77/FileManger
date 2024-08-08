<?php

use App\Http\Controllers\ClientFileManagerController;
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


Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
Route::get('show/image/{id}/{file_name}', [ClientFileManagerController::class, 'show']);
Route::get('private/image/{id}/{file_name}', [ClientFileManagerController::class, 'private'])
    ->name('optimizeImageSigned')->middleware('signed');


