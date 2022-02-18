<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\SoldCarController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Get raw file content by file_req_id
 * $format (pdf,docx,xlsx)
 */
Route::post('/sold_cars/report/{format}/create/raw', [SoldCarController::class, 'generateReportRawForFront']);
/**
 *  Generate and send repotr to post (not implemented)
 * $format (pdf,docx,xlsx)
 */
Route::post('/sold_cars/report/{format}/create/send_post', [SoldCarController::class, 'generateReportAndSendToPost']);
/**
 * Create report and share link for download
 *  * $format (pdf,docx,xlsx)
 */
Route::post('/sold_cars/report/create/share_link/{format}', [SoldCarController::class, 'generateReportAndShareLink']);


Route::get('/file/download/{link_record_id}', [LinkController::class, 'downloadFile']);
