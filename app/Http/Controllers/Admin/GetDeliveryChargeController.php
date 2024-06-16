<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DeliveryMan;

class GetDeliveryChargeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $delivery_charge = DeliveryMan::where('id', $request->delivery_id)->first();
        return response()->json($delivery_charge, 200);
    }
}
