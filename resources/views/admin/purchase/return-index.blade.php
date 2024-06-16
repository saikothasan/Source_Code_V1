@extends('layouts.app')
@section('title', 'View Purchase Return')
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

        .filter {
            display: flex;
            justify-content: center;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h3 class="header">{{translate('View')}} {{translate('Product')}} {{translate('Purchase')}} {{translate('Return')}}</h3>
                        </div>
                    </div>
                    <form action="{{ route('purchase-return.index') }}" method="get" class="bg-none">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row text-center spacer">
                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>
                                        <input value="{{ request()->get('invoice') }}" name="invoice"
                                            class="form-control corner" placeholder="{{translate('Invoice')}} {{translate('No')}}">
                                    </label>
                                </div>
                            </div>
                            @if (!isSupplier())
                                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <select name="supplier_id" class="form-control select2" id="supplier_id"
                                            style="width: 100%">
                                            <option value="">{{translate('Select')}} {{translate('Supplier')}}</option>
                                            @foreach (getAllSupplier() as $supplier)
                                                <option value="{{ $supplier->value }}"
                                                    {{ request()->get('supplier_id') == $supplier->value ? 'selected' : '' }}>
                                                    {{ $supplier->text }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 groupedInput">
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
                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <x-url-param-clear></x-url-param-clear>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group" >
                                    <button class="form-control">{{translate('Submit')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body p-0 spacer" style="overflow-x: auto" >
                    <table class="table table-striped table-responsive example-table">
                        <thead>
                            <tr>
                                <th>{{translate('SN')}}.</th>
                                <th>{{translate('Date')}}</th>
                                <th>{{translate('Invoice')}} {{translate('No')}}</th>
                                <th>{{translate('Suppliers')}}</th>
                                <th>{{translate('Quantity')}}</th>
                                <th>{{translate('Total')}}</th>
                                <th>{{translate('Status')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchases as $value)
                                <tr>
                                    <td>{{ serialNumber($purchases, $loop) }}</td>
                                    <td>{{ date('d M Y', strtotime($value->date)) }}</td>
                                    <td>{{ $value->purchase->invoice }}</td>
                                    <td>{{ $value->supplier->name ?? '' }}</td>
                                    <td>{{ $value->total_quantity }} {{translate('pcs')}}</td>
                                    <td>{{ number_format($value->total_amount) }}</td>
                                    <td>
                                        @if ($value->status === \App\Model\Purchase_return::STATUS['pending'] && isSupplier())
                                            <div style="display: flex;justify-content: space-evenly;">
                                                <form action="{{ route('purchase-return-status.update') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="return_id" value="{{ $value->id }}">
                                                    <input type="hidden" name="receive_type" value="received">
                                                    <button type="submit" class="btn btn-block btn-success btn-sm">
                                                        {{translate('Received')}}
                                                    </button>
                                                </form>
                                                <form action="{{ route('purchase-return-status.update') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="return_id" value="{{ $value->id }}">
                                                    <input type="hidden" name="receive_type" value="reject">
                                                    <button type="submit" class="btn btn-block btn-danger btn-sm">
                                                        {{translate('Reject')}}
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($value->status === \App\Model\Purchase_return::STATUS['pending'])
                                            <span class="label label-warning">{{ $value->status_text }}</span>
                                        @elseif($value->status == \App\Model\Purchase_return::STATUS['received'])
                                            <span class="label label-success">{{ $value->status_text }}</span>
                                        @else
                                            <span class="label label-danger">{{ $value->status_text }}</span>
                                        @endif
                                    </td>
                                    <td class="action">
                                        <a href="{{ route('purchase-return.show', $value->id) }}">
                                            <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                alt="" />
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="9">
                                        <h4 class="font-weight-bold">{{translate('No Return available')}}</h4>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                        <tr>
                            <td colspan="3" style="text-align: right; font-weight: bold;">
                                @if (request()->get('from-date') && request()->get('to-date'))
                                    {{ date('d F ', strtotime(request()->get('from-date'))) }} {{translate('to')}}
                                    {{ date('d F Y', strtotime(request()->get('to-date'))) }}
                                @endif
                            </td>

                            <td>{{translate('Total')}} =</td>
                            <td>{{ $total_quantity }}</td>
                            <td>{{ number_format($total_return_amount) }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    {{ $purchases->withQueryString()->links() }}
                </div>
            </div>
    </div>
    </section>
    </div>

@endsection
