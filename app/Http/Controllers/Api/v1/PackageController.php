<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\UserPackages;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    use ApiResponseTrait;

    public function getPackages() {
        $packages = Package::get();
        if ($packages) {
            return $this->sendResponse('Package data get successfully.', 1, array($packages), $this->successStatus);
        }
    }

    public function purchasePackage(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'user_id' => 'required|exists:users,_id',
            'package_id' => 'required|exists:packages,_id',
            'purchase_date' => 'required|date_format:Y-m-d',
            'credit' => 'nullable'
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return response()->json(['error' => $error], 400);
            }
        }
        $package = UserPackages::create($data);

        return $this->sendResponse('Package added successfully.',1, array($package), $this->successStatus);

    }

    public function getUserPackage() {
        $userPackage = UserPackages::where('user_id',Auth::id())->get();
        return $this->sendResponse('User Package details get successfully.',1, array($userPackage), $this->successStatus);
    }
}
