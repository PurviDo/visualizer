<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $category = Category::query()
                ->with('subCategories')
                ->where('is_deleted', 0)
                ->where('parent_id', null)
                ->get();
            return DataTables::of($category)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    $btn = '<button class="btn btn-sm btn-warning btn-round tooltip-toggle edit-category" data-id="' . $row->id . '" data-name="' . $row->name . '"  data-original-title="Edit"><i class="nav-icon fas fa-edit"></i></button>';
                    $btn .= ' <button class="btn btn-sm btn-danger btn-round tooltip-toggle delete-category" data-original-title="Delete" data-action="' . route('category.destroy', $row->id) . '"><i class="nav-icon fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.category.index');
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
            $message = "Category has been updated successfully";
            $category = Category::findOrFail($id);
        } else {
            $message = "Category has been created successfully";
            $category = new Category();
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
        $category->is_deleted = false;

        $category->save();
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [],
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->is_deleted == 1) {
            $message = 'Category has been deactivated successfully';
        } elseif ($category->is_deleted == 0) {
            $message = 'Category has been activated successfully';
        }

        $category->is_deleted = !$category->is_deleted;

        $category->save();

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [],
        ]);
    }
}
