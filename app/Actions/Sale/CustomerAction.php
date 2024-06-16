<?php

namespace App\Actions\Sale;

use App\Model\Customer;

class CustomerAction
{
    public function handle($request)
    {
       return Customer::firstOrCreate(
            ['phone' => $request->customer['phone']],
            [
                'name' => $request->customer['name'],
                'address' => $request->customer['address']
            ]

        );
    }
}
