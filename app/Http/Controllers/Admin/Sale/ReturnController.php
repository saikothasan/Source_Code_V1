<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Model\Sale;
use App\Model\SaleReturnPurchaseHistory;
use App\Model\Stock;
use App\Model\CashDrawer;
use App\Model\CashHistory;
use App\Model\Sale_detail;
use App\Model\Sale_return;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Services\SaleService;
use App\Model\SaleReturnDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaleReturnRequest;
use App\Model\BranchPaymentMethodHistory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ReturnController extends Controller
{
    use ApiResponse;

    public function index()
    {
    }

    public function create()
    {
//        Session::flash('error', 'Sale Return not available in this moment!');
//        return redirect()->back();
        return view('admin.sale.create-return', SaleService::exchangeReturnResource());
    }

    public function store(SaleReturnRequest $request)
    {
        try {
//           return $request->all();
            DB::beginTransaction();
            $user = auth()->user();
            $main_invoice = $request->get('main_invoice');
            $sale_id = $request->get('main_invoice')['id'];
            $invoice_calculation = $request->get('main_invoice_calculation');
            $main_products = $request->get('main_products');
            $return_calculation = $request->get('return_detail');
            $return_products = $request->get('return_products');

            $sale = Sale::findOrFail($sale_id);
            $this->cashDrawerAmountUpdate($request, $sale);
            $final_total = $sale->final_total - $return_calculation['return_total'];
            $vat_amount = $sale->vat_amount - $return_calculation['vat_total'];
            $discount_amount = $sale->discount_amount - $return_calculation['discount_amount'];
            $net_total = $sale->net_total - $return_calculation['return_total'];

            $sale->final_total = $final_total <= 0 ? 0 : $final_total;
            $sale->vat_amount = $vat_amount <= 0 ? 0 : $vat_amount;
            $sale->discount_amount = $discount_amount <= 0 ? 0 : $discount_amount;
            $sale->net_total = $net_total <= 0 ? 0 : $net_total;
            $sale->return_total += $return_calculation['return_total'];
            $sale->flat_discount = $invoice_calculation['flat_discount'];
            $sale->save();

            $sale_return = new Sale_return();
            $sale_return->return_type = Sale_return::RETURN_TYPE['return'];
            $sale_return->return_date = date('Y-m-d');
            $sale_return->sale_id = $sale_id;
            $sale_return->user_id = $user->id;
            $sale_return->branch_id = $sale->branch_id;
            $sale_return->customer_id = $sale->customer_id;
            $sale_return->vat_percentage = $sale->vat_percentage;
            $sale_return->vat_amount = $return_calculation['vat_total'];
            $sale_return->discount_percentage = $sale->discount_percentage;
            $sale_return->discount_amount = $return_calculation['discount_amount'];
            $sale_return->flat_discount = $return_calculation['flat_discount_total'];
            $sale_return->return_total = $return_calculation['return_total'];
            $sale_return->return_amount = $return_calculation['return_total'];
            $sale_return->save();


            $invoiceQuantity = collect($main_products)->sum('quantity');
            $returnQuantity = collect($return_products)->sum('quantity');
            $totalQuantity = ($invoiceQuantity - $returnQuantity);
            foreach ($return_products as $value) {
                $sale_product = Sale_detail::query()
                    ->where('sale_id', $value['sale_id'])
                    ->where('id', $value['sale_detail_id'])->firstOrFail();
                $quantity = $sale_product->quantity - $value['quantity'];
                if ($quantity <= 0) {
                    $sale_product->delete();
                } else {
                    $flatDiscountTotal = 0;
                    if ($sale->flat_discount > 0) {
                        $flatDiscountTotal = ($sale->flat_discount / $totalQuantity) * $quantity;
                    }
                    $sale_product->quantity = $quantity;
                    $sale_product->flat_discount_total = $flatDiscountTotal;
                    $sale_product->discount_total = $sale_product->discount_total - $value['single_discount'];
                    $sale_product->vat_total = $sale_product->vat_total - $value['single_vat'];
                    $sale_product->product_total = $sale_product->product_total - $value['product_total'];
                    $sale_product->net_total = $sale_product->net_total - $value['net_total'];
                    $sale_product->save();
                }
                $sale_return_products = new SaleReturnDetail();
                $returnflatDiscount = 0;
                if ($return_calculation['flat_discount_total'] > 0) {
                    $returnflatDiscount = ($return_calculation['flat_discount_total'] / $returnQuantity) * $value['quantity'];
                }

                $product_data = [
                    'return_type' => SaleReturnDetail::RETURN_TYPE['return'],
                    'sale_return_id' => $sale_return->id,
                    'sale_id' => $sale->id,
                    'user_id' => $user->id,
                    'customer_id' => $sale->customer_id,
                    'branch_id' => $value['branch_id'],
                    'vat_total' => $value['vat_total'],
                    'discount_total' => $value['discount_total'],
                    'flat_discount_total' => $returnflatDiscount,
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
                    ->where('sale_detail_id', $value['sale_detail_id'])
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
                        'sale_detail_id' => $value['sale_detail_id'],
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
            DB::commit();
            return $this->respondCreated(
                null,
                'Sale return successfully'
            );
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
                'success' => false,
                'data' => []
            ], 422);
        }
    }


    private function cashDrawerAmountUpdate($request, $sale)
    {
        $branch_id = auth()->user()->branch_id;
        $return_total = $request->return_detail['return_total'];
        $cash_drawer = CashDrawer::query()->where('branch_id', auth()->user()->branch_id)->firstOrFail();
        if ($return_total > $cash_drawer->amount) {
            $validator = Validator::make([], []);
            $validator->errors()->add('cash_drawer', 'Cash drawer insufficient balance');
            throw new ValidationException($validator);
        } else {
            $cash_drawer->amount -= $return_total;
            $cash_drawer->save();
            $cash_history = new CashHistory();
            $cash_history->cash_id = $cash_drawer->id;
            $cash_history->branch_id = $branch_id;
            $cash_history->cash_type = CashHistory::CASH_TYPE['sale_return'];
            $cash_history->date = date('Y-m-d');
            $cash_history->amount = -$return_total;
            $cash_history->note = $sale->invoice_code;
            $cash_history->sale_id = $sale->id;
            $cash_history->save();

            $branch_payment_history = new BranchPaymentMethodHistory();
            $branch_payment_history->date = date('Y-m-d');
            $branch_payment_history->type = BranchPaymentMethodHistory::TYPE['sale'];
            $branch_payment_history->invoice_reference = $sale->invoice_code;
            $branch_payment_history->sale_id = $sale->id;
            $branch_payment_history->branch_id = $branch_id;
            $branch_payment_history->payment_method_id = 1;
            $branch_payment_history->payment_number = null;
            $branch_payment_history->payment_reference = null;
            $branch_payment_history->return_amount = -$return_total;
            $branch_payment_history->payable_amount = $sale->payable_amount;
            $branch_payment_history->save();
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
