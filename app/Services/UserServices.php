<?php

namespace App\Services;

use App\Models\User;
use App\Models\Package;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserServices
{
    use ValidatesRequests;

    public function create(Request $request)
    {
        $id = $request->id;
        $rules = [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id, '_id'),
            ],
            'mobile_no' => 'string|min:9|max:10|nullable|regex:/[0-9]{9}/',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred',
                'data' => $validator->errors()
            ]);
            // return redirect(route('leads'))->with('error-create', 'Error creating Leads')->withErrors($validator)->withInput();
        }
        $package_id = Package::first(); exit;

        $customer = new User();
        $customer->name = $request->name;
        $customer->lname = $request->lname;
        $customer->email = $request->email;
        $customer->mobile_no = $request->phone;
        $customer->purchased_credit = 10;
        $customer->package_id = Package::first();
        return $customer->save();
    }

    public function edit(Request $request, Customer $customer): bool|RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'lname' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'string|min:9|max:10|nullable|regex:/[0-9]{9}/',
            'passport' => 'required|max:9|min:7',
            'status_id' => 'required',
            'city_id' => 'required',
            'source_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('leads'))->with('error-edit-lead', 'Error updating Lead')->with('leadId', $customer->id)->withErrors($validator)->withInput();
        }

        $customer->name = $request->name;
        $customer->lname = $request->lname;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->passport = $request->passport;
        $customer->status_id = !empty($request->status_id) ? $request->status_id : '';
        $customer->city_id = !empty($request->city_id) ? $request->city_id : '';
        $customer->source_id = !empty($request->source_id) ? $request->source_id : '';
        $customer->user_id = !empty($request->user_id) ? $request->user_id : '';
        $customer->address = $request->address;
        $customer->notes = $request->notes;
        $customer->date_contact = isset($request->date_contact) ? date('Y-m-d H:i:s', strtotime($request->date_contact)) : date('Y-m-d H:i:s');

        return $customer->save();
    }

    public function search(Request $request)
    {
        $customers = Customer::with(['statuses', 'sources', 'cities', 'users'])->orderBy('id', 'DESC');
        if ($request->filled('search')) {
            $searchQuery = $request->get('search');
            $customers = $customers->where(function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('lname', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('passport', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('phone', 'LIKE', '%' . $searchQuery . '%');
            });
        }

        if ($request->filled('status_id')) {
            $customers = $customers->where('status_id', '=', $request->get('status_id'));
        }

        $customers =  $customers->paginate(20)->withQueryString();

        return $customers;
    }

    public function getAllUsers()
    {
        return User::where('user_type', 0)->get();
    }

    public function getUserById($id)
    {
        return User::with('package')->where('user_type', 0)->findOrFail($id);
    }
}
