<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Model\Variation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class VariationValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'variation_value' => 'required|unique:variations,variation_value',
            'variation_code' => 'nullable',
            'type_id' => 'required',
        ]);
        $variation = new Variation();
        $variation->fill($validatedData)->save();
        if ($variation) {
            Session::flash('message', 'Variation value add Successfully!');
        }
        return redirect()->route('variation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $variation = Variation::findOrFail($id);

        $validatedData = $request->validate([
            'variation_value' => 'required|unique:variations,variation_value,' . $id,
            'variation_code' => 'nullable',
            'type_id' => 'required',
        ]);

        $variation->fill($validatedData)->save();
        Session::flash('message', 'Variation value update Successfully!');
        return redirect()->route('variation.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
