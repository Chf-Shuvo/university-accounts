<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Voucher;
use App\Models\LedgerHead;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $vouchers = Voucher::all();
            return view('backend.content.voucher.manage.index', compact('vouchers'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Voucher::firstOrCreate(['name' => $request->name]);
            toast('Voucher created successfully', 'success');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Voucher  $manage
     * @return \Illuminate\Http\Response
     */
    public function edit(Voucher $manage)
    {
        try {
            return view('backend.content.voucher.manage.edit', compact('manage'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Voucher  $manage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voucher $manage)
    {
        try {
            $manage->update($request->except('_token', '_method'));
            toast('Voucher type updated successfully', 'success');
            return redirect()->route('voucher.manage.index');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $manage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $manage)
    {
        try {
            $manage->delete();
            toast('Voucher type deleted successfully', 'success');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function accounting_voucher_create()
    {
        try {
            $ledgerHeads = LedgerHead::where('parent_id', '!=', 0)->get();
            $vouchers = Voucher::all();
            return view('backend.content.voucher.transaction.create', compact('ledgerHeads', 'vouchers'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function accounting_voucher_store(Request $request)
    {
        try {
            $transaction = Transaction::create([
                'company_id' => auth()->user()->company,
                'voucher_type' => $request->voucher_type,
                'total_amount' => $request->total_amount,
                'narration' => $request->narration,
                'date' => Carbon::parse($request->date)->format('Y-m-d')
            ]);
            foreach ($request->account_type as $index => $account_type) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'particular' => $account_type,
                    'ledger_head' => $request->particular[$index],
                    'amount' => $request->amount[$index],
                ]);
            }
            toast('Voucher created successfully!', 'success');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
