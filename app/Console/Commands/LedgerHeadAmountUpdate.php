<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TransactionDetail;
use App\Helper\TransactionReports\Calculation;
use App\Models\LedgerHeadAmount;

class LedgerHeadAmountUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "ledger_head_amount:update";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "This command takes all the amounts from Transaction Details table and assigns the summed amount in ledger_head_amounts table with distinct ledger heads.";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $ledger_heads = TransactionDetail::select("ledger_head")
                ->distinct("ledger_head")
                ->pluck("ledger_head");
            foreach ($ledger_heads as $head) {
                $amount = Calculation::calculate_summary($head);
                LedgerHeadAmount::updateOrCreate(
                    ["ledger_head" => $head],
                    [
                        "parent_id" => $amount["parent_id"],
                        "dr" => $amount["debit"],
                        "cr" => $amount["credit"],
                    ]
                );
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
