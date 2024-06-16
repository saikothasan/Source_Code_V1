<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Bank_transaction;
use App\Model\Customer;
use App\Model\Owner;
use App\Model\Sale;
use App\Model\Sale_due_collection;
use App\Model\Sale_payment;
use App\Model\Sale_return;
use App\Model\User;
use Illuminate\Http\Request;

class SaleDueCollectionController extends Controller
{
    private $sale_due_object;

    public function __construct()
    {
        $this->sale_due_object = new Sale_due_collection;
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sale_due_collection = $this->sale_due_object->get_sale_due_collection();
        return view('admin.saledue.list', compact('sale_due_collection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sale         = new Sale;
        $sale_return  = new Sale_return;
        $sale_payment = new Sale_payment;
        $bank         = new Bank_transaction;
        $owner        = new Owner;
        $users        = User::select('id','name')->get();
        $customers    = Customer::select('id','name', 'credit_limit')->get();

        if ($customers) {
            foreach ($customers as $key => $value) {

                $customer_total_buy        = $sale->get_customer_total_buy($value->id);

                $customer_total_paid       = $sale_payment->get_customer_total_pay($value->id);

                $customer_total_due_paid   = $this->sale_due_object->customer_total_due_paid($value->id);
                $customer_total_bank_paid  = $bank->customer_total_bank_paid($value->id);
                $customer_total_bkash_paid = $owner->customer_total_bkash_paid($value->id);
                $customer_return           = $sale_return->get_customer_sale_return($value->id);

                $sale_return_amount = 0; //, 'products.sell_price'

                if ($customer_return) {

                    foreach ($customer_return as $key2 => $return) {

                        $sale_return_amount += $return->return_quantity * $return->sell_price;
                    }
                }

                $total_paid = $customer_total_paid + $customer_total_due_paid + $customer_total_bank_paid + $customer_total_bkash_paid + $sale_return_amount;


                $due = $customer_total_buy + $value->credit_limit - $total_paid;

                $customers[$key]->due = $due;
            }
        }

        return view('admin.saledue.add', compact('users', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate(Sale_due_collection::$validateRule);

        $this->sale_due_object->store_sale_due_collection($request);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->sale_due_object->delete_sale_due_collection($id);

        return redirect()->back();
    }
}
