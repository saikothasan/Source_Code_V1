@extends('layouts.app')
@section('title', 'View Purchase')
@section('content')
    <style>
        .header {
            color: rgb(7, 7, 6);
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
                            <h3 class="header">{{translate('View')}} {{translate('Product')}} {{translate('Purchase')}}</h3>
                        </div>
                    </div>
                    <form action="{{ route('purchases.index') }}" method="get" class="bg-none">
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
                                <th>{{translate('Item')}}</th>
                                <th>{{translate('Quantity')}}</th>
                                <th>{{translate('Available')}}</th>
                                <th class="text-right">{{translate('Buy')}} {{translate('Price')}}</th>
                                <th>{{translate('Status')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchases as $value)
                                <tr>
                                    <td>{{ serialNumber($purchases, $loop) }}</td>
                                    <td>{{ date('d M Y', strtotime($value->date)) }}</td>
                                    <td>{{ $value->invoice }}</td>
                                    <td>{{ $value->supplier->name ?? '' }}</td>
                                    <td>{{ $value->total_items }}</td>
                                    <td>{{ $value->total_quantity }} {{translate('pcs')}}</td>
                                    <td>{{ $value->available_stocks }} {{translate('pcs')}}</td>
                                    <td class="text-right">{{ formatWithComma($value->total) }}</td>
                                    <td>
                                        @if ($value->status == \App\Model\Purchase::STATUS['pending'])
                                            <form action="{{ route('purchase-status-update', $value->id) }}" method="POST"
                                                id="purchase_update_{{ $value->id }}">
                                                @csrf
                                                @method('PUT')
                                                <label>
                                                    <select class="form-control" style="width: 100%;" id="status"
                                                        name="status"
                                                        onchange="statusUpdate(event,'purchase_update_{{ $value->id }}')">
                                                        <option value hidden>Pending</option>
                                                        @if (
                                                            ($value->sender_type == \App\Model\Purchase::SENDER_TYPE['supplier'] && isMainBranch()) ||
                                                                ($value->sender_type == \App\Model\Purchase::SENDER_TYPE['management'] && isSupplier()))
                                                            <option value="1"> {{translate('Approved')}}</option>
                                                        @endif
                                                        @if (
                                                            ($value->sender_type == \App\Model\Purchase::SENDER_TYPE['management'] && isMainBranch()) ||
                                                                ($value->sender_type == \App\Model\Purchase::SENDER_TYPE['supplier'] && isSupplier()))
                                                            <option value="3"> {{translate('Cancelled')}}</option>
                                                        @endif
                                                    </select>
                                                </label>
                                            </form>
                                        @endif
                                        @if ($value->status == \App\Model\Purchase::STATUS['approved'])
                                            <span class="label label-success">{{translate('Purchased')}}</span>
                                        @endif
                                        @if ($value->status == \App\Model\Purchase::STATUS['cancelled'])
                                            <span class="label label-danger">{{translate('Cancelled')}}</span>
                                        @endif
                                    </td>
                                    <td class="action">
                                        <a href="{{ route('purchases.show', $value->id) }}">
                                            <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                alt="" />
                                        </a>
                                        @if ($value->status == \App\Model\Purchase::STATUS['approved'] && isMainBranch())
                                            <a href="{{ route('purchase-return.create', $value->id) }}"
                                                class="text-red font-weight-bolder">
                                                <i class="fa fa-arrow-circle-o-left" style="font-size: 18px"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="10">
                                        <h4 class="font-weight-bold">{{translate('No Purchase available')}}</h4>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                        <tr>
                            <td colspan="3" style="text-align: right; font-weight: bold;">
                                @if (request()->get('from-date') && request()->get('to-date'))
                                    {{ date('d F ', strtotime(request()->get('from-date'))) }} to
                                    {{ date('d F Y', strtotime(request()->get('to-date'))) }}
                                @endif
                            </td>

                            <td>{{translate('Total')}} =</td>
                            <td>{{ formatWithComma($total_items) }}</td>
                            <td>{{ formatWithComma($total_quantity) }}</td>
                            <td>{{ formatWithComma($available_stocks) }}</td>
                            <td>{{ formatWithComma($total_buy_price) }} {{get_settings('currency_symbol')}}</td>
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
@push('js')
    <script>
        function statusUpdate(e, id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, do it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#' + id).submit();
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                    return false;
                }
                $("#status").val('');
            })

            return false;
        }
    </script>
@endpush
