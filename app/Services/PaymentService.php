<?php
namespace App\Services;

use App\Model\CashDrawer;
use App\Model\Employee;

class PaymentService
{
    public static function paymentData()
    {
        return [
            'payment_resource'=>json_encode([
                'employee' => Employee::query()
                    ->select('id as value','name as text')
                    ->get()
                    ->toArray(),
                'cashDrawer' => CashDrawer::query()
                    ->where('branch_id', auth()->user()->branch_id)
                    ->first(),
                'user' => auth()->user(),
            ]),
        ];
    }
}
