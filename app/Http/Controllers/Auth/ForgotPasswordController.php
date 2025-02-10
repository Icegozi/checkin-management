<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = DB::table('users')->where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống.']);
        }

        $token = Str::random(60);
        DB::table('users')
            ->where('email', $request->email)
            ->update(['reset_token' => $token]);
    
        // $link = url("/password/reset/{$token}?email={$request->email}");
        // Gửi email thủ công (không sử dụng Password::sendResetLink)
        Mail::to($request->email)->send(new \App\Mail\ResetPasswordMail($token, $request->email));
        return back()->with(['status' => 'Vui lòng kiểm tra email của bạn.']);
    }
}
