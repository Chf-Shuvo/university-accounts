<?php

namespace App\Http\Controllers\API;

use App\Models\LedgerHead;
use App\Enums\ParticularType;
use App\Models\TransactionDetail;
use App\Http\Controllers\Controller;
use App\Helper\TransactionReports\Calculation;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    public function closing_balance($student_id)
    {
        try {
            $ledger_head = LedgerHead::where("name", $student_id)->first();
            $transactions = TransactionDetail::where(
                "ledger_head",
                $ledger_head->id
            )->get();
            if ($transactions->isEmpty()) {
                return response()->json([
                    "response" => "404",
                ]);
            } else {
                $debit = 0;
                $credit = 0;
                $closing = 0;
                foreach ($transactions as $transaction) {
                    if ($transaction->particular == ParticularType::Debit) {
                        $debit = $debit + $transaction->amount;
                    } else {
                        $credit = $credit + $transaction->amount;
                    }
                }
                $closing = $debit - $credit;
                $transaction_summary = [
                    "receivable" => $debit,
                    "paid" => $credit,
                    "closing_balance" => $closing,
                ];
            }
            return response()->json(
                [
                    "summary" => $transaction_summary,
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "response" => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function student_ledger($student_id)
    {
        try {
            $ledger_head = LedgerHead::where("name", $student_id)->first()->id;
            $company_transactions = TransactionDetail::with(
                "company_transactions"
            )
                ->where("ledger_head", $ledger_head)
                ->get();
            $transactionIDs = $company_transactions
                ->where("company_transactions", "!=", null)
                ->pluck("transaction_id");
            // return $transactionIDs;
            $transactions = TransactionDetail::with(
                "head",
                "transaction.voucher"
            )
                ->whereIn("transaction_id", $transactionIDs)
                ->get();
            $transactions = $transactions
                ->filter(function ($query) use ($ledger_head) {
                    return $query->ledger_head != $ledger_head;
                })
                ->values();
            return response()->json($transactions, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "response" => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
