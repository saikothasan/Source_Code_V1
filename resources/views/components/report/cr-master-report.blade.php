
<style>

 .row{
     display: flex;
 }
</style>


<div class="center second-section">
    <h3><strong>  {{$report['report_name']}} </strong></h3>
    <p>{{date('d-m-Y',strtotime($report['from_date']))}} to {{date('d-m-Y',strtotime($report['to_date']))}}</p>
    <p>
        {!! $report['details']['total_pieces']['report_title'] !!}
    </p>
</div>
@if(isset($report['details']['total_pieces']))
    @php
        $total_report =  $report['details']['total_pieces'];
    @endphp
    <div>
        <div class="">
            <div class="col-md-12" style="margin-bottom: 20px;padding-left: 10px;">
                <table class="table table-striped table-responsive example-table">
                    <thead class="header">
                    <tr class="table-head">
                        <th class="text-center">Total Sales</th>
                        <th class="text-center">Total Cost</th>
                        <th class="text-center">Profit</th>

                    </tr>

                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center">{{number_format($total_report['total_sales'] ?? 0)}} {{get_settings('currency_symbol')}}</td>
                        <td class="text-center">{{number_format($total_report['total_cost'] ?? 0)}} {{get_settings('currency_symbol')}}</td>
                        <td class="text-center">{{number_format($total_report['total_profit'] ?? 0)}} {{get_settings('currency_symbol')}}</td>

                    </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="row" style="margin-bottom: 12%;">
            <div class="col-md-4 paddin-dicress">
                <div class="card card-sale">
                    <div class="card-header">
                        Sale Details
                    </div>
                    @if(isset($total_report['sales_details']))
                        <ul class="list-group list-group-flush">
                            @foreach($total_report['sales_details']['branch'] as $value)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-8">
                            <span class="for-title-branch">
                                {{$value['name']}}
                            </span>
                                            <p> {{$value['payment_method']}}</p>

                                            <div class="total_pices">{{$value['sale_pcs'] ?? 0}} pcs</div>
                                        </div>
                                        <div class="col-md-4 amount-margin text-right">
                                            <strong>{{number_format($value['total_amount'])}} {{get_settings('currency_symbol')}}</strong>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                            <div class="row" style="padding: 14px;">
                                <div class="col-md-8">
                                    <div class="total_pices">{{$total_report['sales_details']['total_pieces']}}pcs
                                    </div>
                                </div>
                                <div class="col-md-4 text-right">
                                    <strong>{{number_format($total_report['sales_details']['total_amount'])}} {{get_settings('currency_symbol')}}</strong>
                                </div>
                            </div>
                        </ul>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <span> Return : {{$total_report['sales_details']['total_return_pcs']}} pcs</span>
                                </div>
                                <div class="col-md-6">
                                    <span> Exchange : {{$total_report['sales_details']['total_exchange_pcs']}} pcs</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card card-other-cost">
                    <div class="card-header">
                        Others Cost
                    </div>
                    @if(isset($total_report['others_cost']))
                        <ul class="list-group list-group-flush">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td rowspan="3" style="padding-top: 12%;"><span> Delivery </span></td>
                                    <td colspan="4">Normal (no cost) <span style="float: right;">{{number_format($total_report['others_cost']['normal_delivery_cost'])}} {{get_settings('currency_symbol')}}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4">Return <span style="float: right;">{{number_format($total_report['others_cost']['return_delivery_cost'])}} {{get_settings('currency_symbol')}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">Exechange <span style="float: right;">{{number_format($total_report['others_cost']['exchange_delivery_cost'])}} {{get_settings('currency_symbol')}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span> Discount </span></td>
                                    <td colspan="4"><span style="float: right;">{{number_format($total_report['others_cost']['discount'])}} {{get_settings('currency_symbol')}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-center text-red">
                                        <strong>{{number_format($total_report['others_cost']['total_other_cost'])}}
                                             {{get_settings('currency_symbol')}}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </ul>
                    @endif
                </div>
            </div>

            <div class="col-md-4 paddin-dicress">
                <div class="card card-cost">
                    <div class="card-header">
                        Cost Details
                    </div>
                    @if(isset($total_report['cost_details']))
                        <ul class="list-group list-group-flush">
                            @foreach($total_report['cost_details']['branch'] as $value)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-8">
                            <span class="for-title-branch">
                                {{$value['name']}}
                            </span>
                                        </div>
                                        <div class="col-md-4"></div>
                                    </div>
                                    <div class="cost-row">
                                        <div class="row">
                                        <div class="col-md-8">
                                           Daily Cost
                                        </div>
                                        <div class="col-md-4 text-right text-nowrap">
                                           {{number_format($value['daily_cost'])}} {{get_settings('currency_symbol')}}
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-8">
                                           Monthly Cost
                                        </div>
                                        <div class="col-md-4 text-right text-nowrap">
                                           {{number_format($value['monthly_cost'])}} {{get_settings('currency_symbol')}}
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-8">
                                           One Time Cost
                                        </div>

                                        <div class="col-md-4 text-right text-nowrap" >
                                            {{number_format($value['one_time_cost'])}} {{get_settings('currency_symbol')}}
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-8">
                                          Salary
                                        </div>
                                        <div class="col-md-4 text-right text-nowrap">
                                          0 {{get_settings('currency_symbol')}}
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-8">
                                            Sales Product Purchase
                                        </div>
                                        <div class="col-md-4 text-right text-nowrap">
                                           {{number_format($value['sales_product_purchase'])}}
                                                 {{get_settings('currency_symbol')}}
                                        </div>
                                        </div>
                                    </div>
                                    <div class="text-center" style="color: red; margin-top: 10px;">
                                        <center> {{strtolower($value['name'])}} total cost
                                            : {{number_format($value['total_cost'])}} {{get_settings('currency_symbol')}}
                                        </center>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-profit">
                    <div class="card-header">
                        Profit Details
                    </div>
                    @if(isset($total_report['profit_details']))
                        <ul class="list-group list-group-flush">
                            @foreach($total_report['profit_details']['branch'] as $value)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <span> {{$value['name']}}</span>
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <span>  {{number_format($value['total_profit'] ?? 0)}} {{get_settings('currency_symbol')}}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="card card-blance">
                    <div class="card-header">
                        Bank Blance
                    </div>
                    @if(isset($total_report['bank_balance']))
                        <ul class="list-group list-group-flush">
                            @foreach($total_report['bank_balance'] as $value)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <span>{{$value['name']}}</span>
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <span> {{number_format($value['total_amount']?? 0)}} {{get_settings('currency_symbol')}}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

@endif
