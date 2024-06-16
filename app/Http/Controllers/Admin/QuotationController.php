<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Quotation;
use App\Model\QuotationDetail;
use App\Model\Unit;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    private $quotation_object;

    public function __construct()
    {

        $this->quotation_object   = new Quotation;
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
        $quotations = Quotation::orderBy('date', 'desc')->get();
        return view('admin.quotation.list', compact('quotations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products  = Product::select('id', 'name', 'sell_price')->get();
        $units     = Unit::select('value', 'id')->get();
        return view('admin.quotation.add', compact('products', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Quotation::$validateStoreRule);
        $quotation_id = $this->quotation_object->store_quotation($request);
        return redirect()->route('quotation', $quotation_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation_detail_object = new QuotationDetail();
        $quotation = Quotation::findOrFail($id);
        $quotation_details = $quotation_detail_object->get_quotation_detail_by_quotation_id($id);
        return view('admin.quotation.view', compact('quotation', 'quotation_details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->quotation_object->delete_quotation($id);
        return redirect()->back();
    }
}
