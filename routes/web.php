<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LedgerHeadController;
use App\Http\Controllers\user\UserSettingController;
use App\Http\Controllers\user\UserPermissionController;
use App\Http\Controllers\frontend\LandingPageController;
use App\Http\Controllers\VoucherController;

/**
 * ***********************
 * Test Routes
 * ***********************
 */
Route::get('test', function () {
    //
});
/**
 * *********************************************
 * Front-End Routes
 * *********************************************
 */
Route::group(['namespace' => 'frontend'], function () {
    Route::get('/', [LandingPageController::class, 'landingPage'])->name('frontend.landing');
});



/**
 * *********************************************
 * Back-End Routes
 * *********************************************
 */
Auth::routes([
    'logout' => false,
    'register' => false
]);
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    /**
     * ********************************************
     * User Routes
     * ********************************************
     */
    Route::controller(HomeController::class)->group(function () {
        Route::get('home', 'index')->name('home');
        Route::get('user-logout', 'logout')->name('logout');
    });
    Route::controller(UserSettingController::class)->group(function () {
        Route::get('user-profile/delete/{id}', 'destroy')->name('user-profile.destroy');
        Route::resource('user-profile', UserSettingController::class)->except('destroy');
        // audit routes
        Route::get('user/audits/index', 'auditSettings')->name('audit.index');
        Route::post('user/audits/get', 'getAudits')->name('audit.get');
    });

    /**
     * permission Routes
     */
    Route::controller(UserPermissionController::class)->group(function () {
        Route::get('permission/create/{id}', 'create')->name('permission.create');
        Route::get('permission/delete/{id}', 'destroy')->name('permission.destroy');
        Route::resource('permission', UserPermissionController::class)->except('destroy', 'create');
        Route::match(['put', 'patch'], 'user/assigned-permissions/update/{userID}', 'permissionUpdate')->name('permission.user.update');
    });

    /**
     * ****************************************
     * Ledger Head Management Routes
     * ****************************************
     */
    Route::controller(LedgerHeadController::class)->group(function () {
        Route::get('ledger-head/destroy/{ledgerHead}', 'destroy')->name('ledger-head.destroy');
        Route::resource('ledger-head', LedgerHeadController::class)->except('create', 'show', 'destroy');
    });
    /**
     * ****************************************
     * Voucher Routes
     * ****************************************
     */
    Route::controller(VoucherController::class)->group(function () {
        Route::group(['prefix' => 'voucher', 'as' => 'voucher.'], function () {
            Route::get('manage/destroy/{manage}', 'destroy')->name('manage.destroy');
            Route::resource('manage', VoucherController::class)->except('create', 'show', 'destroy');
        });
    });
});
