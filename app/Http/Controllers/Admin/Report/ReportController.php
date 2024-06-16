<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrMasterReportRequest;
use App\Http\Requests\ProductReportRequest;
use App\Http\Requests\SaleReportRequest;
use App\Http\Requests\StockReportRequest;
use App\Model\Report;
use App\Services\Report\Product\ProductReport;
use App\Services\Report\Sale\SalesReport;
use App\Services\Report\CRMaster\CrMasterReport;
use App\Services\Report\Stock\StockReport;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{

    use  ApiResponse;

    public function index()
    {
        $reports = Report::query()->latest()->paginate(100);
        return view('admin.report.report-history', compact('reports'));
    }

    public function show(Report $report)
    {
        if($report->report_name == 'Product Report') {
            return view('admin.report.product-report-view', compact('report'));
        }
        return view('admin.report.report-view', compact('report'));
    }

    public function getReport(Report $report)
    {
        if($report->report_name == 'Product Report') {
            return view('components.report.product-report', compact('report'));
        }
        return view('components.report.report-view', compact('report'));
    }

    public function saleReport()
    {
        return view('admin.report.sale-report', SalesReport::salesReportResource());
    }

    public function generateSaleReport(SaleReportRequest $request)
    {
        try {
            DB::beginTransaction();
            $report = SalesReport::generateReport($request);
            $report_save = new Report();
            $report_save->fill($report)->save();
            DB::commit();
            return $this->respondSuccess($report_save, 'Sale Report generate successfully');
            //return view('components.report.sale-report', compact('report'));
        } catch (\Throwable $exception) {
            return $exception->getMessage();
        }
    }

    public function stockReport()
    {
        return view('admin.report.stock-report', (new StockReport())->stockReportResource());
    }


    public function generateStockReport(StockReportRequest $request)
    {
        try {
            DB::beginTransaction();
            $report = (new StockReport())->generateReport($request);
            $report_save = new Report();
            $report_save->fill($report)->save();
            DB::commit();
            return $this->respondSuccess($report_save, 'Stock Report generate successfully');
            //return view('components.report.sale-report', compact('report'));
        } catch (\Throwable $exception) {
            return $exception->getMessage();
        }
    }

    public function crMasterReport()
    {
        return view('admin.report.cr-master-report', (new CrMasterReport())->crReportReportResource());
    }


    public function generateCrMasterReport(CrMasterReportRequest $request)
    {
        try {
            DB::beginTransaction();
            $report = (new CrMasterReport())->generateReport($request);
            $report_save = new Report();
            $report_save->fill($report)->save();
            DB::commit();
            return $this->respondSuccess($report_save, 'C.R Master Report generate successfully');
            //return view('components.report.sale-report', compact('report'));
        } catch (\Throwable $exception) {
            return $exception->getMessage();
        }
    }

    public function productReport()
    {
        return view('admin.report.product-report', (new ProductReport())->productReportResource());
    }

    public function generateProductReport(ProductReportRequest $request)
    {
        try {
            DB::beginTransaction();
            $report = (new ProductReport())->generateReport($request);
            $report_save = new Report();
            $report_save->fill($report)->save();
            DB::commit();
            return $this->respondSuccess($report_save, 'Product Report generate successfully');
        } catch (\Throwable $exception) {
            return $exception->getMessage();
        }
    }


}
