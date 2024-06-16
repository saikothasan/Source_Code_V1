<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Product_transfer;
use App\Model\User;
use Illuminate\Http\Request;

class ProductTransferController extends Controller
{

    private $product_transfer_object;

    public function __construct()
    {
        $this->product_transfer_object = new Product_transfer();

        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transfers = $this->product_transfer_object->get_all_transferred_products();
        return view('admin.transfer.list', compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users    = User   ::select('id', 'name')->get();
        return view('admin.transfer.add', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Product_transfer::$validateRule);
        $this->product_transfer_object->store_product_transfer($request);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product_transfer  $product_transfer
     * @return \Illuminate\Http\Response
     */
    public function show(Product_transfer $product_transfer)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product_transfer  $product_transfer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transfer = $this->product_transfer_object->get_transferred_product_by_id($id);
        $users    = User::select('id', 'name')->get();
        return view('admin.transfer.edit', compact('users', 'transfer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product_transfer  $product_transfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(Product_transfer::$validateRule);
        $this->product_transfer_object->update_product_transfer($request, $id);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product_transfer  $product_transfer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->product_transfer_object->delete_product_transfer($id);
        return redirect()->back();
    }
}
