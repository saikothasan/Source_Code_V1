<?php

namespace App\Http\Controllers\Admin\Branch;

use App\Http\Controllers\Controller;

use App\Model\Branch;
use App\Model\Cost;
use App\Model\Sale;
use App\Model\SaleDelivery;
use App\Model\Stock;
use App\Model\User;
use App\Services\ProductService;
use App\Services\SaleService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchWiseReportController extends Controller
{
    /**
     * Handle the incoming request.
     *  ++++++-*
     * @param Request $request
     * @return Application|Factory|View
     */
    public function sale(Request $request, $branch_id, $type)
    {
        ini_set('memory_limit', '-1');
        $firstDay = date("Y-n-j", strtotime("first day of this month"));
        $lastDay = date("Y-n-j", strtotime("last day of this month"));

        $branch = Branch::findOrFail($branch_id);
        $sales = Sale::query()
            ->where('branch_id', $branch_id)
            ->search($request->get('search'))
            ->filterByDate($request->get('from-date'), $request->get('to-date'))
            ->with(['user:id,name', 'seller:id,name', 'customer:id,name,phone', 'saleDetails'])
            ->withCount('saleDetails as total_items')
            ->withSum('saleDetails as total_quantity', 'quantity')
            ->withSum('saleDetails as total_buy_price', 'buy_rate');

        $salesClone = clone $sales;
        $salesClone = $salesClone->get();

        $total = collect($salesClone)->map(function ($data) {
            return collect($data->saleDetails)->map(function ($saledetail_data) use ($data) {

                return [
                    'quantity' => $saledetail_data->quantity,
                    'buy_price_total' => $saledetail_data->quantity * $saledetail_data->buy_rate,
                    'profit_total' => $data->final_total - ($saledetail_data->quantity * $saledetail_data->buy_rate),
                ];
            });
        });

        $sub_total_buy_price = collect($total)->collapse()->sum('buy_price_total');
        $total_sale_quantity = collect($total)->collapse()->sum('quantity');
        $total_items = collect($salesClone)->sum('total_items');
        $total_quantity = collect($salesClone)->sum('total_quantity');
        $total_buy_price = collect($salesClone)->sum('total_buy_price');
        $total_sell = collect($salesClone)->sum('final_total');
        $sub_total_profit = $total_sell - $sub_total_buy_price;



        $monthly_sell = Sale::query()
            ->where('branch_id', $branch_id)->whereBetween('date', [$firstDay, $lastDay])->sum('final_total');

        //monthly profit
        $sell = Sale::query()
            ->where('branch_id', $branch_id)->whereBetween('date', [$firstDay, $lastDay])
            ->with('saleDetails')
            ->withSum('saleDetails as total_quantity', 'quantity')
            ->withSum('saleDetails as total_buy_price', 'buy_rate')->get();

        $buy_price = collect($sell)->map(function ($data) {
            return collect($data->saleDetails)->map(function ($saledetail_data) use ($data) {

                return [
                    'quantity' => $saledetail_data->quantity,
                    'buy_price_total' => $saledetail_data->quantity * $saledetail_data->buy_rate,
                    'profit_total' => $data->final_total - ($saledetail_data->quantity * $saledetail_data->buy_rate),
                ];
            });
        });
        $sell_buy_price = collect($buy_price)->collapse()->sum('buy_price_total');

        $monthly_cost = Cost::query()
            ->where('branch_id', $branch_id)->whereBetween('created_at', [$firstDay, $lastDay])->sum(('amount'));
        $total_cost = $monthly_cost;
        $monthly_profit = $sub_total_profit - $total_cost;


        $sales = $sales->orderBy('id', 'DESC')->paginate(100);


        //total Stock

        $total_stock = Stock::query()
            ->where('current_branch', $branch_id)->where('stock_status', 1)->count();
        if ($type == 'stock') {
            $branch_product = ProductService::branchProducts($request, $branch_id);
            return view('admin.branch.single-branch-sale', compact(
                'branch_product',
                'monthly_profit',
                'sub_total_buy_price',
                'sub_total_profit',
                'branch',
                'sales',
                'total_items',
                'total_quantity',
                'total_stock',
                'total_sell',
                'monthly_sell',
                'total_sale_quantity',
                'sell_buy_price',
                'monthly_cost'
            ));
        }
        if ($type == 'profit') {

            $start = request()->get('from-date');
            $end = request()->get('to-date');
            $branch_cost = Cost::query()
                ->filterByDate($start, $end)
                ->filterByCostType($request->get('cost_type'))
                ->where('branch_id', $branch_id)
                ->with(['paymentMethod:id,name','employee:id,name'])
                ->latest()
                ->get();

            $sales = DB::table('sales')
                ->where('sales.branch_id', $branch_id)
                ->leftJoin('sale_details', 'sale_details.sale_id', '=', 'sales.id')
                ->select(
                    'sale_details.*',
                    'sales.*',
                    DB::raw('SUM(quantity) as total_quantity'),
                    DB::raw('SUM(buy_rate * quantity) as total_buy_price '),

                )
                // ->whereBetween(DB::raw('date'), [$start, $end])
                // ->groupBy('sales.date')
                ->orderBy('date', 'asc')
                ->get();


            return view('admin.branch.single-branch-sale', compact(
                'sales',
                'branch_cost',
                'monthly_profit',
                'sub_total_buy_price',
                'sub_total_profit',
                'branch',
                'sales',
                'total_items',
                'total_quantity',
                'total_stock',
                'total_sell',
                'monthly_sell',
                'total_sale_quantity',
                'sell_buy_price',
                'monthly_cost'
            ));
        }

        return view('admin.branch.single-branch-sale', compact(
            'monthly_profit',
            'sub_total_buy_price',
            'sub_total_profit',
            'branch',
            'sales',
            'total_items',
            'total_quantity',
            'total_stock',
            'total_sell',
            'monthly_sell',
            'total_sale_quantity',
            'sell_buy_price',
            'monthly_cost'
        ));
    }

    public function stock(Request $request, $branch_id)
    {
        $branch = Branch::findOrFail($branch_id);
        return view('admin.branch.single-branch-sale', compact('branch_product', 'branch'));
    }
}
