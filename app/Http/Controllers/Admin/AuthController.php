<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            // User is already logged in, redirect to dashboard
            return redirect('/dashboard');
        }

        return view('admin.auth.login');
    }

    public function forgot_password()
    {
        return view('admin.auth.forgotpassword');
    }
}
