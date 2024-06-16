<?php

namespace App\Services;

use App\Model\BankTransfer;
use App\Model\Branch;
use App\Model\CashDrawer;
use App\Model\Cost;
use App\Model\PaymentMethod;
use App\Model\Purchase;
use App\Model\Purchase_return;
use App\Model\Sale;
use App\Model\Sale_detail;
use App\Model\SaleDelivery;
use App\Model\Stock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public static function management()
    {
        $firstDay = date("Y-n-j", strtotime("first day of this month"));
        $lastDay = date("Y-n-j", strtotime("last day of this month"));
        $branches = Branch::query()
            ->withOutMainBranch()
            ->whereNotIn('id', [5])
            ->withCount(['stocks as available' => function ($query) {
                $query->where('stock_status', Stock::STATUS['Stock'])
                    ->whereNull('sale_id')
                    ->whereNull('sale_detail_id')
                    ->whereNull('transfer_id');
            }])
            ->withSum(['costs as today_expenses' => function ($query) {
                $query->whereDate('created_at', today());
            }], 'amount')
            ->withSum(['sales as today_sales' => function ($query) {
                $query->whereDoesntHave('saleDelivery', function ($q) {
                    $q->whereIn(
                        'order_status',
                        [
                            SaleDelivery::ORDER_STATUS['pending'],
                            SaleDelivery::ORDER_STATUS['returned'],
                            SaleDelivery::ORDER_STATUS['cancelled']
                        ]
                    );
                })->whereDate('date', today());
            }], 'final_total')
            ->withSum(['costs as month_expenses' => function ($query) use ($firstDay, $lastDay) {
                $query->whereBetween('created_at', [$firstDay, $lastDay]);
            }], 'amount')
            ->withSum(['sales as month_sales' => function ($query) use ($firstDay, $lastDay) {
                $query->whereDoesntHave('saleDelivery', function ($q) {
                    $q->whereIn(
                        'order_status',
                        [
                            SaleDelivery::ORDER_STATUS['pending'],
                            SaleDelivery::ORDER_STATUS['returned'],
                            SaleDelivery::ORDER_STATUS['cancelled']
                        ]
                    );
                })->whereBetween('date', [$firstDay, $lastDay]);
            }], 'final_total')
            ->get();

//        $total_sale = Sale::query()->whereDoesntHave('saleDelivery', function ($q) {
//            $q->whereIn(
//                'order_status',
//                [
//                    SaleDelivery::ORDER_STATUS['pending'],
//                    SaleDelivery::ORDER_STATUS['returned'],
//                    SaleDelivery::ORDER_STATUS['cancelled']
//                ]
//            );
//        })->selectRaw('SUM(final_total) as total_sale')->first()->total_sale ?? 0;
//        $total_cost = Cost::query()->selectRaw('SUM(amount) as total_cost')->first()->total_cost ?? 0;
        $stock = Stock::query()
        ->selectRaw('COUNT(CASE WHEN stock_status != 4 THEN 1 END) as total_product')
        ->selectRaw('SUM(stock_status=0 && sale_detail_id IS NOT NULL && sale_id IS NOT NULL) as total_sale')
            ->first();
        $total_buy_price = Sale_detail::query()->selectRaw('SUM(buy_rate*quantity) as total_buy')->first()->total_buy ?? 0;
//        $total_expense = $total_buy_price + $total_cost;
//        $total_profit = number_format($total_sale - $total_expense);

            $month_wise_sale = ChartService::sale_amount();
            $month_wise_cost = ChartService::cost_amount();
            $branches_product = Branch::query()
            ->withCount(['stocks as stock'])
            ->withCount(['stocks as sale' => function ($query) {
                $query->where('stock_status', Stock::STATUS['Sale'])
                    ->whereNotNull('sale_id')
                    ->whereNotNull('sale_detail_id');

            }])->get(5);
            $cash_drawer = CashDrawer::where('branch_id', branch_id())->first();
             $paymentMethods = PaymentMethod::query()
            ->withSum('methodBalance as total_balance', 'total_balance')
            ->whereNotIn('name', ['Bank'])
            ->take(4)->get();
// month wise sale end
        return [
            'branches' => $branches,
            'total_sale_amount' => 0,
            'total_expense' => 0,
            'total_profit' => 0,
            'total_product' => $stock->total_product ?? 0,
            'total_sale' => $stock->total_sale ?? 0,
            'month_wise_sale'=> $month_wise_sale,
            'branch_wise_product' => $branches_product,
            'month_wise_cost' => $month_wise_cost,
            'cash_drawer' => $cash_drawer,
            'paymentMethods' => $paymentMethods
        ];
    }

    public static function branchDashboard(): array
    {
        $data['totalSale'] = Sale::query()
            ->where('branch_id', auth()->user()->branch_id)
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
            ->sum('final_total');
        $data['today_sale'] = Sale::query()
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
            ->where('branch_id', auth()->user()->branch_id)
            ->whereDate('date', today())
            ->sum('final_total');
        $data['total_product'] = Stock::query()
            ->userBranch(auth()->user()->branch_id)
            ->count();
        $data['available_product'] = Stock::query()
            ->userBranch(auth()->user()->branch_id)
            ->stockProduct()
            ->count();

        $data['total_cost'] = Cost::query()->where('branch_id', auth()->user()->branch_id)
            ->selectRaw('SUM(amount) as total_cost')
            ->first()->total_cost ?? 0;

        $data['today_cost'] = Cost::query()->where('branch_id', auth()->user()->branch_id)
            ->whereDate('created_at', today())
            ->whereDate('created_at', today())
            ->selectRaw('SUM(amount) as today_cost')
            ->first()->today_cost ?? 0;
        return $data;
    }

    public static function supplier($request): array
    {
        $supplier = auth()->user()->load('supplier:id,name,user_id')->supplier;
        return [
            'supplier_sliders' => [
                self::payableAmount($request, $supplier),
                ...self::totalSell($request, $supplier),

            ],
            'supplier' => $supplier,
        ];
    }

    protected static function payableAmount($request, $supplier): array
    {
        $from_date = $request->get('from-date', '');
        $to_date = $request->get('to-date', '');
        $purchases = Purchase::query()
            ->where('supplier_id', $supplier->id)
            ->withCount(['stocks as total_sell' => function ($query) use ($from_date, $to_date) {
                $query->where('stock_status', Stock::STATUS['Sale'])
                    ->whereNotNull('sale_id')
                    ->whereNotNull('sale_detail_id')
                    ->WhereHas('saleDetails', function ($sale) use ($from_date, $to_date) {
                        $sale->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                            $query->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date]);
                        });
                    });
            }])
            ->withCount('purchaseDetails')
            ->having('total_sell', '>', '0')
            ->withSum('purchaseDue', 'due_total')
            ->withSum('purchaseDue', 'paid_total')
            ->withSum(['purchasePayments as advanced_payment' => function ($query) {
                $query->whereDoesntHave('bankHistory', function ($q) {
                    $q->where('status', BankTransfer::STATUS['Reject']);
                });
            }], 'total_pay')
            ->withSum(['stocks as sales_product_purchase_price' => function ($query) use ($from_date, $to_date) {
                $query->where('stock_status', Stock::STATUS['Sale'])
                    ->whereNotNull('sale_id')
                    ->whereNotNull('sale_detail_id')
                    ->whereHas('sales', function (Builder $q) use ($from_date, $to_date) {
                        $q->filterByDate($from_date, $to_date);
                    })
                    ->deliveredSale('sales.saleDeliveries');
            }], 'buy_price')
