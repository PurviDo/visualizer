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
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

        return redirect("/login")->with('message','Oppes! You have entered invalid credentials');
    }

    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();

        return Redirect('/login');
    }
    
    public function showProfile() : View
    {
        return view('admin.auth.showProfile');
    }

    public function showChangePassword() : View
    {
        return view('admin.auth.changePassword');
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'mobile_no'  => 'required|string|min:9|max:10|nullable|regex:/[0-9]{9}/',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore(Auth::id(),'_id')
            ],
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $user = User::find(Auth::id());
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['email'] = $request->email;
        $data['mobile_no'] = $request->mobile_no;
        $user->update($data);            

        return response()->json(['success' => 'Profile updated successfully.']);
    }

    public function changePassword(Request $request)
    {
        $validator = [
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => 'required|min:5',
        ];
        $validator = Validator::make($request->all(), $validator);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }
        User::find(Auth::id())->update([
            'password' => Hash::make($request->password)
        ]);
    
        return response()->json(['success' => 'Password changed successfully.']);
    }
}
