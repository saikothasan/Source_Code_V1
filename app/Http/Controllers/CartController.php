<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Product_transfer;
use App\Model\Purchase_detail;
use Cart;
use DB;
use Illuminate\Http\Request;
use App\Model\Sale_return;
use App\Model\Purchase_return;
use App\Product_return;
use App\Model\Employee;
use App\Model\Size;

class CartController extends Controller
{
    // this function is used for finding  product and available quantity
    public function cart(Request $request)
    {
        $transfer_details = new Product_transfer;
        $purchase_return  = new Purchase_return;
        $sale_return      = new Sale_return;
        $product_return   = new Product_return();
        $product = '';
        $available = 0;

    	$productCode = $request->productCode;

    	$product     = DB::table('products')->where('product_code', $productCode)->select('id', 'name', 'buy_price', 'sell_price', 'unit_id')->first();

    	if($product != '') {

    	    $stock = DB::table('stocks')
                     ->groupBy('stocks.product_id')
                     ->where('stocks.product_id', $product->id)
                     ->select(DB::raw('SUM(stocks.quantity) as total_quanity'));

            if ($stock->count() > 0) {

                $stock = $stock->first()->total_quanity;

            } else {

                $stock = '0';
            }

            $sales = DB::table('sale_details')
                     ->groupBy('sale_details.product_id')
                     ->where('sale_details.product_id', $product->id)
                     ->select(DB::raw('SUM(sale_details.quantity) as sale_quantity'));

            if ($sales->count() > 0) {

                $sales = $sales->first()->sale_quantity;

            } else {

                $sales = '0';
            }

            $transfers_quantity       = $transfer_details->get_product_transfer_quantity($product->id);
            $purchase_return_quantity = $purchase_return->get_product_purchase_return_quantity($product->id);
            $sale_return_quantity     = $sale_return->get_product_sale_return_quantity($product->id);
            $product_return_quantity  = $product_return->get_product_return_quantity($product->id);

            $all_plus  = $stock + $sale_return_quantity + $product_return_quantity;

            $all_minus = $sales + $transfers_quantity +
            $purchase_return_quantity;

            $available = $all_plus - $all_minus;
    	}

    	$response['product']   = $product;
    	$response['available'] = $available;

        echo json_encode($response);
    }

    public function get_quotation(Request $request)
    {
        $transfer_details = new Product_transfer;
        $purchase_return  = new Purchase_return;
        $sale_return      = new Sale_return;
        $product_return   = new Product_return();
        $product = '';
        $available = 0;

        $productCode = $request->productCode;

        $product     = DB::table('products')
                           ->join('units', 'products.unit_id', '=', 'units.id')
                           ->where('product_code', $productCode)
                           ->select('products.id', 'products.name', 'products.buy_price', 'products.sell_price', 'units.value as unit')->first();

        if ($product != '') {

            $stock = DB::table('stocks')
                ->groupBy('stocks.product_id')
                ->where('stocks.product_id', $product->id)
                ->select(DB::raw('SUM(stocks.quantity) as total_quanity'));

            if ($stock->count() > 0) {

                $stock = $stock->first()->total_quanity;
            } else {

                $stock = '0';
            }

            $sales = DB::table('sale_details')
            ->groupBy('sale_details.product_id')
            ->where('sale_details.product_id', $product->id)
                ->select(DB::raw('SUM(sale_details.quantity) as sale_quantity'));

            if ($sales->count() > 0) {

                $sales = $sales->first()->sale_quantity;
            } else {

                $sales = '0';
            }

            $transfers_quantity       = $transfer_details->get_product_transfer_quantity($product->id);
            $purchase_return_quantity = $purchase_return->get_product_purchase_return_quantity($product->id);
            $sale_return_quantity     = $sale_return->get_product_sale_return_quantity($product->id);
            $product_return_quantity  = $product_return->get_product_return_quantity($product->id);

            $all_plus  = $stock + $sale_return_quantity + $product_return_quantity;

            $all_minus = $sales + $transfers_quantity +
                $purchase_return_quantity;

            $available = $all_plus - $all_minus;
        }

        $response['product']   = $product;
        $response['available'] = $available;

        echo json_encode($response);
    }

    public function subtotal()
    {
    	$subtotal = Cart::subtotal();

        $subtotal2 = str_replace(',', '', $subtotal);

    	echo $subtotal2;
    }

    public function product(Request $request)
    {
        $products = Product::where('category_id', $request->category_id)->select('id', 'name')->get();

        echo json_encode($products);
    }

    public function check_product(Request $request)
    {
        $products = Product::where('product_code', $request->productCode)->count();

        echo $products;
    }

    public function employee(Request $request)
    {
        $department = $request->department_id;

        $employees = Employee::where('department_id', $department)->select('id', 'name')->get();

        echo json_encode($employees);
    }

    public function get_product(Request $request)
    {
        $transfer_details = new Product_transfer;
        $purchase_return  = new Purchase_return;
        $sale_return      = new Sale_return;
        $product_return   = new Product_return();
        $product = '';
        $available = 0;

        $id = $request->productid;
        $supplier = Purchase_detail::query()->where('product_id',$id)->first();
        $product = DB::table('products')->where('id', $id)->select('id', 'name', 'buy_price', 'sell_price', 'unit_id', 'product_code','size_id')->first();

       if($product->size_id == !null){
        $size = Size::where('id',$product->size_id)->first()->name;
        $response['size'] = $size;
       }

        if ($product != '') {

            $stock = DB::table('stocks')
                ->groupBy('stocks.product_id')
                ->where('stocks.product_id', $product->id)
                ->select(DB::raw('SUM(stocks.quantity) as total_quanity'));

            if ($stock->count() > 0) {

                $stock = $stock->first()->total_quanity;
            } else {

                $stock = '0';
            }

            $sales = DB::table('sale_details')
            ->groupBy('sale_details.product_id')
            ->where('sale_details.product_id', $product->id)
                ->select(DB::raw('SUM(sale_details.quantity) as sale_quantity'));

            if ($sales->count() > 0) {

                $sales = $sales->first()->sale_quantity;
            } else {

                $sales = '0';
            }

            $transfers_quantity       = $transfer_details->get_product_transfer_quantity($product->id);
            $purchase_return_quantity = $purchase_return->get_product_purchase_return_quantity($product->id);
            $sale_return_quantity     = $sale_return->get_product_sale_return_quantity($product->id);
            $product_return_quantity  = $product_return->get_product_return_quantity($product->id);

            $all_plus  = $stock + $sale_return_quantity + $product_return_quantity;

            $all_minus = $sales + $transfers_quantity +
                $purchase_return_quantity;

            $available = $all_plus - $all_minus;
        }

        $response['product']   = $product;
        $response['available'] = $available;
        $response['supplier_id'] = $supplier->supplier_id ?? null;

        echo json_encode($response);
    }
}
