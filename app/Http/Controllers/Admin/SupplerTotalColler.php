<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Product_transfer;
use App\Model\Purchase_payment;
use App\Model\Purchase_return;
use App\Model\Sale_detail;
use App\Model\Sale_return;
use App\Model\Stock;
use App\Product_return;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplerTotalColler extends Controller
{
    public function get_total_sale( Request $requrst){
              // total sale 
     $id = $requrst->suplier_id;

        ///total sale price 

        $stock            = new Stock();
        $sale_details     = new Sale_detail();
        $transfer_details = new Product_transfer();
        $sale_return      = new Sale_return();
        $product_return   = new Product_return();
        $purchase_return  = new Purchase_return();
        $purchase_payment = new Purchase_payment();



              $products = DB::table('purchases')
              ->leftJoin('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
              ->leftJoin('purchase_details', 'purchases.id', '=', 'purchase_details.purchase_id' )
              ->leftJoin('products', 'products.id', '=', 'purchase_details.product_id')
              ->leftJoin('sizes', 'products.size_id', '=', 'sizes.id') 
               ->leftJoin('units', 'products.unit_id', '=', 'units.id')
              ->where('purchases.supplier_id', $id)
          
              ->select('products.id', 'products.name','sizes.name as size', 'products.buy_price', 'units.value')
              ->get();

                  $total_sale = 0;
                  foreach ($products as $key => $value) {

                      $product_stock            = $stock->get_product_stock($value->id);
                      $sales_quantity           = $sale_details->get_product_sale_quantity($value->id);
                      $transfers_quantity       = $transfer_details->get_product_transfer_quantity($value->id);
                      $purchase_return_quantity = $purchase_return->get_product_purchase_return_quantity($value->id);
                      $sale_return_quantity     = $sale_return->get_product_sale_return_quantity($value->id);
                      $product_return_quantity  = $product_return->get_product_return_quantity($value->id);

                      $all_plus  = $product_stock + $sale_return_quantity + $product_return_quantity;

                      $all_minus = $sales_quantity + $transfers_quantity +
                          $purchase_return_quantity;

                      $available = $all_plus - $all_minus;
                      $total_sale += $sales_quantity * $value->buy_price;
                      

                  }
                  return response()->json($total_sale);
  
    }
    
}
