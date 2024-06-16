<?php

namespace App\Actions\Sale;

use App\Jobs\SMSJob;
use App\Services\SMSService;

class SaleSMSAction
{
    public function execute($request, $sale)
    {
        $sms = [
            'sms_to' => $request->customer['phone'],
            'sms_text' => "আসসালামু আলাইকুম,\n"
                          .$request->customer['name']."\nআপনার অর্ডারটি কনফার্ম করা হলো, ইনভয়েস নম্বর # ". $sale->invoice_code ."\nজাজাকাল্লাহ খইরন ❤️\nপ্রডাক্ট দেখতে ক্লিক করুন \nwww.colourful.com.bd"
        ];
        SMSService::sendSms($sms);
        //SMSJob::dispatch($sms);
    }
}
