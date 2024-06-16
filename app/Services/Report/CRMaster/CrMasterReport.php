<?php

namespace App\Services\Report\CRMaster;

use App\Model\Bank;
use App\Model\Branch;
use App\Model\Report;
use App\Services\Report\ReportContract;
use App\Services\Report\Sale\SalesReport;
use Illuminate\Http\Request;

class CrMasterReport
{
    public function crReportReportResource(): array
    {
        return [
            'resource' => json_encode([
                'branches' => collect(getAllBranch())
                    ->prepend([
                        'text' => 'Select Branch',
                        'value' => ''
                    ]),
                'reportMode' => collect(ReportContract::reportMode())->where('value', '!=', 'individual_pieces')->toArray(),
                'fileMode' => ReportContract::fileMode(),
            ]),
        ];
    }

    public function generateReport(Request $request): array
    {
        $from_date = $request->get('from_date', '');
        $to_date = $request->get('to_date', '');

        $banks = Bank::query()
            ->when($request->selectedBranch['value'], function ($query) use ($request) {
                $query->where('branch_id', $request->selectedBranch['value']);
            })
            ->whereNotNull('branch_id')
            ->select('id', 'name', 'account_no')
            ->withSum(['bankTransfers as total_amount' => function ($query) use ($from_date, $to_date) {
                $query->whereBetween('date', [$from_date, $to_date]);
            }], 'paid')
            ->get();

        $branches = Branch::query()
            ->when($request->selectedBranch['value'], function ($query) use ($request) {
                $query->where('id', $request->selectedBranch['value']);
            })
            ->select('id', 'name')
            ->crMasterReport($request)
            ->orderBy('id', 'asc')
            ->get();

        return self::reportFormat($request, [
            'banks' => $banks,
            'branches' => $branches
        ]);

    }

    public static function reportFormat($request, $query): array
    {
        return [
            'report_id' => Report::query()->generateReportId(),
            "created_at" => date('Y-m-d H:i:s'),
            'report_name' => Report::REPORT_TYPE['cr_master_report'],
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'description' => $request->description,
            'details' => [
                'generator_name' => auth()->user()->name,
                'report_mode' => $request->get('selectedReportMode'),
                'report_file_mode' => $request->get('report_file_mode'),
                'branch' => $request->get('selectedBranch'),
                'total_pieces' => self::totalPiecesFormat($request, $query),
                'individual_pieces' => $request->selectedReportMode['value'] == "individual_pieces"
                    ? self::individualFormat($request, $query) : null,
            ],
        ];
    }

    public static function totalPiecesFormat($request, $query): array
    {
        $sales_details = [];
        $cost_details = [];
        $profit_details = [];
        $others_cost = [];
        foreach ($query['branches'] as $value) {
            $total_amount = $value['sale_total'] + $value['sale_exchange_total'];
            $sales_details['branch'][] = [
                'id' => $value['id'],
                'name' => $value['name'],
                'sale_pcs' => $value['sale_pcs'],
                'return_pcs' => $value['return_pcs'],
                'exchange_pcs' => $value['exchange_pcs'],
                'total_amount' => $total_amount,
                'payment_method' => 'All Payment Method'
            ];

            $total_cost = $value['daily_cost'] + $value['monthly_cost'] + $value['one_time_cost'] + $value['sales_product_purchase'];

            $cost_details['branch'][] = [
                'id' => $value['id'],
                'name' => $value['name'],
                'daily_cost' => $value['daily_cost'],
                'monthly_cost' => $value['monthly_cost'],
                'one_time_cost' => $value['one_time_cost'],
                'sales_product_purchase' => $value['sales_product_purchase'],
                'total_cost' => $total_cost,
            ];

            $profit_details['branch'][] = [
                'id' => $value['id'],
                'name' => $value['name'],
                'total_profit' => ($total_amount - (
                        $total_cost
                        + $value['return_delivery_cost']
                        + $value['exchange_delivery_cost']
                        + $value['discount_amount']
                        + $value['flat_discount']))
            ];
        }
        $branches = collect($query['branches']);

        $others_cost['normal_delivery_cost'] = $branches->sum('normal_delivery_cost');
        $others_cost['return_delivery_cost'] = $branches->sum('return_delivery_cost');
        $others_cost['exchange_delivery_cost'] = $branches->sum('exchange_delivery_cost');
        $others_cost['discount'] = $branches->sum('discount_amount') + $branches->sum('flat_discount');
        $others_cost['total_other_cost'] = $others_cost['return_delivery_cost'] + $others_cost['exchange_delivery_cost'] + $others_cost['discount'];

        $total_sales = collect($sales_details['branch'])->sum('total_amount');
        $total_cost = collect($cost_details['branch'])->sum('total_cost') + $others_cost['total_other_cost'];
        $sales_details['total_pieces'] = collect($sales_details['branch'])->sum('sale_pcs');
        $sales_details['total_amount'] = $total_sales;
        $sales_details['total_return_pcs'] = collect($sales_details['branch'])->sum('return_pcs');
        $sales_details['total_exchange_pcs'] = collect($sales_details['branch'])->sum('exchange_pcs');
        $cost_details['total_cost'] = $total_cost;
        $total_profit = $total_sales - $total_cost;

        return [
            'report_title' => self::totalReportTitle($request),
            'sales_details' => $sales_details,
            'cost_details' => $cost_details,
            'profit_details' => $profit_details,
            'others_cost' => $others_cost,
            'total_sales' => $total_sales,
            'total_cost' => $total_cost,
            'total_profit' => $total_profit,
            'bank_balance' => collect($query['banks'])->toArray(),
        ];
    }


