<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Report\ReportProductSearchResource;
use App\Model\Product;
use App\Model\Sale_detail;
use App\Model\Stock;
use App\Model\User;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportFilterController extends Controller
{
    use ApiResponse;

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saleFilter(Request $request)
    {
        try {
            $data = [...$this->sellFilterData($request)];
            $data['seller'] = $this->seller($request);
            return $this->respondSuccess($data, 'Sale filter fetched successfully');
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false,
                'data' => []
            ], 400);
        }
    }

    private function seller($request)
    {
        return User::query()->whereIn('branch_id', $request->selectedBranch)
            ->active()
            ->select('id as value', 'name as text')
            ->orderBy('name')
            ->get()
            ->prepend([
                'text' => 'Select Seller',
                'value' => ''
            ])
            ->toArray();
    }

    private function sellFilterData($request)
    {
        $sale_details = Sale_detail::query()
            ->whereIn('branch_id', $request->selectedBranch)
            ->when($request->selectedSupplier, function ($query) use ($request) {
                $query->WhereIn('supplier_id', $request->selectedSupplier);
            })
            ->with(['product'])
            ->when($request->selectedSupplier, function ($query) {
                $query->groupBy(['supplier_id', 'product_id']);
            })
            ->when(count($request->selectedSupplier) <= 0, function ($query) {
                $query->groupBy(['branch_id', 'product_id']);
            })
            ->get();

        $products = collect($sale_details)->unique('product_id')->pluck('product')->toArray();
        $categories = collect($products)->pluck('category_id')->unique()->sort()->values()->all();
        $brands = collect($products)->pluck('brand_id')->unique()->sort()->values()->all();
        $suppliers = collect($sale_details)->pluck('supplier_id')->unique()->sort()->values()->all();

        return [
            'categories' => $categories,
            'brands' => $brands,
            'suppliers' => $suppliers,
        ];
    }


    public function stockFilter(Request $request)
    {
        try {
            $stocks = Stock::query()
                ->whereIn('current_branch', $request->selectedBranch)
                ->when($request->selectedSupplier, function ($query) use ($request) {
                    $query->WhereIn('supplier_id', $request->selectedSupplier);
                })
                ->with(['product'])
                ->when($request->selectedSupplier, function ($query) {
                    $query->groupBy(['supplier_id', 'product_id']);
                })
                ->when(count($request->selectedSupplier) <= 0, function ($query) {
                    $query->groupBy(['current_branch', 'product_id']);
                })
                ->get();


            $products = collect($stocks)->unique('product_id')->pluck('product')->toArray();
            $categories = collect($products)->pluck('category_id')->unique()->sort()->values()->all();
            $brands = collect($products)->pluck('brand_id')->unique()->sort()->values()->all();
            $suppliers = collect($stocks)->pluck('supplier_id')->unique()->sort()->values()->all();

            $data = [
                'categories' => $categories,
                'brands' => $brands,
                'suppliers' => $suppliers,
            ];
            return $this->respondSuccess($data, 'Stock filter fetched successfully');
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false,
                'data' => []
            ], 400);
        }
    }


    public function productSearch(Request $request)
    {
        try {
            $model = 'App\Model\Stock';
            if ($request->searchType === 'sale') {
                $model = 'App\Model\Sale_detail';
            }
            $products = $model::query()
                ->when($request->searchType === 'stock', function ($q) use ($request) {
                    $q->searchProduct($request)
                        ->when($request->selectedBranch, function ($q) use ($request) {
                            $q->whereIn('current_branch', $request->selectedBranch);
                        });
                })
                ->when($request->searchType === 'sale', function ($q) use ($request) {
                    $q->searchProduct($request)
                        ->whereIn('branch_id', $request->selectedBranch);
                })
                ->when($request->selectedSupplier, function ($q) use ($request) {
                    $q->whereIn('supplier_id', $request->selectedSupplier);
                })
                ->when($request->selectedBrand, function ($q) use ($request) {
                    $q->WhereHas('product', function (Builder $q) use ($request) {
                        $q->whereIn('brand_id', $request->selectedBrand);
                    });
                })
                ->when($request->selectedCategory, function ($q) use ($request) {
                    $q->WhereHas('product', function (Builder $q) use ($request) {
                        $q->whereIn('category_id', $request->selectedCategory);
                    });
                })
                ->with([
                    'product:id,name',
                    'productVariations.variantValues.variantValueName'
                ])
                ->groupBy('product_barcode')
                ->limit(9)
                ->get();

            $products = ReportProductSearchResource::collection($products);

            return $this->respondSuccess($products, 'Product fetched successfully');
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false,
                'data' => []
            ], 400);
        }
    }

    public function productInfo(Request $request)
    {
        try {
            $product = Product::with(['createdUser:id,name', 'supplier:id,name'])->findOrFail($request->product_id);
            $data['product'] = [
                'name' => $request->text,
                'product_barcode' => $request->value,
                'product_id' => $request->product_id,
                'product_sku' => $request->product_sku,
                'sell_price' => $request->sell_price,
                'buy_price' => $request->buy_price,
                'supplier_name' => $product->supplier->name,
                'supplier_id' => $product->supplier->id,
                'added_by' => $product->createdUser->name,
                'date' => date('d F Y', strtotime($product->created_at)),
            ];

            $stocks = collect(Stock::query()
                ->whereProductBarcode($request->value)
                ->groupBy(['main_branch', 'current_branch'])
                ->get());

            $data['available_branch'] = array_merge($stocks->pluck('main_branch')->unique()->toArray(), $stocks->pluck('current_branch')->toArray());

            return $this->respondSuccess($data, 'Product fetched successfully');
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false,
                'data' => []
            ], 400);
        }
    }
}
