<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Trang chủ trang admin
    public function index() {
        return view('admin.index', [
            'title' => 'NOS Fruits Admin - Trang chủ'
        ]);
    }

    // Render trang login admin page
    public function login() {
        return view('admin.login');
    }

    // Xử lí bấm đăng nhập vào admin page
    public function store(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        
        $email = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password, 'level' => 3])) {
            return redirect('/admin');
        }
        $request->session()->flash('wrong', 'Tài khoản hoặc mật khẩu không chính xác!');
        return redirect()->route('admin_login');
    }

    // Xử lí logout
    public function logout() {
        Auth::logout();
        return redirect()->route('admin_login');
    }
}
