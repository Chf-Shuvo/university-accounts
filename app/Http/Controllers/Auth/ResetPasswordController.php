<?php

namespace App\Http\Controllers\Auth;

use App\Models\OTP;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function reset(Request $request){
        $otp = OTP::find($request->otpID);
        $otp = $otp->otp;
        if($otp == $request->otp){
            User::find($request->userID)->update([
                'password' => Hash::make($request->password)
            ]);
            toast('Password updated successfully','success');
            return redirect()->route('login');
        }else{
            toast('Invalid OTP','error');
            return redirect()->route('login');
        }
    }
}
