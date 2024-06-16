@extends('layouts.app')
@section('title', 'Branch Wise Stock')
@section('content')
    <style>
        .header {
            color: rgb(37, 37, 36);
            margin-bottom: 3%;
        }

        .corner {
            border-radius: 7px;
            text-align: center;
        }

        .groupedInput {
            border: 1px solid #e1cdcd;
            border-radius: 7px;
            /*border-radius: 10px;*/
        }

        .spacer {
            margin-top: 20px;
        }

        .table-head {
            background-color: #231f20;
            color: white;
            font-size: 18px;
        }

        td {
            border: 1px solid black;
        }

        .groupedLabel {
            margin-top: 7px;
            color: rgb(153, 153, 153);
        }



        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
        }

        .action {
            color: rgb(167, 169, 172);
            font-family: 'Roboto Light';
        }

        .image-size {
            width: 1.5em;
            height: 1.5em;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h3 class="header">{{translate('Product')}} {{translate('with')}} {{translate('Position')}}</h3>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-2">
                        <p>{{translate('Sppliers')}} : {{ $product->product->supplier->name ?? '' }}</p>
                    </div>
                    <div class="col-md-2">
                        <p>{{translate('Category')}} : {{ $product->product->category->name ?? '' }}</p>
                    </div>
                    <div class="col-md-2">
                        <p>{{translate('Brand')}} : {{ $product->product->brand->name ?? '' }}</p>
                    </div>
                    <div class="col-md-2"></div>

                    <div class="col-md-4">
                        <p>{{translate('Product')}} {{translate('Add')}}: {{ date('d F Y h:m:s A', strtotime($product->created_at)) }} </p>
                    </div>

                </div>
                <div class="card-body p-0 spacer" style="overflow-x: auto" >
                    <table class="table table-striped table-responsive example-table">
                        <thead class="header">
                            <tr class="table-head">
                                <th>{{translate('SKU')}}</th>
                                <th>{{translate('Barcode')}}</th>
                                <th>{{translate('Product')}} {{translate('Name')}}</th>
                                <th>{{translate('Item')}}</th>
                                <th>{{translate('Total')}}</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>


                                <td>{{ $product->product->product_sku }}</td>
                                <td>{{ $product->product_barcode }}</td>
                                <td>{{ $product->product->name }}</td>

                                <td>
                                    {{--                                        collect($product->items)->count() ?? --}}
                                    {{ 1 }}
                                </td>
                                <td>{{ $product->total_quantity }} {{translate('pcs')}}</td>
                            </tr>

                        </tbody>
                    </table>

                </div>
                <br>
                @if (auth()->user()->is_main_branch == 1)


                    <div class="card-body p-0 spacer" style="overflow-x: auto" >
                        <div>
                            <h4> <strong>{{translate('Purchase')}} {{translate('History')}}</strong> </h4>
                        </div>
                        <table class="table table-striped table-responsive example-table">
                            <thead>
                                <tr class="table-head">
                                    <th>{{translate('Invoice')}} {{translate('No')}}.</th>
                                    <th>{{translate('Iteams')}}</th>
                                    <th>{{translate('Total')}} {{translate('Pcs')}}</th>
                                    <th>{{translate('Total')}} {{translate('Amount')}}</th>


                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_pec = 0;
                                    $total_amount = 0;

                                @endphp

                                @foreach ($purchases as $value)
                                    <tr>
                                        <td>{{ $value->invoice }}</td>
                                        <td>1</td>
                                        <td>{{ $value->quantity }}</td>

                                        <td>{{ $value->total }} {{get_settings('currency_symbol')}}</td>
                                        @php
                                            $total_pec += $value->quantity;
                                            $total_amount += $value->total;

                                        @endphp

                                    </tr>
                                @endforeach


                                <tr>
                                    <td colspan="2" style="text-align: end">{{translate('Total')}}</td>
                                    <td>{{ $total_pec }}</td>
                                    <td>{{ $total_amount }} {{get_settings('currency_symbol')}}</td>


                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <br>
                @endif
                <div class="card-body p-0 spacer" style="overflow-x: auto" >
                    <div>
                        <h4> <strong>{{translate('Transfer')}} {{translate('History')}}</strong> </h4>
                    </div>
                    <table class="table table-striped table-responsive example-table">
                        <thead>
                            <tr class="table-head">
                                <th>{{translate('Invoice')}} {{translate('No')}}.</th>
                                <th>{{translate('Sender')}}</th>
                                <th>{{translate('Received')}}</th>
                                <th>{{translate('Quantity')}} </th>
                                <th>{{translate('Date')}} </th>
                                <th>{{translate('Status')}} </th>




                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_pec = 0;

                            @endphp

                            @foreach ($transfers as $value)
                                <tr>
                                    <td>{{ $value->invoice_code }}</td>
                                    <td>{{ $value->transfer->sendBranch->name ?? '' }}</td>
                                    <td>{{ $value->transfer->receiveBranch->name ?? '' }}</td>
                                    <td>{{ $value->quantity }}</td>

                                    <td>{{ date('d F Y ', strtotime($value->date)) }}</td>
                                    <td>
                                        @if ($value->transfer?->invoice_type === 1 && $value->transfer->status === 0)
                                            <span>{{translate('Receive')}} {{translate('Pending')}}</span>
                                        @elseif($value->transfer?->invoice_type === 1 && $value->transfer->status === 1)
                                            <span>{{translate('Transferred')}}</span>
                                        @elseif($value->transfer?->invoice_type === 2 && $value->transfer->status === 1)
                                            <span>{{translate('Received')}}</span>
                                        @elseif($value->transfer?->status === 2)
                                            <span>{{translate('Transfer')}} {{translate('Reject')}}</span>
                                        @endif
                                    </td>
                                    @php
                                        $total_pec += $value->quantity;

                                    @endphp

                                </tr>
                            @endforeach


                            {{--                                <tr> --}}
                            {{--                                    <td colspan="3" style="text-align: end">Total</td> --}}
                            {{--                                    <td>{{ $total_pec }}</td> --}}
                            {{--                                    <td></td> --}}
                            {{--                                    <td></td> --}}



                            {{--                                </tr> --}}
                        </tbody>
                    </table>

                </div>
                <br>

                <div class="card-body p-0 spacer" style="overflow-x: auto" >
                    <div style="text-align: center">
                        <h4> <strong>{{translate('STOCK')}}</strong> </h4>
                    </div>
                    <table class="table table-striped table-responsive example-table">
                        <thead>
                            <tr class="table-head">
                                <th>S.N</th>
                                <th>{{translate('Position')}}</th>
                                <th>{{translate('Date')}}</th>
                                <th>{{translate('Total')}}</th>
                                <th>{{translate('Sale')}}</th>
                                <th>{{translate('Available')}}</th>



                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_sell = 0;
                                $total_qty = 0;
                                $total_available = 0;

                            @endphp
                            @foreach ($stocks as $value)
                                <tr>
                                    @php
                                        $available = $value->total_quantity - $value->total_sell;
                                        $total_qty += $value->total_quantity;
                                        $total_sell += $value->total_sell;
                                        $total_available += $available;

                                    @endphp
                                    <td style="width: 10px;">{{ serialNumber($stocks, $loop) }}</td>
                                    <td>{!! $value->branch->name ?? '<span class="text-red text-bold">On Hold</span>' !!}</td>

                                    <td>{{ date('d F Y h:m:s A', strtotime($value->created_at)) }}</td>

                                    <td>{{ $value->total_quantity }} {{translate('pcs')}}</td>
                                    <td>{{ $value->total_sell }} {{translate('pcs')}}</td>
                                    <td>{{ $available }} pcs</td>

                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" style="text-align: end">{{translate('Total')}}</td>
                                <td>{{ $total_qty }}</td>
                                <td>{{ $total_sell }}</td>
                                <td>{{ $total_available }}</td>

                            </tr>


                        </tbody>
                    </table>

                </div>
            </div>
    </div>
    </section>
    </div>

@endsection
