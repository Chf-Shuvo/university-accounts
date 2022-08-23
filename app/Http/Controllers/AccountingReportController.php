<?php

namespace App\Http\Controllers;

use App\Enums\NameOfGroup;
use App\Enums\ParticularType;
use App\Helper\TransactionReports\Calculation;
use App\Models\LedgerHead;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

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
            foreach ($asset_items as $item) {
                $transaction_summary = Calculation::calculate_summary(
                    $item->id
                );
                $item->transaction_summary = $transaction_summary;
            }
            // return $asset_items;

            $liability_items = LedgerHead::where(
                "company_id",
                auth()->user()->company
            )
                ->where("name_of_group", NameOfGroup::Liabilities)
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
            $particular = LedgerHead::with(
                "particulars:parent_id,id,name,alias_of",
                "particulars.alias"
            )->find($ledgerHead);
            foreach ($particular->particulars as $ledger) {
                $transaction_summary = Calculation::calculate_summary(
                    $ledger->id
                );
                $ledger->transaction_summary = $transaction_summary;
                // return $ledger;
            }
            $particular->particulars = $particular->particulars->filter(
                function ($item) {
                    return $item->alias_of == null;
                }
            );
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
            $ledgerHead = explode("-", $ledgerHead);
            $ledgerHead = LedgerHead::where("name", $ledgerHead[0])->first()
                ->id;
            $transactions = Calculation::calculate($ledgerHead);
            $transactions = $transactions
                ->filter(function ($query) use ($ledgerHead) {
                    return $query->ledger_head == $ledgerHead;
                })
                ->values();
            $closing_balance =
                $transactions
                    ->where("particular", ParticularType::Debit)
                    ->sum("amount") -
                $transactions
                    ->where("particular", ParticularType::Credit)
                    ->sum("amount");
            $ledgerHead = LedgerHead::find($ledgerHead);
            // return $transactions;
            return view(
                "backend.content.report.balanceSheet.transactions",
                compact("transactions", "ledgerHead", "closing_balance")
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
                compact("transactions", "transaction_id")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * ***********************
     * Display Section
     * ***********************
     */
    public function display_ledger()
    {
        try {
            return view("backend.content.report.display.ledger");
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function display_get_ledgers(Request $request)
    {
        try {
            $data_array = [];
            $ledgerHeads = LedgerHead::select("head_code", "name")
                ->where("name", "like", "%" . $request->keyword . "%")
                ->get();
            foreach ($ledgerHeads as $ledgerHead) {
                array_push(
                    $data_array,
                    $ledgerHead->name . "-" . $ledgerHead->head_code
                );
            }
            return $data_array;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function display_ledger_transactions($ledgerHead)
    {
        try {
            $ledgerHead = explode("-", $ledgerHead);
            $ledgerHead = LedgerHead::where("name", $ledgerHead[0])->first()
                ->id;
            $transactions = Calculation::calculate($ledgerHead);
            $transactions = $transactions
                ->filter(function ($query) use ($ledgerHead) {
                    return $query->ledger_head == $ledgerHead;
                })
                ->values();
            $closing_balance =
                $transactions
                    ->where("particular", ParticularType::Debit)
                    ->sum("amount") -
                $transactions
                    ->where("particular", ParticularType::Credit)
                    ->sum("amount");
            $ledgerHead = LedgerHead::find($ledgerHead);
            // return $transactions;
            return view(
                "backend.content.report.display.transactions",
                compact("transactions", "ledgerHead", "closing_balance")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * *******************************************
     * Income Statement Part
     * *******************************************
     */
    public function income_index()
    {
        try {
            $asset_items = LedgerHead::where(
                "company_id",
                auth()->user()->company
            )
                ->where("name_of_group", NameOfGroup::Income)
                ->orderBy("visibility_order", "asc")
                ->get();
            foreach ($asset_items as $item) {
                $transaction_summary = Calculation::calculate_summary(
                    $item->id
                );
                $item->transaction_summary = $transaction_summary;
            }
            // return $asset_items;

            $liability_items = LedgerHead::where(
                "company_id",
                auth()->user()->company
            )
                ->where("name_of_group", NameOfGroup::Expense)
                ->orderBy("visibility_order", "asc")
                ->get();
            foreach ($liability_items as $item) {
                $transaction_summary = Calculation::calculate_summary(
                    $item->id
                );
                $item->transaction_summary = $transaction_summary;
            }
            // return $liability_items;
            return view(
                "backend.content.report.incomeStatement.index",
                compact("asset_items", "liability_items")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    // this function will return all the childs of a group ledger head
    public function income_get_particulars($ledgerHead)
    {
        try {
            $particular = LedgerHead::with(
                "particulars:parent_id,id,name"
            )->find($ledgerHead);
            foreach ($particular->particulars as $ledger) {
                $transaction_summary = Calculation::calculate_summary(
                    $ledger->id
                );
                $ledger->transaction_summary = $transaction_summary;
                // return $ledger;
            }
            // return $particular;
            return view(
                "backend.content.report.incomeStatement.particulars",
                compact("particular")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    // this function returns all the transactions of a particular ledger Head
    public function income_get_transactions($ledgerHead)
    {
        try {
            $transactions = Calculation::calculate($ledgerHead);
            $ledgerHead = LedgerHead::find($ledgerHead);
            return view(
                "backend.content.report.incomeStatement.transactions",
                compact("transactions", "ledgerHead")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function income_particular_transaction_details($transaction_id)
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

    /**
     * ********************************************
     * Expense Part
     * ********************************************
     */
    public function expense_index()
    {
        try {
            return $asset_items = LedgerHead::where(
                "company_id",
                auth()->user()->company
            )
                ->where("name_of_group", NameOfGroup::Expense)
                ->orderBy("visibility_order", "asc")
                ->get();
            foreach ($asset_items as $item) {
                $transaction_summary = Calculation::calculate_summary(
                    $item->id
                );
                $item->transaction_summary = $transaction_summary;
            }
            // return $asset_items;

            $liability_items = LedgerHead::where(
                "company_id",
                auth()->user()->company
            )
                ->where("name_of_group", NameOfGroup::Expense)
                ->orderBy("visibility_order", "asc")
                ->get();
            return view(
                "backend.content.report.incomeStatement.index",
                compact("asset_items", "liability_items")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    // this function will return all the childs of a group ledger head
    public function expense_get_particulars($ledgerHead)
    {
        try {
            $particular = LedgerHead::with(
                "particulars:parent_id,id,name"
            )->find($ledgerHead);
            foreach ($particular->particulars as $ledger) {
                $transaction_summary = Calculation::calculate_summary(
                    $ledger->id
                );
                $ledger->transaction_summary = $transaction_summary;
                // return $ledger;
            }
            // return $particular;
            return view(
                "backend.content.report.incomeStatement.particulars",
                compact("particular")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    // this function returns all the transactions of a particular ledger Head
    public function expense_get_transactions($ledgerHead)
    {
        try {
            $transactions = Calculation::calculate($ledgerHead);
            $ledgerHead = LedgerHead::find($ledgerHead);
            return view(
                "backend.content.report.incomeStatement.transactions",
                compact("transactions", "ledgerHead")
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function expense_particular_transaction_details($transaction_id)
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
