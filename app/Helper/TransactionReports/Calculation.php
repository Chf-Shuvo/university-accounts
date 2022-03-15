<?php

namespace App\Helper\TransactionReports;

use App\Models\LedgerHead;
use App\Models\TransactionDetail;

class Calculation
{
    public static function calculate($ledgerHead)
    {
        try {
            $head = LedgerHead::find($ledgerHead);
            if ($head->has_child > 0) {
                $company_transactions = TransactionDetail::with(
                    "company_transactions"
                )
                    ->where("ledger_head", $ledgerHead)
                    ->get();
                $transactionIDs = $company_transactions
                    ->where("company_transactions", "!=", null)
                    ->pluck("transaction_id");
                // return $transactionIDs;
                $transactions = TransactionDetail::with(
                    "head",
                    "transaction.voucher"
                )
                    ->where("ledger_head", $ledgerHead)
                    ->whereIn("transaction_id", $transactionIDs)
                    ->get();
            } else {
                $company_transactions = TransactionDetail::with(
                    "company_transactions"
                )
                    ->where("ledger_head", $ledgerHead)
                    ->get();
                $transactionIDs = $company_transactions
                    ->where("company_transactions", "!=", null)
                    ->pluck("transaction_id");
                // return $transactionIDs;
                $transactions = TransactionDetail::with(
                    "head",
                    "transaction.voucher"
                )
                    ->where("ledger_head", $ledgerHead)
                    ->whereIn("transaction_id", $transactionIDs)
                    ->get();
            }
            return $transactions;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
