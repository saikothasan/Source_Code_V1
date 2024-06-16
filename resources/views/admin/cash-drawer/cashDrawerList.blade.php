@extends('layouts.app')
@section('title', 'Cash History')
@section('content')
    <style>
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

        .groupedLabel {
            margin-top: 7px;
            color: rgb(153, 153, 153);
        }

        .action {
            color: rgb(167, 169, 172);
            font-family: 'Roboto Light', serif;
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
                            <h2 class="text-uppercase"><strong> {{translate('View')}} {{translate('Cash')}} {{translate('History')}}</strong></h2>
                        </div>
                    </div>
                    <form action="{{ route('cash-drawer.create') }}" method="get">
                        <div class="row text-center spacer">

                            <div class="col-md-1">
                                <div class="form-group">
                                    <input type="checkbox" name="isCash" value="true">
                                    <label style="color: #000;">{{translate('Cash')}} {{translate('in')}}</label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <input type="checkbox" name="isPayment" value="true">
                                    <label style="color: #000;">{{translate('Payment')}}</label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <input type="checkbox" name="isTransfer" value="true">
                                    <label style="color: #000;">{{translate('Transfer')}}</label>
                                </div>
                            </div>
                            <div class="col-md-5 groupedInput">
                                <div class="row form-inline">
                                    <div class="col-md-1 text-center">
                                        <label class="groupedLabel">{{translate('From')}}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input value="{{ request()->get('from-date') }}" name="from-date" type="date"
                                                class="form-control corner">
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
                                <div class="form-group" >
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
                </div>
                <div class="card-body p-0 spacer" style="overflow-x: auto" >
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>{{translate('SN')}}.</th>
                                <th>{{translate('Date')}}</th>
                                <th>{{translate('Type')}}</th>
                                <th>{{translate('Details')}}</th>
                                <th>{{translate('Amount')}}</th>
                                <th>{{translate('Status')}}</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cashHistory as $value)
                                <tr>
                                    <td>{{ serialNumber($cashHistory, $loop) }}</td>
                                    <td>{{ date('d M Y', strtotime($value->date)) }}</td>
                                    <td>{{ $value->cash_type_name }}</td>
                                    <td>{{ $value->note }}</td>
                                    <td class="text-left">
                                        @if ($value->amount <= 0)
                                            <span class="text-red">{{ formatWithComma($value->amount) }}</span>
                                        @else
                                            {{ formatWithComma($value->amount) }}
                                        @endif
                                    </td>
                                    <td>{{ translate($value->cash_status) }}</td>
                                    <td>
                                        @if ($value->receiver_branch_id == auth()->user()->branch_id || $value->branch_id == auth()->user()->branch_id)
                                            @if (
                                                ($value->cash_type == 2 && $value->status == 0 && $value->payment_method_id != 7) ||
                                                    ($value->cash_type == 5 && $value->status == 0) ||
                                                    ($value->cash_type == 2 && $value->status == 0 && $value->payment_reference == null) ||
                                                    ($value->cash_type == 7 && $value->status == 0))
                                                <a href="{{ route('cash-in.accept-transfer', $value->id) }}">
                                                    <button class="btn btn-sm bg-green">{{translate('Accept')}}</button>
                                                </a>
                                                <a href="{{ route('cash-in.reject-transfer', $value->id) }}">
                                                    <button class="btn btn-sm bg-red">{{translate('Reject')}}</button>
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                    @php
                                        $types = ['Payment', 'Transfer', 'Cash In'];
                                    @endphp
                                    <td class="action">
                                        {{--                                            @if ($value->cash_type == 2 && $value->status == 0 && $value->payment_reference == null) --}}
                                        {{--                                                <a href="{{ route('cash-in.accept-transfer', $value->id) }}"> --}}
                                        {{--                                                    <button>Accept</button> --}}
                                        {{--                                                </a> --}}
                                        @if ($value->cash_type_name == 'Sale')
                                            <a href="{{ route('sales.show', $value->sale_id) }}">
                                                <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                    alt="edit" />
                                            @elseif($value->cash_type_name == 'Cost')
                                                <a href="{{ route('costs.show', $value->cost_id) }}">
                                                    <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                        alt="edit" />
                                                </a>
                                            @elseif(collect($types)->contains($value->cash_type_name))
                                                <a href="{{ route('cash-drawer.show', $value->id) }}">
                                                    <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                        alt="edit" />
                                                </a>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="9">
                                        <h4 class="font-weight-bold">{{translate('No')}} {{translate('Costs')}} {{translate('Available')}}</h4>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tr>
                            <td colspan="4" style="text-align: end">{{translate('Total')}} =</td>
                            <td>{{ formatWithComma($total_amount) }} {{get_settings('currency_symbol')}}</td>
                            <td></td>

                        </tr>
                    </table>
                    {{ $cashHistory->withQueryString()->links() }}
                </div>
            </div>
    </div>
    </section>
    </div>

@endsection
