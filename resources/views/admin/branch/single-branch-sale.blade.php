@extends('layouts.app')
@section('title', 'View Sale')
@section('content')
    <style>
        .header {
            border-radius: 12px;
            border: 2px solid black;
            padding: 12px
        }

        .active {

            color: rgb(255 255 255) !important;
            background: #00c0ef !important;
        }

        .active h4 {
            color: white;
        }

        .non-active {
            /*border: 1px solid #00c0ef !important;*/
            background: white !important;
            color: #00c0ef !important;
        }

        .corner {
            border-radius: 7px;
            text-align: center;
        }

        .box-header {
            border-radius: 8px;
        }

        .groupedInput {
            border: 1px solid #e1cdcd;
            border-radius: 7px;
            /*border-radius: 10px;*/
        }

        .spacer {
            margin-top: 20px;
        }

        .groupedLabel {
            margin-top: 7px;
            color: rgb(153, 153, 153);
        }

        .example-table tr:nth-child(2n+1) {
            background-color: #ddd;
        }

        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
        }

        .action {
            color: rgb(167, 169, 172);
            font-family: 'Roboto Light', serif;
        }

        .image-size {
            width: 1.5em;
            height: 1.5em;
        }

        .product {
            background-color: #00c0ef !important;
            color: #ffff;
        }

        .product-inner {
            background-color: rgb(255, 255, 255) !important;
            color: rgb(35, 31, 32);
        }

        .small-box>.inner {
            padding: 10px;
            border: 1px solid #00c0ef;
        }

        .box-header {
            color: #444;
            display: block;
            padding: 0;
            position: relative;
        }

        .for-height {
            height: 130px;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                        <h3 class="header"><strong>{{ translate($branch->name) }}</strong></h3>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="for-height" style="border-radius: 12px;border: 2px solid #00c0ef;">
                            <div
                                class="box-header @if (Request::path() === 'admin/branch-sell/' . $branch->id . '/stock') {{ 'active' }} @else {{ 'non-active' }} @endif">
                                <a href="{{ route('branch.sale', ['branch' => $branch->id, 'type' => 'stock']) }}"
                                    class="small-box-footer top-radious" style="">
                                    <h4 class="text-center box-header"><strong>{{translate('Stock')}}</strong></h4>
                                </a>
                            </div>
                            <hr style="border: 0;border-top: 2px solid #00c0ef; margin:0;" />
                            <div class="inner-body">
                                <br>
                                <div class="row">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <p class="left-align" style="white-space: pre">{{translate('Total')}} {{translate('Stock')}}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <p>{{ number_format($sub_total_buy_price) }} {{get_settings('currency_symbol')}}</p>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                </div>
                                <div class="row">

                                    <div class="text-center">
                                        <p class="left-align">{{ number_format($total_stock) }} pcs</p>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 mt-3"></div>

                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="for-height " style="border-radius: 12px;border: 2px solid #00c0ef; ">
                            <div
                                class="box-header @if (Request::path() === 'admin/branch-sell/' . $branch->id . '/sale') {{ 'active' }} @else {{ 'non-active' }} @endif">
                                <a href="{{ route('branch.sale', ['branch' => $branch->id, 'type' => 'sale']) }}"
                                    class="small-box-footer top-radious" style="">
                                    <h4 class="text-center "><strong>{{translate('Sale')}}</strong></h4>
                                </a>
                            </div>

                            <hr style="border: 0;border-top: 2px solid #00c0ef; margin:0px;" />
                            <div class="inner-body">
                                <br>
                                <div class="row">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <p class="left-align">{{translate('Total')}} {{translate('Sale')}}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <p>{{ number_format($total_sell) }} {{get_settings('currency_symbol')}}</p>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <p class="left-align" style="white-space: pre">
                                            {{ number_format($total_sale_quantity) }} {{translate('pcs')}}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <p>{{ number_format($sub_total_buy_price) }} {{get_settings('currency_symbol')}}</p>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>

                                    <div class="container">

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="for-height" style="border-radius: 12px;border: 2px solid #00c0ef;">
                            <div
                                class="box-header @if (Request::path() === 'admin/branch-sell/' . $branch->id . '/profit') {{ 'active' }} @else {{ 'non-active' }} @endif">
                                <a href="{{ route('branch.sale', ['branch' => $branch->id, 'type' => 'profit']) }}"
                                    class="small-box-footer top-radious @if (Request::path() === 'admin/branch-sell/2/stock') {{ 'active' }} @else {{ 'non-active' }} @endif"
                                    style="">
                                    <h4 class="text-center box-header"><strong>{{translate('Profit')}}</strong></h4>
                                </a>
                            </div>
                            <hr style="border: 0;border-top: 2px solid #00c0ef; margin:0;" />
                            <div class="inner-body">
                                <br>
                                <div class="row">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <p class="left-align">{{translate('Total')}} {{translate('Profit')}}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <p>{{ $monthly_profit }} {{get_settings('currency_symbol')}}</p>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <p class="left-align">{{translate('Total')}} {{translate('Cost')}}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <p>{{ $monthly_cost }} {{get_settings('currency_symbol')}}</p>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @if (isset($branch_product))
                    @include('admin.branch.stock_list')
                @elseif(isset($branch_cost))
                    @include('admin.branch.profit-list')
                @else
                    @include('admin.branch.single-sale-list')
                @endif
            </div>
    </div>
    </section>
    </div>

@endsection
