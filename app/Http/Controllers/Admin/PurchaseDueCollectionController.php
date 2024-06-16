<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Purchase;
use App\Model\Purchase_due;
use App\Model\Purchase_payment;
use App\Model\Purchase_return;
use App\Model\PurchaseDue;
use App\Model\Supplier;
use App\Model\User;
use Illuminate\Http\Request;

class PurchaseDueCollectionController extends Controller
{
    private $purchase_due_object;

     public function __construct()
    {
        $this->purchase_due_object = new PurchaseDue();
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
        $purchase_due_collection = $this->purchase_due_object->get_purchase_due_collection();
        return view('admin.purchasedue.list', compact('purchase_due_collection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $purchase         = new Purchase;
        $purchase_return  = new Purchase_return;
        $purchase_payment = new Purchase_payment;

        $users     = User::select('id','name')->get();
        $suppliers = Supplier::select('id','name', 'due')->get();


        if ($suppliers) {


            foreach ($suppliers as $key => $value) {




                $supplier_total_buy = $purchase->get_supplier_total_buy($value->id);

                $supplier_total_paid = $purchase_payment->get_supplier_total_pay($value->id);

                $supplier_total_due_paid = $this->purchase_due_object->supplier_total_due_paid($value->id);
                $supplier_return = $purchase_return->get_supplier_purchase_return($value->id);

                $purchase_return_amount = 0; //, 'products.sell_price'

                if ($supplier_return) {

                    foreach ($supplier_return as $key2 => $return) {

                        $purchase_return_amount += $return->return_quantity * $return->buy_price;
                    }
                }

                $total_paid = $supplier_total_paid + $supplier_total_due_paid + $purchase_return_amount;

                $due = $value->due + $supplier_total_buy - $total_paid;

                $suppliers[$key]->due = $due;
                $suppliers[$key]->total_paid = $total_paid;

            }



        }

        return view('admin.purchasedue.add', compact('users', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate(Purchase_due::$validateRule);

        $this->purchase_due_object->store_purchase_due_collection($request);

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
        $this->purchase_due_object->delete_purchase_due_collection($id);

        return redirect()->back();
    }
}
