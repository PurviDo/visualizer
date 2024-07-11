<?php

namespace App\Services;
use App\Models\Customers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CustomerServices
{
    use ValidatesRequests;

    public function create(Request $request): bool|RedirectResponse
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

        if ($validator->fails())
        {
            return redirect(route('leads'))->with('error-create', 'Error creating Leads')->withErrors($validator)->withInput();
        }
        // echo "<pre>"; print_r($request->all()); exit;

        $lead = new Lead();
        $lead->name = $request->name;
        $lead->lname = $request->lname;
        $lead->email = $request->email;
        $lead->phone = $request->phone;
        $lead->passport = $request->passport;
        $lead->status_id = !empty($request->status_id) ? $request->status_id : '';
        $lead->city_id = !empty($request->city_id) ? $request->city_id : '';
        $lead->source_id = !empty($request->source_id) ? $request->source_id : '';
        $lead->user_id = !empty($request->user_id) ? $request->user_id : '';
        $lead->address = $request->address;
        $lead->notes = $request->notes;
        $lead->date_contact = isset($request->date_contact) ? date('Y-m-d H:i:s', strtotime($request->date_contact)) : date('Y-m-d H:i:s');
               
        return $lead->save();
    }

    public function edit(Request $request, Lead $lead): bool|RedirectResponse
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

        if ($validator->fails())
        {
            return redirect(route('leads'))->with('error-edit-lead', 'Error updating Lead')->with('leadId', $lead->id)->withErrors($validator)->withInput();
        }

        $lead->name = $request->name;
        $lead->lname = $request->lname;
        $lead->email = $request->email;
        $lead->phone = $request->phone;
        $lead->passport = $request->passport;
        $lead->status_id = !empty($request->status_id) ? $request->status_id : '';
        $lead->city_id = !empty($request->city_id) ? $request->city_id : '';
        $lead->source_id = !empty($request->source_id) ? $request->source_id : '';
        $lead->user_id = !empty($request->user_id) ? $request->user_id : '';
        $lead->address = $request->address;
        $lead->notes = $request->notes;
        $lead->date_contact = isset($request->date_contact) ? date('Y-m-d H:i:s', strtotime($request->date_contact)) : date('Y-m-d H:i:s');

        return $lead->save();
    }

    public function search(Request $request) {       
        $leads = Lead::with(['statuses', 'sources', 'cities', 'users'])->orderBy('id', 'DESC');
        if($request->filled('search')) {
            $searchQuery = $request->get('search');
            $leads = $leads->where(function($query) use ($searchQuery){
                                  $query->where('name', 'LIKE', '%' . $searchQuery . '%')
                                        ->orWhere('email', 'LIKE', '%' . $searchQuery . '%')
                                        ->orWhere('lname', 'LIKE', '%' . $searchQuery . '%')
                                        ->orWhere('passport', 'LIKE', '%' . $searchQuery . '%')
                                        ->orWhere('phone', 'LIKE', '%' . $searchQuery . '%');
                              });
        }
        
        if($request->filled('status_id')) {
            $leads = $leads->where('status_id', '=' , $request->get('status_id'));
        }

        $leads =  $leads->paginate(20)->withQueryString();

        return $leads;
    }

    public function getCustomers() {
        return Customers::get();
    }
}