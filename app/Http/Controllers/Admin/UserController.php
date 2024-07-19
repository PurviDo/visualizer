<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\Helper;
use App\Models\Package;
use App\Services\UserServices;
use Yajra\DataTables\DataTables;
use App\Http\Requests\RegisterApiRequest;
use App\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    protected $userRepository = '';

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('user_type', 0)->whereNull('deleted_at')->orderBy('created_at', 'DESC')->get();
            
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

    public function store(RegisterApiRequest $request)
    {
        $users = $this->userRepository->createWebUser($request->validated());
        $message = "User Created successfully.";

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [],
        ]);
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

    public function destroy($id)
    {
        $users = $this->userRepository->delete($id);
        echo $message = "User Deleted successfully."; exit;

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [],
        ]);
    }
}
