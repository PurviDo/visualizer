<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Cms\ContactUs;
use App\Models\Cms\FaqCategory;
use App\Models\Cms\Setting;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;


class CmsController extends Controller
{
    use ApiResponseTrait;

    public function getFaq() {
        $faq = FaqCategory::with('faq')->get();
        if ($faq) {
            return $this->sendResponse('FAQ data get successfully.', 1, array($faq), $this->successStatus);
        }
    }

    public function getContactUs() {
        $contactUs = ContactUs::with('faq')->get();
        if ($contactUs) {
            return $this->sendResponse('Contact us data get successfully.', 1, array($contactUs), $this->successStatus);
        }
    }

    public function getDetails($module) {
        $settings = Setting::where('data','$module')->get();
        if ($settings) {
            return $this->sendResponse('Data get successfully.', 1, array($settings), $this->successStatus);
        }
    }
}
