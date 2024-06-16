<?php

namespace App\Http\Controllers\Admin\CashDrawer;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Model\CashDrawer;
use App\Model\CashHistory;
use App\Services\PaymentService;
use App\Services\TransferService;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use  ApiResponse;
    public function create(): Factory|View|Application
    {
        return view('admin.cash-drawer.payment.add', PaymentService::paymentData());
    }

    public function store(PaymentRequest $request, CashHistory $cashHistory)
    {
        try {
            $senderCashDrawer = CashDrawer::query()->where('id', $request->sender_cash_id)->first();
            if ((int)$senderCashDrawer->amount < $request->amount) {
                return throw new \Exception('Given Amount cant be greater than Cash Drawer Amount');
            }
            $data = [
                'cash_type' => 1,
                'employee_id' => $request->selectedEmployee,
                'sender_id' => $request->sender_cash_id,
                'branch_id' => auth()->user()->branch_id,
                'amount' => $request->amount,
                'note' => $request->note,
                'date' => date('Y-m-d'),
                'status' => null,
            ];
            $cashHistory->fill($data)->save();
            $senderCashDrawer->update([
                'amount' => $senderCashDrawer->amount - $request->amount,
            ]);

//            return view('components.payment.payment', ['cashHistory' => $cashHistory->load('branch:id,name', 'receiver:id,name')]);
            return $this->respondCreated($cashHistory,
                'Payment Successful'
            );
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
                'data' => []
            ], 400);
        }
    }

    public function show()
    {
        return view('admin.cash-drawer.payment.show');
    }
}
