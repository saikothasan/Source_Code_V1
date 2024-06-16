<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Actions\PurchaseStoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Model\Purchase;
use App\Services\PurchaseService;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{

    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('purchases');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        return view('admin.purchase.list', PurchaseService::purchaseList($request));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.purchase.add', PurchaseService::purchaseResource());
    }

    /**
     * Store a newly created resource in storage.
     * @param PurchaseRequest $request
     * @param PurchaseStoreAction $action
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(PurchaseRequest $request, PurchaseStoreAction $action, Purchase $purchase)
    {
        try {
            DB::beginTransaction();
            $saved = $action->handle($request, $purchase);
            DB::commit();

            return $this->respondCreated($saved,
                'Product added successfully'
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
     * @param Purchase $purchase
     * @return Application|Factory|View
     */
    public function show(Purchase $purchase)
    {
        $purchase = PurchaseService::purchaseView($purchase);
        return view('admin.purchase.view', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        return redirect()->back();
    }
}
