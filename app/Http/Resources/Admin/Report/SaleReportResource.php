<?php

namespace App\Http\Resources\Admin\Report;

use App\Model\Report;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {

        return [
            'report_id' => Report::query()->generateReportId(),
            "created_at" => date('Y-m-d H:i:s'),
            'report_name' => 'Sales Report',
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'description' => $request->description,
            'generator_name' => auth()->user()->name,
            'details' => [
                'total_pieces' => TotalPiecesResource::collection($this['total_pieces']),
            ],
        ];
    }
}
