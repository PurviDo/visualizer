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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $category = Setting::all();
            return DataTables::of($category)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    $btn = '<button class="btn btn-sm btn-warning btn-round tooltip-toggle edit-setting" data-id="' . $row->id . '" data-name="' . $row->name . '"  data-original-title="Edit"><i class="nav-icon fas fa-edit"></i></button>';
                    $btn .= ' <button class="btn btn-sm btn-danger btn-round tooltip-toggle delete-setting" data-original-title="Delete" data-action="' . route('setting.destroy', $row->id) . '"><i class="nav-icon fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.cms.setting.index');
    }

    public function store(Request $request)
    {
        $id = $request->id;

        $rules = [
            'name' => [
                'required',
                'max:255',
                Rule::unique('categories')->ignore($id, '_id'),
            ],
        ];

        if ($id != 0) {
            $message = "Setting has been updated successfully";
            $category = Setting::findOrFail($id);
        } else {
            $message = "Setting has been created successfully";
            $category = new Setting();
        }

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred',
                'data' => $error->errors()
            ]);
        }

        $category->name = $request->name;

        $category->save();
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [],
        ]);
    }

    public function destroy(Setting $setting)
    {        
        $setting->delete();
        $message = 'Setting has been deactivated successfully';
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [],
        ]);
    }
}
