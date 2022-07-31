<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            return view("backend.content.dashboard");
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function change_period(Request $request)
    {
        try {
            session()->put([
                "start_date" => Carbon::parse($request->from)->format('Y-m-d'),
                "end_date" => Carbon::parse($request->to)->format('Y-m-d'),
            ]);
            return redirect()->back();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
            Session::flush();
            toast("User logged out!", "success");
            return redirect()->route("login");
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
