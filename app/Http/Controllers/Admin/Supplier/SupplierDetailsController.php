<?php

namespace App\Http\Controllers\Admin\Supplier;

use App\Http\Controllers\Controller;
use App\Model\Bank;
use App\Model\BankTransfer;
use App\Model\PaymentMethod;
use App\Model\Purchase;
use App\Model\PurchasePayment;
use App\Model\SaleDelivery;
use App\Model\Stock;
use App\Model\Supplier;
use App\Services\SupplierService;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;


class SupplierDetailsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('admin');
        // $this->middleware('supplier');
    }


    public function index($id)
    {

        $purchases = Purchase::where('supplier_id', $id)
            ->withCount('purchaseDetails')->get();
        return view('supplier.pages.purchase', compact('purchases'));
    }

    public function product($id)
    {
        $supplier_info = Supplier::findOrFail($id);
        $products = Stock::query()
            ->with([
                'product:id,name,is_active,sell_price,buy_price',
                'productVariations.variantValues.variantValueName'
            ])
            ->select(
                'stocks.*',
                \Illuminate\Support\Facades\DB::raw('count(current_branch) as total_quantity'),
                DB::raw('SUM(stock_status=0 && sale_detail_id IS NOT NULL && sale_id IS NOT NULL) as total_sale'),
                DB::raw('SUM(stock_status=1 && sale_detail_id IS NULL && sale_id IS NULL && transfer_id IS NULL) as available_stock')
            )
            ->where('supplier_id', $id)->groupBy(['product_barcode']);

        $productsClone = clone $products;
        $productsClone = $productsClone->get();
        $total_items = collect($productsClone)->unique('product_sku')->count();
        $total_quantity = collect($productsClone)->sum('total_quantity');
        $sell_total = collect($productsClone)->sum('total_sale');
        $available_total = ($total_quantity - $sell_total);
        $products = $products->paginate(100);

        return view('supplier.pages.product', [
            'supplier_info' => $supplier_info,
            'products' => $products,
            'total_items' => $total_items,
            'total_quantity' => $total_quantity,
            'sell_total' => $sell_total,
            'available_total' => $available_total,
        ]);
    }

    public function stock($id)
    {

        $supplier_info = Supplier::findOrFail($id);
        $products = Stock::with(['purchaseDetail', 'purchaseDetail.product.brand', 'branch'])
            ->select(
                'stocks.*',
                DB::raw('count(current_branch) as total_quantity'),
                DB::raw('SUM(stock_status=0 && sale_detail_id IS NOT NULL && sale_id IS NOT NULL) as total_sale'),
                DB::raw('SUM(stock_status=1 && sale_detail_id IS NULL && sale_id IS NULL && transfer_id IS NULL) as available_stock')
            )
            ->where('supplier_id', $id)->groupBy('current_branch')->get();
        //  dd($products);
        return view('supplier.pages.stockPosition', compact('products', 'supplier_info'));
    }


    public function payable(Request $request, $id)
    {
        $supplier_info = Supplier::findOrFail($id);
        $from_date = $request->get('from_date', '');
        $to_date = $request->get('to_date', '');
        $purchases = Purchase::query()
            ->where('supplier_id', $id)
            ->withCount(['stocks as total_sell' => function ($query) use ($from_date, $to_date) {
                $query->where('stock_status', Stock::STATUS['Sale'])
                    ->whereNotNull('sale_id')
                    ->whereNotNull('sale_detail_id')
                    ->WhereHas('saleDetails', function ($sale) use ($from_date, $to_date) {
                        $sale->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date]);
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
                    'id' => $data->id,
                    'date' => $data->date,
                    'user_id' => $data->user_id,
                    'supplier_id' => $data->supplier_id,
                    'invoice' => $data->invoice,
                    'total_items' => $data->purchase_details_count,
                    'total_quantity' => $data->total_quantity,
                    'total_sell' => $data->total_sell,
                    'subtotal' => $data->subtotal,
                    'total_payable' => $amount,
                    'advance_payment' => (int)$data->advanced_payment,
                    'total_due' => $data->purchase_due_sum_due_total,
                    'total_paid' => $data->purchase_due_sum_paid_total,
                    'pay_amount' => 0,
                    'due_amount' => 0,
                ];
            });

        $senderAccount = Bank::where('branch_id', auth()->user()->branch_id)
            ->where('is_main_bank', 1)
            ->get();

        $supplier_banks = Bank::where('user_id', $supplier_info->user_id)->get();

        $resource = [
            'purchases' => $purchases,
            'supplier_info' => $supplier_info,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'senderAccount' => $senderAccount,
            'supplierBanks' => $supplier_banks,
        ];
        return view('supplier.pages.payable', $resource);
    }


    public function viewPayment(Request $request, $id)
    {
        $supplier_info = Supplier::findOrFail($id);
        $purchasePayments = PurchasePayment::query()
            ->filterByDate($request->get('from-date'), $request->get('to-date'))
            ->where('supplier_id', $id)
            ->withSum('paidAmount', 'total_pay')
            ->latest()
            ->paginate(100);
        return view('supplier.pages.payment', compact('purchasePayments', 'supplier_info'));
    }

    public function singlePayment($id)
    {
        $purchasePayment = SupplierService::purchasePaymentInvoice($id);
        return view('supplier.pages.payment-view', compact('purchasePayment'));
    }
}
