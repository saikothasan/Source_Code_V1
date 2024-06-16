@extends('layouts.app')
@section('title', 'Payment Method')
@section('content')
    <style>
        .example-table tr:nth-child(2n+1) {
            background-color: #ddd;
        }

        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
        }

        .image-size {
            width: 1.5em;
            height: 1.5em;
        }

        .small-box {
            border-radius: 10px;
        }

        .small-box:hover {
            text-decoration: none;
            color: #000;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4 text-center">
                            <h4><strong>{{ strtoupper($paymentMethod->name) }}</strong></h4>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    <br />
                    <br />
                    <form action="" method="get">
                        <div class="col-md-12 row text-center spacer">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>
                                        <input value="{{ request()->get('search') }}" name="search"
                                            class="form-control corner" placeholder="Search">
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 row">
                                <div class="form-control">
                                    <div class="col-md-2 text-center text-color">
                                        From
                                    </div>
                                    <div class="col-md-4 ">
                                        <input type="date" class="form-control" name="from_date" value="">
                                    </div>
                                    <div class="col-md-2 text-center text-color">To</div>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" value="" name="to_date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group" style="width: 72px;">
                                    <x-url-param-clear></x-url-param-clear>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group" style="width: 72px;">
                                    <button class="form-control">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br />
                    <div class="row">
                        <div class="col-lg-4 col-xs-6">
                            <div class="small-box" style="background-color: rgb(227,227,227)">
                                <div class="inner-body text-center" style="padding-top: 20px;">
                                    <h3><strong>{{ formatWithComma($payment_method_data->total_balance) }}</strong>
                                    </h3>
                                </div>
                                <h4 class="small-box-footer box-header"
                                    style="border-bottom-left-radius: 13px;border-bottom-right-radius: 13px;background-color: rgb(117,0,0)">
                                    Paid Balance</h4>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-6">
                            <a href="{{ route('transfer.history', $paymentMethod->id) }}">
                                <div class="small-box" style="background-color: rgb(227,227,227)">
                                    <div class="inner-body text-center" style="padding-top: 20px;">
                                        <h3>
                                            <strong>{{ formatWithComma($payment_method_data->transfer_balance) }}</strong>
                                        </h3>
                                    </div>
                                    <h4 class="small-box-footer box-header bg-green"
                                        style="border-bottom-left-radius: 13px;border-bottom-right-radius: 13px;">
                                        Transfer Balance</h4>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-xs-6">
                            <div class="small-box" style="background-color: rgb(227,227,227)">
                                <div class="inner-body text-center" style="padding-top: 20px;">
                                    <h3>
                                        <strong>{{ formatWithComma($payment_method_data->total_balance - $payment_method_data->transfer_balance) }}</strong>
                                    </h3>
                                </div>
                                <h4 class="small-box-footer box-header"
                                    style="border-bottom-left-radius: 13px;border-bottom-right-radius: 13px;background-color: rgb(0,0,121)">
                                    Available Balance</h4>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="card-body p-0 spacer" style="overflow-x: auto" >
                        <table class="table table-striped table-responsive example-table">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Date</th>
                                    <th>Invoice No</th>
                                    <th>Phone</th>
                                    <th>Reference</th>
                                    <th>Return</th>
                                    <th>Paid</th>
                                    <th>Total Bill</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paymentHistory as $value)
                                    <tr>
                                        <td>{{ serialNumber($paymentHistory, $loop) }}</td>
                                        <td>{{ date('d F Y', strtotime($value->date)) }}</td>
                                        <td>{{ $value->invoice_reference ?? '' }}</td>
                                        <td>{{ $value->sale->customer->phone ?? '' }}</td>
                                        <td>{{ $value->payment_reference ?? '' }}</td>
                                        <td>
                                            @if ($value->return_amount < 0)
                                                <span class="text-red">{{ formatWithComma($value->return_amount) }}</span>
                                            @endif

                                        </td>
                                        <td>{{ formatWithComma($value->pay_amount) }}</td>
                                        <td>{{ formatWithComma($value->payable_amount) }}</td>
                                        <td class="action">
                                            @if ($value->sale_id)
                                                <a href="{{ route('sales.show', $value->sale_id) }}">
                                                    <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                        alt="edit" />
                                                </a>
                                            @endif
                                        </td>
                                    </tr>

                                @empty
                                    <tr class="text-center">
                                        <td colspan="9">
                                            <h4 class="font-weight-bold">No sale
                                                has {{ strtoupper($paymentMethod->name) }}</h4>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            {{--                                <tr> --}}
                            {{--                                    <td colspan="3"></td> --}}
                            {{--                                    <td >Total</td> --}}
                            {{--                                    <td>{{$payment_method_data->total_balance}}</td> --}}
                            {{--                                    <td>{{$payment_method_data->transfer_balance}}</td> --}}
                            {{--                                </tr> --}}
                        </table>
                        {{ $paymentHistory->withQueryString()->links() }}
                        <br />
                        <div class="row text-center">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <a href="{{ route('payment-method.index') }}">
                                    <button class="btn btn-info">Payment Method</button>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('transfer-money.create') }}">
                                    <button class="btn btn-success">Money Transfer</button>
                                </a>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

@endsection
