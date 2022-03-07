<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
}
