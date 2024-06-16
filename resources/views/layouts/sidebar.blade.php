<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar text-center">
        <ul class="sidebar-menu">
            @if (auth()->user()->can('Supplier') ||
                    auth()->user()->can('All'))
                <li class="treeview @if (Request::path() === 'admin/suppliers/create' || Request::path() === 'admin/suppliers') {{ 'active' }} @endif">
                    <a href="#">
                        <i class="fa fa-opencart"></i>
                        <span>{{ translate('Supplier') }}</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="@if (Request::path() === 'admin/suppliers/create') {{ 'active' }} @endif"><a
                                href="{{ route('suppliers.create') }}">{{ translate('New') }}
                                {{ translate('Supplier') }}</a>
                        </li>
                        <li class="@if (Request::path() === 'admin/suppliers') {{ 'active' }} @endif"><a
                                href="{{ route('suppliers.index') }}">{{ translate('View') }}
                                {{ translate('Supplier') }}</a>
                        </li>
                    </ul>

                </li>
            @endif
            @if (auth()->user()->can('Branch') ||
                    auth()->user()->can('All'))
                <li class="treeview @if (Request::path() === 'admin/branch/create' || Request::path() === 'admin/branch') {{ 'active' }} @endif">
                    <a href="#">
                        <i class="fa fa-file"></i>
                        <span>{{ translate('Branch') }}</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="@if (Request::path() === 'admin/branch/create') {{ 'active' }} @endif"><a
                                href="{{ route('branch.create') }}">{{ translate('New') }}
                                {{ translate('Branch') }}</a>
                        </li>
                        <li class="@if (Request::path() === 'admin/branch') {{ 'active' }} @endif"><a
                                href="{{ route('branch.index') }}">{{ translate('View') }}
                                {{ translate('Branch') }}</a>
                        </li>
                    </ul>

                </li>
            @endif
            @if (auth()->user()->hasRole(['Admin', 'User']))
                @if (auth()->user()->can('Sale') ||
                        auth()->user()->can('All'))
                    <li class="treeview @if (Request::path() === 'admin/sales/create' ||
                            Request::path() === 'admin/sales' ||
                            Request::path() === 'admin/sale-payments/create' ||
                            Request::path() === 'admin/sale-payments' ||
                            Request::path() === 'admin/sale-returns' ||
                            request()->is('admin/sale-returns/*') ||
                            request()->is('admin/sales/*') ||
                            request()->is('admin/sale-payments/*/edit') ||
                            Request::path() === 'admin/sale-dues/create' ||
                            Request::path() === 'admin/sale-exchange/create' ||
                            Request::path() === 'admin/sale-return/create' ||
                            Request::path() === 'admin/sale-dues') {{ 'active' }} @endif">

                        <a href="#">

                            <i class="fa fa-opencart"></i>
                            <span>{{ translate('Sales') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">

                            <li class="@if (Request::path() === 'admin/sales/create') {{ 'active' }} @endif"><a
                                    href="{{ route('sales.create') }}">{{ translate('New') }}
                                    {{ translate('Sale') }}</a>
                            </li>

                            <li class="@if (Request::path() === 'admin/sales') {{ 'active' }} @endif"><a
                                    href="{{ route('sales.index') }}"> {{ translate('View') }}
                                    {{ translate('Sale') }}</a>
                            </li>
                            <li class="@if (Request::path() === 'admin/sale-return/create') {{ 'active' }} @endif"><a
                                    href="{{ route('sale-return.create') }}">{{ translate('Return') }}
                                    {{ translate('Sale') }}</a>
                            </li>

                            <li class="@if (Request::path() === 'admin/sale-exchange/create') {{ 'active' }} @endif"><a
                                    href="{{ route('sale-exchange.create') }}"> {{ translate('Exchange') }}
                                    {{ translate('Sale') }}</a>
                            </li>
                            {{-- <li class="@if (Request::path() === 'admin/sale-delivery') {{ 'active' }} @endif"><a
                                    href="{{ route('sale-delivery.index') }}"> Sale Delivery</a>
                            </li> --}}
                        </ul>
                    </li>
                @endif
                {{-- @if ((int) ecommerceBranchId() === auth()->user()->branch_id)
                    <li class="treeview">
                        <a href="#">
                            <span>Online Orders</span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="">
                                <a href="{{ route('online-order.index') }}">Online Orders</a>
                            </li>
                        </ul>
                    </li>
                @endif --}}
                @if (auth()->user()->can('Product') ||
                        auth()->user()->can('All'))
                    <li class="treeview @if (Request::path() === 'admin/products/create' ||
                            Request::path() === 'admin/products' ||
                            Request::path() === 'admin/categories' ||
                            Request::path() === 'admin/stocks' ||
                            Request::path() === 'admin/brand' ||
                            Request::path() === 'admin/variation' ||
                            Request::path() === 'admin/transfer-product/create' ||
                            Request::path() === 'admin/received-product' ||
                            Request::path() === 'admin/transfer-received' ||
                            Request::path() === 'admin/units' ||
                            Request::path() === 'admin/product-returns' ||
                            request()->is('admin/products/*/edit') ||
                            Request::path() === 'admin/products/sorts/list') {{ 'active' }} @endif">
                        <a href="#">
                            <i class="fa fa-support "></i>
                            <span> {{ translate('Products') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@if (Request::path() === 'admin/products/create') {{ 'active' }} @endif"><a
                                    href="{{ route('products.create') }}"> {{ translate('Add') }}
                                    {{ translate('Product') }}</a></li>
                            <li class="@if (Request::path() === 'admin/products') {{ 'active' }} @endif"><a
                                    href="{{ route('products.index') }}"> {{ translate('View') }}
                                    {{ translate('Product') }}</a></li>
                            <li class="@if (Request::path() === 'admin/categories') {{ 'active' }} @endif"><a
                                    href="{{ route('categories.index') }}">
                                    <span> {{ translate('Categories') }}</span></a>
                            </li>
                            <li class="@if (Request::path() === 'admin/brand') {{ 'active' }} @endif"><a
                                    href="{{ route('brand.index') }}">
                                    <span> {{ translate('Brand') }}</span></a>
                            </li>
                            <li class="@if (Request::path() === 'admin/variation') {{ 'active' }} @endif"><a
                                    href="{{ route('variation.index') }}">
                                    <span> {{ translate('Variation') }}</span></a>
                            </li>
                            <li class="@if (Request::path() === 'admin/transfer-product/create') {{ 'active' }} @endif">
                                <a href="{{ route('transfer-product.create') }}">
                                    <span> {{ translate('Transfer') }} {{ translate('Product') }}</span></a>
                            </li>
                            <li class="@if (Request::path() === 'admin/received-product') {{ 'active' }} @endif"><a
                                    href="{{ route('received-product.index') }}">
                                    <span> {{ translate('Received') }} {{ translate('Product') }}</span></a>
                            </li>
                            <li class="@if (Request::path() === 'admin/transfer-received') {{ 'active' }} @endif"><a
                                    href="{{ route('transfer-received.list') }}">
                                    <span> {{ translate('View') }} {{ translate('Transfer') }} &
                                        {{ translate('Received') }}</span></a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('Product') ||
                        auth()->user()->can('All'))
                    {{-- <li class="treeview   @if (Request::path() === 'admin/gift-products/create' || Request::path() === 'admin/gift-products' || Request::path() === 'admin/gift-purchases' || Request::path() === 'admin/gift/stocks' || Request::path() === 'admin/units' || Request::path() === 'admin/products/sorts/list') {{ 'active' }} @endif">
                        <a href="#">
                            <span>Gift</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@if (Request::path() === 'admin/gift-products/create') {{ 'active' }} @endif"><a
                                    href="{{ route('gift-products.create') }}">Add Product</a></li>
                            <li class="@if (Request::path() === 'admin/gift-products') {{ 'active' }} @endif"><a
                                    href="{{ route('gift-products.index') }}"> View Product</a></li>
                            <li class="@if (Request::path() === 'admin/gift-purchase') {{ 'active' }} @endif"><a
                                    href="{{ route('gift-purchases.create') }}">
                                    <span>New Purchase</span></a>
                            </li>
                            <li class="@if (Request::path() === 'admin/gift-purchase') {{ 'active' }} @endif"><a
                                    href="{{ route('gift-purchases.index') }}">
                                    <span>View Purchase</span></a>
                            </li>
                        </ul>
                    </li> --}}
                    {{-- <li class="treeview @if (Request::path() === 'admin/gift-products/create' || Request::path() === 'admin/gift-products' || Request::path() === 'admin/gift-purchases' || Request::path() === 'admin/gift/stocks' || Request::path() === 'admin/units' || Request::path() === 'admin/products/sorts/list') {{ 'active' }} @endif">
                        <a href="#">
                            <span>Offer</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@if (Request::path() === 'admin/offers/create') {{ 'active' }} @endif"><a
                                    href="{{ route('offers.create') }}">Add Offer</a>
                            </li>
                            <li class=" ">
                                <a href="{{ route('flat-discount.create') }}">Add Flat Discount</a>
                            </li>
                            <li class="">
                                <a href="{{ route('upto-discount.create') }}">Add UpTo Discount</a>
                            </li>
                            <li class="">
                                <a href="{{ route('combo-discount.create') }}">Add Combo Discount</a>
                            </li>
                            <li class="">
                                <a href="{{ route('buy-to-get-discount.create') }}">Add Buy To Get Discount</a>
                            </li>
                            <li class="">
                                <a href="{{ route('coupon-discount.create') }}">Add Coupon Discount</a>
                            </li>
                            <li class="@if (Request::path() === 'admin/offers') {{ 'active' }} @endif"><a
                                    href="{{ route('offers.index') }}"> View Offer</a></li>

                        </ul>
                    </li> --}}
                @endif
                @if (auth()->user()->can('Purchase') ||
                        auth()->user()->can('All'))
                    <li class="treeview @if (Request::path() === 'admin/purchases/create' ||
                            Request::path() === 'admin/purchases' ||
                            Request::path() === 'admin/purchase-payments/create' ||
                            Request::path() === 'admin/purchase-payments' ||
                            Request::path() === 'admin/purchases-return' ||
                            request()->is('admin/purchases/*') ||
                            request()->is('admin/purchases-return/*') ||
                            request()->is('admin/purchase-payments/*/edit') ||
                            Request::path() === 'admin/purchase-dues/create' ||
                            Request::path() === 'admin/purchase-dues') {{ 'active' }} @endif">
                        <a href="#">
                            <i class="fa fa-cart-plus"></i>
                            <span>{{ translate('Purchases') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@if (Request::path() === 'admin/purchases/create') {{ 'active' }} @endif"><a
                                    href="{{ route('purchases.create') }}">{{ translate('New') }}
                                    {{ translate('Purchases') }} </a>
                            </li>
                            <li class="@if (Request::path() === 'admin/purchases') {{ 'active' }} @endif"><a
                                    href="{{ route('purchases.index') }}">{{ translate('View') }}
                                    {{ translate('Purchases') }}</a>
                            </li>
                            <li class="@if (Request::path() === 'admin/purchases-return') {{ 'active' }} @endif"><a
                                    href="{{ route('purchase-return.index') }}">{{ translate('Purchases') }}
                                    {{ translate('Return') }}</a></li>
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('Cost') ||
                        auth()->user()->can('All'))
                    <li class="treeview @if (Request::path() === 'admin/costs/create' ||
                            Request::path() === 'admin/costs' ||
                            request()->is('admin/costs/*/edit')) {{ 'active' }} @endif">
                        <a href="#">
                            <i class="fa fa-money"></i>
                            <span>{{ translate('Costs') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@if (Request::path() === 'admin/costs/create') {{ 'active' }} @endif"><a
                                    href="{{ route('costs.create') }}"> {{ translate('New') }}
                                    {{ translate('Cost') }} </a>
                            </li>
                            <li class="@if (Request::path() === 'admin/costs') {{ 'active' }} @endif"><a
                                    href="{{ route('costs.index') }}"> {{ translate('View') }}
                                    {{ translate('Cost') }} </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('Cash') ||
                        auth()->user()->can('All'))
                    <li
                        class="{{ Request::path() == 'admin/cash-drawer/*' || request()->is('admin/cash-drawer') ? 'active' : '' }}">
                        <a href="{{ route('cash-drawer.index') }}">
                            <i class="fa"> {{ get_settings('currency_symbol') }}</i>
                            <span>{{ translate('Cash') }} {{ translate('Drawer') }}</span>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->can('Bank') ||
                        auth()->user()->can('All'))
                    <li class="treeview @if (Request::path() === 'admin/banks' ||
                            Request::path() === 'admin/banks/*' ||
                            Request::path() === 'admin/banks/create' ||
                            Request::path() === 'admin/bank/admin-transfer' ||
                            Request::path() === 'admin/bank/transfer-list') {{ 'active' }} @endif">
                        <a href="#">
                            <i class="fa fa-bank"></i>

                            <span>{{ translate('Banks') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@if (Request::path() === 'admin/banks') {{ 'active' }} @endif"><a
                                    href="{{ route('banks.index') }}"> {{ translate('View') }}
                                    {{ translate('Bank') }}
                                </a>
                            </li>
                            <li class="@if (Request::path() === 'admin/banks/create') {{ 'active' }} @endif"><a
                                    href="{{ route('bank-transfer.create') }}"> {{ translate('Add') }}
                                    {{ translate('Bank') }} {{ translate('Transaction') }} </a>
                            </li>
                            <li class="@if (Request::path() === 'admin/bank/transfer-list') {{ 'active' }} @endif"><a
                                    href="{{ route('bank-transfer.index') }}"> {{ translate('View') }}
                                    {{ translate('Bank') }} {{ translate('Transaction') }}
                                </a>
                            </li>
                            <li class="@if (Request::path() === 'admin/bank/admin-transfer') {{ 'active' }} @endif"><a
                                    href="{{ route('admin-transfer') }}">{{ translate('Admin') }}
                                    {{ translate('Transfer') }} </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('Customer') ||
                        auth()->user()->can('All'))
                    <li class="treeview @if (Request::path() === 'admin/customers' || Request::path() === 'admin/customers/create') {{ 'active' }} @endif">
                        <a href="#">
                            <i class="fa fa-user"></i>

                            <span> {{ translate('Customers') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@if (Request::path() === 'admin/customers/create') {{ 'active' }} @endif"><a
                                    href="{{ route('customers.create') }}"> {{ translate('Add') }}
                                    {{ translate('Customer') }} </a>
                            </li>
                            <li class="@if (Request::path() === 'admin/customers') {{ 'active' }} @endif"><a
                                    href="{{ route('customers.index') }}"> {{ translate('View') }}
                                    {{ translate('Customer') }} </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('Report') ||
                        auth()->user()->can('All'))
                    <li class="treeview @if (Request::path() === 'admin/report-history' ||
                            Request::path() === 'admin/sale-report' ||
                            Request::path() === 'admin/purchase-payment-reports' ||
                            Request::path() === 'admin/sale-payment-reports' ||
                            Request::path() === 'admin/stock-report' ||
                            Request::path() === 'admin/admin/report-history' ||
                            Request::path() === 'admin/sale-due' ||
                            Request::path() === 'admin/purchase-due' ||
                            Request::path() === 'admin/product-report' ||
                            Request::path() === 'admin/cr-master-report' ||
                            Request::path() === 'admin/total-profits' ||
                            Request::path() === 'admin/net-profits' ||
                            Request::path() === 'admin/investment') {{ 'active' }} @endif">
                        <a href="#">
                            <i class="fa fa-file"></i>

                            <span>{{ translate('Reports') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@if (Request::path() === 'admin/report-history') {{ 'active' }} @endif"><a
                                    href="{{ route('report-history.index') }}">
                                    {{ translate('Report') }} {{ translate('History') }} </a>
                            </li>
                            <li class="@if (Request::path() === 'admin/sale-report') {{ 'active' }} @endif"><a
                                    href="{{ route('sale.report') }}"> {{ translate('Sale') }}
                                    {{ translate('Report') }} </a>
                            </li>
                            <li class="@if (Request::path() === 'admin/stock-report') {{ 'active' }} @endif"><a
                                    href="{{ route('stock.report') }}"> {{ translate('Stock') }}
                                    {{ translate('Report') }} </a>
                            </li>
                            <li class="@if (Request::path() === 'admin/cr-master-report') {{ 'active' }} @endif"><a
                                    href="{{ route('cr.master.report') }}"> {{ translate('C.R') }}
                                    {{ translate('Master') }} {{ translate('C.R') }} {{ translate('Report') }}
                                </a>
                            </li>
                            <li class="@if (Request::path() === 'admin/product-report') {{ 'active' }} @endif"><a
                                    href="{{ route('product.report') }}"> {{ translate('Product') }}
                                    {{ translate('Report') }} </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('User') ||
                        auth()->user()->can('Admin') ||
                        auth()->user()->can('All'))
                    <li class="treeview @if (Request::path() === 'admin/users/create' ||
                            Request::path() === 'admin/users' ||
                            Request::path() === 'admin/designations' ||
                            Request::path() === 'admin/sections' ||
                            request()->is('admin/users/*/edit')) {{ 'active' }} @endif">
                        <a href="#">
                            <i class="fa fa-users"></i>

                            <span>{{ translate('users') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@if (Request::path() === 'admin/designations') {{ 'active' }} @endif"><a
                                    href="{{ route('designations.index') }}">{{ translate('Designations') }}</a>
                            </li>
                            <li class="@if (Request::path() === 'admin/sections') {{ 'active' }} @endif"><a
                                    href="{{ route('sections.index') }}">{{ translate('Sections') }}</a>
                            </li>
                            <li class="@if (Request::path() === 'admin/users/create') {{ 'active' }} @endif"><a
                                    href="{{ route('users.create') }}"> {{ translate('Add') }}
                                    {{ translate('User') }}</a>
                            </li>
                            <li class="@if (Request::path() === 'admin/users') {{ 'active' }} @endif"><a
                                    href="{{ route('users.index') }}"> {{ translate('View') }}
                                    {{ translate('user') }}</a>
                            </li>
                        </ul>
                    </li>
                @endif
                {{-- @if (auth()->user()->can('User') ||
    auth()->user()->can('All'))
                    <li class="treeview @if (Request::path() === 'admin/delivery-man/create' || Request::path() === 'admin/delivery-man' || request()->is('admin/delivery-man/*/edit')) {{ 'active' }} @endif">
                        <a href="#">
                            <span>Delivery Man</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@if (Request::path() === 'admin/delivery-man') {{ 'active' }} @endif"><a
                                    href="{{ route('delivery-man.create') }}">Add
                                    Delivery
                                    Man</a>
                            </li>
                            <li class="@if (Request::path() === 'admin/delivery-man') {{ 'active' }} @endif"><a
                                    href="{{ route('delivery-man.index') }}"> View
                                    Delivery
                                    Man</a>
                            </li>
                        </ul>
                    </li>
                @endif --}}
                @if (auth()->user()->can('Payment Method') ||
                        auth()->user()->can('All'))
                    <li>
                        <a href="{{ route('payment-method.index') }}">
                            <i class="fa fa-money"></i>
                            <span>{{ translate('Payment') }} {{ translate('Method') }}</span>
                        </a>
                    </li>
                @endif
                {{-- <li class="treeview @if (Request::path() === 'admin/salary/create' || Request::path() === 'admin/salary' || request()->is('admin/salary/*/edit') || Request::path() === 'admin/employees/create' || Request::path() === 'admin/employees' || request()->is('admin/employees/*/edit') || Request::path() === 'admin/loan-advance/create' || Request::path() === 'admin/loan-advance' || Request::path() === 'admin/attendance/create' || Request::path() === 'admin/attendance') {{ 'active' }} @endif">
                    <a href="#">
                        <span>Employee Management</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview @if (Request::path() === 'admin/employees/create' || Request::path() === 'admin/employees' || request()->is('admin/employees/*/edit')) {{ 'active' }} @endif">
                            <a href="{{ route('employees.index') }}"> Employees
                            </a>
                        <li class="@if (Request::path() === 'admin/departments') {{ 'active' }} @endif"><a
                                href="{{ route('departments.index') }}">Department</a>
                        </li>
                        <ul class="treeview-menu">
                            <li class="@if (Request::path() === 'admin/employees/create') {{ 'active' }} @endif">
                                <a href="{{ route('employees.create') }}"> New Employee</a>
                            </li>
                            <li class="@if (Request::path() === 'admin/employees') {{ 'active' }} @endif"><a
                                    href="{{ route('employees.index') }}">
                                    View Employee</a>
                            </li>
                        </ul>
                   </li>
               </ul>
            </li> --}}


                {{-- <li class="treeview">
            <a href="#">
                <span>Ecommerce</span>
            </a>
            <ul class="treeview-menu">
                <li class="treeview ">
                    <a href="#">
                        <span>Slider</span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview ">
                            <a href="{{ route('ecomsilder') }}"> Create Silder
                            </a>
                            <a href="{{ route('viewslider') }}"> View Silder
                            </a>

                        </li>
                    </ul>
                </li>
                <li class="treeview ">
                    <a href="#">
                        <span>News</span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview ">
                            <a href="{{ route('news.create') }}"> Create News
                            </a>
                            <a href="{{ route('news.index') }}"> View News
                            </a>

                        </li>
                    </ul>
                </li>
                <li class="treeview ">
                    <a href="#">
                        <span>Message</span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview ">
                            <a href="{{ route('contact.message') }}"> Message List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="@if (Request::path() === 'admin/frontend/settings') {{ 'active' }} @endif">
                    <a href="{{ route('frontend.settings.index') }}">
                        <span>Settings</span>
                    </a>
                </li>


        </li> --}}
                @if (auth()->user()->can('All'))
                    <li class="treeview @if (Request::path() === 'admin/settings' || Request::path() === 'admin/settings/sms') {{ 'active' }} @endif">
                        <a href="#">
                            <i class="fa fa-cog"></i>
                            <span>{{ translate('Settings') }}</span>
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="@if (Request::path() === 'admin/settings') {{ 'active' }} @endif"><a
                                    href="{{ route('settings.index') }}"> {{ translate('System') }}
                                    {{ translate('Settings') }}
                                </a>
                            </li>
                            {{-- <li class="@if (Request::path() === 'admin/settings/sms') {{ 'active' }} @endif"><a
                                href="{{ route('sms.index') }}">
                                {{ translate('SMS') }} {{ translate('Setup') }} </a>
                        </li> --}}
                        </ul>
                    </li>

                    <li class="@if (Request::path() === 'admin/language/*') {{ 'active' }} @endif">
                        <a class="nav-link " href="{{ route('language.index') }}" title="add new  language">
                            <i class="fa  fa-language"></i>
                            <span class="text-truncate">{{ translate('Language') }}</span>
                        </a>
                    </li>
                @endif
        </ul>
        </li>





        @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