//            ->with(['stocks' => function ($q) use ($from_date, $to_date) {
//                $q->where('stock_status', Stock::STATUS['Sale'])
//                    ->whereNotNull('sale_id')
//                    ->whereNotNull('sale_detail_id')
//                    ->with(['saleDetails' => function ($sale) use ($from_date, $to_date) {
//                        $sale->whereDoesntHave('sale.saleDelivery', function ($q) {
//                            $q->whereIn('order_status',
//                                [
//                                    SaleDelivery::ORDER_STATUS['pending'],
//                                    SaleDelivery::ORDER_STATUS['returned'],
//                                    SaleDelivery::ORDER_STATUS['cancelled']
//                                ]);
//                        })->whereDoesntHave('exchange.exchangeDelivery', function ($q) {
//                            $q->whereIn('order_status',
//                                [
//                                    SaleDelivery::ORDER_STATUS['pending'],
//                                    SaleDelivery::ORDER_STATUS['returned'],
//                                    SaleDelivery::ORDER_STATUS['cancelled']
//                                ]);
//                        })->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
//                            $query->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date]);
//                        });
//                    }]);
//            }])
            ->get()
            ->map(function ($data) {
                //$amount = (int)collect($data->stocks)->sum('saleDetails.buy_rate') - (int)$data->advanced_payment;
                $amount = (int)$data->sales_product_purchase_price - (int)$data->advanced_payment;
                if ($amount < 0) {
                    $amount = 0;
                }
                return [
                    'data' => $data,
                    'total_payable' => $amount,

                ];
            });
        $total_payable = collect($purchases)->sum('total_payable');

        return [
            'title' => "PAYABLE AMOUNT",
            'total' => number_format($total_payable) . get_settings('currency_symbol'),
        ];
    }

    protected static function totalSell($request, $supplier): array
    {
        $stock = collect(Stock::query()
            ->filterByDate($request->get('from-date'), $request->get('to-date'))
            ->where('supplier_id', $supplier->id)
            ->selectRaw('SUM(stock_status=1 && sale_detail_id IS NULL && sale_id IS NULL && transfer_id IS NULL) as available_stock')
            ->selectRaw('SUM(stock_status=1 && sale_detail_id IS NULL && sale_id IS NULL && transfer_id IS NULL)*buy_price as available_stock_price')
            ->selectRaw('SUM(stock_status=0 && sale_detail_id IS NOT NULL && sale_id IS NOT NULL) as total_sale')
            ->selectRaw('SUM(stock_status=3 && purchase_return_id IS NOT NULL) as total_purchase_return')
            ->groupBy('stocks.product_barcode')
            ->get());

        $purchase_return = Purchase_return::query()
            ->whereStatus(Purchase_return::STATUS['received'])
            ->where('supplier_id', $supplier->id)->sum('total_quantity');

        return [
            [
                'title' => "Total Available Product",
                'total' => number_format($stock->sum('available_stock')) . ' pcs',
            ],
            [
                'title' => "Total Available Product Price",
                'total' => number_format($stock->sum('available_stock_price')) . get_settings('currency_symbol'),
            ],
            [
                'title' => "Total Sell Pieces",
                'total' => number_format($stock->sum('total_sale')) . ' pcs',
            ],
            [
                'title' => "Total Return Product",
                'total' => number_format($purchase_return) . ' pcs',
            ]
        ];
    }
}
