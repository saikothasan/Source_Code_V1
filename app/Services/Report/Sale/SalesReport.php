<?php

namespace App\Services\Report\Sale;


use App\Constant\Constant;
use App\Model\Report;
use App\Model\Sale_detail;
use App\Model\SaleDelivery;
use App\Model\SaleReturnDetail;
use App\Services\Report\ReportContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesReport
{
    public static function salesReportResource(): array
    {
        return [
            'resource' => json_encode([
                'branches' => getAllBranch(),
                'categories' => getAllCategory(),
                'suppliers' => getAllSupplier(),
                'brands' => getAllBrand(),
                'paymentMethods' => collect(getPaymentMethods(['Bank']))
                    ->prepend([
                        'text' => 'Select Payment Method',
                        'value' => ''
                    ]),
                'amountType' => self::amountType(),
                'reportMode' => ReportContract::reportMode(),
                'fileMode' => ReportContract::fileMode(),
                'statusFilter' => self::statusFilter(),
            ]),
        ];
    }

    public static function generateReport(Request $request): array
    {
        $from_date = $request->get('from_date', '');
        $to_date = $request->get('to_date', '');
        $filter = $request->select_status['value'];
        $query = Sale_detail::query()
            ->when($request->selectedPaymentMethod['value'], function ($q) use ($request) {
                $q->whereHas('sale.salePayments', function ($q) use ($request) {
                    $q->where('payment_method_id', $request->selectedPaymentMethod['value']);
                });
            })
            ->when($request->items, function ($q) use ($request) {
                $q->WhereIn('product_barcode', self::pluckValue($request->items, 'value'));
            })
            ->select('sale_details.*',
                DB::raw('SUM(quantity) as sales_pieces'),
                DB::raw('SUM(quantity*sale_rate) as total_sale_price'),
                DB::raw('SUM(quantity*buy_rate) as total_buy_price'),
            )
            ->WhereHas('product', function ($q) use ($request) {
                $q->WhereIn('category_id', self::pluckValue($request->selectedCategory, 'value'))
                    ->WhereIn('brand_id', self::pluckValue($request->selectedBrand, 'value'))
                    ->WhereIn('supplier_id', self::pluckValue($request->selectedSupplier, 'value'));
            })
            ->WhereIn('branch_id', self::pluckValue($request->selectedBranch, 'value'))
            ->when(isset($request->selectedSeller['value']), function ($q) use ($request) {
                $q->whereHas('sale', function ($q) use ($request) {
                    $q->where('seller_id', $request['selectedSeller']['value']);
                });
            })
            ->when($request->selectedReportMode['value'] == "individual_pieces", function ($q) {
                $q->with(['product' => [
                    'category:id,name',
                    'brand:id,name',
                    'supplier:id,name',
                ], 'productVariations.variantValues.variantValueName']);
            })
            ->withSum('sale as total_amount', 'final_total')
            ->withSum('sale as total_discount_amount', 'discount_amount')
            ->withSum('sale as total_flat_discount', 'flat_discount')
            ->when(!isset($filter) || collect(['with_out_delivery_sale', 'delivered', 'cancelled', 'pending'])->contains($filter), function ($query) use ($request, $filter) {
                $query->with(['sale' => function ($query) use ($request, $filter) {
                    $query->withSum(['saleDetails as with_out_delivery_sale' => function ($query) {
                        $query->whereHas('sale', function ($q) {
                            $q->whereDoesntHave('saleDelivery');
                        })->whereDoesntHave('exchange.exchangeDelivery');
                    }], 'quantity')
                        ->withSum(['saleDetails as delivered' => function ($query) use ($request) {
                            $query->whereHas('sale.saleDeliveries', function ($q) use ($request) {
                                $q->where('order_status', '=', SaleDelivery::ORDER_STATUS['delivered']);
                            })->whereDoesntHave('sale.saleDeliveries', function ($q) {
                                $q->whereIn('order_status',
                                    [
                                        SaleDelivery::ORDER_STATUS['pending'],
                                        SaleDelivery::ORDER_STATUS['returned'],
                                        SaleDelivery::ORDER_STATUS['cancelled']
                                    ]);
                            });
                        }], 'quantity')
                        ->when($filter == 'pending', function ($query) use ($request) {
                            $query->withSum(['saleDetails as pending' => function ($query) use ($request) {
                                $query->whereHas('sale.saleDelivery', function ($q) use ($request) {
                                    $q->where('order_status', '=', SaleDelivery::ORDER_STATUS['pending']);
                                })->whereDoesntHave('exchange.exchangeDelivery', function ($q) {
                                    $q->whereIn('order_status',
                                        [
                                            SaleDelivery::ORDER_STATUS['delivered'],
                                            SaleDelivery::ORDER_STATUS['returned'],
                                            SaleDelivery::ORDER_STATUS['cancelled']
                                        ]);
                                })->orWhereHas('exchange.exchangeDelivery', function ($q) {
                                    $q->where('order_status', '=', intval(SaleDelivery::ORDER_STATUS['pending']));
                                });
                            }], 'quantity');
                        })
                        ->withSum(['saleDetails as cancelled' => function ($query) use ($request) {
                            $query->whereHas('sale.saleDelivery', function ($q) use ($request) {
                                $q->where('order_status', '=', SaleDelivery::ORDER_STATUS['cancelled']);
                            });
                        }], 'quantity');
                }]);
            })
            ->with('exchange')
            ->when(isset($filter) && $filter == 'with_out_delivery_sale', function ($query) use ($filter) {
                $query->whereDoesntHave('sale.saleDelivery')->whereDoesntHave('exchange.exchangeDelivery', function ($q) {
                    $q->whereIn('order_status',
                        [
                            SaleDelivery::ORDER_STATUS['pending'],
                            SaleDelivery::ORDER_STATUS['delivered'],
                            SaleDelivery::ORDER_STATUS['returned'],
                            SaleDelivery::ORDER_STATUS['cancelled']
                        ]);
                });
            })
            ->when(isset($filter) && $filter != 'with_out_delivery_sale', function ($query) use ($filter) {
                $query->whereHas('sale.saleDelivery', function ($q) use ($filter) {
                    $q->where('order_status', '=', intval(SaleDelivery::ORDER_STATUS[$filter]));
                })->when($filter == 'pending', function ($query) use ($filter) {
                    $query->whereDoesntHave('exchange.exchangeDelivery', function ($q) {
                        $q->whereIn('order_status',
                            [
                                SaleDelivery::ORDER_STATUS['delivered'],
                                SaleDelivery::ORDER_STATUS['returned'],
                                SaleDelivery::ORDER_STATUS['cancelled']
                            ]);
                    })->orWhereHas('exchange.exchangeDelivery', function ($q) use ($filter) {
                        $q->where('order_status', '=', SaleDelivery::ORDER_STATUS[$filter]);
                    });
                });

            })
            ->WhereIn('supplier_id', self::pluckValue($request->selectedSupplier, 'value'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date])
            ->groupBy('id');


//        dd(collect($query->get())->toArray());


        $sale_cancelled = [];
        if (!isset($filter) || $filter == 'cancelled') {
            $cancelled_clone = clone $query;
            $sale_cancelled = $cancelled_clone->whereHas('sale.saleDelivery', function ($q) {
                $q->whereIn('order_status',
                    [
                        SaleDelivery::ORDER_STATUS['cancelled']
                    ]);
            })->when($request->items, function ($q) use ($request) {
                $q->WhereIn('product_barcode', self::pluckValue($request->items, 'value'));
            })->when($request->selectedReportMode['value'] == "individual_pieces", function ($q) {
                $q->with(['product' => [
                    'category:id,name',
                    'brand:id,name',
                    'supplier:id,name',
                ], 'productVariations.variantValues.variantValueName']);
            })->get();
        }

        $sale_pending = [];
//        !isset($filter) || $filter == 'pending'
        if (!isset($filter) || $filter == 'pending') {
            $pending_clone = clone $query;
            $sale_pending = $pending_clone->whereHas('sale.saleDelivery', function ($q) {
                $q->whereIn('order_status',
                    [
                        SaleDelivery::ORDER_STATUS['pending'],
                    ]);
            })->orWhereHas('exchange.exchangeDelivery', function ($q) {
                $q->whereIn('order_status',
                    [
                        SaleDelivery::ORDER_STATUS['pending'],
                    ]);
            })->whereDoesntHave('exchange.exchangeDelivery', function ($q) {
                $q->whereIn('order_status',
                    [
                        SaleDelivery::ORDER_STATUS['delivered'],
                        SaleDelivery::ORDER_STATUS['returned'],
                        SaleDelivery::ORDER_STATUS['cancelled']
                    ]);
            })->select('sale_details.*',
                DB::raw('SUM(quantity) as sales_pieces'),
                DB::raw('SUM(quantity) as total_pending'),
            )
                ->when($request->selectedReportMode['value'] == "individual_pieces", function ($q) {
                    $q->with(['product' => [
                        'category:id,name',
                        'brand:id,name',
                        'supplier:id,name',
                    ], 'productVariations.variantValues.variantValueName']);
                })->WhereHas('product', function ($q) use ($request) {
                    $q->WhereIn('category_id', self::pluckValue($request->selectedCategory, 'value'))
                        ->WhereIn('brand_id', self::pluckValue($request->selectedBrand, 'value'))
                        ->WhereIn('supplier_id', self::pluckValue($request->selectedSupplier, 'value'));
                })->when($request->items, function ($q) use ($request) {
                    $q->WhereIn('product_barcode', self::pluckValue($request->items, 'value'));
                })
                ->WhereIn('supplier_id', self::pluckValue($request->selectedSupplier, 'value'))
                ->get();
        }

        $sale_delivered = [];
        if (!isset($filter) || $filter == 'delivered') {
            $delivered_clone = clone $query;
            $sale_delivered = collect($delivered_clone->whereHas('sale.saleDeliveries', function ($q) {
                $q->where('order_status', '=', SaleDelivery::ORDER_STATUS['delivered']);
            })->whereDoesntHave('sale.saleDeliveries', function ($q) {
                $q->whereIn('order_status',
                    [
                        SaleDelivery::ORDER_STATUS['pending'],
                        SaleDelivery::ORDER_STATUS['returned'],
                        SaleDelivery::ORDER_STATUS['cancelled']
                    ]);
            })->get());
        }
//
//        dd(collect($sale_delivered)->sum('sales_pieces'));


        $query = $query->when(!isset($filter), function ($query) use ($filter) {
            $query->whereDoesntHave('sale.saleDelivery', function ($q) {
                $q->whereIn('order_status',
                    [
                        SaleDelivery::ORDER_STATUS['pending'],
                        SaleDelivery::ORDER_STATUS['returned'],
                        SaleDelivery::ORDER_STATUS['cancelled']
                    ]);
            })->whereDoesntHave('exchange.exchangeDelivery', function ($q) {
                $q->whereIn('order_status',
                    [
                        SaleDelivery::ORDER_STATUS['pending'],
                        SaleDelivery::ORDER_STATUS['returned'],
                        SaleDelivery::ORDER_STATUS['cancelled']
                    ]);
            });
        })->when(isset($filter) && $filter == "delivered", function ($query) {
            $query->whereDoesntHave('sale.saleDeliveries', function ($q) {
                $q->whereIn('order_status',
                    [
                        SaleDelivery::ORDER_STATUS['pending'],
                        SaleDelivery::ORDER_STATUS['returned'],
                        SaleDelivery::ORDER_STATUS['cancelled']
                    ]);
            });
        })->get();


        $data = [
            'total_pieces' => $query,
            'sale_return' => self::saleReturn($request),
            'sale_cancelled' => $sale_cancelled,
            'sale_pending' => $sale_pending,
            'sale_delivered' => $sale_delivered,
        ];

        return self::format($request, $data);
    }


    public static function saleReturn($request)
    {
        $from_date = $request->get('from_date', '');
        $to_date = $request->get('to_date', '');
        $filter = $request->select_status['value'];
        $sale_return = [];
        if (!isset($filter) || $filter == 'returned') {
            $sale_return = SaleReturnDetail::query()
                ->when($request->items, function ($q) use ($request) {
                    $q->WhereIn('product_barcode', self::pluckValue($request->items, 'value'));
                })
                ->WhereHas('product', function ($q) use ($request) {
                    $q->WhereIn('category_id', self::pluckValue($request->selectedCategory, 'value'))
                        ->WhereIn('supplier_id', self::pluckValue($request->selectedSupplier, 'value'))
                        ->WhereIn('brand_id', self::pluckValue($request->selectedBrand, 'value'));
                })
                ->WhereIn('branch_id', self::pluckValue($request->selectedBranch, 'value'))
                ->when(isset($request->selectedSeller['value']), function ($q) use ($request) {
                    $q->whereHas('sale', function ($q) use ($request) {
                        $q->where('seller_id', $request['selectedSeller']['value']);
                    });
                })
                ->select('sale_return_details.*',
                    DB::raw('SUM(quantity) as returned'),
                )
                ->with(['sale', 'saleReturn'])
                ->when($request->selectedReportMode['value'] == "individual_pieces", function ($q) {
                    $q->with(['product' => [
                        'category:id,name',
                        'brand:id,name',
                        'supplier:id,name',
                    ], 'productVariations.variantValues.variantValueName']);
                })
                ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date])
                ->groupBy('id')
                ->get();
        }
        return $sale_return;
    }


    public static function format($request, $query): array
    {
        return [
            'report_id' => Report::query()->generateReportId(),
            "created_at" => date('Y-m-d H:i:s'),
            'report_name' => Report::REPORT_TYPE['sales_report'],
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'description' => $request->description,
            'details' => [
                'generator_name' => auth()->user()->name,
                'payment_method' => $request->get('selectedPaymentMethod'),
                'seller' => $request->get('selectedSeller'),
                'amount_type' => $request->get('selectedAmountType'),
                'select_status' => $request->get('select_status'),
                'report_mode' => $request->get('selectedReportMode'),
                'report_file_mode' => $request->get('report_file_mode'),
                'branch' => $request->get('selectedBranch'),
                'category' => $request->get('selectedCategory'),
                'supplier' => $request->get('selectedSupplier'),
                'brand' => $request->get('selectedBrand'),
                'sellers' => $request->get('selectedSeller'),
                'total_pieces' => TotalPiecesService::totalReportFormat($request, $query),
                'individual_pieces' => $request->selectedReportMode['value'] == "individual_pieces"
                    ? individualReportService::individualReport($request, $query) : null,
            ],
        ];
    }


    public static function pluckValue($array, $column): array
    {
        return collect($array)->pluck($column)->toArray();
    }


    public static function amountType(): array
    {
        return [
            [
                'text' => 'Select Amount',
                'value' => '',
                'amount' => 0,
            ],
            [
                'text' => 'Profit Amount',
                'value' => 'profit_amount',
                'amount' => 0,
            ],
            [
                'text' => 'Purchase Amount',
                'value' => 'purchase_amount',
                'amount' => 0,
            ],
            [
                'text' => 'Delivery Amount',
                'value' => 'delivery_amount',
                'amount' => 0,
            ],
            [
                'text' => 'Discount Amount',
                'value' => 'discount_amount',
                'amount' => 0,
            ],
            [
                'text' => 'Vat Amount',
                'value' => 'vat_amount',
                'amount' => 0,
            ],
            [
                'text' => 'Total Amount',
                'value' => 'total_amount',
                'amount' => 0,
            ],
        ];
    }


    public static function statusFilter(): array
    {
        return collect(Constant::DELIVERY_STATUS)->map(function ($data, $index) {
            return [
                'value' => array_keys(SaleDelivery::ORDER_STATUS)[$index],
                'text' => $data,
                'total' => 0,
            ];
        })->prepend([
            'value' => 'with_out_delivery_sale',
            'text' => 'Sale',
            'total' => 0,
        ])->prepend([
            'value' => '',
            'text' => 'Select Status',
            'total' => 0,
        ])->toArray();
    }

}
