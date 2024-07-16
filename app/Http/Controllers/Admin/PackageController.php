<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Package::query()
                ->where('status', 'Active')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->editColumn('action', function ($row) {
                    $showUrl = route('packages.show', $row->id);
                    $deleteUrl = route('packages.destroy', $row->id);
                    $btn = '<button class="btn btn-sm btn-warning btn-round tooltip-toggle edit-package" data-action="' . $showUrl . '" data-original-title="Edit"><i class="nav-icon fas fa-edit"></i></button>';
                    $btn .= ' <button class="btn btn-sm btn-info btn-round tooltip-toggle show-package" data-action="' . $showUrl . '" data-original-title="Edit"><i class="nav-icon fas fa-eye"></i></button>';
                    $btn .= ' <button class="btn btn-sm btn-danger btn-round tooltip-toggle delete-package" data-original-title="Delete" data-action="' . $deleteUrl . '"><i class="nav-icon fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.package.index');
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $rules = [
            'name' => [
                'required',
                'max:255',
                Rule::unique('packages')->ignore($id, '_id'),
            ],
            'duration' => 'required|integer|min:1',
            'description' => 'required|string',
            'credits' => 'required|integer|min:0',
            'actual_price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0|lt:actual_price',
            'status' => 'required|in:Active,Inactive',
        ];

        if ($id != 0) {
            $message = "Package has been updated successfully";
            $package = Package::findOrFail($id);
        } else {
            $message = "Package has been created successfully";
            $package = new Package();
        }

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred',
                'data' => $error->errors()
            ]);
        }

        $package->name = $request->name;
        $package->duration = $request->duration;
        $package->description = $request->description;
        $package->credits = $request->credits;
        $package->actual_price = $request->actual_price;
        $package->discounted_price = $request->discounted_price;
        $package->status = $request->status;
        $package->save();

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [],
        ]);
    }

    public function show($id)
    {
        $subCategory = Package::query()
            ->findOrFail($id);

        $subCategory->no_of_users = 0;
        return response()->json([
            'success' => true,
            'message' => "",
            'data' => $subCategory,
        ]);
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);

        if ($package->status == 'Active') {
            $package->status = 'Inactive';
            $message = 'Category has been deactivated successfully';
        } elseif ($package->status == 'Inactive') {
            $package->status = 'Active';
            $message = 'Category has been activated successfully';
        }

        $package->save();

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [],
        ]);
    }
}
