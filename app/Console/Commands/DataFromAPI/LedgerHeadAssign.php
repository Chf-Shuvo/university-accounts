<?php

namespace App\Console\Commands\DataFromAPI;

use Carbon\Carbon;
use App\Models\LedgerHead;
use App\Models\Transaction;
use Illuminate\Console\Command;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Http;
use App\Helper\TransactionReports\Calculation;
use App\Helper\BAIUST_API\StudentRelated\Information;

class LedgerHeadAssign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "ledgerHead:assign";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "This script fetches all the students from BAIUST IUMSS and assigns the student ID and Name as Ledger Heads. Existing IDs are filtered.";

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
            $current_semester = Http::withToken(
                "2867|5M2Sjrdkf58fxiGEwDFsgbq2QA2KmUULtnwhtWND",
                "Bearer"
            )->get(
                "https://api.baiust.edu.bd/api/v.1/student/current-semester"
            );
            $current_semester = json_decode($current_semester);
            $current_semester = $current_semester->title;
            $students = json_decode(
                Http::withToken(
                    "2867|5M2Sjrdkf58fxiGEwDFsgbq2QA2KmUULtnwhtWND",
                    "Bearer"
                )->get("https://api.baiust.edu.bd/api/v.1/student/all-students")
            );

            foreach ($students as $student) {
                if ($student->Program == "CSE" || $student->Program == "LLB") {
                    $parent_id = Information::get_parent_id(
                        $student->Program,
                        $student->Enrollment_Semester
                    );
                    LedgerHead::updateOrCreate(
                        ["name" => $student->ledger_head],
                        [
                            "head_code" => $student->Full_Name,
                            "parent_id" => $parent_id,
                            "company_id" => 1,
                        ]
                    );

                    // get transactions
                    $student_for_receivable = [
                        "student_id" => $student->ledger_head,
                        "session" => $current_semester,
                    ];
                    $receivables = Http::withToken(
                        "2867|5M2Sjrdkf58fxiGEwDFsgbq2QA2KmUULtnwhtWND",
                        "Bearer"
                    )->post(
                        "https://api.baiust.edu.bd/api/v.1/student/accounts/receivable",
                        $student_for_receivable
                    );
                    $receivables = json_decode($receivables);
                    if ($receivables) {
                        $total = array_sum(
                            array_column($receivables, "amount")
                        );

                        $transaction = Transaction::create([
                            "company_id" => auth()->user()->company,
                            "voucher_type" => 1,
                            "total_amount" => $total,
                            "date" => Carbon::parse(Carbon::now())->format(
                                "Y-m-d"
                            ),
                        ]);
                        $this->info("Main Transaction: " . $transaction);
                        $ledger_head_student = LedgerHead::where(
                            "name",
                            $student->ledger_head
                        )->first()->id;
                        $parents_student = json_encode(
                            Calculation::parents($ledger_head_student)
                        );
                        TransactionDetail::create([
                            "transaction_id" => $transaction->id,
                            "particular" => "Dr",
                            "ledger_head" => $ledger_head_student,
                            "amount" => $total,
                            "date" => Carbon::parse(Carbon::now())->format(
                                "Y-m-d"
                            ),
                            "parents" => $parents_student,
                        ]);
                        foreach ($receivables as $receivable) {
                            $ledger_head = Information::get_ledger_head(
                                $receivable->fee_id
                            );
                            $parents = Calculation::parents($ledger_head);
                            $parents = json_encode($parents);
                            TransactionDetail::create([
                                "transaction_id" => $transaction->id,
                                "particular" => "Cr",
                                "ledger_head" => $ledger_head,
                                "amount" => $receivable->amount,
                                "date" => Carbon::parse(Carbon::now())->format(
                                    "Y-m-d"
                                ),
                                "parents" => $parents,
                            ]);
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
