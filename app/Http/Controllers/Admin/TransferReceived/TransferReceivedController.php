<?php

namespace App\Http\Controllers\Admin\TransferReceived;

use App\Http\Controllers\Controller;
use App\Services\TransferReceivedService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;


class TransferReceivedController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request)
    {
        $transferReceived = TransferReceivedService::transferReceivedList($request);
//        return  $transferReceived;
        return view('admin.transfer-received.transfer-received-list', compact('transferReceived'));
    }
}
