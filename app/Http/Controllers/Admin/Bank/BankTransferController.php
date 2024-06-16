<?php

namespace App\Http\Controllers\Admin\Bank;

use App\Actions\SupplierBankPayment;
use App\Http\Controllers\Controller;
use App\Http\Requests\BankTransferRequest;
use App\Model\Bank;
use App\Model\BankTransfer;
use App\Model\BranchPaymentMethod;
use App\Model\CashDrawer;
use App\Model\CashHistory;
use App\Model\Designation;
use App\Model\MoneyTransfer;
use App\Model\Purchase;
use App\Model\PurchaseDue;
use App\Model\PurchasePaymentInvoice;
use App\Model\SaleDelivery;
use App\Model\Stock;
use App\Model\Supplier;
use App\Model\User;
use App\Services\BankService;
use App\Traits\ApiResponse;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class BankTransferController extends Controller
{

    use  ApiResponse;

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request): View|Factory|Application
    {
        ini_set('memory_limit', '-1');
        $bankTransfer = BankTransfer::query()
            ->with(['user', 'senderUser', 'senderBank', 'receiverBank'])
            ->with(['sale.customer:id,name'])
            ->when(auth()->user()->is_main_branch, function ($query) {
                $query->get();
            })
            ->when(isBranch(), function ($query) {
                $query->where('branch_id', auth()->user()->branch_id)
                    ->orWhere('user_id', auth()->user()->id);
            })
            ->when(isSupplier(), function ($query) {
                $query->where('user_id', '=', auth()->user()->id);
            })
            ->filterByDate($request->get('from-date'), $request->get('to-date'))
            ->filterByStatus($request)
            ->orderBy('date', 'desc');

        $clone  = $bankTransfer->newQuery()->get();

        $total_amount  = collect($clone)->sum('paid');

        $bankTransfer = $bankTransfer->paginate(100);

        return view('admin.bank.transactionList', compact('bankTransfer','total_amount'));
    }

    public function create()
    {

        if (auth()->user()->is_main_branch != 1) {
            $users = User::orderBy('name', 'asc')->get();
            $designations = Designation::orderBy('name', 'asc')->get();
            $senderAccount = Bank::where('branch_id', auth()->user()->branch_id)->where('is_main_bank', 1)->get();
            $receiverAccount = Bank::where('user_id', '!=', auth()->user()->id)->get();
            return view('admin.bank.branch-payment', compact('users', 'senderAccount'));
        }
        $resource = (new BankService())->bankPaymentResource();
        return view('admin.bank.makePayment', compact('resource'));
    }

    public function sendMoney()
    {
        $users = User::query()
            ->active()
            ->whereNot('id', auth()->id())
            ->get();
        $senderAccount = Bank::where('branch_id', auth()->user()->branch_id)->where('is_main_bank', 1)->get();
        $receiverAccount = Bank::where('user_id', '!=', auth()->user()->id)->get();

        return view('admin.bank.branch-payment', compact('users', 'senderAccount', 'receiverAccount'));
    }

    public function sendMoneyStore(Request $request, BankTransfer $bankTransfer)
    {

        $validated = $request->validate([
            'sender_bank_id' => 'required',
            'user_id' => 'required',
            'receiver_bank_id' => 'required',
            'paid' => 'required|gt:0',
            'amount' => 'required|gt:0',
        ]);
        dd($request->all());
        try {
            DB::beginTransaction();
            $bankTransfer->fill($request->all())->save();
            // $update_receiver_bank = Bank::find($request->receiver_bank_id);
            // $update_receiver_bank->amount += $request->paid;
            // $update_receiver_bank->save();
            $update_send_bank = Bank::find($request->sender_bank_id);
            if ((int)$update_send_bank->amount < $request->paid) {
                session()->flash('error', 'Amount cant be greater than Bank Amount!');
                return back();
            }
            $update_send_bank->amount -= $request->paid;
            $update_send_bank->save();
            DB::commit();
            session()->flash('message', 'Bank Transfer create Successfully!');
            return redirect()->route('banks.index');
        } catch (Throwable $e) {
            session()->flash('error', 'Something Went Wrong!');
            return $e->getMessage();
            DB::rollBack();
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BankTransferRequest $request
     * @return JsonResponse|void
     * @throws Throwable
     */
    public function store(BankTransferRequest $request)
    {
        if ($request->payment_type == 'Supplier') {
            $payment = (new SupplierBankPayment)->execute($request);
            if (isset($payment->id)) {
                return $this->respondSuccess($payment, 'Supplier Bank Payment Successfully!');
            }
        }
    }

    public function single_transaction(Request $request, $bank_id)
    {

        $bank = Bank::where('id', $bank_id)->with('user')->first();
        $send_amount = BankTransfer::where('sender_bank_id', $bank_id)->sum('paid');
        //return $purchasePayments;
        $bank_transaction = BankTransfer::with(['user'])
            ->where('receiver_bank_id', $bank_id)
            ->orWhere('sender_bank_id', $bank_id)
            ->when(isBranch(), function ($query) {
                $query->orwhere('branch_id', auth()->user()->branch_id);
            })
            ->filterByStatus($request)
            ->filterByDate($request->get('from-date'), $request->get('to-date'))
            ->orderBy('id', 'desc');
        $clone_transaction = $bank_transaction->newQuery()->get();
        $total_amount = collect($clone_transaction)->sum('paid');

        $bank_transaction = $bank_transaction->paginate(100);
        return view('admin.bank.single-bank-transation', compact(
            'bank_transaction',
            'send_amount',
            'bank',
            'total_amount'
        ));
    }


    /**
     * @throws Throwable
     */
    public function acceptTransfer($id)
    {
        DB::beginTransaction();
        $bankTransfer = BankTransfer::findOrFail($id);
        $receiveBankAccount = Bank::where('id', $bankTransfer->receiver_bank_id)->first();
        $receiveBankAccount->update([
            'amount' => $receiveBankAccount->amount + $bankTransfer->paid,
        ]);
        $bankTransfer->update([
            'status' => 1
        ]);
        if ($bankTransfer->cash_id != null) {
            $cashHistory = CashHistory::query()
                ->where('id', $bankTransfer->connect_id)
                ->update([
                    'status' => CashHistory::STATUS['receive'],
                ]);
        } else if ($bankTransfer->money_transfer_id) {
            MoneyTransfer::query()
                ->where('id', $bankTransfer->money_transfer_id)
                ->update([
                    'status' => MoneyTransfer::STATUS['Receive'],
                ]);
        }

        DB::commit();
        return redirect()->back();
    }

    /**
     * @throws Throwable
     */
    public function rejectTransfer($id)
    {
        DB::beginTransaction();
        $bankTransfer = BankTransfer::query()->findOrFail($id);
        $purchasePaymentInvoices = PurchasePaymentInvoice::wherePurchasePaymentsId($bankTransfer->connect_id)->get();
        foreach ($purchasePaymentInvoices as $value) {
            $purchaseDue = PurchaseDue::query()->wherePurchaseId($value->purchase_id)->firstOrFail();
            $purchaseDue?->update([
                'paid_total' => $purchaseDue->paid_total - $value->total_pay,
                'due_total' => $purchaseDue->due_total + $value->total_pay,
            ]);
        }
        if ($bankTransfer->payment_method_id != null) {
            $branchPaymentMethod = BranchPaymentMethod::query()
                ->where('payment_method_id', $bankTransfer->payment_method_id)
                ->first();
            $branchPaymentMethod->update([
                'total_balance' => $branchPaymentMethod->total_balance + $bankTransfer->paid,
                'transfer_balance' => $branchPaymentMethod->transfer_balance - $bankTransfer->paid,
            ]);
        } else if ($bankTransfer->cash_id != null) {
            $recieverCashDrawer = CashDrawer::query()->where('id', $bankTransfer->cash_id)->first();
            $recieverCashDrawer->update([
                'amount' => $recieverCashDrawer->amount + $bankTransfer->paid,
            ]);
            $cashHistory = CashHistory::query()
                ->where('id', $bankTransfer->connect_id)
                ->update([
                    'status' => CashHistory::STATUS['reject'],
                ]);
        } else if ($bankTransfer->money_transfer_id) {
            MoneyTransfer::query()
                ->where('id', $bankTransfer->money_transfer_id)
                ->update([
                    'status' => MoneyTransfer::STATUS['Reject'],
                ]);
        } else {
            $sendBankAccount = Bank::query()->where('id', $bankTransfer->sender_bank_id)->first();
            $sendBankAccount->update([
                'amount' => $sendBankAccount->amount + $bankTransfer->paid,
            ]);
        }
        $bankTransfer->update([
            'status' => 2
        ]);


        DB::commit();
        return redirect()->back();
    }

    //payment invoice

    public function singleInvoice($id)
    {
        $bankTransfer = BankTransfer::with(['user', 'senderUser', 'senderBank', 'receiverBank'])->where('id', $id)->first();

        return view('admin.bank.transfer-invoice', compact('bankTransfer'));
    }
}
