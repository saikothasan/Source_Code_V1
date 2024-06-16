<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Purchase;
use App\Model\Purchase_payment;
use App\Model\PurchasePayment;
use App\Model\Supplier;
use App\Model\User;
use Illuminate\Http\Request;

class PurchasePaymentController extends Controller
{
    private $purchase_payment_object;

    public function __construct()
    {
        $this->purchase_payment_object = new PurchasePayment();
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
        $purchase_payments = $this->purchase_payment_object->get_purchase_payments();
        return view('admin.purchasepayment.list', compact('purchase_payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
        $purchase  = new Purchase;
        $users     = User::select('id','name')->get();
        $suppliers = Supplier::select('id','name')->get();

        if ($suppliers) {
            foreach ($suppliers as $key => $value) {

                $supplier_total_buy = $purchase->get_supplier_total_buy($value->id);

                $supplier_total_paid = $this->purchase_payment_object->get_supplier_total_pay($value->id);

                $due = $supplier_total_buy - $supplier_total_paid;

                $suppliers[$key]->due = $due;
            }
        }

        return view('admin.purchasepayment.add', compact('users', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404);
        $validateData = $request->validate(Purchase_payment::$validateStoreRule);

        $this->purchase_payment_object->store_purchase_payment($request);

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
        $purchase  = new Purchase;
        $purchase_payment = Purchase_payment::findOrFail($id);
        $users     = User::select('id','name')->get();
        $suppliers = Supplier::select('id','name')->get();

        if ($suppliers) {
            foreach ($suppliers as $key => $value) {

                $supplier_total_buy = $purchase->get_supplier_total_buy($value->id);

                $supplier_total_paid = $this->purchase_payment_object->get_supplier_total_pay($value->id);

                $due = $supplier_total_buy - $supplier_total_paid;

                $suppliers[$key]->due = $due;
            }
        }

        return view('admin.purchasepayment.edit', compact('purchase_payment', 'users', 'suppliers'));
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
        $validateData = $request->validate(Purchase_payment::$validateUpdateRule);

        $this->purchase_payment_object->update_purchase_payment($request, $id);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->purchase_payment_object->delete_purchase_payment($id);

        return redirect()->back();
    }
}
