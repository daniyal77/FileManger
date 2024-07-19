<?php

use App\Http\Controllers\FileMangerFolderController;
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

Route::get('/', [FileMangerFolderController::class, 'index'])->name('main.folder');
Route::get('/folder/{slug}', [FileMangerFolderController::class, 'show'])->name('show.folder');
Route::post('/create', [FileMangerFolderController::class, 'store'])->name('create.folder');
