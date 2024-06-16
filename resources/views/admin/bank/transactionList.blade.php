@extends('layouts.app')
@section('title', 'View Transaction')
@section('content')
    <style>
        .header {
            color: rgb(2, 2, 2);
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

        .form-inline {
            display: flex;
            margin: 5px;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h3 class="header">{{ translate('View') }} {{ translate('Bank') }} {{ translate('Transaction') }}
                            </h3>
                        </div>
                    </div>
                    <form action="{{ route('bank-transfer.index') }}" method="get" class="bg-none">
                        <div class="row text-center spacer">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="status" class="form-control select2" id="supplier" style="width: 100%">
                                        <option value="" selected> {{ translate('Select') }} {{ translate('Type') }}
                                        </option>

                                        <option value="pending"
                                            {{ request()->get('status') == 'pending' ? 'selected' : '' }}>
                                            {{ translate('Pending') }}
                                        </option>
                                        <option value="send" {{ request()->get('status') == 'send' ? 'selected' : '' }}>
                                            {{ translate('Send') }}
                                        </option>
                                        <option value="received"
                                            {{ request()->get('status') == 'received' ? 'selected' : '' }}>
                                            {{ translate('Received') }}
                                        </option>
                                        @if (isMainBranch())
                                            <option value="transfer"
                                                {{ request()->get('status') == 'transfer' ? 'selected' : '' }}>
                                                {{ translate('Transfer') }}
                                            </option>
                                        @endif

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 groupedInput">
                                <div class="row form-inline">
                                    <div class="col-md-1 text-center">
                                        <label class="groupedLabel">{{ translate('From') }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input value="{{ request()->get('from-date') }}" name="from-date"
                                                type="date" class="form-control corner">
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center" style="margin-left: 25px;">
                                        <label class="groupedLabel">{{ translate('To') }}</label>
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
                                    <button class="form-control">{{ translate('Submit') }}</button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <x-url-param-clear></x-url-param-clear>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body p-0 spacer" style="overflow-x: auto">
                <table class="table table-striped table-responsive example-table">
                    <thead>
                        <tr>
                            <th>{{ translate('SL') }}.</th>
                            <th>{{ translate('Date') }}</th>
                            <th>{{ translate('Type') }}</th>
                            <th>{{ translate('Name') }}/{{ translate('Account') }}({{ translate('sender') }})</th>
                            <th>{{ translate('Name') }}/{{ translate('Account') }}({{ translate('receiver') }})</th>
                            <th>{{ translate('Receipt') }}</th>
                            <th>{{ translate('Reference') }}</th>
                            <th>{{ translate('Amount') }}</th>
                            <th>{{ translate('Status') }}</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_items = 0;
                            $total_quantity = 0;
                            $total_available = 0;
                            $buy_price = 0;
                        @endphp
                        @forelse($bankTransfer as $value)
                            <tr>
                                <td>{{ serialNumber($bankTransfer, $loop) }}</td>
                                <td>{{ date('d M Y', strtotime($value->date)) }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $value->type)) ?? '' }}</td>
                                <td>
                                    @if ($value->type == 'Sale')
                                        {{ $value->sale->customer->name ?? '' }}
                                    @else
                                        {{ $value->senderUser->name ?? '' }}
                                        <p>{{ $value->senderBank->account_no ?? '' }}</p>
                                    @endif
                                </td>
                                <td>
                                    {{--                                        {{$value->user->name ?? ''}} --}}
                                    {{ $value->receiverBank->name ?? '' }}
                                    <p>{{ $value->receiverBank->account_no ?? '' }}</p>
                                </td>
                                <td>{{ $value->reference_id }}</td>
                                @php
                                    $invoices = collect(json_decode($value->referance_invoice));
                                @endphp
                                <td> {!! $invoices->implode('<br>') !!}</td>
                                <td class="{{ $value->paid < 0 ? 'text-red' : '' }}">{{ number_format($value->paid) }}
                                </td>

                                @if ($value->status == 0)
                                    @if ($value->created_by == auth()->user()->id || $value->created_by != auth()->user()->id)
                                        <td>
                                            <span class="label label-warning"> {{ translate('Pending') }} </span>
                                            <br />
                                        </td>
                                    @endif
                                @elseif($value->status == 1 && $value->type == 'supplier')
                                    <td><span class="label label-info"> Transferd </span></td>
                                @elseif ($value->status == 1)
                                    @if ($value->created_by == auth()->user()->id)
                                        <td><span class="label label-success"> {{ translate('Send') }} </span></td>
                                    @else
                                        <td><span class="label label-success"> {{ translate('Receive') }} </span></td>
                                    @endif
                                @elseif ($value->status == 3)
                                    <td><span class="label label-danger"> {{ $value->bank_status }} </span></td>
                                @else
                                    <td><span class="label label-danger"> {{ translate('Reject') }} </span></td>
                                @endif
                                <td>
                                    @if ($value->branch_id == auth()->user()->branch_id || $value->user_id == auth()->user()->id)
                                        @if ($value->status == 0)
                                            <a href="{{ route('bank.accept-transfer', $value->id) }}">
                                                <button class="btn btn-sm bg-green">{{ translate('Accept') }}</button>
                                            </a>
                                            <a href="{{ route('bank.reject-transfer', $value->id) }}">
                                                <button class="btn btn-sm bg-red">{{ translate('Reject') }}</button>
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
                                        <a href="{{ route('bank.payment-invoice', $value->id) }}"> <img class="image-size"
                                                src="{{ asset('images/sales/02.png') }}" alt="edit" /></a>
                                    @elseif($value->type == 'Sale' && $value->connect_id)
                                        <a href="{{ route('sales.show', $value->connect_id) }}"> <img class="image-size"
                                                src="{{ asset('images/sales/02.png') }}" alt="edit" /></a>
                                    @elseif($value->type == 'Cash Drawer')
                                        <a href="{{ route('cash-drawer.show', $value->connect_id) }}"> <img
                                                class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                alt="edit" /></a>
                                    @endif
                                </td>
                            </tr>

                        @empty
                            <tr class="text-center">
                                <td colspan="11">
                                    <h4 class="font-weight-bold">{{ translate('No') }} {{ translate('purchase') }}
                                        {{ translate('available') }}</h4>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                    <tr>
                        <td colspan="7" class="text-right">
                        </td>
                        <td>
                            {{ number_format($total_amount) }}
                        </td>
                        <td colspan="3"></td>
                    </tr>
                </table>
                {{ $bankTransfer->withQueryString()->links() }}
            </div>
    </div>
    </section>
    </div>

@endsection
