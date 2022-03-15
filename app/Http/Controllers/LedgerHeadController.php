<?php

namespace App\Http\Controllers;

use App\Models\LedgerHead;
use Illuminate\Http\Request;

class LedgerHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $items = LedgerHead::where('company_id', auth()->user()->company)->orderBy('parent_id', 'asc')->get();
            // return $items;
            return view('backend.content.ledgerHeads.index', compact('items'));
        } catch (\Exception $e) {
            return $e->getMessage();
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
            return $request;
            LedgerHead::firstOrCreate(
                ['name' => $request->name],
                [
                    'head_code' => $request->head_code,
                    'parent_id' => $request->parent_id,
                    'company_id' => auth()->user()->company,
                    'name_of_group' => $request->name_of_group,
                    'visibility_order' => $request->visibility_order
                ]
            );
            toast()->success('Account Head Created');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LedgerHead  $ledgerHead
     * @return \Illuminate\Http\Response
     */
    public function edit(LedgerHead $ledgerHead)
    {
        try {
            $items = LedgerHead::all();
            return view('backend.content.ledgerHeads.edit', compact('ledgerHead', 'items'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LedgerHead  $ledgerHead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LedgerHead $ledgerHead)
    {
        try {
            $ledgerHead->update($request->except('_method', '_token'));
            toast()->success('Account Head Updated');
            return \redirect()->route('ledger-head.index');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LedgerHead  $ledgerHead
     * @return \Illuminate\Http\Response
     */
    public function destroy(LedgerHead $ledgerHead)
    {
        try {
            $ledgerHead->delete();
            toast()->success('Account Head Removed');
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    // single ledgers
    public function single_ledgers()
    {
        try {
            $items = LedgerHead::orderBy('parent_id', 'asc')->get();
            $items = $items->where('has_child', 0);
            return view('backend.content.ledgerHeads.index', compact('items'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    // group ledgers
    public function group_ledgers()
    {
        try {
            $items = LedgerHead::orderBy('parent_id', 'asc')->get();
            $items = $items->where('has_child', '!=', 0);
            // return $items;
            return view('backend.content.ledgerHeads.index', compact('items'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
