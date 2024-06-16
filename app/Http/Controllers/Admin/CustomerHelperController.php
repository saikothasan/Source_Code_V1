<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Customer;
use Illuminate\Http\Request;

class CustomerHelperController extends Controller
{
    public function autocomplete_customer(Request $request)
    {
      
        $search = $request->search;
        $customer = Customer::orderby('created_at', 'asc')->select('id', 'name', )->where('phone', 'like', '%' . $search . '%')->limit(1)->get()->toArray();
       
      foreach($customer as $cus){
          
        return response()->json($cus);
      }
  }

}
