<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Model\Stock;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchWiseStockController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function __invoke(Request $request, $product)
    {
        $stock = Stock::query()
            ->where('product_id', $product)
            ->when(isBranch(), function ($q) {
                $q->where('current_branch', auth()->user()->branch_id);
            })
            ->when(isSupplier(), function ($q) {
                $q->where('supplier_id', supplierAuth()->supplier->id);
            })
            ->filterByLikeBarcode($request->get('barcode'))
            ->filterByBranch($request->get('branch'))
            ->with(['branch'])
            ->stockDetail()
            ->select(DB::raw('stocks.*,
                COUNT(stocks.id) as total_quantity,
                SUM(stock_status=0 && sale_detail_id IS NOT NULL && sale_id IS NOT NULL) as total_sell,
                SUM(stock_status=1 && sale_detail_id IS NULL && sale_id IS NULL && transfer_id IS NULL) as available_pieces
            '))
            ->whereNotIn('stock_status',[Stock::STATUS['PurchaseReturn']])
            ->groupby(['product_barcode', 'current_branch']);


        $stockCount = collect($stock->newQuery()->get());
        $total_quantity = $stockCount->sum('total_quantity');
        $total_sell = $stockCount->sum('total_sell');
        $total_available = $total_quantity - $total_sell;

        $stock = $stock->paginate(100);

        return view('admin.products.branch_wise_stock', [
            'stock' => $stock,
            'product' => $product,
            'total_quantity' => $total_quantity,
            'total_sell' => $total_sell,
            'total_available' => $total_available,
        ]);
    }
}
