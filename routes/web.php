<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use App\Http\Controllers\Admin\BalanceTransferController;
use App\Http\Controllers\Admin\Bank\AdminTransferController;
use App\Http\Controllers\Admin\Bank\BankController;
use App\Http\Controllers\Admin\Bank\BankTransferController;
use App\Http\Controllers\Admin\Branch\BranchWiseReportController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CashController;
use App\Http\Controllers\Admin\CashDrawer\CashDrawerController;
use App\Http\Controllers\Admin\CashDrawer\CashInController;
use App\Http\Controllers\Admin\CashDrawer\TransferController;
use App\Http\Controllers\Admin\CommonServiceController;
use App\Http\Controllers\Admin\ContactMessage;
use App\Http\Controllers\Admin\Cost\CostController;
use App\Http\Controllers\Admin\Cost\CostEmployeeSearchController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CustomerHelperController;
use App\Http\Controllers\Admin\DeliveryManController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\Admin\ecommerce\NewsController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\FrontendSettingsController;
use App\Http\Controllers\Admin\GetBankController;
use App\Http\Controllers\Admin\GetDeliveryChargeController;
use App\Http\Controllers\Admin\InvestController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\LoanAdvanceController;
use App\Http\Controllers\Admin\MoneyTransferController;
use App\Http\Controllers\Admin\NewBankController;
use App\Http\Controllers\Admin\OwnerController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\PrintController;
use App\Http\Controllers\Admin\Product\BranchWiseStockController;
use App\Http\Controllers\Admin\Product\BrandController;
use App\Http\Controllers\Admin\Product\CategoryController;
use App\Http\Controllers\Admin\Product\GenerateSkuBarcodeController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Product\ProductImageController;
use App\Http\Controllers\Admin\Product\ProductWisePositionController;
use App\Http\Controllers\Admin\Product\VariationController;
use App\Http\Controllers\Admin\Product\VariationValueController;
use App\Http\Controllers\Admin\ProductReturnController;
use App\Http\Controllers\Admin\ProductTransferController;
use App\Http\Controllers\Admin\Purchase\PurchaseController;
use App\Http\Controllers\Admin\Purchase\PurchaseReturnController;
use App\Http\Controllers\Admin\Purchase\PurchaseStatusUpdateController;
use App\Http\Controllers\Admin\Purchase\SkuWiseProductController;
use App\Http\Controllers\Admin\PurchaseDueCollectionController;
use App\Http\Controllers\Admin\PurchasePaymentController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\RBAC\DepartmentController;
use App\Http\Controllers\Admin\Report\ReportController;
use App\Http\Controllers\Admin\Report\ReportFilterController;
use App\Http\Controllers\Admin\Report\SaleReportController;
use App\Http\Controllers\Admin\SalaryController;
use App\Http\Controllers\Admin\Sale\ExchangeController;
use App\Http\Controllers\Admin\Sale\GetCustomerInvoiceController;
use App\Http\Controllers\Admin\Sale\GetInvoiceController;
use App\Http\Controllers\Admin\Sale\Pathao\PathaoController;
use App\Http\Controllers\Admin\Sale\ReturnController;
use App\Http\Controllers\Admin\Sale\SaleController;
use App\Http\Controllers\Admin\Sale\SaleCustomerSearchController;
use App\Http\Controllers\Admin\Sale\SaleDeliveryController;
use App\Http\Controllers\Admin\Sale\SaleProductAddController;
use App\Http\Controllers\Admin\Sale\SaleProductSearchController;
use App\Http\Controllers\Admin\Sale\Winx\WinxController;
use App\Http\Controllers\Admin\SaleDueCollectionController;
use App\Http\Controllers\Admin\SalePaymentController;
use App\Http\Controllers\Admin\SaleReturnController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SmsController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\SupplerTotalColler;
use App\Http\Controllers\Admin\Supplier\PaymentController;
use App\Http\Controllers\Admin\Supplier\SupplierController;
use App\Http\Controllers\Admin\Supplier\SupplierDetailsController;
use App\Http\Controllers\Admin\Supplier\SupplierPayController;
use App\Http\Controllers\Admin\SupplierDashboardController;
use App\Http\Controllers\Admin\TransferReceived\ReceivedProductController;
use App\Http\Controllers\Admin\TransferReceived\TransferProductController;
use App\Http\Controllers\Admin\TransferReceived\TransferProductSearchController;
use App\Http\Controllers\Admin\TransferReceived\TransferReceivedController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BarCodeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DataUpdateController;
use App\Http\Controllers\Ecommerce\Frontend\HomeController;
use App\Http\Controllers\Ecommerce\OnlineOrderController;
use App\Http\Controllers\Ecommerce\SilderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('auth.login');
    });
});
Route::get('/report-desgin', function () {
    return view('admin.report.reprot-design');
});
Route::get('/product-report-design', function () {
    return view('admin.report.product-report-design');
});


