<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\User;
use App\Models\UserPackages;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PackageController extends Controller
{
    use ApiResponseTrait;

    public function getPackages()
    {
        $packages = Package::get();
        if ($packages) {
            return $this->sendResponse('Package data get successfully.', 1, array($packages), $this->successStatus);
        }
    }

    public function purchasePackage(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'package_id' => 'required|exists:packages,_id',
            'start_date' => 'required|date_format:Y-m-d',
            'credit' => 'nullable',
            'actual_price' => 'nullable',
            'discounted_price' => 'nullable',
            'total_paid_amount' => 'nullable'
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return response()->json(['error' => $error], 400);
            }
        }
        $package = Package::findOrfail($request->package_id);
        $startDate = Carbon::parse($request->start_date);
        $endDate = $startDate->copy()->addMonths($package->duration);
        $data['user_id'] = Auth::id();
        $data['end_date'] = $endDate->format('Y-m-d');
        $userPackage = UserPackages::create($data);

        //user table update
        $user = User::findOrfail(Auth::id());
        $user->purchased_credit += $package->credits;
        $user->package_id = $package->id;
        $user->update();
        return $this->sendResponse('User Package added successfully.', 1, array($userPackage), $this->successStatus);
    }

    public function getUserPackage()
    {
        $userPackage = UserPackages::with('package')->where('user_id', Auth::id())->get();
        return $this->sendResponse('User Package details get successfully.', 1, array($userPackage), $this->successStatus);
    }
}
