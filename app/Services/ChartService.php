<?php

namespace App\Services;

use App\Model\Cost;
use App\Model\Sale;
use App\Model\SaleDelivery;

class ChartService{



    public static function sale_amount(){
        $all_months = range(1, 12);

        $month_wise_sale = Sale::where('branch_id', branch_id())
            ->whereDoesntHave('saleDelivery', function ($q) {
                $q->whereIn(
                    'order_status',
                    [
                        SaleDelivery::ORDER_STATUS['pending'],
                        SaleDelivery::ORDER_STATUS['returned'],
                        SaleDelivery::ORDER_STATUS['cancelled']
                    ]
                );
            })
            ->whereYear('created_at', date('Y'))
            ->selectRaw('SUM(final_total) as total_sale, MONTH(created_at) as month')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total_sale', 'month')
            ->map(fn ($sale) => $sale ?? 0)
            ->union(array_fill_keys($all_months, 0))
            ->sortBy(fn ($value, $key) => $key)
            ->values()
            ->toArray();
        
        return $month_wise_sale;
    }

    public static function cost_amount(){
        $month_wise_cost = Cost::where('branch_id', branch_id())
        ->whereYear('created_at', date('Y'))
        ->selectRaw('SUM(amount) as total_cost, MONTH(created_at) as month')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total_cost', 'month')
        ->map(fn($cost) => $cost ?? 0)
        ->toArray();
    
    $month_wise_cost += array_fill_keys(range(1, 12), 0);
    ksort($month_wise_cost);
    
    return array_values($month_wise_cost);
    }
}