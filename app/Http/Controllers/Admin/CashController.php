<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Bank_transaction;
use App\Model\Cash;
use App\Model\Cost;
use App\Model\Salary;
use App\Model\Sale_due_collection;
use App\Model\Sale_payment;
use Illuminate\Http\Request;

class CashController extends Controller
{
    private $cash_object;

    public function __construct()
    {
        $this->cash_object = new Cash;
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
    	$cashes = Cash::orderBy('date', 'desc')->get();
    	

        return view('admin.cash.list', compact('cashes'));
    }

    public function create()
    {
        $today                   = date('Y-m-d');
        $yester_day              = date('Y-m-d', strtotime("-1 days"));
        $salePaymentObject       = new Sale_payment();
        $saleDueCollectionObject = new Sale_due_collection();
        $costObject              = new Cost();
        $cashObject              = new Cash();

        $today_sale_payment        = $salePaymentObject->get_todays_sale_payment($today);
        $today_sale_due_collection = $saleDueCollectionObject->get_todays_sale_due_collection($today);
        $today_cost                = $costObject->get_todays_cost($today);
        $yesterday_cash            = $cashObject->yesterday_cash($yester_day);
        $salary = Salary::where('date', $today)->selectRaw('sum(amount) as paid')->first()->paid;

        // today calculation
        $today_cash_transfer = Cash::where('date',$today)->sum('transfer');
        
        $all_plus = $today_sale_payment + $today_sale_due_collection;
        $all_minus = $today_cost + $salary;
        $in_cash = $all_plus - $all_minus;
        $in_cash = $in_cash - $today_cash_transfer;
        $todaySendCacsh = Bank_transaction::where('type','sendCacsh')->sum('amount');

        $todays_in_cash = $yesterday_cash +  $in_cash +  $todaySendCacsh ;

       
        return view('admin.cash.add', compact('todays_in_cash'));
    }

    public function store(Request $request)
    {
    	$validateData = $request->validate(Cash::$validateRule);

        $this->cash_object->store_cash($request);

        return redirect()->back();
    }

    public function destroy($id)
    {
    	$this->cash_object->delete_cash($id);

        return redirect()->back();
    }
}
