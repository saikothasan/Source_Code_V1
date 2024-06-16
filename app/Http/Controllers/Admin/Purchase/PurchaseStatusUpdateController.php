<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Model\Purchase;
use App\Model\Stock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PurchaseStatusUpdateController extends Controller
{
    public function __invoke(Request $request, Purchase $purchase)
    {
        try {
            DB::beginTransaction();
            if ($purchase->status != Purchase::STATUS['pending']) {
                Session::flash('warning', 'Status already changed!');
                return redirect()->back();
            }
            if ($request->status == Purchase::STATUS['approved']) {
                $this->approved($purchase);
                Session::flash('message', 'Purchase Approved!');

            }
            if ($request->status == Purchase::STATUS['cancelled']) {
                $this->cancelled($purchase);
                Session::flash('message', 'Purchase Cancelled!');
            }
            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back();
        }
    }

    private function approved($purchase): void
    {
        $purchase->update(['status' => Purchase::STATUS['approved']]);
        Stock::query()
            ->where('purchase_id', $purchase->id)
            ->update(['stock_status' => Stock::STATUS['Stock']]);
    }

    private function cancelled($purchase): void
    {
        $purchase->update(['status' => Purchase::STATUS['cancelled']]);
        Stock::query()
            ->where('purchase_id', $purchase->id)
            ->update(['stock_status' => Stock::STATUS['PurchaseCancelled']]);
    }
}
