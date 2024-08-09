<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cms\ContactUs;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $contactUs = ContactUs::all();
            return DataTables::of($contactUs)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    $btn = '<button class="btn btn-sm btn-warning btn-round tooltip-toggle edit-contact-us" data-action="' . route('contact-us.show', $row->id) . '" data-original-title="Edit"><i class="nav-icon fas fa-edit"></i></button>';
                    //$btn .= ' <button class="btn btn-sm btn-danger btn-round tooltip-toggle delete-contact-us" data-original-title="Delete" data-action="' . route('contact-us.destroy', $row->id) . '"><i class="nav-icon fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.cms.contactUs.index');
    }

    public function show($id)
    {
        $contactUs = ContactUs::findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => "",
            'data' => $contactUs,
        ]);
    }

    public function store(Request $request)
    {
        $id = $request->id;

        $rules = [
            'title' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
        ];

        if ($id != 0) {
            $message = "Contact us details has been updated successfully";
            $contactUs = ContactUs::findOrFail($id);
        } else {
            $message = "Contact Us details has been created successfully";
            $contactUs = new ContactUs();
        }

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred',
                'data' => $error->errors()
            ]);
        }

        $contactUs->title = $request->title;
        $contactUs->email = $request->email;
        $contactUs->phone = $request->phone;
        $contactUs->address = $request->address;
        $contactUs->map_url = $request->map_url;
        $contactUs->save();

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [],
        ]);
    }

    public function destroy($id)
    {        
        $contactUs = ContactUs::findOrFail($id);
        $contactUs->delete();
        $message = 'Contact Us deatils has been deleted successfully';
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [],
        ]);
    }
}
