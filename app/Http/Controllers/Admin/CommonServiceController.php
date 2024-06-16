<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Bank;
use App\Model\Supplier;
use App\Model\User;
use App\Services\SupplierService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CommonServiceController extends Controller
{
    use  ApiResponse;

    public function supplierPayableAmount(Request $request)
    {
        $supplier = Supplier::where('user_id', $request->user_id)->firstOrFail();
        $total_payable = collect((new SupplierService())->purchasePayableAmount($supplier))->sum('total_payable');
        return $this->respondSuccess($total_payable, 'Supplier payable amount fetch successfully');
    }

    public function getUserBank(Request $request)
    {
        $user_id = $request->user_id;
        $banks = Bank::where('user_id', $user_id)
            ->select('id as value', 'name as text' , 'account_no')
            ->get()
            ->toArray();
        return $this->respondSuccess($banks, 'User banks fetch successfully');
    }

    public function getDesignationUsers(Request $request)
    {
        $designation = $request->designation;
        $users = User::where('designation_id', $designation)
            ->select('id as value', 'name as text')
            ->latest('name')
            ->get()->toArray();
        return $this->respondSuccess($users, 'Designation user get successfully');
    }
}
