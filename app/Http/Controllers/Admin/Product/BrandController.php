<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\Stock;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $brands = $this->brands();
        return view('admin.brand.index', compact('brands'));
    }

    private function brands()
    {
        return Brand::query()->withCount('totalVariants')
            ->withCount('products as total_items')
            ->withCount(['availableStocks' => function ($query) {
                $query->where('stock_status', Stock::STATUS['Stock'])
                    ->whereNull('sale_id')
                    ->whereNull('sale_detail_id')
                    ->whereNull('transfer_id');
            }])
            ->orderBy('name')
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:brands,name',
        ]);
        $brand = new Brand();
        $brand->fill($validatedData)->save();
        Session::flash('message', 'Brand create Successfully!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Model\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Model\Brand $brand
     * @return Application|Factory|View
     */
    public function edit(Brand $brand)
    {
        $brands = $this->brands();
        return view('admin.brand.index', compact('brands', 'brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Brand $brand
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Brand $brand)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:brands,name,' . $brand->id,
        ]);
        $brand->fill($validatedData)->save();
        Session::flash('message', 'Brand update Successfully!');
        return redirect()->route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Model\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        if ($brand) {
            Session::flash('message', 'Brand delete Successfully!');
        }

        return redirect()->back();
    }
}
