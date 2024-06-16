<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Model\Variation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class VariationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $variations = $this->getVariation();
        return view('admin.Variation.index', compact('variations'));
    }

    private function getVariation()
    {
        return Variation::query()
            ->variation()
            ->with('variationValue')
            ->get();
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
            'variation_name' => 'required|unique:variations,variation_name',
        ]);
        $variation = new Variation();
        $variation->fill($validatedData)->save();
        Session::flash('message', 'Variation create Successfully!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Variation $variation
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function show(Variation $variation)
    {
        if (!isset($variation->type_id)) {
            abort(404);
        }
        $variation_value = $variation->load('variantType');
        $variations = $this->getVariation();
        return view('admin.Variation.index', compact('variations', 'variation_value'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Variation $variation
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Variation $variation)
    {
        $variations = $this->getVariation();
        return view('admin.Variation.index', compact('variations', 'variation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Variation $variation
     * @return RedirectResponse
     */
    public function update(Request $request, Variation $variation)
    {
        $validatedData = $request->validate([
            'variation_name' => 'required|unique:variations,variation_name,' . $variation->id,
        ]);
        $variation->fill($validatedData)->save();
        Session::flash('message', 'Variation update Successfully!');
        return redirect()->route('variation.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Variation $variation
     * @return RedirectResponse
     */
    public function destroy(Variation $variation)
    {
        return redirect()->back();
    }
}
