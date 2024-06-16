<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product_return;
use Illuminate\Http\Request;

class ProductReturnController extends Controller
{
    public function index()
    {
        $product_return = new Product_return;
        $product_returns = $product_return->get_product_returns();
        return view('admin.return.list', compact('product_returns'));
    }

    public function destroy($id)
    {
        $product_return = new Product_return;
        $product_return->delete_product_returns($id);
        return redirect()->back();
    }
}
