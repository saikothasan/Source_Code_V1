<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleInvoiceRequest;
use App\Http\Resources\Admin\Sale\InvoiceResource;
use App\Model\Sale;
use App\Model\SaleDelivery;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class GetInvoiceController extends Controller
{

    use ApiResponse;

    public $currentDate;

    public function __constructor()
    {
        $this->currentDate = Carbon::now();
    }

    /**
     * Handle the incoming request.
     *
     * @param SaleInvoiceRequest $request
     */

    public function __invoke(SaleInvoiceRequest $request)
    {
        $sale = Sale::query()
            ->saleType(Sale::SALETYPE['pos_sale'])
            ->where('branch_id', auth()->user()->branch_id)
            ->where('invoice_code', $request->get('invoice_code'))
            ->with(['saleProducts' => [
                'product',
                'productVariations.variantValues.variantValueName'
            ],
                'customer:id,name,phone',
                'salePayment',
                'delivery:id,name,phone,delivery_area',
                'saleDelivery',
                'saleReturns.returnProducts' => [
                    'product',
                    'productVariations.variantValues.variantValueName'
                ],
            ])
            ->withCount('saleReturns')
            ->withCount('exchanges')
            ->first();
        if ($sale->saleDelivery && $sale->saleDelivery->order_status == SaleDelivery::ORDER_STATUS['pending']) {
            $validator = Validator::make([], []);
            $validator->errors()->add('invoice_code', 'Order Status pending');
            throw new ValidationException($validator);
        }
        if ($request->invoice_type == 'return') {
            $this->returnPossibility($sale);
        }
        if ($request->invoice_type == 'exchange') {
            $this->exchangePossibility($sale);
        }
        return $this->respondSuccess(new InvoiceResource($sale), 'sale invoice');
    }

    private function returnPossibility($sale)
    {
        $validator = Validator::make([], []);
        if ($sale->sale_returns_count >= getSetting('return_total')) {
            $validator->errors()->add('invoice_code', 'Sale return limit reached');
            throw new ValidationException($validator);
        }
        if ($this->diffInDays($sale) >= getSetting('return_in')) {
            $validator->errors()->add('invoice_code', 'Sale return time limit reached');
            throw new ValidationException($validator);
        }
    }

    private function exchangePossibility($sale)
    {
        $validator = Validator::make([], []);
        if ($sale->exchanges_count >= getSetting('exchange_total')) {
            $validator->errors()->add('invoice_code', 'Sale exchange limit reached');
            throw new ValidationException($validator);
        }
        if ($this->diffInDays($sale) >= getSetting('exchange_in')) {
            $validator->errors()->add('invoice_code', 'Sale exchange time limit reached');
            throw new ValidationException($validator);
        }
    }

    private function diffInDays($sale)
    {
        return $sale->created_at->diffInDays($this->currentDate);
    }
}
