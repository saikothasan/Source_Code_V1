<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

/**
 * App\Product_return
 *
 * @property int $id
 * @property string $date
 * @property int $sale_id
 * @property string $invoice
 * @property int $product_id
 * @property float $quantity
 * @property float $rate
 * @property float $amount
 * @property int $customer_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Product_return newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product_return newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product_return query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product_return whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product_return whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product_return whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product_return whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product_return whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product_return whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product_return whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product_return whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product_return whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product_return whereSaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product_return whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product_return whereUserId($value)
 * @mixin \Eloquent
 */
class Product_return extends Model
{
    protected $fillable = [

        'date', 'invoice', 'user_id', 'customer_id', 'product_id', 'sale_id', 'quantity', 'amount', 
    ];

    public function get_product_returns()
    {
        $product_returns = $this::leftJoin('products', 'product_returns.product_id', '=', 'products.id')
                                  ->leftJoin('users', 'product_returns.user_id', '=', 'users.id')
                                  ->leftJoin('customers', 'product_returns.customer_id', '=', 'customers.id')
                                  ->select('product_returns.*', 'users.name as user', 'products.name as product', 'customers.name as customer')
                                  ->get();
        return $product_returns;
    }

    public function get_product_return_by_sale_id($sale_id)
    {
        $product_returns = $this::join('products', 'product_returns.product_id', '=', 'products.id')
                                  ->leftJoin('units', 'products.unit_id', '=', 'units.id')
                                  ->where('product_returns.sale_id', $sale_id)
                                  ->select('product_returns.quantity', 'product_returns.amount', 'products.name', 'units.value');

        if ($product_returns->count() > 0) {

            return $product_returns->get();

        } else {

            return null;
        } 
    }

    public function get_product_return_quantity($product_id)
    {
        $query = $this::where('product_id', $product_id)
            ->selectRaw('SUM(quantity) as return_quantity');
        if ($query->count() > 0) {

            return $query->first()->return_quantity;
        } else {

            return '0';
        }
    }

    public function delete_product_returns($id)
    {
        $delete_returns = $this::where('id', $id)->delete();

        if ($delete_returns) {

            Session::flash('message', 'Product Return Deleted Successfully!');

        } else {

            Session::flash('message', 'Product Return Delete Failed!');
        }
        
    }
}
