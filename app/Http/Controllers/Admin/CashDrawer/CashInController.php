<?php

namespace App\Http\Controllers\Admin\CashDrawer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CashInRequest;
use App\Model\CashDrawer;
use App\Model\CashHistory;
use App\Model\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class CashInController extends Controller
{
    use  ApiResponse;

    public function create()
    {
        $employees = User::where('branch_id', auth()->user()->branch_id)
            ->active()
            ->select('id as value', 'name as text')
            ->orderBy('name')
            ->get();
        return view('admin.cash-drawer.cash-in.add', compact('employees'));
    }

    public function store(CashInRequest $request, CashHistory $cashHistory)
    {
        try {
            $cashDrawer = CashDrawer::query()
                ->where('branch_id', Auth::user()->branch_id)
                ->first();
            $data = [
                'cash_id' => $cashDrawer->id,
                'cash_type' => 0,
                'note' => $request->note,
                'branch_id' => auth()->user()->branch_id,
                'employee_id' => $request->employee,
                'amount' => $request->amount,
                'date' => date('Y-m-d'),
            ];
            $cashHistory->fill($data)->save();
            $cashDrawer->update([
                'amount' =>  $cashDrawer->amount + $request->amount,
            ]);
            return redirect()->back()->with('id', $cashHistory->id);
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
        return view('admin.cash-drawer.cash-in.show');
    }
}
