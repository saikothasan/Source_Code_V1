<?php

namespace App\Http\Controllers;

use App\Model\Bank_transaction;
use App\Model\Branch;
use App\Model\Cash;
use App\Model\Cost;
use App\Model\Invest;
use App\Model\Owner;
use App\Model\Purchase;
use App\Model\PurchaseDue;
use App\Model\PurchasePayment;
use App\Model\Salary;
use App\Model\Sale;
use App\Model\Sale_detail;
use App\Model\Sale_due_collection;
use App\Model\Sale_payment;
use App\Model\Sale_return;
use App\Model\Setting;
use App\Model\Stock;
use App\Services\DashboardService;
use App\Services\TranslateService;
use Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        TranslateService::language_load();
        session()->put('local', 'en');
        if (@Auth::user()->hasRole(['Admin']) && isMainBranch()) {
            return view('dashboard.management', DashboardService::management());
        } else if (@Auth::user()->hasRole(['Supplier'])) {
//            dd(DashboardService::supplier($request));
            return view('dashboard.supplier', DashboardService::supplier($request));
        } else {
            return view('dashboard.branch', DashboardService::branchDashboard());
        }
    }
}
