<?php

use App\Http\Controllers\DownloadCenter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LineRequest;
use App\Http\Controllers\Line_branchCustomer;
use App\Http\Middleware\EnsureTokenIsValid;

use function Ramsey\Uuid\v1;

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

// Route::get('/ARCustomerCard', [App\Http\Controllers\libs\report\AR_CustomerCard_report::class, 'CreateReport']);
// Route::group(['prefix' => '/Downloads'], function () {
//     Route::get('/', [App\Http\Controllers\DownloadCenter::class, 'getDownloadFolder']);
//     Route::get('/storages', [App\Http\Controllers\DownloadCenter::class, 'getDownloadFolder']);
//     Route::get('/storages/file', [App\Http\Controllers\DownloadCenter::class, 'getDownloadFolder']);
//     Route::get('/report', [App\Http\Controllers\DownloadCenter::class, 'getReportFolder']);
//     Route::get('/report/{filename}', function ($filename) {
//         $report = new DownloadCenter($filename);
//         return $report->download($filename);
//     });
// });
// Route::get('/Downloads', function () {
//     return redirect('/Downloads/storages');
// });
// Route::get('/Downloads/storages/{path?}/{subPath?}', function ($path = null, $subpath = null) {
//     $DownloadCenter = new DownloadCenter;
//     return $DownloadCenter->getDownloadFolder($path, $subpath);
// });
// Route::get('/Downloads/storages/{path?}/{subPath?}', function ($path = null, $subpath = null) {
//     $DownloadCenter = new DownloadCenter;
//     return $DownloadCenter->getDownloadFolder($path, $subpath);
// });


// http://127.0.0.1:8000/Downloads/storages/file/report/report_CustCard_112022.xlsx


Route::post('/LineRequest', [App\Http\Controllers\LineRequest::class, 'keepRequest']);
Route::get('/LineRequest', [App\Http\Controllers\LineRequest::class, 'keepRequest']);

Route::get('/Line', [Line_branchCustomer::class, 'Get_Request']);