Route::get('/server-down', function () {
    Artisan::call('down');
    return view('auth.login');
});
//Route::get('/server-up', function (){
//    dd('hi');
//    if(Storage::exists('framework/down')){
//        Storage::delete('framework/down');
//
//    }else{
//        return view('auth.login');
//    }
//    Artisan::call('optimize:clear');
//    Artisan::call('up');
//
//    return view('auth.login');
//});
//auth routes

Auth::routes([
    'register' => false,
    'reset' => false,
]);
Auth::routes();
Route::get('/dashboard', [ \App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get("/test", function () {
    return view('admin.test');
});

/** cart route start **/
Route::post('/cart', [CartController::class, 'cart'])->name('add.cart');
Route::post('/get-quotation', [CartController::class, 'get_quotation'])->name('get.quotation');
Route::post('/get-product', [CartController::class, 'get_product'])->name('get.product');
Route::post('/cart-subtotal', [CartController::class, 'subtotal'])->name('cart.subtotal');
Route::post('/find-product', [CartController::class, 'product'])->name('find.product');
Route::post('/check-product', [CartController::class, 'check_product'])->name('check.product');
Route::get('/bar-code', [BarCodeController::class, 'index'])->name('barcode');

/** cart route end **/

//Admin route

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::controller(CommonServiceController::class)->group(function () {
        Route::post('/supplier-payable-amount', 'supplierPayableAmount')->name('supplier-payable');
        Route::post('/get-user-bank', 'getUserBank')->name('get-user.bank');
        Route::post('/get-designation-user', 'getDesignationUsers')->name('get-designation-user');
    });

    Route::get('data-update/{type}', DataUpdateController::class);
    /**settings **/
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'store'])->name('settings.store');

    //frontend setting

    Route::get('frontend/settings', [FrontendSettingsController::class, 'index'])->name('frontend.settings.index');
    Route::post('frontend/settings', [FrontendSettingsController::class, 'store'])->name('frontend.settings.store');
    //end forntend settigns

    /**Product **/
    /**Product **/
    Route::resource('/variation', VariationController::class);
    Route::resource('/variation-value', VariationValueController::class);
    Route::resource('/brand', BrandController::class);
    Route::resource('/products', ProductController::class);

    //    Gift Product Route

    Route::resource('/gift-products', \App\Http\Controllers\Admin\Gift\Product\ProductController::class);
    Route::resource('/gift-purchases', \App\Http\Controllers\Admin\Gift\Purchase\PurchaseController::class);
    Route::controller(ProductImageController::class)->group(function () {
        Route::get('/product-image', 'index')->name('product-image.index');
        Route::get('/product-image/{product}', 'create')->name('product-image.create');
        Route::post('/product-image-store', 'store')->name('product-image.store');
        Route::post('/product-image-update', 'update')->name('product-image.update');
        Route::post('/product-image-crop', 'crop')->name('product-image.crop');
        Route::delete('/product-image/{productImage}', 'destroy')->name('product-image.destroy');
    });


    Route::get('/products/sorts/{id}/sort/{sort}', [ProductController::class, 'sort'])->name('products.sort');
    Route::get('/products/sorts/list', [ProductController::class, 'list'])->name('products.list');
    Route::resource('/categories', CategoryController::class);
    Route::get('/stocks', [StockController::class, 'index'])->name('product.stock');
    Route::post('/generate-sku-barcode', GenerateSkuBarcodeController::class)->name('generate-sku-barcode');
    Route::get('/branch-wise-stock/{product}', BranchWiseStockController::class)->name('branch-wise-stock');
    Route::get('/product-wise-position/{product}', ProductWisePositionController::class)->name('product-wise-position');
    /**Branch**/
    Route::resource('/branch', BranchController::class);


    //Branch
    Route::get('branch-sell/{branch}/{type}', [BranchWiseReportController::class, 'sale'])->name('branch.sale');
    Route::get('branch-stock/{branch}', [BranchWiseReportController::class, 'stock'])->name('branch.stock');
    //endBranch
    /**Purchases **/
    Route::resource('/purchases', PurchaseController::class);
    Route::put('/purchase-status-update/{purchase}', PurchaseStatusUpdateController::class)->name('purchase-status-update');
    Route::post('/sku-wise-product', SkuWiseProductController::class)->name('sku-wise-product');

    /**Purchases Return**/
    Route::get('/purchases-return', [PurchaseReturnController::class, 'index'])->name('purchase-return.index');
    Route::post('/purchases-return', [PurchaseReturnController::class, 'store'])->name('purchase-return.store');
    Route::post('/purchases-return-status', [PurchaseReturnController::class, 'statusUpdate'])->name('purchase-return-status.update');
    Route::get('/create-purchases-return/{purchase}', [PurchaseReturnController::class, 'returnCreate'])->name('purchase-return.create');
    Route::get('/purchases-return/{purchase_return}', [PurchaseReturnController::class, 'show'])->name('purchase-return.show');


    /**TransferReceivedService **/
    Route::resource('/transfer-product', TransferProductController::class);
    Route::resource('/received-product', ReceivedProductController::class);
    Route::get('/transfer-received', TransferReceivedController::class)->name('transfer-received.list');
    Route::get('/transfer-product-search/{search}', TransferProductSearchController::class)->name('transfer.product.search');

    /**Sales **/
    Route::resource('/sales', SaleController::class);
    Route::post('/sale-product-search', SaleProductSearchController::class)->name('sale-product-search');
    Route::post('/sale-product-add', SaleProductAddController::class)->name('sale-product-add');
    Route::post('/sale-customer-search', SaleCustomerSearchController::class)->name('sale-customer-search');
    Route::get('/sale-returns', [SaleReturnController::class, 'index']);
    Route::post('/sale-returns/store', [SaleReturnController::class, 'store'])->name('sale-returns.store');
    Route::get('/sale-returns/{id}', [SaleReturnController::class, 'return'])->name('sale-returns');
    Route::delete('/sale-returns/{id}', [SaleReturnController::class, 'destroy'])->name('sale-returns-destroy');
    /**SaleDelivery**/
    Route::get('/sale-delivery', [SaleDeliveryController::class, 'index'])->name('sale-delivery.index');
    Route::put('/sale-delivery-status/{sale_id}', [SaleDeliveryController::class, 'update'])->name('sale-delivery.update');

    Route::group(['prefix' => 'pathao'], function () {
        Route::get('/generate-token', [PathaoController::class, 'generateToken'])->name('pathao-token');
        Route::get('/city-list', [PathaoController::class, 'getCityList'])->name('pathao-city');
        Route::get('/get-zone/{city}', [PathaoController::class, 'getCityZones'])->name('pathao-zone');
        Route::get('/get-area/{zone}', [PathaoController::class, 'getZoneArea'])->name('pathao-area');
        Route::get('/get-store-list', [PathaoController::class, 'getStoreList'])->name('pathao-store');
        Route::post('/price-calculation', [PathaoController::class, 'priceCalculation'])->name('pathao-price-calculation');
    });

    Route::group(['prefix' => 'winx'], function () {
        Route::get('/location-list', [WinxController::class, 'getLocationList'])->name('winx-location');
        Route::get('/package-list', [WinxController::class, 'getPackageList'])->name('winx-package');
        Route::get('/pickup-locations', [WinxController::class, 'getPickUpLocation'])->name('winx-store');
    });


    /**exchange & Return**/
    Route::resource('/sale-return', ReturnController::class);
    Route::resource('/sale-exchange', ExchangeController::class);
    Route::post('/get-invoice', GetInvoiceController::class)->name('get-invoice');
    Route::get('/customer-invoice/{phone}', GetCustomerInvoiceController::class)->name('customer-invoice');

    /**Print **/
    Route::get('/new-sale-print/{sale}', [PrintController::class, 'newSalePrint'])->name('new-sale-print');
    Route::get('/purchase-print/{purchase}', [PrintController::class, 'purchasePrint'])->name('purchase.print');
    Route::get('/purchase-barcode/{purchase}', [PrintController::class, 'purchaseBarcode'])->name('purchase.barcode');
    Route::get('/transfer-print/{transfer_product}', [PrintController::class, 'transferPrint'])->name('transfer.print');
    Route::get('/received-print/{received_product}', [PrintController::class, 'receivedPrint'])->name('received.print');

    /**Download **/
    Route::get('/report-download/{report}', [DownloadController::class, 'reportDownload'])->name('report.download');
    Route::get('/purchase-download/{purchase}', [DownloadController::class, 'purchaseDownload'])->name('purchase.download');
    Route::get('/sale-download/{sale}', [DownloadController::class, 'SaleDownload'])->name('sale.download');
    Route::get('/purchase-return-download/{purchase_return}', [DownloadController::class, 'PurchaseReturnDownload'])->name('purchase.return.download');
    Route::get('/product-received/{received_product}', [DownloadController::class, 'ProductReceivedDownload'])->name('received.download');
    Route::get('/product-transfer/{transfer_product}', [DownloadController::class, 'ProductTransferDownload'])->name('transfer.download');
    Route::get('/cash-history/{cash_drawer}', [DownloadController::class, 'CashHistoryDownload'])->name('cash-history.download');
    Route::get('/bank-branch-transfer/{bank_transfer}', [DownloadController::class, 'BankTransferDownload'])->name('bank-branch.transfer.download');
    Route::get('/supplier-transfer/{supplier_transfer}', [DownloadController::class, 'SupplierTransfer'])->name('supplier.transfer.download');


    //end Download Invoice
    /**User **/
    Route::resource('/users', UserController::class);
    Route::resource('/designations', DesignationController::class);
    Route::resource('/departments', DepartmentController::class);
    Route::resource('/sections', SectionController::class);

    Route::get('/get-delivery-charge', GetDeliveryChargeController::class)->name('delivery.charge');
    Route::resource('/payment-method', PaymentMethodController::class);
    Route::get('/transfer-history/{id}', [PaymentMethodController::class, 'paymentMethodHistory'])->name('transfer.history');
    Route::resource('/delivery-man', DeliveryManController::class);
    Route::resource('/transfers', ProductTransferController::class);
    Route::resource('/quotations', QuotationController::class);
    Route::resource('/supplier-dashboard', SupplierDashboardController::class);
    Route::resource('/banks', BankController::class);
    Route::resource('/new-banks', NewBankController::class);
    Route::resource('/salaries', SalaryController::class);
    Route::resource('/balances', BalanceTransferController::class);
    Route::resource('/invests', InvestController::class);
    Route::resource('/owners', OwnerController::class);
    Route::resource('/customers', CustomerController::class);
    //cash drawer start
    Route::resource('/cash-drawer', CashDrawerController::class);
    Route::get('/cash-in/accept-transfer/{cash_drawer}', [CashDrawerController::class, 'acceptTransfer'])->name('cash-in.accept-transfer');
    Route::get('/cash-in/reject-transfer/{cash_drawer}', [CashDrawerController::class, 'rejectTransfer'])->name('cash-in.reject-transfer');
    //cash in
    Route::get('/cash-in/create', [CashInController::class, 'create'])->name('cash-in.create');
    Route::post('/cash-in/store', [CashInController::class, 'store'])->name('cash-in.store');
    Route::get('/cash-in/show', [CashInController::class, 'show'])->name('cash-in.show');
    //payment
    Route::get('/payment/create', [\App\Http\Controllers\Admin\CashDrawer\PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/store', [\App\Http\Controllers\Admin\CashDrawer\PaymentController::class, 'store'])->name('payment.store');
    Route::get('/payment/show', [\App\Http\Controllers\Admin\CashDrawer\PaymentController::class, 'show'])->name('payment.show');
    //transfer
    Route::get('/transfer/create', [TransferController::class, 'create'])->name('transfer.create');
    Route::post('/get-branch-banks-cash-drawer', GetBankController::class)->name('get-branch-banks-cash-drawer');
    Route::post('/transfer/store', [TransferController::class, 'store'])->name('transfer.store');
    Route::get('/transfer/show', [TransferController::class, 'show'])->name('transfer.show');
    //cash drawer end
    //bank route

    Route::get('/bank/make-payment', [BankTransferController::class, 'create'])->name('bank-transfer.create');
    Route::get('/bank/send-money', [BankTransferController::class, 'sendMoney'])->name('bank-send-money.create');
    Route::post('/bank/send-money-store', [BankTransferController::class, 'sendMoneyStore'])->name('bank-send-money.store');
    Route::get('/single-bank-transaction/{bank}', [BankTransferController::class, 'single_transaction'])->name('single-bank-transaction');


    Route::get('/bank/transfer-list', [BankTransferController::class, 'index'])->name('bank-transfer.index');
    Route::post('/bank/bank-transfer-store', [BankTransferController::class, 'store'])->name('bank-transfer.store');

    //accept reject
    Route::get('/bank/accept-transfer/{cash_drawer}', [BankTransferController::class, 'acceptTransfer'])->name('bank.accept-transfer');
    Route::get('/bank/reject-transfer/{cash_drawer}', [BankTransferController::class, 'rejectTransfer'])->name('bank.reject-transfer');

    Route::get('/bank/admin-transfer', [AdminTransferController::class, 'admin_transfer'])->name('admin-transfer');
    Route::post('/bank/admin-transfer-store', [AdminTransferController::class, 'admin_transfer_store'])->name('admin-transfer-store');

    Route::get('/bank/payment-invoice/{id}', [BankTransferController::class, 'singleInvoice'])->name('bank.payment-invoice');


    //end bank
    //transfer money
    Route::resource('/transfer-money', MoneyTransferController::class);
    //cost route
    Route::resource('/costs', CostController::class);
    Route::post('/cost-employee-search', CostEmployeeSearchController::class)->name('cost-employee-search');

    //supplier Route
    Route::resource('/suppliers', SupplierController::class);
    Route::get('/supplier/product/{id}', [SupplierDetailsController::class, 'product'])->name('supplier.product');
    Route::get('/supplier/stock/{id}', [SupplierDetailsController::class, 'stock'])->name('supplier.stock');
    Route::get('/supplier/payable/{id}', [SupplierDetailsController::class, 'payable'])->name('supplier.payable');
    Route::post('/supplier/payable-amount', PaymentController::class)->name('supplier.payable-amount');
    Route::post('/supplier/payment', SupplierPayController::class)->name('supplier.payment');
    Route::get('/supplier/view-payment/{id}', [SupplierDetailsController::class, 'viewPayment'])->name('supplier.view-payment');
    Route::get('/supplier/payment-details/{id}', [SupplierDetailsController::class, 'singlePayment'])->name('supplier.payment-details');
    //end supplier Route

    Route::resource('/sizes', SizeController::class);
    Route::resource('/units', UnitController::class);
    Route::resource('/news', NewsController::class);

    Route::resource('/purchase-payments', PurchasePaymentController::class);
    Route::resource('/purchase-dues', PurchaseDueCollectionController::class);


    Route::resource('/sale-payments', SalePaymentController::class);
    Route::resource('/sale-dues', SaleDueCollectionController::class);
    Route::resource('/salary', SalaryController::class);
    Route::resource('/employees', EmployeeController::class);

    //  get Old Customer
    Route::get('/old-customer', [CustomerHelperController::class, 'autocomplete_customer'])->name('autocomplete.customer');
    Route::post('/get-supplier-totalSale', [SupplerTotalColler::class, 'get_total_sale'])->name('get_supplier_total_sale');

    /** report route start **/
    Route::controller(ReportFilterController::class)->group(function () {
        Route::post('/sale-report-filter', 'saleFilter')->name('sale-report.filter');
        Route::post('/stock-report-filter', 'stockFilter')->name('stock-report.filter');
        Route::post('/report-product-search', 'productSearch')->name('report.product.search');
        Route::post('/report-product-info', 'productInfo')->name('report.product.info');
    });


    Route::controller(ReportController::class)->group(function () {
        Route::get('report-history', 'index')->name('report-history.index');
        Route::get('report-history/{report}', 'show')->name('report-history.show');
        Route::get('get-report/{report}', 'getReport')->name('report-history.get');
        Route::get('/sale-report', 'saleReport')->name('sale.report');
        Route::get('/stock-report', 'stockReport')->name('stock.report');
        Route::get('/cr-master-report', 'crMasterReport')->name('cr.master.report');
        Route::get('/product-report', 'productReport')->name('product.report');
        Route::post('/generate-sale-report', 'generateSaleReport')->name('generate.sale.report');
        Route::post('/generate-stock-report', 'generateStockReport')->name('generate.stock.report');
        Route::post('/generate-cr-master-report', 'generateCrMasterReport')->name('generate.cr.master.report');
        Route::post('/generate-product-report', 'generateProductReport')->name('generate.product.report');
    });

    /** report route end **/

    /** cash route start **/
    Route::get('/cashes', [CashController::class, 'index'])->name('cashes');
    Route::get('/cashes/create', [CashController::class, 'create'])->name('cashes.create');
    Route::post('/cashes/store', [CashController::class, 'store'])->name('cashes.store');
    Route::delete('/cashes/destroy/{id}', [CashController::class, 'destroy'])->name('cashes.destroy');
    Route::delete('/product-return-destroy/{id}', [ProductReturnController::class, 'destroy'])->name('product.return.destroy');
    /** cash route end **/

    /** Employee managements route start **/


    /** Employee managements route end **/

    /** Loan routes start**/
    Route::get('/loan-advance', [LoanAdvanceController::class, 'index'])->name('loan.advance');
    Route::get('/loan-advance/create', [LoanAdvanceController::class, 'create'])->name('loan.advance.create');
    Route::post('/loan-advance/store', [LoanAdvanceController::class, 'store'])->name('loan.advance.store');
    Route::delete('/loan-advance/destroy/{id}', [LoanAdvanceController::class, 'destroy'])->name('loan.advance.destroy');
    /** Loan routes end**/

    Route::get('create-slider', [SilderController::class, 'index'])->name('ecomsilder');
    Route::post('sliderpost', [SilderController::class, 'create'])->name('ecomsilder.post');

    Route::get('view-slider', [SilderController::class, 'viewslider'])->name('viewslider');
    Route::post('slider-update', [SilderController::class, 'update'])->name('slider.update');
    Route::post('/get-all-product', [SilderController::class, 'getproduct'])->name('getproduct');
    // Route::post('/get-resouce', [SilderController::class,'resouce']);

    Route::post('get-category', [SilderController::class, 'getCategory'])->name('getcategory');
    Route::post('get-brand', [SilderController::class, 'getBrand'])->name('getbrand');
    Route::post('get-bannerDetails', [SilderController::class, 'bannerDetails'])->name('bannerDetails');
    Route::get('slider-delete', [SilderController::class, 'delete'])->name('sliderdelete');

    Route::post('slider-status', [SilderController::class, 'sliderStatus'])->name('sliderstatus');

    // Route::post('resourceTyBySearch',[SilderController::class,'resourceTyBySearch'])->name('resourceTyBySearch');
    Route::get('view-slider-edit', [SilderController::class, 'vuesilderEdit'])->name('vuesilderEdit');
    // Route::get('update-slider', [SilderController::class,'UpdateSlider'])->name('updateslider');


    // Contact Us Message
    Route::get('/contact-message', [ContactMessage::class, 'index'])->name('contact.message');
    Route::get('/contact-message/{id}', [ContactMessage::class, 'show'])->name('contact.message.show');


    //ecommerce route
    Route::resource('/online-order', OnlineOrderController::class);

});

