<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ForgotPasswordController extends Controller
{

    public function showForgetPasswordForm()
    {
        return view('admin.auth.forgetPassword');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        try {
            DB::connection('mongodb')->collection('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            Mail::send('admin.auth.emailForgetPassword', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            return back()->with(['message' => 'Great! Successfully sent to your email.']);
        } catch (\Exception $e) {
            return back()->with(['message' => 'Sorry! Please try again later.'])->withInput();
        }
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($token)
    {
        return view('admin.auth.recoverPassword', ['token' => $token]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::connection('mongodb')->collection('password_reset_tokens')
            ->where('token',$request->token)
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        } else {
            $user = User::where('email', $updatePassword['email'])
                ->update(['password' => \Hash::make($request->password)]);
        }

        DB::connection('mongodb')->collection('password_reset_tokens')->where('token',$request->token)->delete();

        return redirect('/')->with('message', 'Your password has been changed!');
    }
}
