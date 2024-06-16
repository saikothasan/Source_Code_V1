<?php

namespace App\Http\Controllers\Admin\TransferReceived;

use App\Http\Controllers\Controller;
use App\Model\Stock;
use App\Model\TransferReceive;
use App\Model\TransferReceiveDetail;
use App\Services\TransferReceivedService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReceivedProductController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.transfer-received.received-product-list', TransferReceivedService::receivedList($request));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $userId = auth()->user()->id;
            $transfer = TransferReceive::findOrFail($request->get('transfer_receive_id'));
            if ($request->get('receive_type') === 'received') {
                if ($transfer->status === 0) {
                    $transfer->update([
                        'status' => TransferReceive::STATUS['Received'],
                        'receive_by' => $userId,
                    ]);
                    Stock::where('transfer_id', $transfer->id)->update([
                        'stock_status' => Stock::STATUS['Stock'],
                        'current_branch' => $transfer->receive_branch,
                        'transfer_id' => null,
                    ]);

                    $received = new TransferReceive();
                    $received->date = date('Y-m-d');
                    $received->invoice_type = TransferReceive::INVOICE_TYPE['receive'];
                    $received->invoice_code = TransferReceivedService::receivedInvoice();
                    $received->user_id = $transfer->user_id;
                    $received->total_quantity = $transfer->total_quantity;
                    $received->subtotal = $transfer->subtotal;
                    $received->total = $transfer->total;
                    $received->supplier_id = $transfer->supplier_id;
                    $received->transfer_branch = $transfer->transfer_branch;
                    $received->receive_branch = $transfer->receive_branch;
                    $received->receive_by = $userId;
                    $received->main_branch = auth()->user()->is_main_branch ? auth()->user()->branch_id : null;
                    $received->status = TransferReceive::STATUS['Received'];
                    $received->save();

                    $transferProducts = TransferReceiveDetail::where('transfer_invoice_id', $transfer->id)->get();
                    foreach ($transferProducts as $value) {
                        $receivedProduct = new TransferReceiveDetail();
                        $details = [
                            'date' => date('Y-m-d'),
                            'invoice_code' => $received->invoice_code,
                            'transfer_invoice_id' => $received->id,
                            'transfer_receive_from' => $transfer->id,
                            'user_id' => $userId,
                            'product_id' => $value['product_id'],
                            'product_sku' => $value['product_sku'],
                            'product_barcode' => $value['product_barcode'],
                            'supplier_id' => $value['supplier_id'],
                            'main_branch' => $value['main_branch'],
                            'transfer_branch' => $transfer->transfer_branch,
                            'current_branch' => $transfer->receive_branch,
                            'quantity' => $value['quantity'],
                            'rate' => $value['rate'],
                            'total' => $value['total'],

                        ];
                        $receivedProduct->fill($details)->save();
                    }
                    DB::commit();
                    Session::flash('message', 'Transfer received Successfully!');
                    return redirect()->back()->with('received', $received->id);
                }

            } elseif ($request->get('receive_type') === 'reject') {
                if ($transfer->status === 0) {

                    $transfer->update([
                        'status' => TransferReceive::STATUS['Reject'],
                        'receive_by' => $userId
                    ]);
                    Stock::where('transfer_id', $transfer->id)->update([
                        'stock_status' => Stock::STATUS['Stock'],
                        'current_branch' => $transfer->transfer_branch,
                        'transfer_id' => null,
                    ]);
                    DB::commit();
                    Session::flash('message', 'Transfer Reject Successfully!');
                    return redirect()->back();

                }

            }
        } catch (\Throwable $exception) {
            Session::flash('error', 'Something went wrong');
            return redirect()->back();
        }


    }

    public function show(TransferReceive $received_product)
    {
        $receivedProduct = TransferReceivedService::transferView($received_product);
        return view('admin.transfer-received.received-show', compact('receivedProduct'));
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
