<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Balance_transfer;
use App\Model\Cash;
use App\Model\Cost;
use App\Model\Owner;
use App\Model\Sale_due_collection;
use App\Model\Sale_payment;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    
    private $owner_object;

    public function __construct()
    {
        $this->owner_object = new Owner;
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
        $balance           = new Balance_transfer;
        $owners           = Owner::orderBy('date', 'desc')->get();
        $total_balance = $balance->get_total_blance();
        return view('admin.owner.list', compact('owners', 'total_balance'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $today                   = date('Y-m-d');
        $yester_day              = date('Y-m-d', strtotime("-1 days"));
        $sale_payment            = new Sale_payment;
        $sale_due_collection     = new Sale_due_collection;
        $cost                    = new Cost;
        $cash                    = new Cash;

        $today_sale_payment            = $sale_payment->get_todays_sale_payment($today);
        $today_sale_due_collection     = $sale_due_collection->get_todays_sale_due_collection($today);
        $today_cost                    = $cost->get_todays_cost($today);
        $yesterday_cash                = $cash->yesterday_cash($yester_day);
        return view('admin.owner.add', compact('today_sale_payment', 'today_sale_due_collection', 'today_cost', 'yesterday_cash'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate(Owner::$validateCreateRule);

        $this->owner_object->store_owner($request);

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
        $owner = Owner::findOrFail($id);
        return view('admin.owner.edit', compact('owner'));
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
        $validateData = $request->validate(Owner::$validateUpdateRule);

        $this->owner_object->update_owner($request, $id);

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
        $this->owner_object->delete_owner($id);

        return redirect()->back();
    }
}
