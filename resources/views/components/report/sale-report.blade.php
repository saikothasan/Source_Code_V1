<div class="center second-section">
    <h3><strong> {{$report['report_name']}} </strong></h3>
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
        <div class="sale-table">
            <div class="card-body p-0 spacer" style="overflow-x: auto" >
                <table class="table table-striped table-responsive example-table">
                    <thead class="header">
                    <tr class="table-head">
                        @foreach($total_report['column'] as $value)
                            <th class="text-center">{{$value['title']}}</th>
                        @endforeach
                    </tr>

                    </thead>
                    <tbody>
                    <tr>
                        @foreach($total_report['column'] as $value)
                            <td class="text-center">{!! $total_report['column_row_data'][$value['key']] !!}</td>
                        @endforeach

                    </tr>
                    <tr>
                        <td colspan="3">

                            @if(isset($total_report['status_filter']))
                                @foreach($total_report['status_filter'] as $status)
                                    <h4>{{$status['text']}} :
                                        <strong>{{number_format($status['total'])}} pcs</strong>
                                    </h4>
                                @endforeach
                            @else
                                <h4>
                                    Sales Pieces :
                                    <strong>
                                        {{number_format($total_report['sales_pieces'])}} pcs
                                    </strong>
                                </h4>
                            @endif
                        </td>
                        <td colspan="2" style="border-left:none;">
                            @if(isset($total_report['amount_type']['value']))
                                <h4>{{$total_report['amount_type']['text']}} :
                                    <strong>{{number_format($total_report['amount_type']['amount'])}} {{get_settings('currency_symbol')}}</strong>
                                </h4>
                            @endif
                            @if(isset($total_report['amount_types']))
                                @foreach($total_report['amount_types_list'] as $typeName)
                                    <h4 class="{{$typeName['class'] ?? ''}}">{{$typeName['text']}} :
                                        <strong>{{formatWithComma($total_report['amount_types'][$typeName['value']])}}
                                             {{get_settings('currency_symbol')}}</strong>
                                    </h4>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="inword row">
            <div class="col-md-4" style="width: 50%;">
                @if(isset($total_report['amount_type']))
                    <h4><strong> in words </strong></h4>
                    <span> Total sales {{numberToWords($total_report['sales_pieces'])}} &
                            {{$total_report['amount_type']['text']}} {{numberToWords($total_report['amount_type']['amount'])}} </span>
                @endif
            </div>
        </div>
    </div>
@endif

@if(isset($report['details']['individual_pieces']))
    <div>
        <div class="sale-table">
            <div class="card-body p-0 spacer" style="overflow-x: auto" >
                <table class="table table-responsive">
                    <thead class="header">
                    <tr>
                        @foreach($report['details']['individual_pieces']['columns'] as $column)
                            <th class="text-center">{{$column['title']}}</th>
                        @endforeach
                    </tr>

                    </thead>
                    <tbody>
                    @foreach($report['details']['individual_pieces']['column_row_data'] as $value)
                        <tr>
                            @foreach($report['details']['individual_pieces']['columns'] as $column)
                                <td class="{{$column['class']}}">{{$value[$column['key']]}}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif


