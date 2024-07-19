<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Package;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserRepository implements UserRepositoryInterface
{
    public function createUser($request)
    {
        $request['password'] = Hash::make($request['password']);
        $packages_details = Package::first();
        $request['purchased_credit'] = $packages_details->credits;
        // $otp = rand(111111, 999999);
        $otp = 111111;

        $request['package_id'] = $packages_details->_id;
        $request['user_type'] = 0;
        $request['is_active'] = 0;        
        $request['otp'] = $otp;
        $request['deleted_at'] = null; 
        $request['mobile_no'] = $request['phone_number'];

        $user = User::create($request);
        return $user;
    }

    public function createWebUser($request)
    {
        $request['password'] = Hash::make('123456');
        $packages_details = Package::first();
        $request['purchased_credit'] = $packages_details->credits;
        $request['package_id'] = $packages_details->_id;
        $request['user_type'] = 0;
        $request['is_active'] = "1";        
        $request['otp'] = null;
        $request['deleted_at'] = null; 
        $request['mobile_no'] = $request['phone_number'];

        $user = User::create($request);
        return $user;
    }

    public function findUserByEmail($email)
    {
        return User::where('email', $email)->where('user_type', 0)->whereNull('deleted_at')->first();
    }

    public function findUserById($id)
    {
        return User::with('package')->where('_id', $id)->where('user_type', 0)->whereNull('deleted_at')->first();
    }

    public function updateUser($id, $data)
    {
        $user = $this->findUserById($id);
        
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        return $user;
    }

    public function logout($userId)
    {
        return User::where('_id', $userId)->where('user_type', 0)->update(array('device_token' => null, 'access_token' => null));
    }

    public function getUserData()
    {
        return Auth::user();
    }

    public function delete($id)
    {
        return User::where('_id', $id)->where('user_type', 0)->update(array('deleted_at' => date('Y-m-d H:i:s'), 'is_active' => 0));
    }
}
