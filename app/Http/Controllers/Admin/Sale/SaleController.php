<?php

namespace App\Http\Controllers\Admin\Sale;

use App;
use App\Actions\Sale\NewSaleStoreAction;
use App\Actions\Sale\SaleSMSAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewSellRequest;
use App\Model\Sale;
use App\Services\SaleService;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class SaleController extends Controller
{

    use  ApiResponse;

    private Sale $sale;

    public function __construct()
    {
        $this->sale = new Sale;
        $this->middleware('auth');
        // $this->middleware('sale')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        ini_set('memory_limit', '-1');
//        return SaleService::saleList($request);
        return view('admin.sale.list', SaleService::saleList($request));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.sale.newSale', SaleService::saleResource());
    }

    /**
     * Store a newly created resource in storage.
     * @param NewSellRequest $request
     * @param NewSaleStoreAction $action
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(NewSellRequest $request, NewSaleStoreAction $action): JsonResponse
    {
        try {
            DB::beginTransaction();
            $stocksAvailable = [];
            foreach ($request->get('sale_products') as $value) {
                $availableStock = availableStock($value['product_barcode']);
                if ($value['quantity'] > $availableStock) {
                    $stocksAvailable[] = [
                        'available_stock' => $availableStock,
                        'product_barcode' => $value['product_barcode'],
                        'variation_sku' => $value['product_sku'],
                    ];
                }
            }
            if ($stocksAvailable) {
                return $this->respondSuccess($stocksAvailable, 'Check stock available quantity');
            }
            $newSale = $action->handle($request, $this->sale);
//            return $newSale;
            DB::commit();
            if (App::environment('production')) {
                $sale_sms_action = new SaleSMSAction();
                $sale_sms_action->execute($request, $newSale);
            }
            return $this->respondCreated($newSale,
                'Sale create successfully'
            );
        } catch (\Exception $e) {
            DB::rollBack();
//            Session::flash('error', 'Something went wrong!');
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
     * @param Sale $sale
     * @return Application|Factory|View
     */
    public function show(Sale $sale)
    {
        //return SaleService::newSaleView($sale);
        return view('admin.sale.view', ['sale' => SaleService::newSaleView($sale)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
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
