<?php

namespace App\Services;


use App\Http\Resources\Admin\Sale\SaleResource;
use App\Model\Sale;
use App\Model\Sale_return;
use App\Model\SaleDelivery;
use App\Model\SaleExchange;
use App\Model\Setting;
use App\Model\Stock;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class SaleService
{

    public static function saleList(Request $request): array
    {
        $filter = $request->get('filter');
        $sales = Sale::query()
            ->when(isBranch(), function ($query) {
                $query->where('branch_id', auth()->user()->branch_id);
            })
            ->when(isMainBranch(), function ($query) {
                $query->with('branch:id,name');
            })
            ->search($request->get('search'))
            ->filterByDate($request->get('from-date'), $request->get('to-date'))
            ->filterByBranch($request->get('branch'))
            ->filterBySeller($request->get('seller'))
            ->when(isset($filter) && $filter == 'sale', function ($query) use ($filter) {
                $query->whereDoesntHave('saleDelivery');
            })
            ->when(isset($filter) && $filter != 'sale', function ($query) use ($filter) {
                $query->whereHas('saleDelivery', function ($q) use ($filter) {
                    $q->where('order_status', '=', intval(SaleDelivery::ORDER_STATUS[$filter]));
                })->when($filter == 'pending', function ($query) {
                    $query->whereDoesntHave('saleDeliveries', function ($q) {
                        $q->whereIn('order_status',
                            [
                                SaleDelivery::ORDER_STATUS['delivered'],
                                SaleDelivery::ORDER_STATUS['returned'],
                                SaleDelivery::ORDER_STATUS['cancelled']
                            ]);
                    });
                });
            })
            ->when(!isset($filter), function ($query) {
                $query->whereDoesntHave('saleDelivery', function ($q) {
                    $q->where('order_status', SaleDelivery::ORDER_STATUS['pending']);
                });
            })
            ->when(isset($filter) && $filter == 'returned', function ($query) {
                $query->whereDoesntHave('saleDelivery', function ($q) {
                    $q->where('order_status', SaleDelivery::ORDER_STATUS['returned']);
                });
            })
            ->with([
                'user:id,name',
                'seller:id,name',
                'customer:id,name,phone',
                'branch:id,name',
                'saleDelivery:sale_id,order_status'
            ])
            ->withCount('saleProducts as total_items')
            ->withSum('saleProducts as total_quantity', 'quantity');

        $sale_exchanges = SaleExchange::query()
            ->search($request->get('search'))
            ->filterByDate($request->get('from-date'), $request->get('to-date'))
            ->filterByBranch($request->get('branch'))
            ->filterBySeller($request->get('seller'))
            ->when(isBranch(), function ($query) {
                $query->where('branch_id', auth()->user()->branch_id);
            })
            ->when(isMainBranch(), function ($query) {
                $query->with('branch:id,name');
            })
            ->when(!isset($filter) && $filter != 'pending', function ($query) use ($filter) {
                $query->WhereDoesntHave('exchangeDelivery', function ($q) {
                    $q->whereIn('order_status',
                        [
                            SaleDelivery::ORDER_STATUS['pending'],
                        ]);
                });
            })
            ->when(isset($filter) && $filter == 'sale', function ($query) use ($filter) {
                $query->whereDoesntHave('exchangeDelivery');
            })
            ->when(isset($filter) && $filter != 'sale', function ($query) use ($filter) {
                $query->whereHas('exchangeDelivery', function ($q) use ($filter) {
                    $q->where('order_status', '=' ,intval(SaleDelivery::ORDER_STATUS[$filter]));
                })->when($filter=='delivered',function ($query) {
                    $query->WhereDoesntHave('exchangeDelivery', function ($q) {
                        $q->whereIn('order_status',
                            [
                                SaleDelivery::ORDER_STATUS['pending'],
                                SaleDelivery::ORDER_STATUS['returned'],
                                SaleDelivery::ORDER_STATUS['cancelled']
                            ]);
                    });
                });
            })
            ->with([
                'sale.customer:id,name,phone',
                'sale.seller:id,name',
                'branch:id,name',
                'user:id,name',
                'exchangeDelivery:sale_exchange_id,order_status'
            ])
            ->withCount('saleProducts as total_items')
            ->withSum('saleProducts as total_quantity', 'quantity');



        if (!isset($filter) || $filter == 'returned') {
            $sale_returns = Sale_return::query()
                ->search($request->get('search'))
                ->filterByDate($request->get('from-date'), $request->get('to-date'))
                ->filterByBranch($request->get('branch'))
                ->filterBySeller($request->get('seller'))
                ->when(isBranch(), function ($query) {
                    $query->where('branch_id', auth()->user()->branch_id);
                })
                ->when(isMainBranch(), function ($query) {
                    $query->with('branch:id,name');
                })
                ->select('return_date  as date', 'sale_returns.*')
                ->with([
                    'sale.customer:id,name,phone',
                    'sale.seller:id,name',
                    'branch:id,name',
                    'user:id,name',
                ])
                ->withCount('returnProducts as total_items')
                ->withSum('returnProducts as total_quantity', 'quantity');
        }

        $results = array_merge(
            $sales->latest('id')->get()->toArray(),
            $sale_exchanges->latest('id')->get()->toArray(),
        );

        if (!isset($filter) || $filter == 'returned') {
            $results = array_merge(
                $results,
                $sale_returns->latest('id')->get()->toArray()
            );
        }

        $results = collect($results)->sortBy('created_at', SORT_REGULAR,true)->toArray();

        $total_items = collect($results)->whereNull('return_type')->sum('total_items');
        $total_quantity = collect($results)->whereNull('return_type')->sum('total_quantity');
        $total_sell = collect($results)->sum('net_total');
        $total_delivery_return = 0;
        if($filter == 'returned') {
            $total_sell = collect($results)->sum('return_total');
            $total_delivery_return = collect($results)->pluck('sale')->sum('delivery_charge');
            $total_items = collect($results)->sum('total_items');
            $total_quantity = collect($results)->sum('total_quantity');

        }

        $current_page = $request->get('page', 1);

        $currentItems = array_slice($results, 100 * ($current_page - 1), 100);

        $results = new Paginator($currentItems, count($results), 100, $current_page, ['path' => route('sales.index')]);


        return [
            'results' => $results,
            'sales' => (new SaleResource($results))->resolve(),
            'total_items' => $total_items,
            'total_quantity' => $total_quantity,
            'total_sell' => $total_sell,
            'total_delivery_return' => $total_delivery_return,
            'filter_options' => self::saleFilterOptions(),
        ];
    }

    public static function saleFilterOptions(): array
    {
        return collect(SaleDelivery::ORDER_STATUS)->put('sale', 'Sale')->toArray();
    }

    public static function newSaleView(Sale $sale): Sale
    {
        return $sale->load([
            'branch:id,name,address',
            'customer:id,name,phone',
            'seller:id,name',
            'delivery:id,name,phone,delivery_area',
            'salePayment',
            'saleProducts.product:id,name',
            'saleProducts.productVariations.variantValues.variantValueName',
            'saleReturns.returnProducts' => [
                'product:id,name',
                'productVariations.variantValues.variantValueName'
            ],
            'exchanges.saleProducts' => [
                'product:id,name',
                'productVariations.variantValues.variantValueName'
            ],
            'exchanges.exchangePayment',
            'exchanges.deliveryMan',
        ])->loadSum('saleProducts as product_total', 'product_total');
    }

    public static function saleResource(): array
    {
        return [

            'sale_resource' => json_encode([
                'user' => auth()->user()->load('branch'),
                'invoice_code' => Sale::generateInvoiceCode(),
                'date' => date('d F y'),
                'settings' => Setting::getSettingsArray(),
                'deliveryMan' => getDeliveryMans(),
                'paymentMethod' => getPaymentMethods(['Bank']),
                'seller_users' => getBranchUsers(),
                'offers' => getOffers(),
            ])
        ];
    }

    public static function exchangeReturnResource(): array
    {
        return [
            'resource' => json_encode([
                'user' => auth()->user()->load('branch'),
                'date' => date('d F y'),
                'settings' => Setting::getSettingsArray(),
                'deliveryMan' => getDeliveryMans(),
                'paymentMethod' => getPaymentMethods(['Bank']),
                'seller_users' => getBranchUsers(),
            ])
        ];
    }

    public static function productAdd($search)
    {
        $barcodeProduct = Stock::query()
            ->userBranch(auth()->user()->branch_id)
            ->where('product_barcode', $search)
            ->stockDetail()
            ->first();
        if ($barcodeProduct && $barcodeProduct->product->is_active) {
            return self::variantProductFormat($barcodeProduct);
        }
    }


    private static function variantProductFormat($barcodeProduct): array
    {

        $product_name = $barcodeProduct->product->name;
        $product_sell_price = number_format($barcodeProduct->product->sell_price, 2, '.', '');
        if ($barcodeProduct->productVariations) {
            $variation_values_name = collect($barcodeProduct->productVariations->variantValues)
                ->pluck('variantValueName.variation_value')
                ->implode('-');
            $product_name = $barcodeProduct->product->name . '-' . $variation_values_name;
            $product_sell_price = number_format($barcodeProduct->productVariations->variant_price, 2, '.', '');
        }

        return [
            'supplier_id' => $barcodeProduct->supplier_id,
            'branch_id' => $barcodeProduct->current_branch,
            'product_id' => $barcodeProduct->product_id,
            'product_name' => $product_name,
            'offer_name' => null,
            'discount_amount' => null,
            'product_sell_price' => $product_sell_price,
            'product_buy_price' => number_format($barcodeProduct->purchaseDetail->rate, 2, '.', ''),
            'product_barcode' => $barcodeProduct['product_barcode'],
            'product_sku' => $barcodeProduct['product_sku'],
            'total_price' => $product_sell_price,
            'quantity' => 1,
            'available_stock' => availableProductStock($barcodeProduct['product_barcode'], auth()->user()->branch_id),
            'available_in_offer' => 0,
            'offer_id' => null,
        ];
    }


    public static function productSearch($search)
    {
        $barcodeProduct = Stock::query()->userBranch(auth()->user()->branch_id)
            ->where('product_barcode', $search)
            ->stockDetail()
            ->first();
        if ($barcodeProduct) {
            return [self::productVariantBarcode($barcodeProduct)];
        }
        $skuProducts = Stock::query()
            ->userBranch(auth()->user()->branch_id)
            ->where('product_barcode', $search)
            ->stockDetail()
            ->groupBy('product_barcode')
            ->get();
        if ($skuProducts) {
            return self::skuProductFormat($skuProducts);
        }
    }


    private static function productVariantBarcode($barcodeProduct): array
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
            'branch_id' => $barcodeProduct->current_branch,
            'product_id' => $barcodeProduct->product_id,
            'supplier_id' => $barcodeProduct->supplier_id,
            'product_name' => $product_name,
            'product_sell_price' => $barcodeProduct->product->sell_price,
            'product_buy_price' => $barcodeProduct->purchaseDetail->rate,
            'product_barcode' => $barcodeProduct['product_barcode'],
            'variation_sku' => $barcodeProduct['product_sku'],
            'total_price' => $barcodeProduct->purchaseDetail->rate,
            'quantity' => 1,
            'available_stock' => availableStock($barcodeProduct['product_barcode']),

        ];
    }

    private static function skuProductFormat($product): array
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
                'available_stock' => availableStock($value['product_barcode']),

            ];
        }
        return $products;
    }
}
