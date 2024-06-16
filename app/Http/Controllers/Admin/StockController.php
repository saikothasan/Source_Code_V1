<?php

namespace App\Http\Controllers\Admin;

use App\Model\Stock;
use App\Model\Category;
use App\Model\Supplier;
use App\Product_return;
use App\Model\Sale_detail;
use App\Model\Sale_return;
use Illuminate\Http\Request;
use App\Model\Purchase_return;
use App\Model\Product_transfer;
use App\Http\Controllers\Controller;

class StockController extends Controller
{
    private $stock_object;
    private $sale_details_object;

    public function __construct()
    {
        $this->stock_object  = new Stock;
        $this->sale_details_object  = new Sale_detail;
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $suppliers = Supplier::select('id', 'name')->get();
        $categorys = Category::query()->select('id', 'name')->get();
        $transfer_details = new Product_transfer;
        $purchase_return  = new Purchase_return;
        $sale_return      = new Sale_return;
        $product_return   = new Product_return();
        $stocks           = $this->stock_object->get_stock();
        if ($stocks) {

            foreach ($stocks as $key => $value) {

                $sales_quantity           = $this->sale_details_object->get_sale_quantity($value->product_id);
                $transfers_quantity       = $transfer_details->get_product_transfer_quantity($value->product_id);
                $purchase_return_quantity = $purchase_return->get_product_purchase_return_quantity($value->product_id);
                $sale_return_quantity     = $sale_return->get_product_sale_return_quantity($value->product_id);
                $product_return_quantity  = $product_return->get_product_return_quantity($value->product_id);

                $all_plus = $value->total_quanity + $sale_return_quantity + $product_return_quantity;

                $all_minus = $sales_quantity + $transfers_quantity +
                    $purchase_return_quantity;

                $available = $all_plus - $all_minus;

                $stocks[$key]->sale_quantity      = $sales_quantity;
                $stocks[$key]->transfers_quantity = $transfers_quantity;
                $stocks[$key]->purchase_return    = $purchase_return_quantity;
                $stocks[$key]->sale_return        = $sale_return_quantity;
                $stocks[$key]->product_return     = $product_return_quantity;
                $stocks[$key]->available          = $available;
            }
        }


        return view('admin.stock.list', compact('stocks', 'suppliers', 'categorys'));
    }
}
