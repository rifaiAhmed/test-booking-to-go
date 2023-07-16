<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThisIsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ThisIsController::class, 'index']);
Route::get('/data', [ThisIsController::class, 'dataAll']);
Route::get('/detail/{id}', [ThisIsController::class, 'detail']);
Route::get('/delete/{id}', [ThisIsController::class, 'deleteFam']);
Route::get('/delete-cust/{id}', [ThisIsController::class, 'deleteCust']);
Route::post('/insert-cust', [ThisIsController::class, 'insertCustomer'])->name(
    'insert-cust'
);
Route::post('/insert-fam', [ThisIsController::class, 'insertFam'])->name(
    'insert-cust'
);
