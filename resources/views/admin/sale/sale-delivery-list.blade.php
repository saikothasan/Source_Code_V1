@extends('layouts.app')
@section('title', 'Sale Delivery')
@section('content')
    <style>
        .dashboard .container {
            width: 100%;
        }

        .header {
            color: rgb(255, 150, 0);
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
                            <h3 class="header">View Sale Delivery</h3>
                        </div>
                    </div>
                    <form action="{{ route('sale-delivery.index') }}" method="get">
                        <div class="col-md-12 row text-center spacer filter">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>
                                        <input value="{{ request()->get('search') }}" name="search"
                                            class="form-control corner" placeholder="Search">
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="seller" class="form-control select2" id="seller" style="width: 100%">
                                        <option value="">Select Seller</option>
                                        @foreach (getBranchUsers() as $key => $user)
                                            <option value="{{ $user['value'] }}"
                                                {{ request()->get('seller', '') == $user['value'] ? 'selected' : '' }}>
                                                {{ $user['text'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-5 groupedInput" style="height: 38px">
                                <div class="row form-inline">
                                    <div class="col-md-1 text-center">
                                        <label class="groupedLabel">From</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input value="{{ request()->get('from-date') }}" name="from-date" type="date"
                                                class="form-control corner">
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center" style="margin-left: 25px;">
                                        <label class="groupedLabel">To</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input value="{{ request()->get('to-date') }}" name="to-date" type="date"
                                                class="form-control corner">
                                        </div>
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
                </div>
                <div class="card-body p-0 spacer" style="overflow-x: auto" >
                    <table class="table table-striped table-responsive example-table">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Customer</th>
                                @if (isMainBranch())
                                    <th>Branch</th>
                                @endif
                                <th>
                                    User->Seller
                                </th>
                                <th>Delivery</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Sell Price</th>
                                <th>Collect Amount</th>
                                <th class="text-center">Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sale_delivery as $value)

                                <tr>
                                    <td>{{ serialNumber($sale_delivery, $loop) }}</td>
                                    <td>
                                        <div>
                                            <p>
                                                {{ date('d F y', strtotime($value->date)) }}
                                            </p>
                                            <p>
                                                {{ date('h : i : s A', strtotime($value->created_at)) }}
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <p>
                                                {{ $value->sale->invoice_code }}
                                            </p>
                                            <p>
                                                {{ $value->consignment_id }}
                                            </p>
                                        </div>
                                    </td>
                                    <td style="width: 10%">
                                        <p>{{ $value->customer->name ?? '' }}</p>
                                        <p>{{ $value->customer->phone ?? '' }}</p>
                                    </td>
                                    @if (isMainBranch())
                                        <td>{{ $value->branch->name ?? '' }}</td>
                                    @endif
                                    <td>
                                        @if ($value->sale?->user->id != $value->sale?->seller->id)
                                            <p>
                                                {{ $value->sale?->user->name ?? '' }}
                                            </p>
                                            <p>
                                                {{ $value->sale?->seller->name ?? '' }}
                                            </p>
                                        @else
                                            <p>
                                                {{ $value->sale?->user->name ?? '' }}
                                            </p>
                                        @endif

                                    </td>
                                    <td style="width: 10px">
                                        <span>{{ $value->deliveryMan->name ?? '' }}</span>
                                    </td>
                                    <td>{{ number_format($value->sale->total_items ?? 0) }}</td>
                                    <td>{{ number_format($value->sale->total_quantity) }}</td>
                                    <td class="text-end">{{ number_format($value->sale->final_total) }}</td>
                                    <td class="text-end">
                                        {{ number_format($value->amount_to_collect) }}
                                    </td>
                                    <td class="text-end">
                                        @if ($value->status == 'Pending')
                                            <form action="{{ route('sale-delivery.update', $value->id) }}" method="POST"
                                                id="sale_delivery_update_{{ $value->id }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="sale_id" value="{{ $value->sale_id }}">
                                                <label>
                                                    <select class="form-control" style="width: 100%;"
                                                        id="status_{{ $value->id }}" name="status"
                                                        onchange="statusUpdate(event,'sale_delivery_update_{{ $value->id }}',{{ $value->id }})">
                                                        @foreach ($all_status as $status)
                                                            <option value="{{ $status }}"
                                                                {{ $status == $value->status ? 'selected hidden' : '' }}>
                                                                {{ $status }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </form>
                                        @elseif($value->status == 'Delivered')
                                            <span class="label label-success">{{ $value->status }}</span>
                                        @else
                                            <span class="label label-danger">{{ $value->status }}</span>
                                        @endif
                                    </td>
                                    <td class="action">
                                        <a href="{{ route('sales.show', $value->sale_id) }}">
                                            <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                alt="edit" />
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="15">
                                        <h4 class="font-weight-bold">No sale delivery available</h4>
                                    </td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="{{ isMainBranch() ? 8 : 7 }}" style="text-align: end">Total =</td>
                                <td>{{ number_format($total_items) }}</td>
                                <td>{{ number_format($total_quantity) }}</td>
                                <td>{{ number_format($total_sell) }}</td>
                                <td></td>
                                <td></td>
                                <td></td>

                            </tr>
                        </tbody>
                    </table>
                    {{ $sale_delivery->withQueryString()->links() }}
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection
@push('js')
    <script>
        function statusUpdate(e, id, delivery_id) {
            let status_name = $("#status_" + delivery_id).val()
            Swal.fire({
                title: 'Are you sure ' + status_name + " this order ?",
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, do it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#' + id).submit();
                    return false;
                }
                $("#status_" + delivery_id).val('Pending');
            })
            return false;
        }
    </script>
@endpush
