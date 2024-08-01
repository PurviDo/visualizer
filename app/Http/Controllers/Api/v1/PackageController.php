<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;


class PackageController extends Controller
{
    use ApiResponseTrait;

    public function getPackages() {
        $packages = Package::get();
        if ($packages) {
            return $this->sendResponse('Package data get successfully.', 1, array($packages), $this->successStatus);
        }
    }

}