// profile route

Route::group(['middleware' => 'auth'], function () {
    /** profile route start **/
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'photo'])->name('profile.photo');
    Route::get('/password-change', [ProfileController::class, 'changePassword'])->name('get.password.change');
    Route::post('/password', [ProfileController::class, 'password'])->name('password.change');
    Route::post('/profile-update', [ProfileController::class, 'update'])->name('profile.update');
    /** profile route end **/

    /** print route start **/
    Route::get('/sales/{id}', [PrintController::class, 'sale'])->name('sales');
    Route::get('/purchase/{id}', [PrintController::class, 'purchase'])->name('purchases');
    Route::post('/code', [PrintController::class, 'code'])->name('codes');
    Route::get('/quotation/{id}', [PrintController::class, 'quotation'])->name('quotation');
    Route::get('/salary-attendance-print/{id}', [PrintController::class, 'salary'])->name('salary.print');
    /** print route end **/

    Route::post('/find-employee', [CartController::class, 'employee'])->name('find.employee');
});


///language

Route::group(['prefix' => 'language', 'as' => 'language.'], function () {
    Route::get('', [LanguageController::class, 'index'])->name('index');
    Route::post('add-new', [LanguageController::class, 'store'])->name('add-new');
    Route::get('update-default-status', [LanguageController::class,'update_default_status'])->name('update-default-status');
    Route::get('update-status',[ LanguageController::class,'update_status'])->name('update-status');
    Route::post('remove-key/{lang}', [LanguageController::class, 'translate_key_remove'])->name('remove-key');
    Route::any('auto-translate/{lang}', [LanguageController::class,'auto_translate'])->name('auto-translate');
    Route::post('update', [LanguageController::class, 'update'])->name('update');
    Route::get('translate/{lang}', [LanguageController::class,'translate'])->name('translate');
    Route::post('translate-submit/{lang}', [LanguageController::class,'translate_submit'])->name('translate-submit');
    Route::get('delete/{lang}', [LanguageController::class,'delete'])->name('delete');

    Route::post('vue-get', [LanguageController::class, 'vueGet'])->name('vue-get');
});

//set language 

Route::get('lang/{locale}', [LanguageController::class,'setLanguage'])->name('lang');

//Employee route
Route::get("/employee-dashboard", function () {
    return View("employee.dashboard");
});

Route::group(['prefix' => 'sms', 'as' => 'sms.'], function () {
    Route::get('index', [SmsController::class, 'sms_index'])->name('index');
    Route::post('sms-update/{sms_module}', [SmsController::class, 'sms_update'])->name('update');
});



