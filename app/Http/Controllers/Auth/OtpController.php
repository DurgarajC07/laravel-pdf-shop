<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class OtpController extends Controller
{
    public function show()
    {
        // Generate and send OTP
        $code = rand(100000, 999999);
        
        // Delete any existing OTP codes for this user
        auth()->user()->otpCodes()->delete();
        
        // Create new OTP code
        $otpCode = OtpCode::create([
            'user_id' => auth()->id(),
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);
        
        // Send OTP email
        Mail::to(auth()->user()->email)->send(new OtpMail($code));
        
        return view('auth.otp');
    }
    
    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);
        
        $otpCode = OtpCode::where('user_id', auth()->id())
            ->where('code', $request->code)
            ->where('expires_at', '>=', now())
            ->first();
        
        if (!$otpCode) {
            return back()->withErrors(['code' => 'Invalid or expired code']);
        }
        
        // Mark session as OTP verified
        Session::put('otp_verified', true);
        
        // Delete used OTP code
        $otpCode->delete();
        
        // Redirect to intended URL or dashboard
        // if (Session::has('intended_url')) {
        //     $url = Session::pull('intended_url');
        //     return redirect($url);
        // }
        
        return redirect()->route('dashboard');
    }

    public function resend()
    {
        // Delete any existing OTP codes for this user
        auth()->user()->otpCodes()->delete();
        
        // Generate new OTP
        $code = rand(100000, 999999);
        
        // Create new OTP code
        $otpCode = OtpCode::create([
            'user_id' => auth()->id(),
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);
        
        // Send OTP email
        Mail::to(auth()->user()->email)->send(new OtpMail($code));
        
        return back()->with('status', 'A new verification code has been sent to your email.');
    }
}