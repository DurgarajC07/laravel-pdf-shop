<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class VerifyOtp
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if the user has verified OTP for this session
        if (!Session::has('otp_verified')) {
            // Store intended URL to redirect back after OTP verification
            Session::put('intended_url', $request->fullUrl());
            return redirect()->route('otp.show');
        }

        return $next($request);
    }
}