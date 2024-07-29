<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CMSController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}
