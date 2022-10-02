<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\LedgerHead;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Helper\TransactionReports\Calculation;
use App\Helper\BAIUST_API\StudentRelated\Information;

class StudentReceivableController extends Controller
{
    public function store(Request $request)
    {
        try {
            $receivables = $request->all();
            // return $receivables;
            // return $receivables[0];
            $student_for_receivable = $receivables[0]["student_id"];
            if ($receivables) {
                $total = array_sum(array_column($receivables, "amount"));
                $ledger_head_student = LedgerHead::where(
                    "name",
                    $student_for_receivable
                )->first()->id;
                $parents_student = json_encode(
                    Calculation::parents($student_for_receivable)
                );
                // return $parents_student;
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
                        $receivable["fee_id"]
                    );
                    $ledger = LedgerHead::find($ledger_database_id);
                    $parents = json_encode(Calculation::parents($ledger->name));
                    TransactionDetail::create([
                        "transaction_id" => $transaction->id,
                        "particular" => "Cr",
                        "ledger_head" => $ledger->id,
                        "amount" => $receivable["amount"],
                        "date" => Carbon::parse(Carbon::now())->format("Y-m-d"),
                        "parents" => $parents,
                    ]);
                }
            }
            return Response::json([
                "response" => "success",
            ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