    public static function individualFormat($request, $query)
    {
//        $stocks = $query['stocks'];
//        $columns = self::individualColumn();
//
//
//        $columns = collect($columns)->concat(
//            collect(ReportContract::selectPieces())
//                ->whereNotIn('text', ['Select Pieces'])
//                ->when($request->selectedPiece['value'], function ($data) use ($request) {
//                    return $data->where('value', $request->selectedPiece['value']);
//                })
//                ->map(function ($data) use ($stocks) {
//                    return [
//                        'title' => $data['text'],
//                        'key' => $data['value'],
//                        'class' => 'text-center',
//                    ];
//                })->toArray()
//        );
//
//        $columns = collect($columns)->concat(
//            collect(ReportContract::selectPrice())
//                ->whereNotIn('text', ['Select Price'])
//                ->when($request->selectedPrice['value'], function ($data) use ($request) {
//                    return $data->where('value', $request->selectedPrice['value']);
//                })
//                ->map(function ($data) use ($stocks) {
//                    return [
//                        'title' => $data['text'],
//                        'key' => $data['value'],
//                        'class' => 'text-center',
//                    ];
//                })->toArray()
//        );
//
//        $column_row_data = [];
//        foreach ($stocks->chunk(500) as $chunk) {
//            foreach ($chunk as $index => $stock_value) {
//                $column_row_data[] = self::addingIndividualRow($columns, $index, $stock_value);
//            }
//        }
//
//        return [
//            'columns' => $columns,
//            'column_row_data' => $column_row_data,
//        ];
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

    private static function totalReportTitle($request): string
    {
        return "This Report Mode Is " . $request->selectedReportMode['text'];
    }

    public static function addingIndividualRow($columns, $index, $product): array
    {
        $data = [];
        foreach ($columns as $value) {
            $data[$value['key']] = self::indIndividualRowValue($value['key'], $index, $product);
        }
        return $data;
    }

    public static function indIndividualRowValue($key, $index, $stock)
    {
        return [
            'sl_no' => $index + 1,
            'product_name' => self::productName($stock),
            'suppliers' => $stock->product->supplier->name ?? '',
            'category' => $stock->product->category->name ?? '',
            'brands' => $stock->product->brand->name ?? '',
            'sell_pieces' => number_format($stock->sell_pieces) . ' pcs',
            'available_pieces' => number_format($stock->available_pieces) . ' pcs',
            'total_sell_price' => number_format($stock->total_sell_price) . ' pcs',
            'purchase_price' => number_format($stock->purchase_price) . get_settings('currency_symbol'),
            'profit_price' => number_format($stock->profit_price) . get_settings('currency_symbol'),
        ][$key];
    }

    public static function productName($stock)
    {
        $product_name = $stock->product->name;
        if (isset($stock->productVariations)) {
            $product_name = $stock->product->name . '-' . collect($stock->productVariations->variantValues)
                    ->pluck('variantValueName.variation_value')
                    ->implode('-');
        }
        return $product_name;
    }


    public static function individualColumn(): array
    {
        return [
            [
                'title' => 'S.No.',
                'key' => 'sl_no',
                'class' => 'text-center',
            ],
            [
                'title' => 'Product Name',
                'key' => 'product_name',
                'class' => 'text-left',
            ],
            [
                'title' => 'Suppliers',
                'key' => 'suppliers',
                'class' => 'text-center',
            ],
            [
                'title' => 'Category',
                'key' => 'category',
                'class' => 'text-center',
            ],
            [
                'title' => 'Brands',
                'key' => 'brands',
                'class' => 'text-center',
            ]
        ];
    }


    public static function pluckValue($array, $column): array
    {
        return collect($array)->pluck($column)->toArray();
    }


}
