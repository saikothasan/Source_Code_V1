<?php

namespace App\Http\Controllers\Admin\Bank;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankRequest;
use App\Http\Requests\BankTransferRequest;
use App\Model\User;
use App\Model\Bank;
use App\Model\BankTransfer;
use App\Model\CashDrawer;
use App\Model\CashHistory;
use DB;
use Illuminate\Http\Request;

class AdminTransferController extends Controller
{

    public function admin_transfer()
    {
        $banks = Bank::where('user_id', auth()->user()->id)->get();
        $cashDrawer = CashDrawer::get();
        return view('admin.bank.adminTransfer', compact('banks', 'cashDrawer'));
    }

    public function admin_transfer_store(Request $request, CashHistory $cashHistory, BankTransfer $bankTransfer)
    {
        $validated = $request->validate([
            'sender_bank_id' => 'required',
            'cash_drawer_id' => 'required',
            'paid' => 'required|gt:0',
        ]);
        try {

            DB::beginTransaction();
            $update_send_bank = Bank::findOrFail($request->sender_bank_id);
            if ((int)$update_send_bank->amount < $request->paid) {
                session()->flash('error', 'Amount cant be greater than Bank Amount!');
                return back();
            }
            $update_send_bank->amount -= $request->paid;
            $update_send_bank->save();
            $cashDrawer = CashDrawer::find($request->cash_drawer_id);
            $bankTransfer->fill($request->all())->save();

            $data = [
                'cash_id' => $request->cash_drawer_id,
                'cash_type' => CashHistory::CASH_TYPE['bank_to_cash'],
                'current_branch_id' => auth()->user()->branch_id,
                'receiver_branch_id' => $cashDrawer->branch_id,
                'sender_id' => auth()->user()->branch_id, //logged-in user branch id
                'amount' => $request->paid,
                'payment_method_id' => 7,
                'connect_id'   => $update_send_bank->id,
                'payment_reference' => $bankTransfer->id,
                'note' => 'Bank to Cash Transfer',
                'date' => date('Y-m-d'),
                'money_transfer_id' => $update_send_bank->id,
                'status' => CashHistory::STATUS['pending'],
            ];


            $cashHistory->fill($data)->save();
            DB::commit();
            session()->flash('message', 'Transfer  Successfully!');
            return redirect()->route('banks.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Something Went Wrong!');
            return $e->getMessage();
            DB::rollBack();
            return redirect()->back();
        }
    }
}
