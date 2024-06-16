<div id="mySidepanel" class="sidepanel">
    <ul class="sidebar-menu tree" data-widget="tree">
        <li class="active treeview ">
            <a href="javascript:void(0)" onclick="closeNav()">
                <span class="white-text">{{ translate('More')}} {{ translate('Options')}}</span>
                <span class="pull-right-container">
                    <i class="fa fa-fw fa-bars white-text"></i>
                </span>
            </a>
        </li>
        <li>
            <a href="{{ route('supplier.payable', $supplier_info->id) }}">
                <span class="white-text">{{ translate('Payable')}} {{ translate('Amount')}}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('supplier.product',$supplier_info->id) }}">
                <span class="white-text">{{ translate('Product')}}</span>
            </a>
        </li>
        <li>
            <a href="{{route('suppliers.show',$supplier_info->id)}}">
                <span class="white-text">{{ translate('View')}} {{ translate('Purchase')}}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('supplier.stock', $supplier_info->id) }}">
                <span class="white-text">{{ translate('Stockwise')}} {{ translate('Positon')}}</span>
            </a>
        </li>
        <li>
            <a href="{{route('supplier.view-payment', $supplier_info->id)}}">
                <span class="white-text">{{ translate('View')}} {{ translate('Payment')}} </span>
            </a>
        </li>
    </ul>
</div>
