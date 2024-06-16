<?php

namespace App\Http\Controllers\Admin\Supplier;
use App\Http\Controllers\Controller;
use App\Model\Supplier;

class SupplierBankController extends Controller
{
    private $supplier_object;

    public function __construct()
    {
        $this->supplier_object = new Supplier();
        $this->middleware('auth');
        $this->middleware('admin');
    }

  
    public function index($id)
    {
    
        return 'hi';
    }

 
    

 

}
