<?php

namespace App\Http\Controllers\Admin\CashDrawer;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Model\Bank;
use App\Model\BankTransfer;
use App\Model\Branch;
use App\Model\CashDrawer;
use App\Model\CashHistory;
use App\Model\User;
use App\Services\TransferService;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use NumberToWords\Legacy\Numbers\Words\Locale\Pt\Br;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

class TransferController extends Controller
{
    use  ApiResponse;

    public function create()
    {
        return view('admin.cash-drawer.transfer.add', TransferService::transferData());
    }

    public function store(TransferRequest $request, CashHistory $cashHistory, BankTransfer $bankTransfer): JsonResponse
    {
        try {
            DB::beginTransaction();
            $senderCashDrawer = CashDrawer::query()->where('branch_id', $request->sender_cash_id)->first();
            $receiverCashDrawer = CashDrawer::query()->where('branch_id', $request->selectedBranch['id'])->first();
            if ((int)$senderCashDrawer->amount < (int) $request->amount) {
                return throw new \Exception('Amount cant be greater than Cash Drawer Amount');
            }
            $data = [
                'cash_id' => $receiverCashDrawer->id,
                'cash_type' => CashHistory::CASH_TYPE['transfer'],
                'current_branch_id' => auth()->user()->branch_id,
                'receiver_branch_id' => $request->selectedBranch['id'],
                'sender_id' => auth()->user()->branch_id, //logged-in user branch id
                'payment_method_id' => $request->selectPaymentMethod,
                'payment_reference' => $request->selectedBank['account_no'] ?? null,
                'amount' => $request->amount,
                'note' => $request->note,
                'date' => date('Y-m-d'),
                'status' => CashHistory::STATUS['pending'],
            ];
            $cashHistory->fill($data)->save();
            $senderCashDrawer->update([
                'amount' => $senderCashDrawer->amount - $request->amount,
            ]);
            if ($request->selectPaymentMethod == 7) {
                $bank = Bank::query()->where('account_no', $request->selectedBank['account_no'])->first();
                $bankTransfer = new BankTransfer();
                $lastId = BankTransfer::query()->latest()->first();
                $lastId = $lastId->id ?? 0;
                $reference = 'CD' . '-' . strtoupper(str_replace('-', '', substr(auth()->user()->name, 0, 2))) . '-' . (str_pad((int)$lastId + 1, 5, '0', STR_PAD_LEFT));
                $data = [
                    'date' => date('Y-m-d'),
                    'receiver_bank_id' => $bank->id,
                    'paid' => $request->amount,
                    'sender_bank_id' => null,
                    'reference_id' => $reference,
                    'type' => 'Cash Drawer',
                    'user_id' => auth()->id(),
                    'current_branch_id' => auth()->user()->branch_id,
                    'branch_id' => $request->selectedBranch['id'],
                    'cash_id' => $senderCashDrawer->id,
                    'connect_id' =>$cashHistory->id,
                ];
                $bankTransfer->fill($data)->save();
            }
            DB::commit();
            return $this->respondCreated($cashHistory,
                'Payment Successful'
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

    public function show()
    {
        return view('admin.cash-drawer.transfer.show');
    }
}
