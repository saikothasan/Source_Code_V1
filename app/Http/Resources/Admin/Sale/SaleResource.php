<?php

namespace App\Http\Resources\Admin\Sale;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;


class SaleResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {

        //return parent::toArray($request);
        return [
            'data' => SaleResourceCollection::collection($this->collection)->resolve(),
            'current_page' => $this->currentPage(),
            'total' => $this->total(),
            "last_page" => $this->lastPage(),
            'links' => $this->links(),
        ];
    }
}
