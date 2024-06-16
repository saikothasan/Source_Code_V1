<?php

namespace App\Services;

use App\Model\Stock;
use App\Model\TransferReceive;
use Illuminate\Http\Request;


class TransferReceivedService
{
    public static function transferResource(): array
    {
        $transferCount = TransferReceive::query()
            ->tansferInvoice()
            ->where('date', date('Y-m-d'))
            ->count();

        $transferCount = $transferCount ?? 0;
        $invoice = 'CFT' . '-' . auth()->user()->id . '-' . date('dmy') .
            (str_pad($transferCount + 1, 3, '0', STR_PAD_LEFT));

        return [
            'invoice' => json_encode($invoice),
            'user' => json_encode(auth()->user()),
            'date' => json_encode(date('Y-m-d')),
            'send_branch' => getAllBranch(isSupplier(), auth()->user()->branch_id),
         
        ];
    }

    public static function receivedInvoice(): string
    {
        $transferCount = TransferReceive::query()
            ->receiveInvoice()
            ->where('date', date('Y-m-d'))
            ->count();

        $transferCount = $transferCount ?? 0;
        return 'CFR' . '-' . auth()->user()->id . '-' . date('dmy') .
            (str_pad($transferCount + 1, 3, '0', STR_PAD_LEFT));


    }


    public static function productSearch($search, $offer_id)
    {
        $branch_id = auth()->user()->branch_id;
        if (isSupplier()) {
            $branch_id = getMainBranch()->id;
        }
        $barcodeProduct = Stock::query()
            ->when(isSupplier(), function ($query) {
                $query->where('supplier_id', supplierAuth()->supplier->id);
            })
            ->userBranch($branch_id)
            ->where('product_barcode', $search)
            ->stockDetail()
            ->when($offer_id !== null, function ($query) use ($offer_id) {
                $query->where('offer_id', $offer_id);
            })
            ->when($offer_id === null, function ($query) {
                $query->whereNull('offer_id');
            })
            ->first();

        if ($barcodeProduct) {
            return [self::productVariantBarcode($barcodeProduct, $branch_id,$offer_id)];
        }
        $skuProducts = Stock::query()
            ->when(isSupplier(), function ($query) {
                $query->where('supplier_id', supplierAuth()->supplier->id);
            })
            ->userBranch($branch_id)
            ->where('product_sku', $search)
            ->stockDetail()
            ->when($offer_id !== null, function ($query) use ($offer_id) {
                $query->where('offer_id', $offer_id);
            })
            ->when($offer_id === null, function ($query) {
                $query->whereNull('offer_id');
            })
            ->groupBy('product_barcode')
            ->get();
        if ($skuProducts) {
            return self::skuProductFormat($skuProducts, $branch_id, $offer_id);
        }
    }


    private static function productVariantBarcode($barcodeProduct, $branch_id ,$offer_id): array
    {
        $product_name = $barcodeProduct->product->name;
        if ($barcodeProduct->productVariations) {
            $variation_values_name = collect($barcodeProduct->productVariations->variantValues)
                ->pluck('variantValueName.variation_value')
                ->implode('-');
            $product_name = $barcodeProduct->product->name . '-' . $variation_values_name;
        }

        return [
            'purchase_id' => $barcodeProduct->purchase_id,
            'main_branch' => $barcodeProduct->main_branch,
            'current_branch' => $barcodeProduct->current_branch,
            'product_id' => $barcodeProduct->product_id,
            'supplier_id' => $barcodeProduct->supplier_id,
            'product_name' => $product_name,
            'product_buy_price' => $barcodeProduct->purchaseDetail->rate,
            'product_barcode' => $barcodeProduct['product_barcode'],
            'variation_sku' => $barcodeProduct['product_sku'],
            'total_price' => $barcodeProduct->purchaseDetail->rate,
            'quantity' => 1,
            'available_stock' => availableStockByOffer($barcodeProduct['product_barcode'], $branch_id,$offer_id),

        ];
    }

    private static function skuProductFormat($product, $branch_id, $offer_id): array
    {
        $products = [];
        foreach ($product as $value) {
            $product_name = $value->product->name;
            if ($value->productVariations) {
                $variation_values_name = collect($value->productVariations->variantValues)
                    ->pluck('variantValueName.variation_value')
                    ->implode('-');
                $product_name = $value->product->name . '-' . $variation_values_name;
            }
            $products[] = [
                'purchase_id' => $value->purchase_id,
                'main_branch' => $value->main_branch,
                'current_branch' => $value->current_branch,
                'product_id' => $value->product_id,
                'supplier_id' => $value->supplier_id,
                'product_name' => $product_name,
                'product_buy_price' => $value->purchaseDetail->rate,
                'product_barcode' => $value['product_barcode'],
                'variation_sku' => $value['product_sku'],
                'total_price' => $value->purchaseDetail->rate,
                'quantity' => 1,
                'available_stock' => availableStockByOffer($value['product_barcode'], $branch_id, $offer_id),

            ];
        }
        return $products;
    }

    public static function transferReceivedList(Request $request)
    {
        return TransferReceive::query()
            ->when(isBranch(), function ($query) {
                $query->whereHas('sendBranch', function ($q) {
                    return $q->where('transfer_branch', auth()->user()->branch_id)
                        ->where('invoice_type', TransferReceive::INVOICE_TYPE['transfer']);
                })
                    ->orwhereHas('receiveBranch', function ($q) {
                        return $q->where('receive_branch', auth()->user()->branch_id)
                            ->where('invoice_type', TransferReceive::INVOICE_TYPE['receive']);
                    });
            })
            ->when(isSupplier(),function ($query) {
                $query->whereSupplierId(supplierAuth()->supplier->id);
            })
//            ->when(isMainBranch(),function ($query) {
//                $query->whereNull('supplier_id');
//            })
            ->search($request)
            ->with([
                'sendBranch:id,name',
                'receiveBranch:id,name',
                'receiveUser:id,name',
                'sendUser:id,name',
                'sendUser.roles:id,name'
            ])
            ->orderBy('id', 'DESC')
            ->paginate(100);
    }


    public static function receivedList(Request $request): array
    {
        return [
            'receivedProducts' => TransferReceive::query()
                ->where('invoice_type', TransferReceive::INVOICE_TYPE['transfer'])
                ->where('status', TransferReceive::STATUS['Transferring'])
                ->where('receive_branch', auth()->user()->branch_id)
                ->with(['sendBranch','sendUser.roles:id,name'])
                ->latest()
                ->paginate(100)
        ];
    }

    public static function transferView(TransferReceive $transferReceive): TransferReceive
    {
        return $transferReceive->load(
            [
                'productDetails.product:id,name',
                'productDetails.productVariations.variantValues.variantValueName',
                'receiveUser:id,name',
                'sendUser:id,name,designation_id',
                'sendBranch:id,name',
                'receiveBranch:id,name',
                'sendUser.designation'
            ]
        );
    }

}
