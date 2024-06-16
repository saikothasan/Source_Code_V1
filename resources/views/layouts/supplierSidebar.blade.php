<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar text-center">
        <ul class="sidebar-menu">
            <li class="treeview @if (in_array(Request::path(), ['admin/products/create', 'admin/products'])){{ 'active' }} @endif">
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
                </ul>
            </li>
            <li class="treeview @if (in_array(Request::path(), ['admin/purchases/create', 'admin/purchases', 'admin/purchases-return'])){{ 'active' }} @endif">
                <a href="#">
                    <i class="fa fa-support "></i>
                    <span> {{ translate('Purchase') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="@if (Request::path() === 'admin/purchases/create') {{ 'active' }} @endif"><a
                            href="{{ route('purchases.create') }}"> {{ translate('Add') }}
                            {{ translate('Purchase') }}</a></li>
                    <li class="@if (Request::path() === 'admin/purchases') {{ 'active' }} @endif"><a
                            href="{{ route('purchases.index') }}"> {{ translate('View') }}
                            {{ translate('Purchase') }}</a></li>
                    <li class="@if (Request::path() === 'admin/purchases-return') {{ 'active' }} @endif"><a
                            href="{{ route('purchase-return.index') }}"> {{ translate('Purchase') }}
                            {{ translate('Return') }}</a></li>
                </ul>
            </li>
            <li class="@if (Request::path() === 'admin/transfer-received') {{ 'active' }} @endif">
                <a class="nav-link " href="{{ route('transfer-received.list') }}" title="add new  language">
                    <i class="fa  fa-language"></i>
                    <span class="text-truncate">{{ translate('Transfer')  }} {{ translate('&')  }} {{ translate('Received')  }}</span>
                </a>
            </li>
            <li class="@if (Request::path() === 'admin/banks') {{ 'active' }} @endif">
                <a class="nav-link " href="{{ route('banks.index') }}" title="add new  language">
                    <i class="fa  fa-language"></i>
                    <span class="text-truncate">{{ translate('Account')}}</span>
                </a>
            </li>
        </ul>
    </section>

</aside>
