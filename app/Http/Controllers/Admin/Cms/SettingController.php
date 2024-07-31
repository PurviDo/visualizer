<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    public function index(Request $request, $module)
    {

        $setting = Setting::where('data',$module)->first();
        if($module == 'aboutUs') {
            return view('admin.cms.aboutus',compact('setting'));
        } elseif($module == 'privacyPolicy') {
            return view('admin.cms.privacypolicy',compact('setting'));
        } else {
            return view('admin.cms.termsconditions',compact('setting'));
        }
    }

    public function store(Request $request, $module)
    {
        $id = $request->id;

        $rules = [
            'content' => ['required']
        ];

        if ($id != 0) {
            $message = "Data has been updated successfully";
            $setting = Setting::findOrFail($id);
        } else {
            $message = "Data has been created successfully";
            $setting = new Setting();
        }

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred',
                'data' => $error->errors()
            ]);
        }

        $setting->content = $request->content;
        $setting->data = $module;
        $setting->save();

        return redirect('/'.$module)->with('message', $message);
    }
}
