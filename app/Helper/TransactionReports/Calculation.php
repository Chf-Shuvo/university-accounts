<?php

namespace App\Helper\TransactionReports;

use App\Enums\NameOfGroup;
use Carbon\Carbon;
use App\Models\LedgerHead;
use App\Enums\ParticularType;
use App\Models\TransactionDetail;

class Calculation
{
    public static function root_date()
    {
        try {
            return session()->get("root_date");
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public static function start_date()
    {
        try {
            return session()->get("start_date");
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public static function end_date()
    {
        try {
            return session()->get("end_date");
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public static function calculate($ledgerHead)
    {
        try {
            // return $ledgerHead;
            $start_date = self::start_date();
            $end_date = self::end_date();

            $company_transactions = TransactionDetail::with(
                "company_transactions"
            )
                ->where("ledger_head", $ledgerHead)
                ->whereBetween("date", [$start_date, $end_date])
                ->get();
            $transactionIDs = $company_transactions
                ->where("company_transactions", "!=", null)
                ->pluck("transaction_id");

            $transactions = TransactionDetail::with(
                "transaction",
                "transaction.details",
                "head"
            )
                ->whereIn("transaction_id", $transactionIDs)
                ->get();
            return $transactions;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public static function calculate_summary($type, $head)
    {
        try {
            $root_date = Carbon::createFromFormat("Y-m-d", self::root_date());
            $start_date = Carbon::createFromFormat("Y-m-d", self::start_date());
            $end_date = Carbon::createFromFormat("Y-m-d", self::end_date());

            // dd($start_date);
            $ledgerHead = LedgerHead::find($head);
            if ($ledgerHead->has_child > 0) {
                $transactions = TransactionDetail::where(
                    "parents",
                    "like",
                    "%" . "," . $head . "," . "%"
                )->get();
            } else {
                $transactions = TransactionDetail::with("transaction")
                    ->where("ledger_head", $head)
                    ->get();
            }
//             return $transactions;
            if ($transactions->isEmpty()) {
                $transaction_summary = [
                    "openning" => 0,
                    "debit" => 0,
                    "credit" => 0,
                    "closing" => 0,
                ];
            } else {
                // return $transactions;
                $openning = 0;
                $debit = 0;
                $credit = 0;
                $closing = 0;
                // from root date to root end date calculation
                $root_debit = 0;
                $root_credit = 0;
                $balance = 0;
                // regular amount calculation
                foreach ($transactions as $transaction) {
                    $transaction_date = Carbon::createFromFormat(
                        "Y-m-d",
                        $transaction->date
                    );
                    // return $start_date . '+' . $end_date;
                    if ($transaction_date->between($start_date, $end_date)) {
                        if ($transaction->particular == ParticularType::Debit) {
                            $debit = $debit + $transaction->amount;
                        } else {
                            $credit = $credit + $transaction->amount;
                        }
                    }
                }
                // return $debit . '+' . $credit;
                /**
                 * ***********************************
                 * opening balance calculation
                 * ***********************************
                 */
                // return $root_date;
                // return $root_end_date = $start_date->subDay();
                $root_end_date = $start_date->subDay();
                foreach ($transactions as $transaction) {
                    $transaction_date = Carbon::createFromFormat(
                        "Y-m-d",
                        $transaction->date
                    );
                    if (
                        $transaction_date->between($root_date, $root_end_date)
                    ) {
                        if ($transaction->particular == ParticularType::Debit) {
                            $root_debit = $root_debit + $transaction->amount;
                        } else {
                            $root_credit = $root_credit + $transaction->amount;
                        }
                    }
                }
                if ($type == NameOfGroup::Liability->value) {
                    $openning = $root_credit - $root_debit;
                    // return $root_debit . '+' . $root_credit . '+' . $openning;
                    $closing = $openning + $credit - $debit;
                } else {
                    $openning = $root_debit - $root_credit;
                    // return $root_debit . '+' . $root_credit . '+' . $openning;
                    $closing = $openning + $debit - $credit;
                }

                $transaction_summary = [
                    "openning" => $openning,
                    "debit" => $debit,
                    "credit" => $credit,
                    "closing" => $closing,
                ];
            }
            return $transaction_summary;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public static $parents = [];
    public static function parents($ledger_name)
    {
        try {
            self::get_parents($ledger_name);
            $send_parents = self::$parents;
            self::$parents = [];
            return $send_parents;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public static function get_parents($ledger_name)
    {
        try {
            $ledger = LedgerHead::where("name", $ledger_name)->first();
            if ($ledger->parent_id != 0) {
                array_push(self::$parents, "," . $ledger->parent_id . ",");
            }
            // recursive parent allocation
            if ($ledger->parent_id != 0) {
                $name = LedgerHead::find($ledger->parent_id)->name;
                self::get_parents($name);
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
