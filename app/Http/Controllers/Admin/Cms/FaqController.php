<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\Faq;
use App\Models\Cms\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subCategory = Faq::query()
                ->with('Category')
                ->get();
            return DataTables::of($subCategory)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    $btn = '<button class="btn btn-sm btn-warning btn-round tooltip-toggle edit-faq" data-action="' . route('faq.show', $row->id) . '" data-original-title="Edit"><i class="nav-icon fas fa-edit"></i></button>';
                    $btn .= ' <button class="btn btn-sm btn-danger btn-round tooltip-toggle delete-faq" data-original-title="Delete" data-action="' . route('faq.destroy', $row->id) . '"><i class="nav-icon fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $categories = FaqCategory::all();
        return view('admin.cms.faq.index', compact('categories'));
    }

    public function show($id)
    {
        $faq = Faq::query()
            ->with('Category')
            ->findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => "",
            'data' => $faq,
        ]);
    }

    public function store(Request $request)
    {
        $id = $request->id;

        $rules = [
            'name' => [
                'required',
                'max:255',
            ],
            'description' => ['required'],
            'category_id' => ['required'],
        ];

        if ($id != 0) {
            $message = "FAQ has been updated successfully";
            $faq = Faq::findOrFail($id);
        } else {
            $message = "FAQ has been created successfully";
            $faq = new Faq();
        }

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred',
                'data' => $error->errors()
            ]);
        }

        $faq->name = $request->name;
        $faq->category_id = $request->category_id;
        $faq->description = $request->description;
        $faq->save();

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [],
        ]);
    }

    public function destroy(Faq $faq)
    {        
        $faq->delete();
        $message = 'Faq Category has been deactivated successfully';
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [],
        ]);
    }
}
