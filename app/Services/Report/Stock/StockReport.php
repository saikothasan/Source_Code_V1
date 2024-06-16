<?php

namespace App\Services\Report\Stock;

use App\Model\Report;
use App\Model\Stock;
use App\Services\Report\ReportContract;
use App\Services\Report\Sale\SalesReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockReport
{
    public function stockReportResource(): array
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
                'reportMode' => ReportContract::reportMode(),
                'fileMode' => ReportContract::fileMode(),
                'prices' => ReportContract::selectPrice(),
                'pieces' => ReportContract::selectPieces(),
            ]),
        ];
    }

    public function generateReport(Request $request): array
    {
        $from_date = $request->get('from_date', '');
        $to_date = $request->get('to_date', '');
        $stocks = Stock::query()
            ->filterByDate($from_date, $to_date)
            ->WhereIn('current_branch', self::pluckValue($request->selectedBranch, 'value'))
            ->select(DB::raw('stocks.*,
                COUNT(stocks.id) as total_pieces,
                SUM(stock_status=0 && sale_detail_id IS NOT NULL && sale_id IS NOT NULL) as sell_pieces,
                SUM(stock_status=1 && sale_detail_id IS NULL && sale_id IS NULL && transfer_id IS NULL) as available_pieces,
                SUM(stock_status=0 && sale_detail_id IS NOT NULL && sale_id IS NOT NULL)*sell_price as total_sell_price,
                SUM(stock_status=1 && sale_detail_id IS NULL && sale_id IS NULL && transfer_id IS NULL)*buy_price as purchase_price,
                (CASE WHEN (SUM(stock_status=0 && sale_detail_id IS NOT NULL && sale_id IS NOT NULL)*sell_price-COUNT(stocks.id)*buy_price>0)
                THEN SUM(stock_status=0 && sale_detail_id IS NOT NULL && sale_id IS NOT NULL)*sell_price-COUNT(stocks.id)*buy_price ELSE "0" END)
                as profit_price
            '))
            ->when($request->selectedPiece['value'] === 'sell_pieces', function ($q) use ($request) {
                $q->selectRaw('SUM(stock_status=0 && sale_detail_id IS NOT NULL && sale_id IS NOT NULL)*buy_price as purchase_price');
            })
            ->WhereHas('product', function ($q) use ($request) {
                $q->WhereIn('category_id', self::pluckValue($request->selectedCategory, 'value'))
                    ->WhereIn('supplier_id', self::pluckValue($request->selectedSupplier, 'value'))
                    ->WhereIn('brand_id', self::pluckValue($request->selectedBrand, 'value'));
            })
            ->when($request->items, function ($q) use ($request) {
                $q->WhereIn('product_barcode', self::pluckValue($request->items, 'value'));
            })
            ->when($request->selectedReportMode['value'] == "individual_pieces", function ($q) {
                $q->with(['product' => [
                    'category:id,name',
                    'brand:id,name',
                    'supplier:id,name',
                ], 'productVariations.variantValues.variantValueName']);
            })
            ->groupBy('product_barcode')
            ->having('available_pieces' , '>' , 0)
            ->get();
//        return  collect($stocks)->toArray();
        return self::reportFormat($request, [
            'stocks' => $stocks,
        ]);

    }

    public static function reportFormat($request, $query): array
    {
        return [
            'report_id' => Report::query()->generateReportId(),
            "created_at" => date('Y-m-d H:i:s'),
            'report_name' => Report::REPORT_TYPE['stock_report'],
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'description' => $request->description,
            'details' => [
                'generator_name' => auth()->user()->name,
                'report_mode' => $request->get('selectedReportMode'),
                'report_file_mode' => $request->get('report_file_mode'),
                'branch' => $request->get('selectedBranch'),
                'category' => $request->get('selectedCategory'),
                'supplier' => $request->get('selectedSupplier'),
                'brand' => $request->get('selectedBrand'),
                'sellers' => $request->get('selectedSeller'),
                'total_pieces' => self::totalPiecesFormat($request, $query),
                'individual_pieces' => $request->selectedReportMode['value'] == "individual_pieces"
                    ? self::individualFormat($request, $query) : null,
            ],
        ];
    }

    public static function totalPiecesFormat($request, $query): array
    {
        $stocks = collect($query['stocks']);

        $inWords = "Total Sell " . numberToWords($stocks->sum('sell_pieces')) . " pieces & \n" .
            "Total Purchase " . numberToWords($stocks->sum('purchase_price'));
        $stock_pieces = collect(ReportContract::selectPieces())
            ->whereNotIn('text', ['Select Pieces'])
            ->when($request->selectedPiece['value'], function ($data) use ($request) {
                return $data->where('value', $request->selectedPiece['value']);
            })
            ->map(function ($data) use ($stocks) {
                return [
                    'value' => $data['value'],
                    'text' => $data['text'],
                    'total' => $stocks->sum($data['value'])
                ];
            })->toArray();

        $stock_prices = collect(ReportContract::selectPrice())
            ->whereNotIn('text', ['Select Price'])
            ->when($request->selectedPrice['value'], function ($data) use ($request) {
                return $data->where('value', $request->selectedPrice['value']);
            })
            ->map(function ($data) use ($stocks) {
                return [
                    'value' => $data['value'],
                    'text' => $data['text'],
                    'total' => $stocks->sum($data['value'])
                ];
            });
        $column = self::totalReportColumn();
        $column_row_data = [];
        foreach ($column as $value) {
            $column_row_data[$value['key']] = collect(self::piecesReportColumnValue($request, $value['key']))->implode('<br/>');
        }

        return [
            'report_title' => self::totalReportTitle($request),
            'stock_pieces' => $stock_pieces,
            'stock_prices' => $stock_prices,
            'inWords' => $inWords,
            'column' => $column,
            'column_row_data' => $column_row_data,
        ];
    }


    public static function individualFormat($request, $query): array
    {
        $stocks = $query['stocks'];
        $columns = self::individualColumn();


        $columns = collect($columns)->concat(
            collect(ReportContract::selectPieces())
                ->whereNotIn('text', ['Select Pieces'])
                ->when($request->selectedPiece['value'], function ($data) use ($request) {
                    return $data->where('value', $request->selectedPiece['value']);
                })
                ->map(function ($data) use ($stocks) {

                    return [
                        'title' => $data['text'],
                        'key' => $data['value'],
                        'class' => 'text-center',
                    ];
                })->toArray()
        );

        $columns = collect($columns)->concat(
            collect(ReportContract::selectPrice())
                ->whereNotIn('text', ['Select Price', 'Sell Price', 'Profit Price'])
                ->when($request->selectedPrice['value'], function ($data) use ($request) {
                    return $data->where('value', $request->selectedPrice['value']);
                })
                ->map(function ($data) use ($stocks) {
                    return [
                        'title' => $data['text'],
                        'key' => $data['value'],
                        'class' => 'text-center',
                    ];
                })->toArray()
        );


        $column_row_data = [];
        foreach ($stocks->chunk(500) as $chunk) {
            foreach ($chunk as $index => $stock_value) {
                $column_row_data[] = self::addingIndividualRow($columns, $index, $stock_value);
            }
        }

        return [
            'columns' => $columns,
            'column_row_data' => $column_row_data,
        ];
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
        return "This report is generated with " . $request['selectedPrice']['text'] . " of " . $request['selectedPiece']['text'] . " & Report Mode is " . $request['selectedReportMode']['text'];
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
            'total_sell_price' => number_format($stock->total_sell_price) . get_settings('currency_symbol'),
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
