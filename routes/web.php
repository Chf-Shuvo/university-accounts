<?php

use Carbon\Carbon;
use App\Models\LedgerHead;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\VoucherController;
use App\Helper\TransactionReports\Calculation;
use App\Http\Controllers\LedgerHeadController;
use App\Http\Controllers\AccountingReportController;
use App\Http\Controllers\user\UserSettingController;
use App\Helper\BAIUST_API\StudentRelated\Information;
use App\Http\Controllers\user\UserPermissionController;

/**
 * ***********************
 * Tool Routes
 * ***********************
 */
Route::get("clear", function () {
    Artisan::call("optimize:clear");
    return "Cache Cleared";
});
Route::get("test", function () {
    $current_semester = Http::withToken(
        "2867|5M2Sjrdkf58fxiGEwDFsgbq2QA2KmUULtnwhtWND",
        "Bearer"
    )->get("http://api.baiust.edu.bd/api/v.1/student/current-semester");
    $current_semester = json_decode($current_semester);
    $current_semester = $current_semester->title;
    $students = json_decode(
        Http::withToken(
            "2867|5M2Sjrdkf58fxiGEwDFsgbq2QA2KmUULtnwhtWND",
            "Bearer"
        )->get(
            "https://api.baiust.edu.bd/api/v.1/student/list/English/Fall-2021"
        )
    );
    // return $students;
    foreach ($students as $student) {
        // return $student;
        $student_for_receivable = [
            "student_id" => $student->Registration_Number,
            "session" => $current_semester,
        ];
        return $receivables = Http::withToken(
            "2867|5M2Sjrdkf58fxiGEwDFsgbq2QA2KmUULtnwhtWND",
            "Bearer"
        )->post(
            "https://api.baiust.edu.bd/api/v.1/student/accounts/receivable",
            $student_for_receivable
        );
        $receivables = json_decode($receivables);
        $receivables;
        if ($receivables) {
            $total = array_sum(array_column($receivables, "amount"));
            $ledger_head_student = LedgerHead::where(
                "name",
                $student_for_receivable["student_id"]
            )->first()->id;
            $parents_student = json_encode(
                Calculation::parents($student_for_receivable["student_id"])
            );
            $transaction = Transaction::create([
                "company_id" => 1,
                "voucher_type" => 1,
                "total_amount" => $total,
                "date" => Carbon::parse(Carbon::now())->format("Y-m-d"),
            ]);
            TransactionDetail::create([
                "transaction_id" => $transaction->id,
                "particular" => "Dr",
                "ledger_head" => $ledger_head_student, //its the database id of the ledger
                "amount" => $total,
                "date" => Carbon::parse(Carbon::now())->format("Y-m-d"),
                "parents" => $parents_student,
            ]);
            // return $parents_student;
            foreach ($receivables as $receivable) {
                $ledger_database_id = Information::get_ledger_database_id(
                    $receivable->fee_id
                );
                $ledger = LedgerHead::find($ledger_database_id);
                $parents = json_encode(Calculation::parents($ledger->name));
                TransactionDetail::create([
                    "transaction_id" => $transaction->id,
                    "particular" => "Cr",
                    "ledger_head" => $ledger->id,
                    "amount" => $receivable->amount,
                    "date" => Carbon::parse(Carbon::now())->format("Y-m-d"),
                    "parents" => $parents,
                ]);
            }
        }
    }
    return "test done";
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
        Route::post("session/period/change", "change_period")->name(
            "period.change"
        );
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
        Route::get("ledger-head/{type}", "ledgers_by_type")->name(
            "ledger-head.type"
        );
        Route::get("ledger-head/type/data", "ledgers_by_type_data")->name(
            "ledger-head.type.data"
        );
        Route::post("ledger-head/alias/create", "create_alias")->name(
            "ledger-head.alias"
        );
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
            Route::group(
                ["prefix" => "display", "as" => "display."],
                function () {
                    Route::get("ledger/accounts", "display_ledger")->name(
                        "ledger"
                    );
                    Route::get("ledgers", "display_get_ledgers")->name(
                        "ledger.get"
                    );
                }
            );
        });
    });
    /**
     * ****************************************
     * Income Statement
     * ****************************************
     */
    Route::controller(AccountingReportController::class)->group(function () {
        Route::group(["prefix" => "reports", "as" => "report."], function () {
            Route::group(
                ["prefix" => "income", "as" => "income."],
                function () {
                    Route::get("index", "income_index")->name("index");
                    Route::get(
                        "particulars/{ledgerHead}",
                        "income_get_particulars"
                    )->name("particurlars");
                    Route::get(
                        "transactions/{ledgerHead}",
                        "income_get_transactions"
                    )->name("transactions");
                    Route::get(
                        "particular/transaction/details/{transaction_id}",
                        "income_particular_transaction_details"
                    )->name("particular.transacation");
                }
            );
        });
    });
});
