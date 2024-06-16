<?php

namespace App\Services;


use App\Model\Bank;
use App\Model\Branch;
use App\Model\CashDrawer;
use App\Model\PaymentMethod;
use JetBrains\PhpStorm\ArrayShape;

class TransferMoneyService
{
    public static function transferData(): array
    {
        $mainBranch = Branch::query()->where('is_main_branch',1)->first();
        return [
            'transferResource' => json_encode([
                'paymentMethod' => PaymentMethod::query()
                    ->whereIn('name', ['Bkash', 'Nagad', 'Rocket'])
                    ->withSum('methodBalance','total_balance')
                    ->get(),
                'receiverType' => (array) [
                    1 => 'Cash Drawer',
                    2 => 'Bank',
                ],
                'mainBranchBank' => Bank::query()->where('branch_id', $mainBranch->id)->get(),
                'cashDrawer' => CashDrawer::query()->whereIn('branch_id', [ $mainBranch->id,auth()->user()->branch_id])->get(),
                'branch' => Branch::query()->whereIn('id', [ $mainBranch->id,auth()->user()->branch_id])->get(),
            ]),
        ];
    }
}
