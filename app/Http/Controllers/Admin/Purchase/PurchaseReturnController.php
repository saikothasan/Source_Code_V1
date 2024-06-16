<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseReturnRequest;
use App\Model\Purchase;
use App\Model\Purchase_detail;
use App\Model\Purchase_return;
use App\Model\PurchaseDue;
use App\Model\PurchaseReturnProduct;
use App\Model\Stock;
use App\Services\PurchaseService;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class PurchaseReturnController extends Controller
{

    use  ApiResponse;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('purchases')->except(['index','show','statusUpdate']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        //return  PurchaseService::purchaseReturnResource($purchase);
        return view('admin.purchase.return-index', PurchaseService::purchaseReturnList($request));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return RedirectResponse
     */
    public function returnCreate(Purchase $purchase)
    {
        if($purchase->status !=Purchase::STATUS['approved']) {
            Session::flash('warning', 'Purchase return not available');
            return redirect()->route('purchases.index');
        }
//        return  PurchaseService::purchaseReturnResource($purchase);
        return view('admin.purchase.return-create', PurchaseService::purchaseReturnResource($purchase));
    }

    public function store(PurchaseReturnRequest $request)
    {
        //return $request->all();
        try {
            DB::beginTransaction();
            $return_products = collect($request->purchase_products)->filter(function ($value) {
                return $value['return_quantity'] > 0;
            });

            $purchase = Purchase::findOrFail($request->id);

            $purchase->update([
                'total_quantity' => $purchase->total_quantity - $request->total_return_quantity,
                'total' => $purchase->total - $request->total_return_amount,
                'subtotal' => $purchase->subtotal - $request->total_return_amount,
            ]);
            $purchase_return = new Purchase_return();
            $purchase_return->date = date('Y-m-d');
            $purchase_return->purchase_id = $purchase->id;
            $purchase_return->total_quantity = $request->total_return_quantity;
            $purchase_return->total_amount = $request->total_return_amount;
            $purchase_return->supplier_id = $purchase->supplier_id;
            $purchase_return->branch_id = auth()->user()->branch_id;
            $purchase_return->user_id = auth()->user()->id;
            $purchase_return->status = Purchase_return::STATUS['pending'];
            $purchase_return->save();

            $purchaseDue = PurchaseDue::query()->where('purchase_id', $purchase->id)->first();

            $purchaseDue->update([
                'total_amount' => $purchaseDue->total_amount - $request->total_return_amount,
                'due_total' => $purchaseDue->due_total - $request->total_return_amount
            ]);

            foreach ($return_products as $value) {
                $purchase_detail = Purchase_detail::query()->findOrFail($value['purchase_details_id']);
                $return_amount = $value['return_quantity'] * $purchase_detail->rate;
                $purchase_detail->update([
                    'quantity' => $purchase_detail->quantity - $value['return_quantity'],
                    'total' => $purchase_detail->total - $return_amount,
                ]);

                $purchase_return_product = new PurchaseReturnProduct();
                $purchase_return_product->purchase_return_id = $purchase_return->id;
                $purchase_return_product->purchase_id = $purchase->id;
                $purchase_return_product->purchase_detail_id = $purchase_detail->id;
                $purchase_return_product->product_id = $value['product_id'];
                $purchase_return_product->product_sku = $value['product_sku'];
                $purchase_return_product->product_barcode = $value['product_barcode'];
                $purchase_return_product->quantity = $value['return_quantity'];
                $purchase_return_product->rate = $purchase_detail->rate;
                $purchase_return_product->total = $return_amount;
                $purchase_return_product->supplier_id = $purchase->supplier_id;
                $purchase_return_product->branch_id = auth()->user()->branch_id;
                $purchase_return_product->user_id = auth()->user()->id;
                $purchase_return_product->save();

                //Quantity Wise Stock Change
                Stock::query()
                    ->userBranch(auth()->user()->branch_id)
                    ->stockProduct()
                    ->where('purchase_id', $value['purchase_id'])
                    ->where('purchase_details_id', $value['purchase_details_id'])
                    ->where('supplier_id', $purchase->supplier_id)
                    ->where('product_id', $value['product_id'])
                    ->where('product_barcode', $value['product_barcode'])
                    ->limit($value['return_quantity'])
                    ->update([
                        'stock_status' => Stock::STATUS['PurchaseReturn'],
                        'purchase_return_id' => $purchase_return->id,
                        'sale_id' => null,
                        'sale_detail_id' => null,
                        'transfer_id' => null,
                    ]);
            }

            DB::commit();

            return $this->respondCreated($purchase_return,
                'Product return successfully'
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
                'data' => []
            ], 400);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param Purchase_return $purchase_return
     * @return Application|Factory|View
     */
    public function show(Purchase_return $purchase_return)
    {
        $purchase_return = PurchaseService::purchaseReturnView($purchase_return);
//        return  $purchase_return;
        return view('admin.purchase.return-show', compact('purchase_return'));
    }


    public function statusUpdate(Request $request)
    {
        try {
            $purchase_return = Purchase_return::query()
                ->where('status', Purchase_return::STATUS['pending'])
                ->findOrFail($request->return_id);
            if ($request->get('receive_type') === 'received') {
                $purchase_return->update(['status' => Purchase_return::STATUS['received']]);
                Session::flash('message', 'Purchase return received Successfully!');
                return redirect()->back();
            } elseif ($request->get('receive_type') === 'reject') {
                DB::beginTransaction();
                $purchase_return->update(['status' => Purchase_return::STATUS['reject']]);
                $purchaseReturnProducts = PurchaseReturnProduct::query()->where('purchase_return_id', $purchase_return->id)->get();
                $purchase = Purchase::query()->findOrFail($purchase_return->purchase_id);
                $purchase->update([
                    'total_quantity' => $purchase->total_quantity + $purchase_return->total_quantity,
                    'subtotal' => $purchase->subtotal + $purchase_return->total_amount,
                    'total' => $purchase->total + $purchase_return->total_amount,
                ]);

                $purchaseDue = PurchaseDue::query()->where('purchase_id', $purchase->id)->first();
                if(isset($purchaseDue)) {
                    $purchaseDue->update([
                        'total_amount' => $purchaseDue->total_amount + $purchase_return->total_amount,
                        'due_total' => $purchaseDue->due_total + $purchase_return->total_amount
                    ]);
                }


                //Return Product Restore To Purchase invoice
                foreach ($purchaseReturnProducts as $value) {
                    $purchase_detail = Purchase_detail::query()->findOrFail($value['purchase_detail_id']);
                    $purchase_detail->update([
                        'quantity' => $purchase_detail->quantity + $value['quantity'],
                        'total' => $purchase_detail->total + $value['total'],
                    ]);
                    //Purchase Stock update
                    Stock::query()
                        ->where('purchase_return_id', $purchase_return->id)
                        ->where('stock_status', Stock::STATUS['PurchaseReturn'])
                        ->where('purchase_details_id', $value['purchase_detail_id'])
                        ->limit($value['quantity'])
                        ->update([
                            'stock_status' => Stock::STATUS['Stock'],
                            'sale_id' => null,
                            'sale_detail_id' => null,
                            'transfer_id' => null,
                            'purchase_return_id' => null,
                        ]);
                }
                Session::flash('message', 'Purchase reject received Successfully!');
                DB::commit();

                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back();
        }
    }
}
