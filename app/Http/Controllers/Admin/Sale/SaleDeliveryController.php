<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Model\Sale;
use App\Model\Sale_detail;
use App\Model\Sale_return;
use App\Model\SaleDelivery;
use App\Model\SaleReturnDetail;
use App\Model\SaleReturnPurchaseHistory;
use App\Model\Stock;
use App\Services\PathaoService;
use App\Services\SaleDeliveryService;
use App\Services\SaleService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SaleDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        //return SaleDeliveryService::saleDeliveryList($request);
        return view('admin.sale.sale-delivery-list', SaleDeliveryService::saleDeliveryList($request));
    }

    public function update(Request $request, $sale_delivery_id)
    {
        try {
            $user = auth()->user();
            $saleDelivery = SaleDelivery::query()
                ->where('order_status', SaleDelivery::ORDER_STATUS['pending'])
                ->where('id', $sale_delivery_id)
                ->first();
            $sale_id = $saleDelivery->sale_id;

            $sale = Sale::with('saleDetails')
                ->withSum('saleDetails as return_total_amount', 'net_total')
                ->with('salePayment')
                ->findOrFail($sale_id);
            if ($request->get('status') == 'Delivered') {
                DB::beginTransaction();
                SaleDeliveryService::saleCODPayment($saleDelivery, $sale);
                $saleDelivery->update(['order_status' => SaleDelivery::ORDER_STATUS['delivered']]);
                DB::commit();
                Session::flash('message', 'Sale status change to delivered!');
                return redirect()->back();
            } else if ($request->get('status') == "Returned") {
                DB::beginTransaction();
                $sale_return = new Sale_return();
                $sale_return->return_type = Sale_return::RETURN_TYPE['return'];
                $sale_return->return_date = date('Y-m-d');
                $sale_return->sale_id = $sale->id;
                $sale_return->user_id = $user->id;
                $sale_return->branch_id = $sale->branch_id;
                $sale_return->customer_id = $sale->customer_id;
                $sale_return->vat_percentage = $sale->vat_percentage;
                $sale_return->vat_amount = $sale->vat_amount;
                $sale_return->discount_percentage = $sale->discount_percentage;
                $sale_return->discount_amount = $sale->discount_amount;
                $sale_return->flat_discount = $sale->flat_discount;
                $sale_return->return_total = $sale->return_total_amount;
                $sale_return->return_amount = $sale->return_total_amount;
                $sale_return->save();


                $sale->vat_amount = 0.00;
                $sale->discount_percentage = 0.00;
                $sale->discount_amount = 0.00;
                $sale->net_total = 0.00;
                $sale->final_total = ($sale->final_total - $sale->return_total_amount);
                $sale->return_total = $sale->return_total_amount;
                $sale->save();

                foreach ($sale->saleDetails as $value) {
                    $sale_return_products = new SaleReturnDetail();
                    $product_data = [
                        'return_type' => SaleReturnDetail::RETURN_TYPE['return'],
                        'sale_return_id' => $sale_return->id,
                        'sale_id' => $sale->id,
                        'user_id' => $user->id,
                        'customer_id' => $sale->customer_id,
                        'branch_id' => $value['branch_id'],
                        'vat_total' => $value['vat_total'],
                        'discount_total' => $value['discount_total'],
                        'flat_discount_total' => $value['flat_discount_total'],
                        'supplier_id' => $value['supplier_id'],
                        'product_id' => $value['product_id'],
                        'product_sku' => $value['product_sku'],
                        'product_barcode' => $value['product_barcode'],
                        'buy_rate' => $value['buy_rate'],
                        'sale_rate' => $value['sale_rate'],
                        'quantity' => $value['quantity'],
                        'product_total' => $value['product_total'],
                        'net_total' => $value['net_total'],
                    ];
                    $sale_return_products->fill($product_data)->save();
                    //Quantity Wise Stock Update for available sale
                    $stocks = Stock::query()
                        ->userBranch($sale->branch_id)
                        ->where('sale_id', $value['sale_id'])
                        ->where('sale_detail_id', $value['id'])
                        ->limit($value['quantity']);

                    $stocks_clone = $stocks->newQuery()->get();

                    $stocks->update([
                        'stock_status' => Stock::STATUS['Stock'],
                        'sale_id' => null,
                        'sale_detail_id' => null,
                    ]);

                    $purchases = collect($stocks_clone)->groupBy('purchase_id')->toArray();
                    $sale_return_history = [];
                    foreach ($purchases as $purchaseId => $purchase) {
                        $total_quantity_return = count($purchase);
                        $sale_return_history[] = [
                            'return_type' => SaleReturnPurchaseHistory::RETURN_TYPE['return'],
                            'purchase_id' => $purchaseId,
                            'product_id' => $value['product_id'],
                            'product_sku' => $value['product_sku'],
                            'product_barcode' => $value['product_barcode'],
                            'supplier_id' => $value['supplier_id'],
                            'branch_id' => $value['branch_id'],
                            'customer_id' => $sale->customer_id,
                            'sale_id' => $value['sale_id'],
                            'sale_detail_id' => $value['id'],
                            'buy_rate' => $value['buy_rate'],
                            'sale_rate' => $value['sale_rate'],
                            'quantity' => $total_quantity_return,
                            'buy_total' => $value['buy_rate'] * $total_quantity_return,
                            'sale_total' => $value['sale_rate'] * $total_quantity_return,
                            'created_by' => auth()->id(),
                            "created_at" => date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        ];
                    }
                    SaleReturnPurchaseHistory::insert($sale_return_history);

                }
                Sale_detail::query()->where('sale_id', $sale->id)->delete();
                if($saleDelivery->delivery_charge >0) {
                    SaleDeliveryService::saleDeliveryCharge($saleDelivery, $sale);
                }
                $saleDelivery->update(['order_status' => SaleDelivery::ORDER_STATUS['returned']]);
                DB::commit();
                Session::flash('message', 'Sale status change to returned!');
                return redirect()->back();
            } else if ($request->get('status') == "Cancelled") {
                DB::beginTransaction();
                if ($saleDelivery->consignment_id) {
                    $orders_check = 'orders/' . $saleDelivery->consignment_id;
                    $response = PathaoService::get($orders_check);
                    if ($response) {
                        $order_status = $response->data->order_status;
                        if ($order_status == 'Pending') {
                            $endpoint = 'orders/' . $saleDelivery->consignment_id . '/cancel';
                            $pathaoResponse = PathaoService::put($endpoint);
                        }
                    }
                }
                $saleDelivery->update(['order_status' => SaleDelivery::ORDER_STATUS['cancelled']]);
                foreach ($sale->saleDetails as $value) {
                    //Quantity Wise Stock Update for available sale
                    Stock::query()
                        ->userBranch($sale->branch_id)
                        ->where('sale_id', $value['sale_id'])
                        ->where('sale_detail_id', $value['id'])
                        ->limit($value['quantity'])
                        ->update([
                            'stock_status' => Stock::STATUS['Stock'],
                            'sale_id' => null,
                            'sale_detail_id' => null,
                        ]);
                }
                Session::flash('message', 'Order cancelled successfully');
                DB::commit();
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Something went wrong!');
            dd($e->getMessage());
        }
    }
}
