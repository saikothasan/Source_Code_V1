<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\ProductVariantSkuBarcode;
use App\Model\Purchase;
use App\Model\Purchase_detail;
use App\Model\Stock;
use App\Model\TransferReceiveDetail;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductWisePositionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function __invoke(Request $request, $product_id)
    {
        $stocks = Stock::query()
            ->where('product_barcode', $product_id)


            ->with(['branch'])
            ->stockDetail()
            ->select('stocks.*', DB::raw('count(product_id) as total_quantity'), DB::raw('count(sale_id) as total_sell'))
            ->groupby(['product_barcode', 'current_branch'])
            ->paginate(100);

        // return $stocks;

        //product Details

        $product = Stock::query()
            ->with(['product', 'product.supplier', 'product.brand', 'product.category', 'productVariations.variantValues.variantValueName'])
            ->when(!auth()->user()->is_main_branch, function ($q) {
                $q->where('current_branch', auth()->user()->branch_id);
            })
            ->with('items')
            ->select('stocks.*', DB::raw('count(product_barcode) as total_quantity'),)
            ->where('product_barcode', $product_id)
            ->first();
        // return $product;

        //purchase
        $purchases = Purchase_detail::withCount(['productStock' => function ($query) use ($product_id) {
            $query->when(!auth()->user()->is_main_branch, function ($q) {
                $q->where('current_branch', auth()->user()->branch_id);
            })->where('product_barcode', $product_id);
        }])
            ->where('product_barcode', $product_id)->get();


        $transfers = TransferReceiveDetail::with(['transfer', 'transfer.sendBranch', 'transfer.receiveBranch'])->where('product_barcode', $product_id)->get();

        // return $transfers;
        return view('admin.products.product_wise_position', compact('stocks', 'product', 'purchases', 'transfers'));
    }
}
