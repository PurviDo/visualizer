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

        $user = User::create($request);
        return $user;
    }

    public function findUserByEmail($email)
    {
        return User::where('email', $email)->where('user_type', 0)->first();
    }

    public function findUserById($id)
    {
        return User::where('_id', $id)->where('user_type', 0)->first();
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
        return User::where('_id', $userId)->where('user_type', 0)->update(array('device_token' => null, 'access_token' => null, 'updated_at' => now()));
    }

    public function getUserData()
    {
        return Auth::user();
    }

    public function delete($id)
    {
        User::destroy($id);
    }
}
