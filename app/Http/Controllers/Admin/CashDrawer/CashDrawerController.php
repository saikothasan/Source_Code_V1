<?php

namespace App\Http\Controllers\Admin\CashDrawer;

use App\Http\Controllers\Controller;
use App\Model\Bank;
use App\Model\BankTransfer;
use App\Model\Branch;
use App\Model\BranchPaymentMethod;
use App\Model\CashDrawer;
use App\Model\CashHistory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CashDrawerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request, CashDrawer $cashDrawer)
    {
        $branch = Branch::where('id', auth()->user()->branch_id)->first();
        CashDrawer::firstOrCreate(
            [
                'branch_id' => $branch->id,
            ],
            [
                'name' => $branch->name,
                'amount' => 0.00,
                'branch_id' => $branch->id,
            ]
        );
        $cashDrawer = $cashDrawer->where('branch_id', auth()->user()->branch_id)->first();
        return view('admin.cash-drawer.dashboard', compact('cashDrawer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(Request $request): View
    {
        $start = request()->get('from-date');
        $end = request()->get('to-date');
        $cashIn = request()->get('isCash');
        $payment = request()->get('isPayment');
        $transfer = request()->get('isTransfer');
        $cashHistory = CashHistory::query()
            ->filterByDate($start, $end)
            ->when(isMainBranch(), function ($query) {
                $query
                    ->Where('branch_id', auth()->user()->branch_id)
                    ->OrWhere('current_branch_id', auth()->user()->branch_id)
                    ->OrWhere('receiver_branch_id', auth()->user()->branch_id);
                // ->whereNot('payment_method_id', 7);
            })
            ->when(isBranch(), function ($query) {
                $query->Where('current_branch_id', auth()->user()->branch_id)
                    ->OrWhere('branch_id', auth()->user()->branch_id)
                    ->OrWhere('receiver_branch_id', auth()->user()->branch_id);
                // ->whereNot('payment_method_id', 7);
            })
            ->latest('date');

        $total_amount = $cashHistory->newQuery()->sum('amount');
        $cashHistory =     $cashHistory->paginate(100);
        return view('admin.cash-drawer.cashDrawerList', compact('cashHistory','total_amount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, CashHistory $cashHistory): Response
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param CashHistory $cash_drawer
     * @return View
     */
    public function show(CashHistory $cash_drawer): View
    {
        //dd($cash_drawer);
        return view('admin.cash-drawer.cash-in.show', [
            'cash_drawer' => $cash_drawer->load(
                'employee:id,name',
                'sender:id,name',
                'receiver:id,name',
                'branch:id,name',
                'receiverBranch:id,name',
                'bank:id,name,account_no'
            )
        ]);
    }

    public function acceptTransfer(CashHistory $cash_drawer): RedirectResponse
    {
        // dd($cash_drawer);
        if ($cash_drawer->cash_type == 7) {
            $bankTransfer  = BankTransfer::query()->where('id', $cash_drawer->payment_reference)->first();
            // dd($bankTransfer);

            $bankTransfer->update([
                'status' => 1,
            ]);
        }
        $receiverCashDrawer = CashDrawer::query()->where('id', $cash_drawer->cash_id)->first();
        $receiverCashDrawer->update([
            'amount' => $receiverCashDrawer->amount + $cash_drawer->amount,
        ]);
        $cash_drawer->update([
            'status' => 1
        ]);



        return redirect()->back();
    }

    public function rejectTransfer(CashHistory $cash_drawer)
    {
        // dd($cash_drawer);
        if ($cash_drawer->cash_type == CashHistory::CASH_TYPE['payment_method']) {
            $branchPaymentMethod = BranchPaymentMethod::query()
                ->where('payment_method_id', $cash_drawer->payment_method_id)
                ->first();
            $branchPaymentMethod->update([
                'total_balance' => $branchPaymentMethod->total_balance + $cash_drawer->amount,
                'transfer_balance' => $branchPaymentMethod->transfer_balance - $cash_drawer->amount,
            ]);
        } elseif ($cash_drawer->cash_type == 7) {

            $bankTransfer  = BankTransfer::query()->where('id', $cash_drawer->payment_reference)->first();

            $bankTransfer->update([
                'status' => 2,
            ]);

            $bankBlancUpdate = Bank::query()
                ->where('id', $cash_drawer->money_transfer_id)
                ->first();

            $bankBlancUpdate->update([
                'amount' => $bankBlancUpdate->amount + $cash_drawer->amount,
            ]);
        } else {
            $senderCashDrawer = CashDrawer::where('id', $cash_drawer->sender_id)->first();
            $senderCashDrawer->update([
                'amount' => $senderCashDrawer->amount + $cash_drawer->amount,
            ]);
        }
        $cash_drawer->update([
            'status' => 4
        ]);
        return redirect()->back();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(CashHistory $cashHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, CashHistory $cashHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(CashHistory $cash_drawer)
    {
        return redirect()->back();
    }
}
