<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::controller(AuthController::class)->group(function () {
    Route::post("login", "login");
});

Route::controller(ReportController::class)->group(function () {
    Route::group(
        ["middleware" => "auth:sanctum", "prefix" => "reports"],
        function () {
            Route::get("closing-balance/{student_id}", "closing_balance");
            Route::get("student-ledger/{student_id}", "student_ledger");
        }
    );
});
