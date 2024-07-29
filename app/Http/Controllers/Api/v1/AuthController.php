<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

use App\Http\Requests\ForgotPasswordApiRequest;
use App\Http\Requests\LoginApiRequest;
use App\Http\Requests\RegisterApiRequest;
use App\Http\Requests\ResetPasswordApiRequest;
use App\Http\Requests\VerifyOtpApiRequest;
use App\Http\Requests\ResentOtpApiRequest;

use App\Traits\ApiResponseTrait;

use App\Interfaces\UserRepositoryInterface;

use App\Mail\VerifyEmail;
use App\Models\User;

use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Http\Requests\ChangePasswordApiRequest;
use App\Http\Requests\ProfileUpdateApiRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use ApiResponseTrait;
    use HasApiTokens;

    protected $userRepository = '';

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->successStatus = 200;
        $this->failedStatus = 401;
        $this->notFoundStatus = 404;
    }

    public function signUp(RegisterApiRequest $request)
    {
        $data = $this->userRepository->createUser($request->validated());
        if ($data) {
            return $this->sendResponse('User Created successfully.', 1, array($data), $this->successStatus);
        }
        return $this->sendResponse('Something went wrong.', 0, null, $this->failedStatus);
    }

    public function SignIn(LoginApiRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['user_type'] = 0;
        $credentials['deleted_at'] = null;
        $credentials['is_active'] = "1";

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // $user['access_token'] = Helper::createToken();
            $user['access_token'] = $user->createToken(time())->plainTextToken;
            $this->userRepository->updateUser($user->id, ["access_token" => $user['access_token']]);

            return $this->sendResponse('User Logged In successfully.', 1, $user, $this->successStatus);
        } elseif (Auth::attempt(array('email' => $request->email, 'password' => $request->password, 'status' => '0'))) {
            return $this->sendResponse('Your Account is not Verified By Admin.', 0, null, $this->failedStatus);
        } else {
            return $this->sendResponse('Invalid email or password.', 0, null, 401);
        }
    }

    public function forgotPassword(ForgotPasswordApiRequest $request)
    {
        $result = $this->userRepository->findUserByEmail($request->email);
        if ($result) {
            $token = Str::random(64);

            try {
                DB::connection('mongodb')->collection('password_reset_tokens')->where('email',$request->email)->delete();
                DB::connection('mongodb')->collection('password_reset_tokens')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);

                Mail::send('admin.email-template.forgot-password', ['token' => $token], function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('Reset Password');
                });

                return $this->sendResponse('Reset password email sent. Please check you email.', 1, array(["id" => $result->id, "email" => $request->email]), $this->successStatus);
            } catch (\Exception $e) {
                return $this->sendResponse('Mail not sent.', 0, null, $this->failedStatus);
            }
        }
        return $this->sendResponse('Email not exist.', 0, null, $this->failedStatus);
    }

    public function resendOtp(ResentOtpApiRequest $request)
    {
        $result = $this->userRepository->findUserById($request->user_id);
        if ($result) {
            // $otp = rand(111111, 999999);
            $otp = 111111;
            $this->userRepository->updateUser($result->id, ['otp' => $otp, 'is_active' => '1', 'updated_at' => now()]);

            return $this->sendResponse('Verification code resent successfully.', 1, array(["id" => $result->id, "email" => $request->email]), $this->successStatus);
        }
        return $this->sendResponse('Email not exist.', 0, null, $this->notFoundStatus);
    }

    public function verifyOtp(VerifyOtpApiRequest $request)
    {
        $result = $this->userRepository->findUserById($request->user_id);

        if ($result) {
            //use 111111 code for verify otp
            if ($request->otp == $result->otp) {
                if ($request->otp == $result->otp) {

                    $this->userRepository->updateUser($request->user_id, ["otp" => null, 'is_active' => '1']);
                }
                return $this->sendResponse('Otp verified successfully.', 1, array(["id" => $result->id]), $this->successStatus);
            } else {
                return $this->sendResponse('Invalid Otp.', 0, null, $this->failedStatus);
            }
        } else {
            return $this->sendResponse('User not found.', 0, null, $this->notFoundStatus);
        }
    }

    public function resetPassword(ResetPasswordApiRequest $request)
    {
        $updatePassword = DB::connection('mongodb')->collection('password_reset_tokens')
            ->where('token', $request->token)
            ->first();

        if (!$updatePassword) {
            return $this->sendResponse('Invalid token!', 0, null, $this->failedStatus);
        } else {
            $user = User::where('email', $updatePassword['email'])->where('user_type', 0)->first();
            $updateAppUser = $this->userRepository->updateUser($user->_id, ["password" => $request->new_password]);

            if ($updateAppUser) {
                DB::connection('mongodb')->collection('password_reset_tokens')->where('token', $request->token)->delete();
                return $this->sendResponse('Password reset successfully.', 1, null, $this->successStatus);
            }
            return $this->sendResponse('Something went wrong.', 0, null, $this->failedStatus);
        }
    }

    /*public function resetPassword(ResetPasswordApiRequest $request)
    {
        $result = $this->userRepository->findUserById($request->user_id);
        if ($result) {
            $updateAppUser = $this->userRepository->updateUser($request->user_id, ["password" => $request->new_password]);
            if ($updateAppUser) {
                return $this->sendResponse('Password reset successfully.', 1, null, $this->successStatus);
            }
            return $this->sendResponse('Something went wrong.', 0, null, $this->failedStatus);
        } else {
            return $this->sendResponse('User not found.', 0, null, $this->failedStatus);
        }
    }*/

    public function logOut()
    {
        $user = Auth::user();
        // $this->userRepository->updateUser($user->id, ["access_token" => null]);
        $user->currentAccessToken()->delete();
        return $this->sendResponse('User Log Out successfully.', 1, null, $this->successStatus);
    }

    public function changePassword(ChangePasswordApiRequest $request)
    {
        $user = User::find(Auth::id());
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'errors' => ['current_password' => 'Current password is incorrect.']
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return $this->sendResponse('Password changed successfully.', 1, null, $this->successStatus);
    }

    public function profileUpdate(ProfileUpdateApiRequest $request)
    {
        $user = User::find(Auth::id());
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['email'] = $request->email;
        $data['mobile_no'] = $request->phone_number;
        $user->update($data);

        return $this->sendResponse('Profile updated successfully.', 1, $user, $this->successStatus);
    }

    public function userProfile(Request $request)
    {
        $data = $this->userRepository->getUserData($request);
        return $this->sendResponse('My Profile details', 1, $data, $this->successStatus);
    }
}
