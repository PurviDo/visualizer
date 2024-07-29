<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CMSController extends Controller
{
    public function aboutUs()
    {
        return view('admin.cms.aboutus');
    }

    public function contactUs()
    {
        return view('admin.cms.aboutus');
    }

    public function termsConditions()
    {
        return view('admin.cms.termsconditions');
    }

    public function privacyPolicy()
    {
        return view('admin.cms.privacypolicy');
    }

    public function faqSection()
    {
        return view('admin.cms.aboutus');
    }
    
    public function faqsDetails()
    {
        return view('admin.cms.aboutus');
    }
}
