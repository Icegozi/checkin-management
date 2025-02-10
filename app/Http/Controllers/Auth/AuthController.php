<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); 

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if ($user->status === 0) {
                Auth::logout();
                return back()->withErrors(['email' => 'Tài khoản của bạn đã bị vô hiệu hóa.']);
            }

            if ($user->role) {
                return redirect()->route('chart.index');
            } else {
                if ($user->first_login) {
                    return redirect()->route('password.reset');
                }
                return redirect()->route('checkin');
            }
        }
        return back()->withErrors(['email' => 'Thông tin đăng nhập không chính xác.']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->first_login = false;
        $user->save();
        return redirect()->route('checkin');
    }


    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role) {
                return redirect()->route('dashboard');
            } else {
                if ($user->first_login) {
                    return redirect()->route('password.reset');
                }
                return redirect()->route('checkin');
            }
        }
        return view('auth.login');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showResetPasswordForm()
    {
        return view('auth.reset_password');
    }
}
