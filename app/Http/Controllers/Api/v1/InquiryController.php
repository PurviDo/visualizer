<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponseTrait;

class InquiryController extends Controller
{
    use ApiResponseTrait;

    public function addInquiry(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return response()->json(['error' => $error], 400);
            }
        }
        $inquiry = Inquiry::create($data);

        return $this->sendResponse('Inquiry successfully sent.',1, array($inquiry), $this->successStatus);

    }
}
