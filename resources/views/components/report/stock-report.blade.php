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

                            @if(isset($total_report['stock_pieces']))
                                @foreach($total_report['stock_pieces'] as $stock_price)
                                    <h4>{{$stock_price['text']}} :
                                        <strong>{{number_format($stock_price['total'])}}</strong> pcs
                                    </h4>
                                @endforeach
                            @endif
                        </td>
                        <td colspan="2" style="border-left:none;">
                            @if(isset($total_report['stock_prices']))
                                @foreach($total_report['stock_prices'] as $stock_piece)
                                    <h4 class="{{$stock_piece['class'] ?? ''}}">{{$stock_piece['text']}} :
                                        <strong>{{number_format($stock_piece['total'])}}
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
                @if(isset($total_report['inWords']))
                    <h4><strong> in words </strong></h4>
                    <span style="white-space: pre-line;">
                        {!! $total_report['inWords'] !!}
                   </span>
                @endif
            </div>
        </div>
    </div>
@endif

@if(isset($report['details']['individual_pieces']))
    <div>
        <div class="sale-table individual">
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


