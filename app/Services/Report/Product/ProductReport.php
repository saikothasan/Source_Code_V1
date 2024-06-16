<?php

namespace App\Services\Report\Product;

use App\Model\Branch;
use App\Model\Purchase_detail;
use App\Model\PurchaseReturnProduct;
use App\Model\Report;
use App\Model\Sale_detail;
use App\Model\SaleDelivery;
use App\Model\SaleReturnDetail;
use App\Model\Stock;
use App\Model\TransferReceive;
use App\Model\TransferReceiveDetail;
use App\Services\Report\ReportContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductReport
{
    public function productReportResource(): array
    {
        return [
            'resource' => json_encode([
                'branches' => getAllBranch(),
                'reportMode' => ReportContract::reportMode(),
                'fileMode' => ReportContract::fileMode(),
                'pieces' => self::selectPieces(),
                'history' => self::selectHistory(),
            ]),
        ];
    }

    public function generateReport(Request $request): array
    {
        $history = collect($request->history)->pluck('value');
        $filter = $request->selectedPiece['value'];
        $from_date = $request->get('from_date', '');
        $to_date = $request->get('to_date', '');

        if ($history->contains('purchase')) {
            if ($filter != 'returned') {
                $purchase_history = Purchase_detail::query()
                    ->whereProductBarcode($request->product['product_barcode'])
                    ->filterByDate($from_date, $to_date)
                    ->WhereIn('main_branch', self::pluckValue($request->selectedBranch, 'value'))
                    ->select('id', 'date', 'invoice', 'quantity')
                    ->get();
            }
            if ($filter === 'returned') {
                $purchase_returns = PurchaseReturnProduct::query()
                    ->whereProductBarcode($request->product['product_barcode'])
                    ->filterByDate($from_date, $to_date)
                    ->with('purchase')
                    ->WhereIn('branch_id', self::pluckValue($request->selectedBranch, 'value'))
                    ->get();
                foreach ($purchase_returns as $value) {
                    $purchase_history[] = [
                        'date' => $value['purchase']['created_at'],
                        'invoice' => $value['purchase']['invoice'],
                    ];
                }
            }
        }

        if ($history->contains('transfer')) {
            $transfer_history = TransferReceiveDetail::query()
                ->whereNull('transfer_receive_from')
                ->when($filter === 'returned', function ($query) {
                    $query->whereRelation('transfer', 'status', TransferReceive::STATUS['Reject']);
                })
                ->when($filter != 'returned', function ($query) {
                    $query->whereRelation('transfer', 'status', TransferReceive::STATUS['Transferred']);
                })
                ->whereHas('transfer', function ($query) use ($request) {
                    $query->where('status', TransferReceive::STATUS['Transferred'])
                        ->WhereIn('transfer_branch', self::pluckValue($request->selectedBranch, 'value'))
                        ->orWhereIn('receive_branch', self::pluckValue($request->selectedBranch, 'value'));
                })
                ->whereProductBarcode($request->product['product_barcode'])
                ->filterByDate($from_date, $to_date)
                ->select('id', 'date', 'invoice_code', 'quantity')
                ->get();
        }


        return self::reportFormat($request, [
            'purchase_history' => $purchase_history ?? null,
            'transfer_history' => $transfer_history ?? null,
            'selectPieces' => self::selectedPieces($request),
        ]);

    }

    public static function reportFormat($request, $query): array
    {
        return [
            'report_id' => Report::query()->generateReportId(),
            "created_at" => date('Y-m-d H:i:s'),
            'report_name' => Report::REPORT_TYPE['product_report'],
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
        return [
            'report_title' => self::totalReportTitle($request),
            'product' => $request->product,
            'purchase_history' => $query['purchase_history'],
            'transfer_history' => $query['transfer_history'],
            'selectPieces' => $query['selectPieces'],
        ];
    }

    public static function selectedPieces($request): array
    {
        $filter = $request->selectedPiece['value'];
        $from_date = $request->get('from_date', '');
        $to_date = $request->get('to_date', '');
        $selectPieces = [];
        if (!isset($filter) || $filter == 'sale') {
            $sales = Sale_detail::query()
                ->whereDoesntHave('sale.saleDeliveries')
                ->whereProductBarcode($request->product['product_barcode'])
                ->WhereIn('branch_id', self::pluckValue($request->selectedBranch, 'value'))
                ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date])
                ->sum('quantity');
            $selectPieces[] = [
                'title' => "Sale",
                'total_pcs' => $sales,
                'in_word' => "Total sale " . strtolower(numberToWords($sales)) . " pieces",
            ];
        }

        if (!isset($filter) || $filter == 'delivered') {
            $delivered = Sale_detail::query()
                ->whereHas('sale.saleDeliveries', function ($q) {
                    $q->where('order_status', '=', SaleDelivery::ORDER_STATUS['delivered']);
                })
                ->whereProductBarcode($request->product['product_barcode'])
                ->WhereIn('branch_id', self::pluckValue($request->selectedBranch, 'value'))
                ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date])
                ->sum('quantity');
            $selectPieces[] = [
                'title' => "Delivered",
                'total_pcs' => $delivered,
                'in_word' => "Total delivered " . strtolower(numberToWords($delivered)) . " pieces",
            ];
        }

        if (!isset($filter) || $filter == 'pending') {
            $pending = Sale_detail::query()
                ->whereRelation('sale.saleDeliveries', 'order_status', SaleDelivery::ORDER_STATUS['pending'])
                ->whereProductBarcode($request->product['product_barcode'])
                ->WhereIn('branch_id', self::pluckValue($request->selectedBranch, 'value'))
                ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date])
                ->sum('quantity');
            $selectPieces[] = [
                'title' => "Pending",
                'total_pcs' => $pending,
                'in_word' => "Total pending " . strtolower(numberToWords($pending)) . " pieces",
            ];
        }
        if (!isset($filter) || $filter == 'returned') {
            $returned = SaleReturnDetail::query()
                ->whereProductBarcode($request->product['product_barcode'])
                ->WhereIn('branch_id', self::pluckValue($request->selectedBranch, 'value'))
                ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date])
                ->sum('quantity');
            $selectPieces[] = [
                'title' => "Returned",
                'total_pcs' => $returned,
                'in_word' => "Total Returned " . strtolower(numberToWords($returned)) . " pieces",
            ];
        }

        if (!isset($filter) || $filter == 'available') {
            $available = Stock::query()
                ->stockProduct()
                ->whereProductBarcode($request->product['product_barcode'])
                ->WhereIn('current_branch', self::pluckValue($request->selectedBranch, 'value'))
                ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date])
                ->count('id');
            $selectPieces[] = [
                'title' => "Available",
                'total_pcs' => $available,
                'in_word' => "Total available " . strtolower(numberToWords($available)) . " pieces",
            ];
        }
        return $selectPieces;
    }

    private static function totalReportTitle($request): string
    {
        return "This report is generated by " . auth()->user()->name . " & Showing " . $request['selectedPiece']['text'] . " Report Mode is " . $request['selectedReportMode']['text'];
    }


    public static function individualFormat($request, $query)
    {
        $filter = $request->selectedPiece['value'];
        $from_date = $request->get('from_date', '');
        $to_date = $request->get('to_date', '');
        $data = [];
        if (!isset($filter) || $filter == 'sale') {
            $data['sale'] = Sale_detail::query()
                ->with(['sale:id,invoice_code,created_at,seller_id', 'sale.seller:id,name', 'branch:id,name'])
                ->whereDoesntHave('sale.saleDeliveries')
                ->whereIn('branch_id', self::pluckValue($request->selectedBranch, 'value'))
                ->whereProductBarcode($request->product['product_barcode'])
                ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date])
                ->get();
        }

        if (!isset($filter) || $filter == 'delivered') {
            $data['delivered_pieces'] = Sale_detail::query()
                ->with(['sale:id,invoice_code,created_at,seller_id', 'sale.seller:id,name', 'branch:id,name'])
                ->whereHas('sale.saleDeliveries', function ($q) {
                    $q->where('order_status', '=', SaleDelivery::ORDER_STATUS['delivered']);
                })
                ->whereIn('branch_id', self::pluckValue($request->selectedBranch, 'value'))
                ->whereProductBarcode($request->product['product_barcode'])
                ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date])
                ->get();
        }

        if (!isset($filter) || $filter == 'pending') {
            $data['pending'] = Sale_detail::query()
                ->with(['sale:id,invoice_code,created_at,seller_id', 'sale.seller:id,name', 'branch:id,name'])
                ->whereHas('sale.saleDeliveries', function ($q) {
                    $q->where('order_status', '=', SaleDelivery::ORDER_STATUS['pending']);
                })
                ->whereIn('branch_id', self::pluckValue($request->selectedBranch, 'value'))
                ->whereProductBarcode($request->product['product_barcode'])
                ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date])
                ->get();
        }

        if (!isset($filter) || $filter == 'returned') {
            $data['returned'] = SaleReturnDetail::query()
                ->with(['sale:id,invoice_code,created_at,seller_id', 'sale.seller:id,name', 'branch:id,name'])
                ->whereIn('branch_id', self::pluckValue($request->selectedBranch, 'value'))
                ->whereProductBarcode($request->product['product_barcode'])
                ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date])
                ->get();
        }

        if (!isset($filter) || $filter == 'available') {
            $data['available'] = Branch::query()
                ->withSum(['transferProducts as transfer_quantity' => function ($query) use ($request, $from_date, $to_date) {
                    $query->whereNull('transfer_receive_from')
                        ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date])
                        ->whereProductBarcode($request->product['product_barcode']);
                }], 'quantity')
                ->withCount(['stocks as available_quantity' => function ($query) use ($request, $from_date, $to_date) {
                    $query->stockProduct()->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date])
                        ->whereProductBarcode($request->product['product_barcode']);
                }], 'id')
                ->whereIn('id', self::pluckValue($request->selectedBranch, 'value'))
                ->get();
        }
        return $data;
    }

    public static function selectPieces(): array
    {
        return [
            [
                'text' => 'Select Pieces',
                'value' => '',
                'total' => 0
            ],
            [
                'text' => 'Sale',
                'value' => 'sale',
                'total' => 0,
                'inward' => "",
            ],
            [
                'text' => 'Delivered',
                'value' => 'delivered',
                'total' => 0,
                'inward' => "",
            ],
            [
                'text' => 'Pending',
                'value' => 'pending',
                'total' => 0,
                'inward' => "",
            ],
            [
                'text' => 'Return',
                'value' => 'returned',
                'total' => 0,
                'inward' => "",
            ],
            [
                'text' => 'Available',
                'value' => 'available',
                'total' => 0,
                'inward' => "",
            ]
        ];
    }

    public static function selectHistory(): array
    {
        return [
            [
                'text' => 'Purchase',
                'value' => 'purchase',
                'total' => 0
            ],
            [
                'text' => 'Transfer',
                'value' => 'transfer',
                'total' => 0
            ],
        ];
    }

    public static function pluckValue($array, $column): array
    {
        return collect($array)->pluck($column)->toArray();
    }

}
