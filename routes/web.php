<?php

use App\Http\Controllers\MainController;
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

Route::get('/', [MainController::class, 'index']);

Route::get('/Data', [MainController::class, 'GetData'])->name('GetData');
Route::post('/Employeesdatatable', [MainController::class, "Employeesdatatable"])->name('Employeesdatatable');
Route::post('/export-all-data', 'MainController@exportAllData')->name('exportAllData');
