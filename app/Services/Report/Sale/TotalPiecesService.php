<?php

namespace App\Services\Report\Sale;

use Illuminate\Support\Arr;

class TotalPiecesService
{
    public static function totalReportFormat($request, $query): array
    {
        $return_delivery_amount = 0;
        $status_filter = $request->select_status['value'];
        if (!isset($status_filter) || $status_filter == 'returned') {
            $return_delivery_amount = collect($query['sale_return'])->unique('sale_id')->pluck('sale')->sum('delivery_charge');
            $amount['return_delivery_amount'] = -$return_delivery_amount;
            $amount['return_total_amount'] = -collect($query['sale_return'])->unique('sale_return_id')->pluck('saleReturn')->sum('return_total');
        }
        if (!isset($status_filter) || $status_filter == 'cancelled') {
            $amount['cancel_total_amount'] = collect($query['sale_cancelled'])->sum('net_total');
        }
        $uniqueSales = collect($query['total_pieces'])->unique('sale_id');
        $uniqueExchange = collect($query['total_pieces'])->unique('sale_exchange_id')->pluck('exchange');
        $exchange_delivery_charge = $uniqueExchange->sum('delivery_charge');
        $amount['delivery_amount'] = collect($uniqueSales)->pluck('sale')->sum('delivery_charge') + $exchange_delivery_charge;
        $amount['discount_amount'] = collect($query['total_pieces'])->sum('discount_total') + collect($query['total_pieces'])->sum('flat_discount_total');
        $sales_pieces = collect($query['total_pieces'])->sum('sales_pieces');
        $amount['sale_price'] = collect($query['total_pieces'])->sum('total_sale_price');
        $amount['purchase_amount'] = collect($query['total_pieces'])->sum('total_buy_price');
        $amount['profit_amount'] = $amount['sale_price'] - ($amount['purchase_amount'] + $return_delivery_amount);
        $amount['vat_amount'] = collect($query['total_pieces'])->sum('vat_total');
        $amount['total_amount'] = ($amount['purchase_amount'] + $amount['profit_amount'] + $amount['delivery_amount']+$amount['vat_amount']) - $amount['discount_amount'];
        $column = self::totalReportColumn();
        if ($request->selectedSeller['value']) {
            $column = array_merge($column, [[
                'title' => 'Seller',
                'key' => 'sellers'
            ]]);
        }
        $column_row_data = [];
        foreach ($column as $value) {
            $column_row_data[$value['key']] = collect(self::piecesReportColumnValue($request, $value['key']))->implode('<br/>');
        }

        $format_result = [
            'report_title' => self::totalReportTitle($request),
            'sales_pieces' => $sales_pieces,

            'column' => $column,
            'column_row_data' => $column_row_data,
        ];
        if ($request->selectedAmountType['value'] && $status_filter != 'returned' && $status_filter != 'cancelled') {
            $amount_type = $request->selectedAmountType;
            $amount_type = Arr::set($amount_type, 'amount', $amount[$request->selectedAmountType['value']]);
            $format_result = array_merge($format_result, ['amount_type' => $amount_type]);
        } else {
            if ($request->select_status['value'] == 'returned') {
                $amount_types_list = [
                    [
                        "text" => "Returned Delivery Amount",
                        "value" => "return_delivery_amount",
                        'class' => 'text-red',
                        "amount" => 0
                    ], [
                        "text" => "Returned Total Amount",
                        "value" => "return_total_amount",
                        'class' => 'text-red',
                        "amount" => 0
                    ],
                ];
            } elseif ($request->select_status['value'] == 'cancelled') {
                $amount_types_list = [[
                    "text" => "Cancelled Total Amount",
                    "value" => "cancel_total_amount",
                    'class' => 'text-red',
                    "amount" => 0
                ],
                ];
            } elseif ($request->select_status['value'] == '' || $request->select_status['value'] == 'returned') {
                $amount_types_list = collect(SalesReport::amountType())->whereNotIn('text', ['Select Amount'])->prepend([
                    "text" => "Returned Delivery Amount",
                    "value" => "return_delivery_amount",
                    'class' => 'text-red',
                    "amount" => 0
                ])->toArray();
            } else {
                $amount_types_list = collect(SalesReport::amountType())->whereNotIn('text', ['Select Amount'])->toArray();
            }
            $format_result = array_merge($format_result, [
                'amount_types' => $amount,
                'amount_types_list' => $amount_types_list,
            ]);
        }
        if ($request->select_status['value']) {
            $status_name = collect(SalesReport::statusFilter())->where('value', $request->select_status['value']);
            $status_name = $status_name->map(function ($data) use ($uniqueSales, $query) {
                $total = collect($uniqueSales)->pluck('sale')->sum($data['value']);
                if ($data['value'] == 'returned') {
                    $total = collect($query['sale_return'])->sum('returned');
                }
                if ($data['value'] == 'cancelled') {
                    $total = collect($query['sale_cancelled'])->sum('sales_pieces');
                }
                if ($data['value'] == 'pending') {
                    $total = collect($query['sale_pending'])->sum('sales_pieces');
                }
                if ($data['value'] == 'delivered') {
                    $total = collect($query['sale_delivered'])->sum('sales_pieces');
                }
                return [
                    'value' => $data['value'],
                    'text' => $data['text'],
                    'total' => $total
                ];
            })->toArray();
            $format_result = array_merge($format_result, [
                'status_filter' => $status_name,
            ]);
        } else {
            $status_name = collect(SalesReport::statusFilter())->whereNotIn('text', ['Select Status']);
            $status_name = $status_name->map(function ($data) use ($uniqueSales, $query) {
                $total = collect($uniqueSales)->pluck('sale')->sum($data['value']);
                if ($data['value'] == 'returned') {
                    $total = collect($query['sale_return'])->sum('returned');
                }
                if ($data['value'] == 'cancelled') {
                    $total = collect($query['sale_cancelled'])->sum('sales_pieces');
                }
                if ($data['value'] == 'pending') {
                    $total = collect($query['sale_pending'])->sum('sales_pieces');
                }
                if ($data['value'] == 'delivered') {
                    $total = collect($query['sale_delivered'])->sum('sales_pieces');
                }
                return [
                    'value' => $data['value'],
                    'text' => $data['text'],
                    'total' => $total
                ];
            })->toArray();

            $format_result = array_merge($format_result, [
                'status_filter' => $status_name,
            ]);
        }
        return $format_result;

    }


