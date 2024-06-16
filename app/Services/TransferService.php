<?php

namespace App\Services;


use App\Model\Branch;
use App\Model\CashDrawer;
use App\Model\PaymentMethod;

class TransferService
{
    public static function transferData(): array
    {
        return [
            'transfer_resource' => json_encode([
                'allBranch' => Branch::query()
                    ->active()
//                    ->where('id','!=' ,auth()->id() )
                    ->select('id', 'user_id', 'name')
                    ->orderBy('id')
                    ->get(),
                'cashDrawer' => CashDrawer::query()
                    ->where('branch_id', auth()->user()->branch_id)
                    ->first(),
                'user' => auth()->user(),
                'paymentMethod' => PaymentMethod::query()
                    ->active()
                    ->whereIn('name',  ['Cash','Bank'])
                    ->get(),
            ]),
        ];
    }
}
