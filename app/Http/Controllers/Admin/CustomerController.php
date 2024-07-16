<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Helpers\Helper;
use App\Models\Package;
use App\Services\CustomerServices;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function __construct(private CustomerServices $customerServices)
    {
    }

    public function index(Request $request)
    {
        // if ($request->filled('searchvalue') && $request->get('searchvalue') == "searchdata") {
        //     // $isSearch = $this->leadServices->search($request);
        //     // $data = ['customers' => $customers];
        // } else {
        //     $customers = $this->customerServices->getAllCustomers();
        //     $data = ['customers' => $customers];
        // }
        if ($request->ajax()) {
            $data = $this->customerServices->getAllCustomers();
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
        return $this->customerServices->create($request);
        // dd($request->all());
    }

    public function show($id)
    {
        $data = $this->customerServices->getCustomerById($id);
        return response()->json([
            'success' => true,
            'message' => "",
            'data' => $data,
        ]);
    }
}
