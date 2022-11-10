<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LineRequest;
use App\Http\Controllers\Line_branchCustomer;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/LineRequest', [App\Http\Controllers\LineRequest::class, 'keepRequest']);
Route::get('/LineRequest', [App\Http\Controllers\LineRequest::class, 'keepRequest']);

Route::get('/Line', [Line_branchCustomer::class, 'Get_Request']);