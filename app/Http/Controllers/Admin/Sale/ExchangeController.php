<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Actions\Sale\Exchange\SaleExchangeStore;
use App\Model\Sale;
use App\Model\Sale_return;
use App\Model\Sale_detail;
use App\Model\Stock;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\SaleService;
use App\Model\SaleReturnDetail;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExchangeRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Session;

class ExchangeController extends Controller
{

    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
//        Session::flash('error', 'Exchange not available in this moment!');
//        return redirect()->back();
        return view('admin.sale.create-exchange', SaleService::exchangeReturnResource());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExchangeRequest $request
     * @param SaleExchangeStore $action
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(ExchangeRequest $request, SaleExchangeStore $action)
    {

        try {
            DB::beginTransaction();
            $exchange = $action->execute($request);
            DB::commit();
            return $this->respondCreated($exchange,
                'Sale exchange successfully'
            );
        } catch (\Exception $e) {
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
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