    private static function piecesReportColumnValue($request, $key): array
    {
        $data = [
            'suppliers' => SalesReport::pluckValue($request->selectedSupplier, 'text'),
            'branches' => SalesReport::pluckValue($request->selectedBranch, 'text'),
            'brands' => SalesReport::pluckValue($request->selectedBrand, 'text'),
            'categories' => SalesReport::pluckValue($request->selectedCategory, 'text'),
            'sellers' => SalesReport::pluckValue([$request->selectedSeller], 'text'),
        ];
        return $data[$key];
    }


    private static function totalReportTitle($request): string
    {
        $sellers = "";
        if (isset($request['selectedSeller']['value'])) {
            $sellers = "Sellers" . $request['selectedSeller']['text'];
        }
        return "This report is generated with this " . $request['selectedPaymentMethod']['value'] . "
                payment Method, " . $sellers . " & Only Showing " . $request['selectedAmountType']['text'] . "
                Report Mode is
               " . $request['selectedReportMode']['text'] . "
                ";
    }

    public static function totalReportColumn(): array
    {
        return [
            [
                'title' => 'Suppliers',
                'key' => 'suppliers'
            ],
            [
                'title' => 'Branches',
                'key' => 'branches'
            ],
            [
                'title' => 'Categories',
                'key' => 'categories'
            ],
            [
                'title' => 'Brands',
                'key' => 'brands'
            ],
        ];
    }
}
