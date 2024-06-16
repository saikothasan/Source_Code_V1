<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MoneyTransferRequset;
use App\Model\BankTransfer;
use App\Model\BranchPaymentMethod;
use App\Model\CashDrawer;
use App\Model\CashHistory;
use App\Model\MoneyTransfer;
use App\Services\TransferMoneyService;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MoneyTransferController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): Application|Factory|View
    {
        return view('admin.transfer-money.create', TransferMoneyService::transferData());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MoneyTransferRequset $request
     * @param MoneyTransfer $moneyTransfer
     * @return JsonResponse
     */
    public function store(MoneyTransferRequset $request, MoneyTransfer $moneyTransfer)
    {
        try {
            if ((int)$request->availableAmount < $request->amount) {
                return throw new \Exception('Given Amount cant be greater than transfer  amount');
            }
            DB::beginTransaction();
            $data = [
                'date' => date('Y-m-d'),
                'payment_method_id' => $request->selectedPaymentMethod['id'],
                'current_branch_id' => auth()->user()->branch_id,
                'receiver_branch_id' => $request->selectedBranch['id'] ?? null,
                'receive_type' => $request->selectedReceiverType,
                'cash_drawer_id' => $request->selectedCashDrawer['id'] ?? null,
                'bank_id' => $request->selectedBank['id'] ?? null,
                'bank_account_no' => $request->selectedBank['account_no'] ?? null,
                'available_amount' => $request->availableAmount,
                'transfer_amount' => $request->transferAmount,
                'remaining_amount' => $request->remainingAmount,
                'status' => MoneyTransfer::STATUS['pending'],
            ];
            $moneyTransfer->fill($data)->save();
            if ($request->selectedReceiverType == 'Cash Drawer') {
                $cashHistory = new CashHistory();
                $data = [
                    'cash_id' => $request->selectedCashDrawer['id'] ?? null,
                    'cash_type' => CashHistory::CASH_TYPE['payment_method'],
                    'branch_id' => $request->selectedBranch['id'],
                    'payment_method_id' => $request->selectedPaymentMethod['id'] ?? null,
                    'amount' => $request->transferAmount,
                    'date' => date('Y-m-d'),
                    'status' => CashHistory::STATUS['pending'],
                    'money_transfer_id' => $moneyTransfer->id,
                ];
                $cashHistory->fill($data)->save();
            }
            if ($request->selectedReceiverType == 'Bank') {
                $bankTransfer = new BankTransfer();
                $lastId = BankTransfer::query()->latest()->first();
                $lastId = $lastId->id ?? 0;
                $reference = 'CD' . '-' . strtoupper(str_replace('-', '', substr(auth()->user()->name, 0, 2))) . '-' . (str_pad((int)$lastId + 1, 5, '0', STR_PAD_LEFT));
                $data = [
                    'date' => date('Y-m-d'),
                    'receiver_bank_id' => $request->selectedBank['id'],
                    'branch_id' => $request->selectedBranch['id'],
                    'payment_method_id' => $request->selectedPaymentMethod['id'] ?? null,
                    'paid' => $request->transferAmount,
                    'reference_id' => $reference,
                    'type' => $request->selectedPaymentMethod['name'],
                    'user_id' => auth()->id(),
                    'status' => BankTransfer::STATUS['Pending'],
                    'money_transfer_id' => $moneyTransfer->id,
                ];

                $bankTransfer->fill($data)->save();
            }
            $branchPaymentMethod = BranchPaymentMethod::query()
                ->where('payment_method_id', $request->selectedPaymentMethod['id'])
                ->where('branch_id',auth()->user()->branch_id)
                ->first();
            $branchPaymentMethod->update([
                'total_balance' => $branchPaymentMethod->total_balance - $request->transferAmount,
                'transfer_balance' => $branchPaymentMethod->transfer_balance + $request->transferAmount,
            ]);
            DB::commit();
            return $this->respondCreated($moneyTransfer,
                'Money Transfer successfully'
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
                'data' => []
            ], 400);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param MoneyTransfer $transfer_money
     */
    public function show(MoneyTransfer $transfer_money)
    {
        $transfer_money = $transfer_money->load('paymentMethod:id,name','bank:id,name,account_no','branch:id,name','cashDrawer:id,name');
        return  view('admin.payment_method.show',compact('transfer_money'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param MoneyTransfer $moneyTransfer
     * @return Response
     */
    public function edit(MoneyTransfer $moneyTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param MoneyTransfer $moneyTransfer
     * @return Response
     */
    public function update(Request $request, MoneyTransfer $moneyTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MoneyTransfer $moneyTransfer
     * @return Response
     */
    public function destroy(MoneyTransfer $moneyTransfer): Response
    {
        //
    }
}
