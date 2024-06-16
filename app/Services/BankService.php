<?php

namespace App\Services;

class BankService
{
    public function bankPaymentResource()
    {
        return [
            'designations' => getAllDesignation(),
            'sender_accounts' => managementBanks(),
        ];
    }
}
