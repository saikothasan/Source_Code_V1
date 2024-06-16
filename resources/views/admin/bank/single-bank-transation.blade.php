@extends('layouts.app')
@section('title', 'View Transaction')
@section('content')
    <style>
        .header {
            color: rgb(21, 182, 223);
            font-weight: bold;
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

        .top-amount p {
            border: 1px solid #bebebe;
            padding: 8px;
            border-radius: 8px;
            font-size: 22px;
            color: #00a65a;
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
                    <div class="col-md-12 row text-center">
                        <div class="col-md-12 text-center">
                            <h3 class="header">{{ $bank->user->name }}</h3>
                            <p>{{ $bank->name }}</p>
                            <p>{{ $bank->account_no }}</p>

                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3 top-amount">
                            <p>{{get_settings('currency_name')}} {{ $bank->amount }}  {{get_settings('currency_symbol')}}</p>
                            <span>{{translate('Available')}}</span>
                        </div>
                        <div class="col-md-3 top-amount">
                            <p>{{get_settings('currency_name')}}{{ $send_amount }}  {{get_settings('currency_symbol')}}</p>
                            <span>{{translate('Send')}}</span>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <form action="{{ route('single-bank-transaction', $bank->id) }}" method="get">
                        <div class="col-md-12 row text-center spacer">
                            <div class="col-md-1"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="status" class="form-control select2" id="supplier" style="width: 100%">
                                        <option value="" selected> {{translate('Select')}} {{translate('Type')}}</option>

                                        <option value="pending"
                                            {{ request()->get('status') == 'pending' ? 'selected' : '' }}>
                                            {{translate('Pending')}}
                                        </option>
                                        <option value="send" {{ request()->get('status') == 'send' ? 'selected' : '' }}>
                                            {{translate('Send')}}
                                        </option>
                                        <option value="received"
                                            {{ request()->get('status') == 'received' ? 'selected' : '' }}>
                                            {{translate('Received')}}
                                        </option>
                                        @if (isMainBranch())
                                            <option value="transfer"
                                                {{ request()->get('status') == 'transfer' ? 'selected' : '' }}>
                                                {{translate('Transfer')}}
                                            </option>
                                        @endif

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-5 groupedInput">
                                <div class="row form-inline">
                                    <div class="col-md-1 text-center">
                                        <label class="groupedLabel">{{translate('From')}}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input value="{{ request()->get('from-date') }}" name="from-date"
                                                type="date" class="form-control corner">
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center" style="margin-left: 25px;">
                                        <label class="groupedLabel">{{translate('To')}}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input value="{{ request()->get('to-date') }}" name="to-date" type="date"
                                                class="form-control corner">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button class="form-control">{{translate('Submit')}}</button>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <x-url-param-clear></x-url-param-clear>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body p-0 spacer" style="overflow-x: auto">
                    <table class="table table-striped table-responsive example-table">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>{{translate('Date')}}</th>
                                <th>{{translate('Refernce')}}</th>
                                <th>{{translate('Amount')}}</th>
                                <th>{{translate('Status')}}</th>
                                <th></th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody>
                            @if ($bank_transaction)
                                @foreach ($bank_transaction as $value)
                                    <tr>
                                        <td>{{ serialNumber($bank_transaction, $loop) }}</td>
                                        <td>{{ date('d M Y', strtotime($value->date)) }}</td>
                                        <td>
                                            @if ($value->reference_id)
                                                {{ $value->reference_id }}
                                            @else
                                                @php
                                                    $invoices = collect(json_decode($value->referance_invoice));
                                                @endphp
                                                {!! $invoices->implode('<br>') !!}
                                            @endif
                                        </td>

                                        <td>
                                            <p class="{{ $value->paid < 0 ? 'text-red' : '' }}">
                                                {{ number_format($value->paid) }}</p>
                                        </td>

                                        @if ($value->status == 0)
                                            @if ($value->created_by == auth()->user()->id || $value->created_by != auth()->user()->id)
                                                <td>
                                                    <span class="label label-warning"> {{translate('Pending')}} </span>
                                                    <br />
                                                </td>
                                            @endif
                                        @elseif($value->status == 1 && $value->type == 'supplier')
                                            <td><span class="label label-info"> {{translate('Transferd')}} </span></td>
                                        @elseif ($value->status == 1)
                                            @if ($value->created_by == auth()->user()->id)
                                                <td><span class="label label-success"> {{translate('Send')}} </span></td>
                                            @else
                                                <td><span class="label label-success"> {{translate('Receive')}} </span></td>
                                            @endif
                                        @elseif ($value->status == 3)
                                            <td><span class="label label-danger"> {{ $value->bank_status }} </span></td>
                                        @else
                                            <td><span class="label label-danger"> {{translate('Reject')}} </span></td>
                                        @endif
                                        <td>
                                            @if ($value->branch_id == auth()->user()->branch_id || $value->user_id == auth()->user()->id)
                                                @if ($value->status == 0)
                                                    <a href="{{ route('bank.accept-transfer', $value->id) }}">
                                                        <button class="btn btn-sm bg-green">{{translate('Accept')}}</button>
                                                    </a>
                                                    <a href="{{ route('bank.reject-transfer', $value->id) }}">
                                                        <button class="btn btn-sm bg-red">{{translate('Reject')}}</button>
                                                    </a>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($value->type == 'supplier')
                                                <a href="{{ route('supplier.payment-details', $value->connect_id) }}">
                                                    <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                        alt="edit" />
                                                </a>
                                            @elseif($value->type == 'branch')
                                                <a href="{{ route('bank.payment-invoice', $value->id) }}"> <img
                                                        class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                        alt="edit" /></a>
                                            @elseif($value->type == 'Sale' && $value->connect_id)
                                                <a href="{{ route('sales.show', $value->connect_id) }}"> <img
                                                        class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                        alt="edit" /></a>
                                            @elseif($value->type == 'Cash Drawer')
                                                <a href="{{ route('cash-drawer.show', $value->connect_id) }}"> <img
                                                        class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                        alt="edit" /></a>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach

                            @endif
                        </tbody>
                        <tr>
                            <td colspan="3" class="text-right">

                            </td>
                            <td>
                                {{ number_format($total_amount) }}
                            </td>
                            <td colspan="3"></td>
                        </tr>
                    </table>
                    {{ $bank_transaction->withQueryString()->links() }}
                </div>
            </div>
    </div>
    </section>
    </div>

@endsection

@push('js')
    <script>
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        })
    </script>
@endpush
