<?php

namespace App\Http\Controllers\Admin\TransferReceived;

use App\Actions\ProductTransferAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductTransferRequest;
use App\Model\TransferReceive;
use App\Services\TransferReceivedService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferProductController extends Controller
{
    use ApiResponse;

    public function index()
    {

    }

    public function create()
    {
        return view('admin.transfer-received.transfer-create', TransferReceivedService::transferResource());
    }

    public function store(ProductTransferRequest $request, ProductTransferAction $action)
    {
        try {
            DB::beginTransaction();
            $branch_id = auth()->user()->branch_id;
            if (isSupplier()) {
                $branch_id = getMainBranch()->id;
            }
            $stocksAvailable = [];
            foreach ($request->get('transfer_products') as $value) {
                $availableStock = availableStock($value['product_barcode'], $branch_id);
                if ($value['quantity'] > $availableStock) {
                    $stocksAvailable[] = [
                        'available_stock' => $availableStock,
                        'product_barcode' => $value['product_barcode'],
                        'variation_sku' => $value['variation_sku'],
                    ];
                }
            }
            if ($stocksAvailable) {
                return $this->respondSuccess($stocksAvailable, 'Check stock available quantity');
            }

            $transfer = $action->handle($request);
            DB::commit();
            return $this->respondCreated($transfer,
                'Product transfer add successfully'
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

    public function show(TransferReceive $transfer_product)
    {
        $transferProduct = TransferReceivedService::transferView($transfer_product);
        //return $transferProduct;
        return view('admin.transfer-received.transfer-show', compact('transferProduct'));
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
