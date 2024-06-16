<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VariationCombinationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $options = collect($request->variationOptions);
        function get_combinations($arrays)
        {
            $result = array(array());
            foreach ($arrays as $property => $property_values) {
                $tmp = array();
                foreach ($result as $result_item) {
                    foreach ($property_values as $property_value) {

                        $tmp[] = array_merge($result_item, array($property => $property_value['text']));

                    }
                }

                $result = $tmp;
            }
            return $result;
        }
        return response()->json(get_combinations($options->pluck('optionValues')),Response::HTTP_OK);

    }
}
