<form action="{{ route('branch.sale',['branch' =>$branch->id, 'type' => 'sale']) }}" method="get">
    <div class="col-md-12 row text-center spacer">
        <div class="col-md-2">
        </div>
        <div class="col-md-5 groupedInput">
            <div class="row form-inline">
                <div class="col-md-1 text-center">
                    <label class="groupedLabel">{{translate('From')}}</label>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input value="{{request()->get('from-date')}}" name="from-date"
                               type="date" class="form-control corner">
                    </div>
                </div>
                <div class="col-md-1 text-center" style="margin-left: 25px;">
                    <label class="groupedLabel">{{translate('To')}}</label>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input value="{{request()->get('to-date')}}" name="to-date" type="date"
                               class="form-control corner"
                        >
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group" style="width: 72px;">
                <x-url-param-clear></x-url-param-clear>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <button class="form-control">{{translate('Submit')}}</button>
            </div>
        </div>
    </div>
</form>
<div class="card-body p-0 spacer" style="overflow-x: auto">
    <table class="table table-striped table-responsive example-table">
        <thead>
        <tr>
            <th>{{translate('SN')}}.</th>
            <th>{{translate('Sale')}} {{translate('Date')}}</th>
            <th>{{translate('Invoice')}}</th>
            <th>{{translate('Phone')}}</th>
            <th>{{translate('Name')}}</th>
            <th>{{translate('Item')}}</th>
            <th>{{translate('Quantity')}}</th>
            <th>{{translate('Buy')}} {{translate('Price')}}</th>
            <th>{{translate('Sale')}} {{translate('Price')}}</th>

            <th>{{translate('Profit')}}</th>


            <th></th>
            <th></th>

        </tr>
        </thead>
        <tbody>
        @php
            $total_buy_price = 0;
            $total_profit = 0;

        @endphp
        @forelse($sales as $value)
            @php


                $buy_price =   collect($value->saleDetails)->map(function ($saledetail_data) use ($value) {
                    return [
                        'buy_price_total' => $saledetail_data->quantity * $saledetail_data->buy_rate,
                        'profit_total' => $value->final_total - ($saledetail_data->quantity * $saledetail_data->buy_rate),
                    ];
                });
                $buy_price = collect($buy_price)->sum('buy_price_total');

                $profit =  $value->final_total -  $buy_price ;

            @endphp
            <tr>
                <td>{{ serialNumber($sales,$loop) }}</td>
                <td>{{date('d F y',strtotime($value->date))}}</td>
                <td>{{$value->invoice_code}}</td>
                <td>{{$value->customer->phone ?? ''}}</td>
                <td>{{$value->customer->name ?? ''}}</td>

                <td>{{$value->total_items ?? ""}}</td>
                <td>{{$value->total_quantity}}</td>
                <td>{{ $buy_price  }} {{get_settings('currency_symbol')}}</td>
                <td class="text-end">{{$value->final_total}} {{get_settings('currency_symbol')}}</td>
                <td>{{ $profit  }} {{get_settings('currency_symbol')}}</td>
                <td></td>


                <td class="action">
                    <a href="{{route('sales.show',$value->id)}}">
                        <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                             alt="edit"/>
                    </a>
                </td>
            </tr>

        @empty
            <tr class="text-center">
                <td colspan="9">
                    <h4 class="font-weight-bold">{{translate('No sale available')}}</h4>
                </td>
            </tr>
        @endforelse
        <tr>
            <td colspan="5" style="text-align: end">{{translate('Total')}} =</td>
            <td>{{ $total_items }}</td>
            <td>{{ $total_quantity }}</td>
            <td>{{ $sub_total_buy_price }} {{get_settings('currency_symbol')}}</td>
            <td>{{ $total_sell }} {{get_settings('currency_symbol')}}</td>
            <td>{{ $sub_total_profit }} {{get_settings('currency_symbol')}}</td>
            <td></td>
            <td></td>


        </tr>
        </tbody>
    </table>
    {{$sales->withQueryString()->links()}}
</div>
