<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customers;
use App\Helpers\Helper;
use App\Services\CustomerServices;

class CustomerController extends Controller
{
    public function __construct(private CustomerServices $customerServices) {

    }

    public function index(Request $request) {
        if($request->filled('searchvalue') && $request->get('searchvalue') == "searchdata"){
            // $isSearch = $this->leadServices->search($request);
            // $data = ['customers' => $customers];
        }
        else{
            $customers = $this->customerServices->getCustomers();
            $data = ['customers' => $customers];
        }
        
        return view('admin.customers.index', $data);
    }

    public function create() {        
        return view('admin.customers.create');
    }
}
