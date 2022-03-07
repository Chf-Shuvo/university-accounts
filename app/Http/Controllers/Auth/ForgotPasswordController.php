<?php

namespace App\Http\Controllers\Auth;

use App\Helper\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OTP;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm(){
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request){
        $check = User::where('email',$request->email)->exists();
        if ($check) {
            $user = User::where('email',$request->email)->first();
            $otp = OTP::create([
                'otp' => random_int(100000, 999999)
            ]);
            $msg = "Your OTP for password changing is: ".$otp->otp;
            Helper::send_sms($user->phone,$otp);
            return view('auth.passwords.reset',compact('otp','user'));
        } else {
            toast('User not found, please check your email','error');
            return redirect()->back();
        }
        
    }
}
