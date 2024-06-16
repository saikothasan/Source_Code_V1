<?php

namespace App\Http\Resources\Admin\Report;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TotalPiecesResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
//        $sales_pieces = collect($this)->sum('sales_pieces');
//        $total_sale_price = collect($this)->sum('total_sale_price');
//        $total_buy_price = collect($this)->sum('total_buy_price');
//        $profit = $total_sale_price - $total_buy_price;

        return parent::toArray($request);
    }
}
