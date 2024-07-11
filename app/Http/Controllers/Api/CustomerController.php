<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customers;
use App\Helpers\Helper;
use App\Services\CustomerServices;

class CustomerController extends Controller
{
    public function __construct(private CustomerServices $customerServices) {

    }

    public function customers_list(Request $request) {
        $customers = $this->customerServices->getCustomers();
        return responseJSON($customers);
    }
}
