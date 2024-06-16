<?php

namespace App\Actions\Sale;

use App;
use App\Http\Requests\NewSellRequest;
use App\Model\Sale;
use App\Services\SMSService;

class NewSaleStoreAction
{

    /**
     * @throws \Exception
     */
    public function handle(NewSellRequest $request, Sale $sale)
    {
        $saleAction = new SaleAction();
        $saleProductAction = new SaleProductAction();
        $salePaymentAction = new SalePaymentAction();

        $sale = $saleAction->handle($request, $sale);
        $saleProductAction->handle($request, $sale);
        $salePaymentAction->handle($request, $sale);
        if ($request->get('deliveryOption') && $request->get('delivery_man')) {
            $saleDeliveryAction = new SaleDeliveryAction();
            $saleDeliveryAction->handle($request, $sale);
        }
        return $sale;
    }

}
