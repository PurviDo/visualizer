<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Traits\ApiResponseTrait;

class AuthController extends Controller
{
    public function index(): View
    {
        return view('admin.auth.login');
    }

    public function registration(): View
    {
        return view('admin.auth.registration');
    }

    public function postLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['user_type'] = 1;
        $credentials['deleted_at'] = null;
        $credentials['is_active'] = "1";
        
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                ->withSuccess('You have Successfully loggedin');
        }

        return redirect("/")->with('message','Oppes! You have entered invalid credentials');
    }

    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }
}
