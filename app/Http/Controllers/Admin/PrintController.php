<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Attendance;
use App\Model\Bank_transaction;
use App\Model\Customer;
use App\Model\Department;
use App\Model\Employee;
use App\Model\Loan_advance;
use App\Model\Month;
use App\Model\Owner;
use App\Model\Product;
use App\Model\Purchase;
use App\Model\Purchase_detail;
use App\Model\Purchase_payment;
use App\Model\Quotation;
use App\Model\QuotationDetail;
use App\Model\Salary;
use App\Model\Sale;
use App\Model\Sale_detail;
use App\Model\Sale_payment;
use App\Model\Supplier;
use App\Model\TransferReceive;
use App\Product_return;
use App\Services\PurchaseService;
use App\Services\SaleService;
use App\Services\TransferReceivedService;
use Illuminate\Http\Request;

class PrintController extends Controller
{

    public function newSalePrint(Sale $sale)
    {
        $sale = SaleService::newSaleView($sale);

        return view('print.new-sale-print',compact('sale'));
    }

    public function purchasePrint(Purchase $purchase)
    {
        $purchase = PurchaseService::purchaseView($purchase);

        return view('print.purchases-print',compact('purchase'));
    }

    public function purchaseBarcode(Purchase $purchase)
    {
        $purchase = PurchaseService::purchaseView($purchase);

        return view('print.purchase-barcode-print',compact('purchase'));
    }
    public function transferPrint(TransferReceive $transfer_product)
    {
        $transferProduct = TransferReceivedService::transferView($transfer_product);
        return view('print.transfer-print',compact('transferProduct'));
    }
    public function receivedPrint(TransferReceive $received_product)
    {
        $receivedProduct = TransferReceivedService::transferView($received_product);
        return view('print.received-print',compact('receivedProduct'));
    }

    public function sale($id)
    {
        $sale = Sale::with('delivery')->findOrFail($id);
        if ($sale) {
            $customer = '';
            $sale_detail_object  = new Sale_detail;
            $sale_payment_object = new Sale_payment;
            $bank_object         = new Bank_transaction;
            $bkash_object        = new Owner;
            $product_return      = new Product_return;

            if ($sale->customer_id != 0) $customer = Customer::findOrFail($sale->customer_id);
            $sale_details        = $sale_detail_object->get_sale_detail_by_sale_id($id);
            $sale_payment        = $sale_payment_object->get_total_sale_payment_by_sale_id($id);
            $bank_payment        = $bank_object->get_total_bank_payment_by_sale_id($id);
            $bkash_payment       = $bkash_object->get_total_bkash_payment_by_sale_id($id);
            $product_returns     = $product_return->get_product_return_by_sale_id($id);
            return view('print.sale', compact('sale', 'customer', 'sale_details', 'sale_payment', 'bank_payment', 'bkash_payment', 'product_returns'));
        }
    }

    public function purchase($id)
    {
        $purchase = Purchase::findOrFail($id);

        if ($purchase) {

            $purchase_datil_object   = new Purchase_detail;
            $purchase_payment_object = new Purchase_payment;
            $supplier                = Supplier::findOrFail($purchase->supplier_id);
            $purchase_details        = $purchase_datil_object->get_purchase_detail_by_purchase_id($id);
            $purchase_payment        = $purchase_payment_object->get_total_purchase_payment_by_purchase_id($id);

            return view('print.purchase', compact('purchase', 'supplier', 'purchase_details', 'purchase_payment'));
        }
    }

    public function code(Request $request)
    {
        $id = $request->product_id;
        $quantity = $request->quantity;
        $product  = Product::findOrFail($id);
        //$quantity = Purchase_detail::select('quantity')->where('product_id', $id)->orderBy('id', 'desc')->first()->quantity;

        return view('print.code', compact('product', 'quantity'));
    }

    public function salary($salary_id)
    {
        $attendance_object = new Attendance();
        $loan_advance      = new Loan_advance();

        $salary        = Salary::findOrFail($salary_id);
        $employee_info = Employee::findOrFail($salary->employee_id);
        $month         = Month::where('id', $salary->month_id)->firstOrFail()->name;
        $department    = Department::where('id', $salary->department_id)->firstOrFail()->name;
        $attendances   = $attendance_object->get_employee_attendance_by_month($salary->month_id, $salary->employee_id);
        $loan_advances = $loan_advance->get_loan_or_advance_by_employee_and_month($salary->month_id, $salary->employee_id);

        return view('print.salary', compact('month', 'employee_info', 'department', 'salary', 'attendances', 'loan_advances'));
    }

    public function quotation($id)
    {
        $quotation_detail_object = new QuotationDetail();
        $quotation = Quotation::findOrFail($id);
        $quotation_details = $quotation_detail_object->get_quotation_detail_by_quotation_id($id);
        return view('print.quotation', compact('quotation', 'quotation_details'));
    }
}
