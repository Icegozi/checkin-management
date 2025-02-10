<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function showResetForm($token, Request $request)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->query('email')]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'token' => 'required'
        ]);

        // Kiểm tra token trong bảng users
        $user = DB::table('users')->where('email', $request->email)->first();
        if (!$user || $user->reset_token !== $request->token) {
            return back()->withErrors(['token' => 'Token không hợp lệ.']);
        }

        // Cập nhật mật khẩu và xóa token
        DB::table('users')
            ->where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password),
                'reset_token' => null 
            ]);

        return redirect()->route('login')->with('status', 'Mật khẩu đã được đặt lại.');
    }
}
