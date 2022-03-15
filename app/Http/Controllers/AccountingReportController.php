<?php

namespace App\Http\Controllers;

use App\Helper\TransactionReports\Calculation;
use App\Models\LedgerHead;
use App\Models\TransactionDetail;

class AccountingReportController extends Controller
{
    public function balance_sheet_index()
    {
        try {
            $asset_items = LedgerHead::where(
                "company_id",
                auth()->user()->company
            )
                ->where("name_of_group", "Asset")
                ->orderBy("visibility_order", "asc")
                ->get();
            $liability_items = LedgerHead::where(
                "company_id",
                auth()->user()->company
            )
                ->where("name_of_group", "Liability")
                ->orderBy("visibility_order", "asc")
                ->get();
            return view(
                "backend.content.report.balanceSheet.index",
                compact("asset_items", "liability_items")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    // this function will return all the childs of a group ledger head
    public function get_particulars($ledgerHead)
    {
        try {
            $particular = LedgerHead::find($ledgerHead);
            // return $particular;
            return view(
                "backend.content.report.balanceSheet.particulars",
                compact("particular")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    // this function returns all the transactions of a particular ledger Head
    public function get_transactions($ledgerHead)
    {
        try {
            $transactions = Calculation::calculate($ledgerHead);
            return view(
                "backend.content.report.balanceSheet.transactions",
                compact("transactions")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function particular_transaction_details($transaction_id)
    {
        try {
            $transactions = TransactionDetail::with(
                "head",
                "transaction.voucher"
            )
                ->where("transaction_id", $transaction_id)
                ->get();
            // return $transactions;
            return view(
                "backend.content.report.balanceSheet.transactions",
                compact("transactions")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
