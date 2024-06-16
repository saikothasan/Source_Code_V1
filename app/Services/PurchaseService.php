<?php

namespace App\Services;

use App\Http\Resources\Admin\Purchase\PurchaseResource;
use App\Model\Purchase;
use App\Model\Purchase_return;
use App\Model\Stock;
use App\Model\User;
use Illuminate\Http\Request;

class PurchaseService
{

    public static function purchaseList(Request $request): array
    {
        $purchases = Purchase::query()
            ->search($request->get('invoice'))
            ->whereNotNull('supplier_id')
            ->when(isSupplier(),function ($query) {
                $query->whereSupplierId(supplierAuth()->supplier->id);
            })
            ->filterBySupplier($request->get('supplier_id'))
            ->filterByDate($request->get('from-date'), $request->get('to-date'))
            ->with('supplier:id,name')
            ->withCount('purchaseDetails as total_items')
            ->withCount(['stocks as available_stocks' => function ($query) {
                $query->where('stock_status', '=', Stock::STATUS['Stock'])->whereNull('sale_id')->whereNull('transfer_id');
            }])
            ->withSum('purchaseDetails', 'rate');
        $purchasesClone = $purchases->newQuery()->get();
        $total_items = collect($purchasesClone)->sum('total_items');
        $total_quantity = collect($purchasesClone)->sum('total_quantity');
        $available_stocks = collect($purchasesClone)->sum('available_stocks');
        $total_buy_price = collect($purchasesClone)->sum('total');

        $purchases = $purchases->orderBy('id', 'DESC')->paginate(100);

        return [
            'purchases' => $purchases,
            'total_items' => $total_items,
            'total_quantity' => $total_quantity,
            'available_stocks' => $available_stocks,
            'total_buy_price' => $total_buy_price,
        ];
    }

    public static function purchaseResource(): array
    {
        $purchaseCount = Purchase::query()->whereDate('date', date('Y-m-d'))->count();
        $purchaseCount = $purchaseCount ?? 0;
        $invoice = 'CFP' . '-' . auth()->user()->id . '-' . date('dmy') .
            (str_pad($purchaseCount + 1, 3, '0', STR_PAD_LEFT));
        return [
            'invoice' => json_encode($invoice),
            'date' => json_encode(date('Y-m-d')),
            'user' => json_encode(auth()->user()),
            'receive_user' => json_encode(User::query()->select('id as value', 'name as text')->get()),
        ];
    }

    public static function purchaseView($purchase)
    {
        return $purchase
            ->loadCount('purchaseDetails')
            ->load(
                [
                    'purchaseDetails.product:id,name,buy_price,sell_price,product_sku,product_code',
                    'purchaseDetails.productVariations.variantValues.variantValueName',
                    'receive:id,name',
                    'user:id,name'
                ]
            );
    }


    public static function purchaseReturnResource($purchase): array
    {
        $purchase = $purchase
            ->loadCount('purchaseDetails')
            ->load(
                [
                    'purchaseDetails.product:id,name,buy_price,sell_price,product_sku,product_code',
                    'purchaseDetails.productVariations.variantValues.variantValueName',
                    'receive:id,name',
                    'user:id,name',
                    'purchaseDetails' => function ($query) {
                        $query->withCount('availableMainBranchStock as available_stock');
                    }
                ]
            );
        return [
            'purchase' => new PurchaseResource($purchase),
        ];
    }

    public static function purchaseReturnList(Request $request): array
    {
        $purchases = Purchase_return::query()
            ->when(isSupplier())->where('supplier_id',supplierAuth()->supplier->id)
            ->search($request->get('invoice'))
            ->filterBySupplier($request->get('supplier_id'))
            ->filterByDate($request->get('from-date'), $request->get('to-date'))
            ->with('purchase')
            ->with('supplier:id,name');

        $purchasesClone = $purchases->newQuery()->get();
        $total_quantity = collect($purchasesClone)->sum('total_quantity');
        $total_return_amount = collect($purchasesClone)->sum('total_amount');

        $purchases = $purchases->orderBy('id', 'DESC')->paginate(100);

        return [
            'purchases' => $purchases,
            'total_quantity' => $total_quantity,
            'total_return_amount' => $total_return_amount,
        ];
    }

    public static function purchaseReturnView($purchase_return)
    {
        return $purchase_return->load(
            [
                'purchase.purchaseDetails.product:id,name,buy_price,sell_price,product_sku,product_code',
                'purchase.purchaseDetails.productVariations.variantValues.variantValueName',
                'purchase.receive:id,name',
                'purchase.user:id,name',
                'user:id,name',
                'returnProducts.product:id,name,buy_price,sell_price,product_sku,product_code',
                'returnProducts.productVariations.variantValues.variantValueName'
            ]
        );
    }

}
