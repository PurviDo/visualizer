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

use App\Models\EmailTemplate;

use Illuminate\Http\Request;
use App\Helpers\Helper;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use ApiResponseTrait;
    use HasApiTokens;

    protected $userRepository = '';

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function signUp(RegisterApiRequest $request)
    {
        $data = $this->userRepository->createUser($request->validated());
        if ($data) {
            return $this->sendResponse(trans('validation.create_success'), 1, array($data), $this->successStatus);
        }
        return $this->sendResponse(trans('validation.unknown_error'), 0, null, $this->failedStatus);
    }

    public function SignIn(LoginApiRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['user_type'] = 0;
        $credentials['is_active'] = "1";
        
        if (Auth::attempt($credentials)) {

            $user = Auth::user();            
            $user['access_token'] = Helper::createToken();
            $this->userRepository->updateUser($user->id, ["access_token" => $user['access_token']]);

            return $this->sendResponse(trans(
                'messages.custom.login_messages',
                ["attribute" => "User"]
            ), 1, $user, $this->successStatus);
        } elseif (Auth::attempt(array('email' => $request->email, 'password' => $request->password, 'status' => '0'))) {
            return $this->sendResponse(trans('messages.custom.account_verify'), 0, null, $this->failedStatus);
        } else {
            return $this->sendResponse(trans('messages.custom.invalid_credential'), 0, null, $this->failedStatus);
        }
    }

    public function forgotPassword(ForgotPasswordApiRequest $request)
    {
        $result = $this->userRepository->findUserByEmail($request->email);
        if ($result) {
            // $otp = rand(1111, 9999);
            $otp = 1111;
            $this->userRepository->updateUser($result->id, ['otp' => $otp, 'updated_at' => now()]);

            $emailTemplate = EmailTemplate::getOtpTemplate();
            $subject = $emailTemplate->subject;
            $html = $emailTemplate->html;
            $html = str_replace('{{OTP}}', $otp, $html);
            $html = str_replace('{{USERNAME}}', $result->name, $html);

            Mail::to($result->email)->send(new VerifyEmail($subject, $html));

            return $this->sendResponse(trans('messages.custom.verify_code'), 1, array(["id" => $result->id, "email" => $request->email]), $this->successStatus);
        }
        return $this->sendResponse(trans('validation.email_not_exist_error'), 0, null, $this->failedStatus);
    }

    public function resendOtp(ResentOtpApiRequest $request)
    {
        $result = $this->userRepository->findUserById($request->user_id);
        if ($result) {
            // $otp = rand(111111, 999999);
            $otp = 111111;
            $this->userRepository->updateUser($result->id, ['otp' => $otp, 'is_active' => '1', 'updated_at' => now()]);

            // $emailTemplate = EmailTemplate::getOtpTemplate();
            // $subject = $emailTemplate->subject;
            // $html = $emailTemplate->html;
            // $html = str_replace('{{OTP}}', $otp, $html);
            // $html = str_replace('{{USERNAME}}', $result->name, $html);

            // Mail::to($result->email)->send(new VerifyEmail($subject, $html));
            return $this->sendResponse(trans('messages.custom.resent_code'), 1, array(["id" => $result->id, "email" => $request->email]), $this->successStatus);
        }
        return $this->sendResponse(trans('validation.email_not_exist_error'), 0, null, $this->failedStatus);
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
                return $this->sendResponse(trans('messages.custom.otp_code'), 1, array(["id" => $result->id]), $this->successStatus);
            } else {
                return $this->sendResponse(trans('messages.custom.invalid_otp'), 0, null, $this->failedStatus);
            }
        } else {
            return $this->sendResponse(trans('validation.id_not_found_error'), 0, null, $this->failedStatus);
        }
    }

    public function resetPassword(ResetPasswordApiRequest $request)
    {
        $result = $this->userRepository->findUserById($request->user_id);
        if ($result) {
            $updateAppUser = $this->userRepository->updateUser($request->user_id, ["password" => $request->new_password]);
            if ($updateAppUser) {
                return $this->sendResponse(trans(
                    'messages.custom.reset_messages',
                    ["attribute" => "Password"]
                ), 1, null, $this->successStatus);
            }
            return $this->sendResponse(trans('validation.unknown_error'), 0, null, $this->failedStatus);
        } else {
            return $this->sendResponse(trans('validation.id_not_found_error'), 0, null, $this->failedStatus);
        }
    }

    public function logOut()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        $update = $this->userRepository->logout($user->id);
        if ($update) {
            return $this->sendResponse(trans(
                'messages.custom.logout_messages',
                ["attribute" => "User"]
            ), 1, null, $this->successStatus);
        } else {
            return $this->sendResponse(trans('validation.unknown_error'), 0, null, $this->failedStatus);
        }
    }

    public function getUser(Request $request)
    {
        $data = $this->userRepository->getUserData($request);
        return $this->sendResponse(trans('messages.custom.get_data'), 1, $data, $this->successStatus);
    }
}
