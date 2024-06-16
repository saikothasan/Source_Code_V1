@extends('layouts.app')
@section('title', 'Management Dashboard')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css') }}">
@endpush
@section('content')

    <style>
        .small-box {
            border-radius: 25px;
        }

        .box-header {
            background: #f1f7f4 !important;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            padding: 10px !important;
            color: #4a4949 !important;
            font-weight: 600;
            padding: 10px;
        }

        .box-footer-f {
            background: #f1f7f4 !important;
            padding: 3px !important;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            color: #4a4949 !important;
            font-family: 'Arial';
            padding: 5px !important;
        }

        .inner-body {
            padding: 5px;
            text-align: center;
        }



        hr.new {
            border: 1px solid rgb(0, 0, 0);
            border-radius: 5px;
            margin-top: 0px;
            margin-bottom: 8px;
        }

        .left-align {
            font-family: 'RobotoLight';
            text-align: left;
        }

        .center-align {
            font-family: 'RobotoLight';
            text-align: center;
        }

        .bg-light {
            background: white;
        }

        .bg-light:hover {
            background: white;
            color: #4a4949;
        }

        .text-large {

            font-size: 27px;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-aqua"><i class="fa fa-apple"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text text-bold">{{ translate('Total') }} {{ translate('Product') }}
                                </span>
                                <span class="info-box-number text-large">{{ number_format($total_product) }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>


                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="fa fa-opencart"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text text-bold">{{ translate('Sale') }} {{ translate('Product') }}
                                </span>
                                <span class="info-box-number text-large"> {{ number_format($total_sale) }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-yellow"><i class="fa fa-gg"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text text-bold">{{ translate('Available Product') }}</span>
                                <span
                                    class="info-box-number text-large">{{ number_format($total_product - $total_sale) }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ translate('Yearly') }} {{ translate('Cash') }}
                                    {{ translate('Flow') }} </h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                    </button>

                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p class="text-center">
                                            <strong> {{ translate('Sales') }} {{ translate('And') }}
                                                {{ translate('Cost') }} </strong>
                                        </p>

                                        <div class="chart" id="bar-chart" style="height: 300px;">
                                            <canvas id="myChart" height="250px"></canvas>

                                        </div>
                                        <!-- /.chart-responsive -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-4">
                                        <p class="text-center">
                                            <strong> {{ translate('Branch') }} {{ translate('Wise') }}
                                                {{ translate('Product') }} {{ translate('Status') }}</strong>
                                        </p>
                                        @foreach ($branch_wise_product as $branch_product)
                                            @php
                                                $branch_sale_percentage = 0;
                                                if ($branch_product->stock > 0) {
                                                    $branch_sale_percentage = round(($branch_product->sale / $branch_product->stock) * 100);
                                                }
                                            @endphp
                                            <div class="progress-group">
                                                <span class="progress-text">{{ $branch_product->name }}</span>
                                                <span
                                                    class="progress-number"><b>{{ number_format($branch_product->sale) }}</b>/{{ number_format($branch_product->stock) }}</span>

                                                <div class="progress ">
                                                    <div class="progress-bar progress-bar-aqua"
                                                        style="width:{{ $branch_sale_percentage }}%"></div>
                                                </div>
                                            </div>
                                        @endforeach


                                        <!-- /.progress-group -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- ./box-body -->
                            <div class="box-footer">

                                <!-- /.row -->
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title"> {{ translate('Total') }} {{ translate('Account') }}
                                    {{ translate('Summary') }} </h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                    </button>

                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body" style="background:#f1efef;">
                                <div class="row">

                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="info-box " style="height:190px">

                                            <div class="info-box-content" style="padding-top:10%;">
                                                <i class="fa fa-money"></i>

                                                <span class="info-box-text text-bold"> {{ translate('Cash Drawer') }}
                                                    {{ translate('Amount') }} </span>
                                                <span
                                                    class="info-box-number text-large">{{ number_format($cash_drawer->amount ?? 0) }}
                                                    {{ get_settings('currency_symbol') }}</span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-8">
                                        @foreach ($paymentMethods as $payment)
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon ">

                                                        <img src="{{ asset($payment->photo) }}" style="height:50%"
                                                            onerror="this.onerror=null;this.src='{{ asset('images/sales/money.png') }}';"
                                                            alt="Card Back">
                                                        </a>
                                                    </span>
                                                    <div class="info-box-content">
                                                        <span
                                                            class="info-box-text"><strong>{{ $payment->name }}</strong></span>
                                                        <span
                                                            class="info-box-number">{{ floatFormat($payment->total_balance) }}
                                                            {{ get_settings('currency_symbol') }}</span>
                                                    </div>

                                                </div>

                                            </div>
                                        @endforeach
                                        <div class="text-center">
                                            <a href="{{ route('payment-method.index') }}">
                                                <button class="btn btn-info"> {{ translate('view') }}
                                                    {{ translate('more') }} </button>
                                            </a>
                                        </div>

                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- ./box-body -->
                            <div class="box-footer">

                                <!-- /.row -->
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="row">


                    @foreach ($branches as $key => $value)
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <div class="small-box bg-light">
                                <h4 class="small-box-footer box-header">{{ $value->name }}</h4>
                                <div class="box-body">
                                    <div class="row" style="font-family: 'RobotoLight';">
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                            <p class="center-align"> {{ translate('MONTHLY') }} </p>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                            <p class="center-align"> {{ translate('TODAY') }} </p>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 0;">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <p>{{ number_format($value->month_sales) }}
                                                {{ get_settings('currency_symbol') }}</p>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            SELLS
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <p>{{ number_format($value->today_sales) }}
                                                {{ get_settings('currency_symbol') }}</p>
                                        </div>
                                    </div>
                                    <hr class="new">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <p>{{ number_format($value->month_expenses) }}
                                                {{ get_settings('currency_symbol') }}</p>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            COST
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <p>{{ number_format($value->today_expenses) }}
                                                {{ get_settings('currency_symbol') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('branch.sale', ['branch' => $value->id, 'type' => 'sale']) }}"
                                    class="center-align small-box-footer box-footer-f"
                                    style="font-size: 15px">{{ translate('More') }}
                                    {{ translate('info') }}
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        {{-- <div class="small-box bg-green">
                                <h4 class="small-box-footer box-header">ALL SELL - EXPENSE - PROFIT</h4>
                                <div class="inner-body">
                                    <div class="row">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <p class="left-align" style="white-space: nowrap;">TOTAL SALE</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <p>: {{ number_format($total_sale_amount) }} {{get_settings('currency_symbol')}}</p>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <p class="left-align" style="white-space: nowrap;">TOTAL EXPENSE</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <p>: {{ number_format($total_expense) }} {{get_settings('currency_symbol')}}</p>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <p class="left-align" style="white-space: nowrap;">TOTAL PROFIT</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <p>: {{ $total_profit }} {{get_settings('currency_symbol')}}</p>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    </div>

                                </div>

                                <a href="{{ route('branch.index') }}" class="center-align small-box-footer box-footer-f"
                                    style="font-size: 15px">More
                                    info
                                </a>

                            </div> --}}
                    </div>
                    {{-- <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="small-box bg-light">
                            <h4 class="small-box-footer box-header"> {{ translate('ALL') }} {{ translate('Product') }}
                            </h4>
                            <div class="inner-body">
                                <div class="row">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6">
                                        <p class="left-align" style="white-space: nowrap;"> {{ translate('TOTAL') }}
                                            {{ translate('PRODUCT') }} </p>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <p>: {{ number_format($total_product) }} {{get_settings('currency_symbol')}}</p>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <p class="left-align" style="white-space: nowrap;">{{ translate('TOTAL') }}
                                            {{ translate('SELL') }} </p>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <p>: {{ number_format($total_sale) }} {{get_settings('currency_symbol')}}</p>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <p class="left-align" style="white-space: nowrap;">{{ translate('TOTAL') }}
                                            {{ translate('AVAILABLE') }} </p>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <p>: {{ number_format($total_product - $total_sale) }} {{get_settings('currency_symbol')}}</p>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                </div>
                            </div>
                            <a href="{{ route('products.index') }}" class="center-align small-box-footer box-footer-f"
                                style="font-size: 15px"> {{ translate('More') }}
                                {{ translate('info') }}
                            </a>

                        </div>
                    </div> --}}
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        {{-- <div class="small-box bg-green">
                                <h4 class="small-box-footer box-header">Employee Management</h4>
                                <div class="inner-body">
                                    <div class="row">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <p class="left-align">TOTAL EMPLOYEE</p>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <p>: 0</p>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <p class="left-align" style="white-space: pre">PRESENT EMPLOYEE</p>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <p>: 0</p>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <p class="left-align">ABSENT EMPLOYEE</p>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <p>: 0</p>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    </div>

                                </div>

                                <a href="/" class="center-align small-box-footer box-footer-f"
                                    style="font-size: 15px">More
                                    info
                                </a>

                            </div> --}}
                    </div>
                </div>
            </div>

        </section>
    </div>

@endsection
@push('js')
    <script src="{{ asset('assets/js/chart.js') }}"></script>

    <script src="{{ asset('assets/plugins/morris/morris.js') }}"></script>


    <script>
        var labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
            'November', 'December'
        ];
        var labels_amarlodge = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
            'October',
            'November', 'December'
        ];
        var cost = {!! json_encode($month_wise_cost) !!};

        var sale = {!! json_encode($month_wise_sale) !!};

        console.log(sale);
        const data = {
            labels: labels,
            labels_amarlodge,
            datasets: [{
                    label: 'Cost',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: cost,
                },
                {
                    label: 'Sale',
                    backgroundColor: 'rgb(0, 53, 236)',
                    borderColor: 'rgb(0, 53, 236)',
                    data: sale,
                }
            ]
        };

        const config = {
            type: 'line',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

        // LINE CHART
        var line = new Morris.Line({
            element: 'line-chart',
            resize: true,
            data: [{
                    y: '2011 Q1',
                    item1: 2666
                },
                {
                    y: '2011 Q2',
                    item1: 2778
                },
                {
                    y: '2011 Q3',
                    item1: 4912
                },
                {
                    y: '2011 Q4',
                    item1: 3767
                },
                {
                    y: '2012 Q1',
                    item1: 6810
                },
                {
                    y: '2012 Q2',
                    item1: 5670
                },
                {
                    y: '2012 Q3',
                    item1: 4820
                },
                {
                    y: '2012 Q4',
                    item1: 15073
                },
                {
                    y: '2013 Q1',
                    item1: 10687
                },
                {
                    y: '2013 Q2',
                    item1: 8432
                }
            ],
            xkey: 'y',
            ykeys: ['item1'],
            labels: ['Item 1'],
            lineColors: ['#3c8dbc'],
            hideHover: 'auto'
        });
    </script>
@endpush
