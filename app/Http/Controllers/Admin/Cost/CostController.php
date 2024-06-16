<?php

namespace App\Http\Controllers\Admin\Cost;

use App\Http\Controllers\Controller;
use App\Http\Requests\CostRequest;
use App\Model\Branch;
use App\Model\CashDrawer;
use App\Model\CashHistory;
use App\Model\Cost;
use App\Services\CostService;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Dd;
use Throwable;

class CostController extends Controller
{

    use ApiResponse;

    private Cost $cost_object;

    public function __construct()
    {
        $this->cost_object = new Cost;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request): View|Factory|Application
    {
        $costs = Cost::query()
            ->filterByBranch($request->get('branch'))
            ->filterByCostType($request->get('cost_type'))
            ->FilterByDate($request->get('from-date'), $request->get('to-date'))
            ->when(isBranch(), function ($query) {
                $query->where('branch_id', Auth::user()->branch_id);
            })
            ->when(isMainBranch(), function ($query) {
                $query->with(['costBranch:id,name', 'branch:id,name']);
            })
            ->with(['creator:id,name', 'paymentMethod:id,name', 'employee:id,name'])
            ->latest();

        $total_amount = $costs->newQuery()->sum('amount');

        $costs = $costs->paginate(100);

        return view('admin.cost.list', compact('costs', 'total_amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('admin.cost.add', CostService::CostData());
    }

    /**
     * Store a newly created resource in storage.
     * @param CostRequest $request
     * @param Cost $cost
     * @param CashHistory $cashHistory
     * @return Application|Factory|View|JsonResponse
     * @throws Throwable
     */
    public function store(CostRequest $request, Cost $cost, CashHistory $cashHistory)
    {
        try {
            DB::beginTransaction();
            $branch_id = auth()->user()->branch_id;
            $cash_drawer = CashDrawer::firstOrCreate(
                [
                    'branch_id' => $branch_id,
                ],
                [
                    'name' => Branch::query()->where('id', $branch_id)->first()->name,
                    'amount' => 0.00,
                    'branch_id' => $branch_id,
                ]
            );

            if ((int)$cash_drawer->amount < (int)$request->amount) {
                return throw new \Exception('Amount cant be greater than Cash Drawer Amount');
            }

            if (isset($request->details['selected_employee'])) {
                $employee_id = $request->details['selected_employee'];
            } elseif (isset($request->selected_employee)) {
                $employee_id = $request->selected_employee;
            } else {
                $employee_id = null;
            }

            $data = [
                'cost_type' => $request->selectedCost,
                'cost_category' => $request->selectedCostCategory,
                'amount' => $request->amount,
                'details' => $request->details,
                'receipt_no' => $cost->generateReceiptCode(),
                'branch_id' => Auth::user()->branch_id,
                'cost_branch_id' => $request->cost_branch_id ?? null,
                'employee_id' => $employee_id,
                'asset_branch_id' => $request->details['selected_asset_position'] ?? null,
                'payment_method_id' => $request->details['selected_payment_method'] ?? null,
            ];
            $cost->fill($data)->save();


            $cash_drawer_history = [
                'cash_id' => $cash_drawer->id,
                'cost_id' => $cost->id,
                'cash_type' => CashHistory::CASH_TYPE['cost'],
                'current_branch_id' => auth()->user()->branch_id,
                'sender_id' => auth()->user()->branch_id,
                'amount' => $request->amount,
                'note' => 'for cost',
                'date' => date('Y-m-d'),
                'status' => CashHistory::STATUS['received'],
            ];
            $cashHistory->fill($cash_drawer_history)->save();
            $cash_drawer->update([
                'amount' => $cash_drawer->amount - $request->amount,
            ]);
            DB::commit();
            return view('components.cost.cost-view', CostService::costView($cost));
        } catch (Throwable $e) {
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
     * @param Cost $cost
     * @return Application|Factory|View
     */
    public function show(Cost $cost)
    {
        return view('admin.cost.view', CostService::costView($cost));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $cost = Cost::findOrFail($id);
        return view('admin.cost.edit', compact('cost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        return redirect()->back();
    }
}
