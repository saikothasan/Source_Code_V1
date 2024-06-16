<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Product;
use Illuminate\Http\Request;

class BarCodeController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'name')->get();

        $products = Product::select('id', 'name')->get();

        return view('barcode', compact('categories', 'products'));
    }
}
