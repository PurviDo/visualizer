<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Category;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subCategory = Category::query()
                ->with('Category')
                ->where('is_deleted', false)
                ->where('parent_id', '!=', null)
                ->get();
            return DataTables::of($subCategory)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    $btn = '<button class="btn btn-sm btn-info btn-round tooltip-toggle edit-sub-category" data-id="' . $row->id . '" data-name="' . $row->name . '" data-category_id="' . $row->Category['id'] . '" data-category_name="' . $row->Category['name'] . '"  data-original-title="Edit"><i class="nav-icon fas fa-edit"></i></button>';
                    $btn .= ' <button class="btn btn-sm btn-danger btn-round tooltip-toggle delete-sub-category" data-original-title="Delete" data-action="' . route('sub-category.destroy', $row->id) . '"><i class="nav-icon fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $categories = Category::where('is_deleted', false)->where('parent_id', null)->get();
        return view('admin.subCategory.index', compact('categories'));
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
            'category_id' => ['required']
        ];

        if ($id != 0) {
            $message = "Sub Category has been updated successfully";
            $subCategory = Category::findOrFail($id);
        } else {
            $message = "Sub Category has been created successfully";
            $subCategory = new Category();
        }

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred',
                'data' => $error->errors()
            ]);
        }

        $subCategory->name = $request->name;
        $subCategory->parent_id = $request->category_id;
        $subCategory->is_deleted = false;

        $subCategory->save();
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [],
        ]);
    }


    public function destroy($id)
    {
        $subCategory = Category::findOrFail($id);

        if ($subCategory->is_deleted == 1) {
            $message = 'Sub Category has been deactivated successfully';
        } elseif ($subCategory->is_deleted == 0) {
            $message = 'Sub Category has been activated successfully';
        }

        $subCategory->is_deleted = !$subCategory->is_deleted;

        $subCategory->save();

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [],
        ]);
    }
}
