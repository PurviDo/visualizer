<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Templates;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subCategory = Templates::all();
            return DataTables::of($subCategory)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    $btn = '<button class="btn btn-sm btn-warning btn-round tooltip-toggle edit-sub-category" data-action="' . route('sub-category.show', $row->id) . '" data-original-title="Edit"><i class="nav-icon fas fa-edit"></i></button>';
                    $btn .= ' <button class="btn btn-sm btn-danger btn-round tooltip-toggle delete-sub-category" data-original-title="Delete" data-action="' . route('sub-category.destroy', $row->id) . '"><i class="nav-icon fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $categories = Category::where('is_deleted', false)->where('parent_id', null)->get();
        $users = User::where('user_type',0)->get();
        return view('admin.template.index', compact('categories','users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
