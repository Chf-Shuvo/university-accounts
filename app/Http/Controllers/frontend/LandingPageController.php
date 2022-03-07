<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function landingPage(){
        try {
            return redirect()->route('login');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
    }
}
