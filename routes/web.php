<?php

use App\Http\Controllers\FileController;
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

Route::get('/files/{directory?}', [FileController::class, 'index'])->where('directory', '.*');
Route::get('/download/{file?}', [FileController::class, 'download'])->where('file', '.*');

Route::post('/new/directory', [FileController::class, 'newDirectory']);
Route::post('/new/file', [FileController::class, 'newFile']);

Route::get('{catchall}', function () {
    return redirect('files');
})->where('catchall', '.*');
