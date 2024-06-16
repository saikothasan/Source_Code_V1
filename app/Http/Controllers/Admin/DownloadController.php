<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\BankTransfer;
use App\Model\CashHistory;
use App\Model\Purchase;
use App\Model\Purchase_return;
use App\Model\Report;
use App\Model\Sale;
use App\Model\Sale_return;
use App\Model\Supplier;
use App\Model\TransferReceive;
use App\Services\PurchaseService;
use App\Services\Report\ReportService;
use App\Services\SaleService;
use App\Services\SupplierService;
use App\Services\TransferReceivedService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function purchaseDownload(Purchase $purchase)
    {
        $purchase = PurchaseService::purchaseView($purchase);
        
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'is RemoteEnabled' => true])->loadView('download.purchases-invoice', ['purchase' => $purchase]);
        $name = 'Purchases Invoice ' . $purchase->invoice;
        return $pdf->download($name . '.pdf');
    }

    public function SaleDownload(Sale $sale)
    {

        $sale = SaleService::newSaleView($sale);

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'is RemoteEnabled' => true])->loadView('download.sale-invoice', ['sale' => $sale]);
        $name = 'Sale Invoice ' . $sale->invoice_code;
        return $pdf->download($name . '.pdf');
    }

    public function PurchaseReturnDownload(Purchase_return $purchase_return)
    {
        $purchase_return = PurchaseService::purchaseReturnView($purchase_return);
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'is RemoteEnabled' => true])->loadView('download.purchases-return-invoice', ['purchase_return' => $purchase_return]);
        $name = 'Purchases Return Invoice ' . $purchase_return->invoice;
        return $pdf->download($name . '.pdf');
    }

    public function ProductReceivedDownload(TransferReceive $received_product)
    {
        $received_product = TransferReceivedService::transferView($received_product);
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'is RemoteEnabled' => true])->loadView('download.product-received-invoice', ['received_product' => $received_product]);
        $name = 'Product Received Invoice ' . $received_product->invoice;
        return $pdf->download($name . '.pdf');
    }

    public function ProductTransferDownload(TransferReceive $transfer_product)
    {
        $transfer_product = TransferReceivedService::transferView($transfer_product);
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'is RemoteEnabled' => true])->loadView('download.product-transfer-invoice', ['transfer_product' => $transfer_product]);
        $name = 'Product Transfer Invoice ' . $transfer_product->invoice;
        return $pdf->download($name . '.pdf');
    }

    public function CashHistoryDownload(CashHistory $cash_drawer)
    {
        //dd($cash_drawer);
        $cash_drawer = $cash_drawer->load(
            'employee:id,name',
            'sender:id,name',
            'receiver:id,name',
            'branch:id,name',
            'receiverBranch:id,name',
            'bank:id,name,account_no'
        );
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'is RemoteEnabled' => true])->loadView('download.cash-history-invoice', ['cash_drawer' => $cash_drawer]);
        $name = 'Cash Transfer Invoice ' . $cash_drawer->id;
        return $pdf->download($name . '.pdf');
    }

    public function BankTransferDownload(BankTransfer $bankTransfer)
    {

        $bankTransfer = BankTransfer::with(['user', 'senderUser', 'senderBank', 'receiverBank'])->where('id', $bankTransfer->id)->first();
        $pdf =PDF::setOptions(['isHtml5ParserEnabled' => true, 'is RemoteEnabled' => true])->loadView('download.branch-transfer-invoice', ['bankTransfer' => $bankTransfer]);
        $name = 'Branch Payment Invoice' . $bankTransfer->id;
        return $pdf->download($name . '.pdf');
    }

    public function SupplierTransfer(Supplier $supplier_transfer)
    {


        $purchasePayment = SupplierService::purchasePaymentInvoice($supplier_transfer->id);
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'is RemoteEnabled' => true])->loadView('download.supplier-payment-invoice', ['purchasePayment' => $purchasePayment]);
        $name = 'Supplier Payment Invoice' . $purchasePayment->id;
        return $pdf->download($name . '.pdf');
    }

    public function reportDownload(Report $report)
    {
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'is RemoteEnabled' => true])
            ->loadView('download.report', ['report' => $report]);
        $name = $report['report_name'] . ' ' . $report['report_id'];
        return $pdf->download($name . '.pdf');
    }
}
