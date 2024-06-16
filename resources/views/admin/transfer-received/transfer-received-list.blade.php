@extends('layouts.app')
@section('title', 'View Transfer & Received')
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
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h3 class="header">{{translate('View')}} {{translate('Transfer')}} {{translate("&")}} {{translate('Recevied')}}</h3>
                        </div>
                    </div>
                    <form action="{{ route('transfer-received.list') }}" method="get" class="bg-none">
                        <div class="col-md-12 row text-center spacer">
                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>
                                        <input value="{{ request()->get('search') }}" name="search"
                                            class="form-control corner" placeholder="{{translate('Search')}}">
                                    </label>
                                </div>
                            </div>
                            <div class=" col-lg-6 col-md-6 col-sm-12 col-xs-12 groupedInput">
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
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button class="form-control">{{translate('Submit')}}</button>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <x-url-param-clear></x-url-param-clear>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body p-0 spacer" style="overflow-x: auto" >
                    <table class="table table-striped table-responsive example-table">
                        <thead>
                            <tr>
                                <th>{{translate('SN')}}#</th>
                                <th>{{translate('Invoice')}} {{translate('No')}}.</th>
                                <th>{{translate('Sender')}}</th>
                                <th>{{translate('Receiver')}}</th>
                                <th>{{translate('Received')}} {{translate('By')}}</th>
                                <th>{{translate('Status')}}</th>
                                <th>{{translate('Date')}} & {{translate('Time')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transferReceived as $value)
                                <tr>
                                    <td>
                                        {{ serialNumber($transferReceived, $loop) }}
                                    </td>
                                    <td>{{ $value->invoice_code }}</td>
                                    <td>
                                        @if (collect($value->sendUser->roles)->pluck('name')->contains('Supplier'))
                                            {{ $value->sendUser->name }} (Supplier)
                                        @else
                                            {{ $value->sendBranch->name }}
                                        @endif

                                    </td>
                                    <td>{{ $value->receiveBranch->name ?? '' }}</td>
                                    <td>{{ $value->receiveUser->name ?? '' }}</td>
                                    <td>
                                        @if ($value->invoice_type === 1 && $value->status === 0)
                                            <span class="label label-warning">{{translate('Receive')}} {{translate('Pending')}}</span>
                                        @elseif($value->invoice_type === 1 && $value->status === 1)
                                            <span class="label label-primary">{{translate('Transferred')}}</span>
                                        @elseif($value->invoice_type === 2 && $value->status === 1)
                                            <span class="label label-success">{{translate('Received')}}</span>
                                        @elseif($value->status === 2)
                                            <span class="label label-danger">{{translate('Transfer')}} {{translate('Reject')}}</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d F Y h:i A', strtotime($value->created_at)) }}</td>
                                    <td class="action">
                                        @if ($value->invoice_type === 1)
                                            <a href="{{ route('transfer-product.show', $value->id) }}">
                                                <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                    alt="edit" />
                                            </a>
                                        @else
                                            <a href="{{ route('received-product.show', $value->id) }}">
                                                <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                    alt="edit" />
                                            </a>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="9">
                                        <h4 class="font-weight-bold">{{translate('No')}} {{translate('Transfer')}} {{translate('&')}} {{translate('Received')}} {{translate('Available')}}</h4>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                    {{ $transferReceived->links() }}
                </div>
            </div>
    </div>
    </section>
    </div>

@endsection
