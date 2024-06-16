<?php

namespace App\Services;

use App\Model\Branch;
use App\Model\Product;
use App\Model\ProductVariantSkuBarcode;
use App\Model\Purchase;
use App\Model\Stock;
use App\Model\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public static int $total_stock = 0;

    public function __construct()
    {

    }

    public static function productList(Request $request): array
    {
        $products = Product::query()
            ->search($request->get('search'))
            ->filterByLikeSku($request->get('sku'))
            ->filterBySupplier($request->get('supplier'))
            ->filterByBrand($request->get('brand'))
            ->filterByCategory($request->get('category'))
            ->withCount(['productStock' => function ($query) {
                $query->wherehas('purchase', function ($query) {
                    $query->where('status', Purchase::STATUS['approved'])
                        ->whereNot('stock_status', Stock::STATUS['PurchaseReturn']);
                });
            }])
            ->when(auth()->user()->is_main_branch, function ($q) {
                $q->withCount(['productStock as available_main_branch' => function ($query) {
                    $query->where('stock_status', Stock::STATUS['Stock'])
                        ->whereNull('sale_id')
                        ->whereNull('sale_detail_id')->where('current_branch', auth()->user()->branch_id);
                }]);
            })
            ->withCount(['productStock as total_sell' => function ($query) {
                $query->where('stock_status', Stock::STATUS['Sale'])
                    ->whereNotNull('sale_id')
                    ->whereNotNull('sale_detail_id')->when(! auth()->user()->is_main_branch, function ($q) {
                        $q->where('current_branch', auth()->user()->branch_id);
                    });
            }])
            ->withCount(['offerProductStock as offer_total_sell' => function ($query) {
                $query->where('stock_status', Stock::STATUS['Sale'])
                     ->whereNotNull('offer_id')
                     ->whereNotNull('offer_type')
                    ->whereNotNull('sale_id')
                    ->whereNotNull('sale_detail_id')->when(! auth()->user()->is_main_branch, function ($q) {
                        $q->where('current_branch', auth()->user()->branch_id);
                    });
            }])
            ->withCount(['offerProductStock as offer_total_stock' => function ($query) {
                $query->where('stock_status', Stock::STATUS['Stock'])
                    ->whereNotNull('offer_id')
                    ->whereNotNull('offer_type')
                    ->whereNotNull('sale_id')
                    ->whereNotNull('sale_detail_id')->when(!auth()->user()->is_main_branch, function ($q) {
                        $q->where('current_branch', auth()->user()->branch_id);
                    });
            }])
            ->withCount(['offerProductStock as offer_total_sale' => function ($query) {
                $query->where('stock_status', Stock::STATUS['Sale'])
                    ->whereNotNull('offer_id')
                    ->whereNotNull('offer_type')
                    ->whereNotNull('sale_id')
                    ->whereNotNull('sale_detail_id');
            }])
            ->with('supplier')
            ->orderBy('name');

        $productsClone = $products->newQuery()->get();
        $total_quantity = collect($productsClone)->sum('product_stock_count');
        $available_main_branch = collect($productsClone)->sum('available_main_branch');
        $transfer_total = ($total_quantity - $available_main_branch);
        $sell_total = collect($productsClone)->sum('total_sell');
        $available_total = ($total_quantity - $sell_total);

        $available_offer_main_branch = collect($productsClone)->sum('offer_total_stock');
        $offer_total_sale = collect($productsClone)->sum('offer_total_sale');
        $products = $products->paginate(100);
        return [
            'products' => $products,
            'total_quantity' => $total_quantity,
            'available_main_branch' => $available_main_branch,
            'transfer_total' => $transfer_total,
            'sell_total' => $sell_total,
            'available_total' => $available_total,
            'available_offer_main_branch' => $available_offer_main_branch,
            'offer_total_sale' => $offer_total_sale,
        ];
    }

    public static function supplierList(Request $request): array
    {
        $mainBranch = Branch::query()->where('is_main_branch', true)->firstOrFail();

        $products = Product::query()
            ->where('supplier_id', supplierAuth()->supplier->id)
            ->search($request->get('search'))
            ->filterByLikeSku($request->get('sku'))
            ->filterBySupplier($request->get('supplier'))
            ->filterByBrand($request->get('brand'))
            ->filterByCategory($request->get('category'))
            ->withCount(['productStock' => function ($query) {
                $query->wherehas('purchase', function ($query) {
                    $query->where('status', Purchase::STATUS['approved'])->whereNot('stock_status', Stock::STATUS['PurchaseReturn']);
                })->where('supplier_id', supplierAuth()->supplier->id);
            }])
            ->withCount(['productStock as available_main_branch' => function ($query) use ($mainBranch) {
                $query->where('stock_status', Stock::STATUS['Stock'])
                    ->whereNull('sale_id')
                    ->whereNull('sale_detail_id')
                    ->where('supplier_id', supplierAuth()->supplier->id)
                    ->where('current_branch', $mainBranch->id);
            }])
            ->withCount(['productStock as total_sell' => function ($query) {
                $query->where('stock_status', Stock::STATUS['Sale'])
                    ->whereNotNull('sale_id')
                    ->whereNotNull('sale_detail_id')->where('supplier_id', supplierAuth()->supplier->id);
            }])
            ->with('supplier')
            ->orderBy('name');

        $productsClone = $products->newQuery()->get();
        $total_quantity = collect($productsClone)->sum('product_stock_count');
        $sell_total = collect($productsClone)->sum('total_sell');
        $available_total = ($total_quantity - $sell_total);
        $available_main_branch = collect($productsClone)->sum('available_main_branch');
        $products = $products->paginate(100);
        return [
            'products' => $products,
            'total_quantity' => $total_quantity,
            'sell_total' => $sell_total,
            'available_total' => $available_total,
            'available_main_branch' => $available_main_branch,
        ];
    }

    public static function branchProducts(Request $request, $branch_id = null): array
    {
        $products = Stock::query()->searchProduct($request)
            ->stockDetail()
            ->with(['product.brand', 'product.supplier'])
            ->select(
                'stocks.*',
                DB::raw('count(current_branch) as total_quantity'),
                DB::raw('SUM(stock_status=0 && sale_detail_id IS NOT NULL && sale_id IS NOT NULL) as total_sale'),
                DB::raw('SUM(stock_status=1 && sale_detail_id IS NULL && sale_id IS NULL && transfer_id IS NULL) as available_stock'),
                DB::raw('SUM(stock_status=1 && sale_detail_id IS NULL && sale_id IS NULL && transfer_id IS NULL && offer_id IS NOT NULL && offer_type IS NOT NULL) as available_in_offer'),
                DB::raw('SUM(stock_status=0 && sale_detail_id IS NOT NULL && sale_id IS NOT NULL && offer_id IS NOT NULL && offer_type IS NOT NULL) as total_sale_in_offer'),
            )
            ->when($branch_id, function ($query) use ($branch_id) {
                $query->where('current_branch', $branch_id);
            })
            ->when($branch_id == null, function ($query) {
                $query->where('current_branch', auth()->user()->branch_id);
            })
            ->groupBy(['current_branch', 'product_barcode']);

        $productsClone = clone $products;
        $productsClone = $productsClone->get();
        $total_items = collect($productsClone)->count();
        $total_quantity = collect($productsClone)->sum('total_quantity');
        $sell_total = collect($productsClone)->sum('total_sale');
        //offer
        $offer_total_quantity = collect($productsClone)->sum('available_in_offer');
        $offer_sell_total = collect($productsClone)->sum('total_sale_in_offer');
        $available_total = ($total_quantity - $sell_total);

        $products = $products->paginate(100);

        return [
            'products' => $products,
            'total_items' => $total_items,
            'total_quantity' => $total_quantity,
            'sell_total' => $sell_total,
            'available_total' => $available_total,
            'offer_total_quantity' => $offer_total_quantity,
            'offer_sell_total' => $offer_sell_total,
        ];
    }

    public static function productResource(): array
    {
        $auth_supplier = (object)[];
        if (isSupplier()) {
            $auth_supplier = supplierAuth();
        }
        $categories = getAllCategory();
        $suppliers = getAllSupplier();
        $brands = getAllBrand();
        $variations = Variation::query()
            ->variation()
            ->with('variationValue:id,type_id,variation_value,variation_code')
            ->get()->map(function ($data) {
                return [
                    'value' => $data->id,
                    'text' => $data->variation_name,
                    'variation_value' => $data->variationValue->map(function ($value) {
                        return [
                            'value' => $value->id,
                            'text' => $value->variation_value,
                            'variation_code' => $value->variation_code,
                            'type_id' => $value->type_id,

                        ];
                    }),
                ];
            })
            ->toArray();

        return [
            'categories' => json_encode($categories),
            'suppliers' => json_encode($suppliers),
            'brands' => json_encode($brands),
            'variations' => json_encode($variations),
            'auth_supplier' => json_encode($auth_supplier),
        ];
    }

    public static function getEditProduct($product): array
    {
        $product->load([
            'options.optionName:id,variation_name',
            'options.optionValues.variantValueName:id,variation_value,variation_code,type_id',
            'options.optionValues' => function ($query) {
                $query->groupBy('variant_value', 'option_id');
            },
            'productVariantSkuBarcode.variantValues.variantValueName:id,variation_value,variation_code,type_id',
        ])->loadCount('productStock as total_stock');
        self::$total_stock = $product->total_stock;
        $productOptions = [];
        $variationValues = [];
        if ($product->product_options) {
            $optionsId = collect($product->options)->pluck('option_id')->toArray();
            $variantValues = Variation::whereNull('variation_name')->whereIn('type_id', $optionsId)->get();

            $productOptions = $product->options->map(function ($option) use ($variantValues) {
                $optionValues = collect($option['optionValues'])->where('option_id', $option['option_id']);
                $variantValues = collect($variantValues)->where('type_id', $option['option_id'])->toArray();
                return [
                    'delete_show' => self::$total_stock <= 0,
                    'editOption' => false,
                    'option_error' => "",
                    'tag' => "",
                    'optionName' => self::getOptionName($variantValues, $option),
                    'optionValues' => self::getOptionValues($optionValues, $option),
                ];
            });

            $variationValues = $product->productVariantSkuBarcode->map(function ($variant_sku_barcode) {
                $variantValueNames = collect($variant_sku_barcode['variantValues'])
                    ->where('product_variant_sku_id', $variant_sku_barcode['id'])
                    ->pluck('variantValueName.variation_value')->toArray();
                return [
                    'variation_barcode' => $variant_sku_barcode['variant_barcode'],
                    'variation_price' => $variant_sku_barcode['variant_price'],
                    'variant_buy_price' => $variant_sku_barcode['variant_buy_price'],
                    'variation_sku' => $variant_sku_barcode['variant_sku'],
                    'variation_values_names' => collect($variantValueNames)->implode('-'),
                    'variationValues' => $variantValueNames,
                    'delete_show' => self::$total_stock <= 0,
                ];
            })->toArray();
        }

        $productInfo = [
            'id' => $product->id,
            'name' => $product->name,
            'product_slug' => $product->product_slug,
            'product_sku' => $product->product_sku,
            'brand_id' => $product->brand_id,
            'supplier_id' => $product->supplier_id,
            'product_options' => $product->product_options,
            'product_code' => $product->product_code,
            'category_id' => $product->category_id,
            'description' => $product->description,
            'buy_price' => $product->buy_price,
            'product_margin' => $product->product_margin,
            'product_profit' => $product->product_profit,
            'is_draft' => $product->is_draft,
            'is_active' => $product->is_active,
            'sell_price' => $product->sell_price,
            'total_stock' => $product->total_stock,
        ];
        return [
            'product_info' => json_encode($productInfo),
            'productOptions' => json_encode($productOptions),
            'productOptionsValues' => json_encode($variationValues),
        ];
    }

    protected static function getOptionValues($optionValues, $option): array
    {
        $optionValues = [$optionValues->map(function ($data) use ($option) {
            if ($data->option_id == $option['option_id']) {
                return [
                    'value' => $data->variant_value,
                    'text' => $data['variantValueName']['variation_value'],
                    'variation_code' => $data['variantValueName']['variation_code'],
                    'type_id' => $data->option_id,
                    'total_stock' => self::$total_stock,
                    'delete' => self::$total_stock <= 0,
                ];
            }
        })];
        return collect($optionValues)->collapse()->toArray();
    }

    protected static function getOptionName($variantValues, $option): array
    {
        $variantValues = [collect($variantValues)->map(function ($value) {
            return [
                'text' => $value['variation_value'],
                'type_id' => $value['type_id'],
                'value' => $value['id'],
                'variation_code' => $value['variation_code'],
                'delete' => true,
            ];
        })];
        return [
            'text' => $option['optionName']['variation_name'],
            'value' => $option['option_id'],
            'variation_value' => collect($variantValues)->collapse()->toArray(),
        ];
    }

    public static function skuProductForPurchase($product_sku)
    {
        $barcodeProduct = ProductVariantSkuBarcode::query()
            ->filterByBarcode($product_sku)
            ->with('product.supplier', 'variantValues.variantValueName:id,variation_value,variation_code,type_id')
            ->first();
        if ($barcodeProduct) {
            return [self::productVariantBarcode($barcodeProduct)];
        }
        $product = Product::query()
            ->filterBySku($product_sku)
            ->orWhere('product_code', $product_sku)
            ->variantSkuBarcodeValues()
            ->with('supplier')
            ->first();
        if ($product) {
            return self::skuProductFormat($product);
        }
    }

    private static function productVariantBarcode($barcodeProduct): array
    {
        $variantValueNames = collect($barcodeProduct['variantValues'])->pluck('variantValueName')->toArray();
        $variation_values_name = collect($variantValueNames)->pluck('variation_value')->implode('-');

        return [
            'product_options' => true,
            'product_id' => $barcodeProduct->product->id,
            'supplier_id' => $barcodeProduct->product->supplier_id,
            'supplier' => $barcodeProduct->product->supplier,
            'product_name' => $barcodeProduct->product->name . '-' . $variation_values_name,
            'product_buy_price' => $barcodeProduct['variant_buy_price'],
            'product_sell_price' => $barcodeProduct['variant_price'],
            'product_barcode' => $barcodeProduct['variant_barcode'],
            'variation_sku' => $barcodeProduct['variant_sku'],
            'variation_values_names' => $variation_values_name,
            'variation_options_values' => collect($variantValueNames)->map(function ($data) {
                return [
                    'option_id' => $data['type_id'],
                    'variant_value' => $data['variation_value'],
                ];
            }),
            'total_price' => $barcodeProduct['variant_buy_price'],
            'quantity' => 1,

        ];
    }

    private static function skuProductFormat($product): array
    {
        if ($product && $product->product_options) {
            $product = $product->productVariantSkuBarcode->map(function ($variant_sku_barcode) use ($product) {
                $variantValueNames = collect($variant_sku_barcode['variantValues'])->pluck('variantValueName')->toArray();
                $variation_values_name = collect($variantValueNames)->pluck('variation_value')->implode('-');
                return [
                    'product_options' => true,
                    'product_id' => $product->id,
                    'supplier_id' => $product->supplier_id,
                    'supplier' => $product->supplier,
                    'product_name' => $product->name . '-' . $variation_values_name,
                    'product_buy_price' => $variant_sku_barcode['variant_buy_price'],
                    'product_sell_price' => $variant_sku_barcode['variant_price'],
                    'product_barcode' => $variant_sku_barcode['variant_barcode'],
                    'variation_sku' => $variant_sku_barcode['variant_sku'],
                    'variation_values_names' => $variation_values_name,
                    'variation_options_values' => collect($variantValueNames)->map(function ($data) {
                        return [
                            'option_id' => $data['type_id'],
                            'variant_value' => $data['variation_value'],
                        ];
                    }),
                    'total_price' => $variant_sku_barcode['variant_buy_price'],
                    'quantity' => 1,
                ];
            })->toArray();
        } else {
            $product = [[
                'product_options' => false,
                'product_id' => $product->id,
                'supplier_id' => $product->supplier_id,
                'supplier' => $product->supplier,
                'product_name' => $product->name,
                'product_buy_price' => $product->buy_price,
                'product_sell_price' => $product->sell_price,
                'product_barcode' => $product->product_code,
                'variation_sku' => $product->product_sku,
                'variation_values_names' => [],
                'variation_options_values' => [],
                'total_price' => $product->buy_price,
                'quantity' => 1,
            ]];
        }
        return $product;
    }

    public static function productDetails($product): array
    {
        $product->load([
            'productImage',
            'options.optionName:id,variation_name',
            'options.optionValues.variantValueName:id,variation_value,variation_code,type_id',
            'options.optionValues' => function ($query) {
                $query->groupBy('variant_value', 'option_id');
            },
            'productVariantSkuBarcode.variantValues.variantValueName:id,variation_value,variation_code,type_id', 'productVariantSkuBarcode.productStock',
        ])->loadCount(['productStock as total_stock' => function ($query) {
            $query->stockProduct()->where('current_branch', (int)ecommerceBranchId());
        }]);
        self::$total_stock = $product->total_stock;
        $productOptions = [];
        $variationValues = [];
        if ($product->product_options) {
            $optionsId = collect($product->options)->pluck('option_id')->toArray();
            $variantValues = Variation::whereNull('variation_name')->whereIn('type_id', $optionsId)->get();
            $productOptions = $product->options->map(function ($option) use ($variantValues) {
                $optionValues = collect($option['optionValues'])->where('option_id', $option['option_id']);
                $variantValues = collect($variantValues)->where('type_id', $option['option_id'])->toArray();
                return [
                    'optionName' => self::getOptionName($variantValues, $option),
                    'optionValues' => self::getOptionValues($optionValues, $option),
                ];
            });
            //stock_status=1 && sale_detail_id IS NULL && sale_id IS NULL && transfer_id IS NULL
            $variationValues = $product->productVariantSkuBarcode->map(function ($variant_sku_barcode) {
                //                dd(collect($variant_sku_barcode['productStock'])->where('stock_status', 1)->whereNull('sale_detail_id')->whereNull('sale_id')->whereNull('transfer_id'));
                $variantValue = collect($variant_sku_barcode['variantValues'])
                    ->where('product_variant_sku_id', $variant_sku_barcode['id']);
                $variantValueNames = $variantValue->pluck('variantValueName.variation_value')->toArray();
                $variations = $variantValue->pluck('variant_value')->toArray();
                $variantStock = collect($variant_sku_barcode['productStock'])
                    ->where('current_branch', (int)ecommerceBranchId())
                    ->where('stock_status', Stock::STATUS['Stock'])
                    ->whereNull('sale_id')
                    ->whereNull('sale_detail_id')
                    ->whereNull('transfer_id')
                    ->whereNotIn('stock_status', [Stock::STATUS['PurchaseReturn']])
                    ->count();
                return [
                    'variation_barcode' => $variant_sku_barcode['variant_barcode'],
                    'variation_price' => $variant_sku_barcode['variant_price'],
                    'variant_buy_price' => $variant_sku_barcode['variant_buy_price'],
                    'variation_sku' => $variant_sku_barcode['variant_sku'],
                    'variation_values_names' => collect($variantValueNames)->implode('-'),
                    'variations' => $variations,
                    'variation_stock' => $variantStock,
                ];
            })->toArray();
        }

        $productInfo = [
            'id' => $product->id,
            'name' => $product->name,
            'product_slug' => $product->product_slug,
            'product_sku' => $product->product_sku,
            'product_options' => $product->product_options,
            'images' => $product->productImage->map(function ($image) {
                return [
                    'id' => $image->id,
                    'product_id' => $image->product_id,
                    'src' => '/' . $image->photo,
                    'variation_id' => $image->variation_id,
                ];
            }),
            'product_code' => $product->product_code,
            'description' => $product->description,
            'is_active' => $product->is_active,
            'sell_price' => $product->sell_price,
            'total_stock' => $product->total_stock,
        ];
        //        return [
        //            'product' => $productInfo,
        //            'product_info' => $productInfo,
        //            'productOptions' => $productOptions,
        //            'productOptionsValues' => $variationValues,
        //        ];
        $related_product = Product::query()
       
        ->where('category_id', $product->category_id)
        ->with('productImage')
        ->orderBy('id', 'desc')
        ->take(12)
        ->get();
        return [
            'product' => $productInfo,
            'product_info' => json_encode($productInfo),
            'productOptions' => json_encode($productOptions),
            'productOptionsValues' => json_encode($variationValues),
            'related_product'  =>  $related_product,
        ];
    }

    public static function search_products($name, $limit = 10, $offset = 1)
    {
        $key = explode(' ', $name);

        $paginator = Product::query()
            ->with('productImage')
            ->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            })->paginate($limit, ['*'], 'page', $offset);

        return [
            'total_size' => $paginator->total(),
            'limit' => (integer)$limit,
            'offset' => (integer)$offset,
            'products' => $paginator->items(),
        ];
    }
}
