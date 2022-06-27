<?php

namespace App\Helper\TransactionReports;

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
            $start_date = Carbon::createFromFormat("Y-m-d", self::start_date());
            $end_date = Carbon::createFromFormat("Y-m-d", self::end_date());

            $company_transactions = TransactionDetail::with(
                "company_transactions"
            )
                ->where("ledger_head", $ledgerHead)
                ->whereBetween("date", [$start_date, $end_date])
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
            return $transactions;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public static function calculate_summary($head)
    {
        try {
            $root_date = Carbon::createFromFormat("Y-m-d", self::root_date());
            $start_date = Carbon::createFromFormat(
                "Y-m-d",
                self::start_date()
            )->subDay();
            $end_date = Carbon::createFromFormat("Y-m-d", self::end_date());

            // dd($start_date);
            $ledgerHead = LedgerHead::find($head);
            if ($ledgerHead->has_child > 0) {
                $transactions = TransactionDetail::with("transaction")
                    ->where("parents", "like", "%" . "," . $head . "," . "%")
                    ->get();
            } else {
                $transactions = TransactionDetail::with("transaction")
                    ->where("ledger_head", $head)
                    ->get();
            }
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

                    if (
                        $transaction_date->between($start_date, $end_date) &&
                        $transaction->transaction->company_id ==
                            auth()->user()->company
                    ) {
                        if ($transaction->particular == ParticularType::Debit) {
                            $debit = $debit + $transaction->amount;
                        } else {
                            $credit = $credit + $transaction->amount;
                        }
                    }
                }
                // opening balance calculation
                if ($start_date->gt($root_date)) {
                    $root_end_date = $start_date->subDay();
                    foreach ($transactions as $transaction) {
                        $transaction_date = Carbon::createFromFormat(
                            "Y-m-d",
                            $transaction->date
                        );
                        if (
                            $transaction_date->between(
                                $root_date,
                                $root_end_date
                            ) &&
                            $transaction->transaction->company_id ==
                                auth()->user()->company
                        ) {
                            if (
                                $transaction->particular ==
                                ParticularType::Debit
                            ) {
                                $root_debit =
                                    $root_debit + $transaction->amount;
                            } else {
                                $root_credit =
                                    $root_credit + $transaction->amount;
                            }
                            $balance = $root_debit - $root_credit;
                            $openning = $openning + $balance;
                        }
                    }
                }
                $closing = $debit - $credit;
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
    public static function get_parents($head)
    {
        try {
            $head = LedgerHead::where("name", $head)->first();
            if ($head->parent_id != 0) {
                array_push(self::$parents, "," . $head->parent_id . ",");
            }
            // recursive parent allocation
            if ($head->parent_id != 0) {
                $name = LedgerHead::find($head->parent_id)->name;
                self::get_parents($name);
            }
            return self::$parents;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
