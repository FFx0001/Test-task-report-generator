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
 * Response
 * {
    "success": true,
    "errors": "",
    "data": {
        "raw_data": "JVBERi0x5kb2...Ri0x5==",
        "extension": "pdf",
        "real_file_name": "Отчет о проданных автомобилях"
        }
    }
 */
Route::post('/sold_cars/report/{format}/create/raw', [SoldCarController::class, 'generateReportRawForFront']);

/**
 *  Generate and send report to post (not implemented)
 * $format (pdf,docx,xlsx)
 * @Response
 * {
    "success": true,
    "errors": "not implemented",
    "data": {}
    }
 */
Route::post('/sold_cars/report/{format}/create/send_post', [SoldCarController::class, 'generateReportAndSendToPost']);

/**
 * Create report and share link for download file
 * $format (pdf,docx,xlsx)
 * @response
 * {
    "success": true,
    "errors": "",
    "data": {
    "url": "http://ReportGenerator.local/api/file/download/8bfc8249-c27f-4251-ba6e-883e9ee81797"
    }
}
 */
Route::post('/sold_cars/report/{format}/create/share_link', [SoldCarController::class, 'generateReportAndShareLink']);

/**
 * This method download file from shred link
 */
Route::get('/file/download/{link_record_id}', [LinkController::class, 'downloadFile']);
