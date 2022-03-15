<?php

namespace App\Console\Commands\DataFromAPI;

use App\Models\LedgerHead;
use Illuminate\Console\Command;
use App\Helper\BAIUST_API\StudentRelated\Information;

class LedgerHeadAssign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ledgerHead:assign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This script fetches all the students from BAIUST IUMSS and assigns the student ID and Name as Ledger Heads. Existing IDs are filtered.';

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
            $students = Information::all_student();
            // $this->info('Data-Type: ' . gettype($students));
            foreach ($students as $student) {
                if ($student['Program'] == 'CSE') {
                    $parent_id = 43;
                } elseif ($student['Program'] == 'EEE') {
                    $parent_id = 44;
                } elseif ($student['Program'] == 'CE') {
                    $parent_id = 45;
                } elseif ($student['Program'] == 'BBA') {
                    $parent_id = 46;
                } elseif ($student['Program'] == 'English') {
                    $parent_id = 47;
                } else {
                    $parent_id = 48;
                }
                LedgerHead::firstOrCreate(
                    ['name' => $student['ledger_head']],
                    [
                        'parent_id' => $parent_id,
                        'company_id' => 1
                    ]
                );
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
