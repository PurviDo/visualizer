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
use App\Models\UserPackages;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
                    $btn .= ' <button class="btn btn-sm btn-info btn-round tooltip-toggle show-customer" data-action="' . $showUrl . '" data-original-title="View"><i class="nav-icon fas fa-eye"></i></button>';
                    $btn .= ' <button class="btn btn-sm btn-danger btn-round tooltip-toggle delete-customer" data-original-title="Delete" data-action="' . $deleteUrl . '"><i class="nav-icon fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $packages = Package::query()->where('status', 'Active')->get();
        return view('admin.customers.index', compact('packages'));
    }

    public function store(RegisterApiRequest $request)
    {
        $users = $this->userRepository->createWebUser($request->validated());
        $message = "User Created successfully.";

        $package = Package::findOrfail($request->package_id);
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addMonths($package->duration);
        $data['package_id'] = $package->id;
        $data['user_id'] = $users->id;
        $data['start_date'] = Carbon::now()->format('Y-m-d');
        $data['end_date'] = $endDate->format('Y-m-d');
        UserPackages::create($data);

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [],
        ]);
    }

    public function update(Request $request, string $id)
    {
        $rules = [
            'first_name' => [
                'required',
                'max:100',
            ],
            'last_name' => [
                'required',
                'max:100',
            ],
            'phone_number' => [
                'required',
                'min:9',
                'max:10',
                'nullable',
                'regex:/[0-9]{9}/',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id, '_id'),
            ],
        ];

        $update_arr = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile_no' => $request->phone_number,
            'email' => $request->email,
        );

        $users = $this->userRepository->updateUser($id, $update_arr);
        $message = "User updated successfully.";

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [],
        ]);
    }

    public function show($id)
    {
        $data = $this->userRepository->findUserById($id);
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
