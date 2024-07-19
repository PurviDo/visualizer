<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\Helper;
use App\Models\Package;
use App\Services\UserServices;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function __construct(private UserServices $userServices)
    {
    }

    public function index(Request $request)
    {
        // if ($request->filled('searchvalue') && $request->get('searchvalue') == "searchdata") {
        //     // $isSearch = $this->leadServices->search($request);
        //     // $data = ['customers' => $customers];
        // } else {
        //     $customers = $this->userServices->getAllUsers();
        //     $data = ['customers' => $customers];
        // }
        if ($request->ajax()) {
            $data = $this->userServices->getAllUsers();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user_name', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->editColumn('action', function ($row) {
                    $showUrl = route('customers.show', $row->id);
                    $deleteUrl = route('customers.destroy', $row->id);
                    $btn = '<button class="btn btn-sm btn-warning btn-round tooltip-toggle edit-customer" data-action="' . $showUrl . '" data-original-title="Edit"><i class="nav-icon fas fa-edit"></i></button>';
                    $btn .= ' <button class="btn btn-sm btn-info btn-round tooltip-toggle show-customer" data-action="' . $showUrl . '" data-original-title="Edit"><i class="nav-icon fas fa-eye"></i></button>';
                    $btn .= ' <button class="btn btn-sm btn-danger btn-round tooltip-toggle delete-customer" data-original-title="Delete" data-action="' . $deleteUrl . '"><i class="nav-icon fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $package = Package::query()->where('status', 'Active')->get();
        return view('admin.customers.index', compact('package'));
    }

    public function store(Request $request)
    {
        return $this->userServices->create($request);
        // dd($request->all());
    }

    public function show($id)
    {
        $data = $this->userServices->getUserById($id);
        return response()->json([
            'success' => true,
            'message' => "",
            'data' => $data,
        ]);
    }
}
