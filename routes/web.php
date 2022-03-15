<?php

use App\Http\Controllers\AccountingReportController;
use App\Http\Controllers\CompanyController;
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
Route::get("test", function () {
    //
});
/**
 * *********************************************
 * Public-End Routes
 * *********************************************
 */
Route::get("/", function () {
    return redirect()->route("login");
});
/**
 * ***************************
 * Company Create Route
 * ***************************
 */
Route::get("company/create", [CompanyController::class, "create"])->name(
    "company.create"
);
Route::post("company/store", [CompanyController::class, "store"])->name(
    "company.store"
);

/**
 * *********************************************
 * Back-End Routes
 * *********************************************
 */
Auth::routes([
    "logout" => false,
    "register" => false,
]);
Route::group(["prefix" => "admin", "middleware" => "auth"], function () {
    /**
     * ********************************************
     * User Routes
     * ********************************************
     */
    Route::controller(HomeController::class)->group(function () {
        Route::get("home", "index")->name("home");
        Route::get("user-logout", "logout")->name("logout");
    });
    Route::controller(UserSettingController::class)->group(function () {
        Route::get("user-profile/delete/{id}", "destroy")->name(
            "user-profile.destroy"
        );
        Route::resource("user-profile", UserSettingController::class)->except(
            "destroy"
        );
        // audit routes
        Route::get("user/audits/index", "auditSettings")->name("audit.index");
        Route::post("user/audits/get", "getAudits")->name("audit.get");
    });
    /**
     * Company Update Routes
     */
    Route::match(["put", "patch"], "user/company/update/{company}", [
        CompanyController::class,
        "update",
    ])->name("company.update");
    /**
     * permission Routes
     */
    Route::controller(UserPermissionController::class)->group(function () {
        Route::get("permission/create/{id}", "create")->name(
            "permission.create"
        );
        Route::get("permission/delete/{id}", "destroy")->name(
            "permission.destroy"
        );
        Route::resource("permission", UserPermissionController::class)->except(
            "destroy",
            "create"
        );
        Route::match(
            ["put", "patch"],
            "user/assigned-permissions/update/{userID}",
            "permissionUpdate"
        )->name("permission.user.update");
    });

    /**
     * ****************************************
     * Ledger Head Management Routes
     * ****************************************
     */
    Route::controller(LedgerHeadController::class)->group(function () {
        Route::get("ledger-head/destroy/{ledgerHead}", "destroy")->name(
            "ledger-head.destroy"
        );
        Route::resource("ledger-head", LedgerHeadController::class)->except(
            "create",
            "show",
            "destroy"
        );
        Route::get("single-ledgers", "single_ledgers")->name(
            "ledger-head.single"
        );
        Route::get("group-ledgers", "group_ledgers")->name("ledger-head.group");
    });
    /**
     * ****************************************
     * Voucher Routes
     * ****************************************
     */
    Route::controller(VoucherController::class)->group(function () {
        Route::group(["prefix" => "voucher", "as" => "voucher."], function () {
            Route::get("manage/destroy/{manage}", "destroy")->name(
                "manage.destroy"
            );
            Route::resource("manage", VoucherController::class)->except(
                "create",
                "show",
                "destroy"
            );
            /** Accounting Vouchers */
            Route::group(
                ["prefix" => "accounting", "as" => "accounting."],
                function () {
                    Route::get("create", "accounting_voucher_create")->name(
                        "create"
                    );
                    Route::post("store", "accounting_voucher_store")->name(
                        "store"
                    );
                }
            );
        });
    });
    /**
     * ****************************************
     * Balance Sheet
     * ****************************************
     */
    Route::controller(AccountingReportController::class)->group(function () {
        Route::group(["prefix" => "reports", "as" => "report."], function () {
            Route::group(
                ["prefix" => "balance-sheet", "as" => "balance-sheet."],
                function () {
                    Route::get("index", "balance_sheet_index")->name("index");
                    Route::get(
                        "particulars/{ledgerHead}",
                        "get_particulars"
                    )->name("particurlars");
                    Route::get(
                        "transactions/{ledgerHead}",
                        "get_transactions"
                    )->name("transactions");
                    Route::get(
                        "particular/transaction/details/{transaction_id}",
                        "particular_transaction_details"
                    )->name("particular.transacation");
                }
            );
        });
    });
});
