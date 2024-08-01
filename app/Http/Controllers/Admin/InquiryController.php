<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $inquiries = Inquiry::all();
            return DataTables::of($inquiries)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    // $btn = '<button class="btn btn-sm btn-warning btn-round tooltip-toggle view-details" data-id="' . $row->id . '" data-name="' . $row->name . '"  data-original-title="Edit"><i class="nav-icon fas fa-edit"></i></button>';
                    $btn = '<button class="btn btn-sm btn-warning btn-round tooltip-toggle view-details" data-id="' .$row->id . '" data-original-title="show"><i class="nav-icon fas fa-eye"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.inquiry.index');
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
        $inquiry = Inquiry::findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => "",
            'data' => $inquiry,
        ]);
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
