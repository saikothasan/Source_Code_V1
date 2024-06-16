@extends('layouts.app')
@section('title', 'View Sale')
@section('content')
    <style>
        .dashboard .container {
            width: 100%;
        }

        .header {
            color: rgb(14, 13, 13);
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

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        @if (isMainBranch())
                            <h3 class="header">{{translate('View')}} {{translate('Sale')}}</h3>
                        @else
                            <h3 class="header">{{ auth()->user()->branch?->name }} {{translate('Sale')}}</h3>
                        @endif
                    </div>
                </div>
                <form action="{{ route('sales.index') }}" method="get" class="bg-none">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row text-center spacer">
                        <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>
                                    <input value="{{ request()->get('search') }}" name="search" class="form-control corner"
                                        placeholder="Search">
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

                        <div class="col-md-3">
                            <div class="form-group">
                                @php
                                    $filter = request()->get('filter', '*');
                                @endphp
                                <select name="filter" class="form-control select2" id="filter" style="width: 100%">
                                    <option value selectedtranslate>{{translate('Select')}} {{translate('Sale')}}</option>
                                    @foreach ($filter_options as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ intval($filter === $key) ? 'selected' : '' }}>
                                            {{ translate(ucfirst($key)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row text-center spacer">
                        @if (isMainBranch())
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="branch" class="form-control select2" id="branch" style="width: 100%">
                                        <option value="">{{translate('Select')}} {{translate('Branch')}}</option>
                                        @foreach (getAllBranch('mainBranchSkip') as $key => $branch)
                                            <option value="{{ $branch->value }}"
                                                {{ request()->get('branch', '') == $branch->value ? 'selected' : '' }}>
                                                {{ $branch->text }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="seller" class="form-control select2" id="seller" style="width: 100%">
                                    <option value="">{{translate('Select')}} {{translate('Seller')}}</option>
                                    @foreach (getBranchUsers() as $key => $user)
                                        <option value="{{ $user['value'] }}"
                                            {{ request()->get('seller', '') == $user['value'] ? 'selected' : '' }}>
                                            {{ $user['text'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group" >
                                <x-url-param-clear></x-url-param-clear>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button class="form-control">{{translate('Submit')}}</button>
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
                            <th>{{translate('Invoice')}}</th>
                            <th>{{translate('Customer')}}</th>
                            @if (isMainBranch())
                                <th>
                                    {{translate('Branch')}}
                                </th>
                            @endif
                            <th>
                                {{translate('User')}}->{{translate('Seller')}}
                            </th>
                            <th>{{translate('Item')}}</th>
                            <th>{{translate('Quantity')}}</th>
                            <th>{{translate('Sell')}} {{translate('Price')}}</th>
                            @if (request()->get('filter') == 'returned')
                                <th>{{translate('Delivery')}} {{translate('Return')}}</th>
                            @endif
                            <th>{{translate('Status')}}</th>
                            <th>{{translate('action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales['data'] as $key =>  $value)
                            @php
                                $index = $key + $results->perPage() * ($results->currentPage() - 1) + 1;
                            @endphp
                            <tr>
                                <td>
                                    {{ $index }}
                                </td>
                                <td>
                                    <div>
                                        {{ date('d F y', strtotime($value['date'])) }}
                                    </div>
                                    <div>
                                        {{ date('h : i : s A', strtotime($value['date_time'])) }}
                                    </div>
                                </td>
                                <td>
                                    {{ $value['invoice_code'] ?? '' }}
                                </td>
                                <td style="width:12%">
                                    <p>{{ $value['customer_name'] }}</p>
                                    <p>
                                        {{ $value['customer_phone'] }}
                                    </p>
                                </td>
                                @if (isMainBranch())
                                    <td>
                                        {{ $value['branch_name'] }}
                                    </td>
                                @endif
                                <td>
                                    <p>
                                        {{ $value['user_name'] }}
                                    </p>
                                    <p>
                                        {{ $value['seller_name'] }}
                                    </p>
                                </td>
                                <td class="{{ $value['total_amount'] < 0 ? 'text-red' : '' }}">
                                    {{ number_format($value['total_items']) ?? '' }}
                                </td>
                                <td class="{{ $value['total_amount'] < 0 ? 'text-red' : '' }}">
                                    {{ number_format($value['total_quantity']) }} pcs
                                </td>
                                <td class="text-end {{ $value['total_amount'] < 0 ? 'text-red' : '' }}">
                                    @if ($value['total_amount'] < 0)
                                        @if (request()->get('filter') == 'returned')
                                            {{ formatWithComma($value['total_amount']) ?? '' }}
                                        @else
                                            {{ -formatWithComma($value['delivery_return']) ?? '' }}
                                        @endif
                                    @else
                                        {{ formatWithComma($value['total_amount']) ?? '' }}
                                    @endif
                                    {{getsetting('currency_symbol')}}
                                </td>
                                @if (request()->get('filter') == 'returned')
                                    <td class="text-center text-red">
                                        {{ -formatWithComma($value['delivery_return']) ?? '' }}
                                    </td>
                                @endif
                                <td class="text-end">
                                    {!! $value['status'] !!}
                                </td>
                                <td class="action">
                                    <a href="{{ route('sales.show', $value['sale_id']) }}">
                                        <img class="image-size" src="{{ asset('images/sales/02.png') }}" alt="edit" />
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="11">
                                    <h4 class="font-weight-bold">{{translate('No sale available')}}</h4>
                                </td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="{{ isMainBranch() ? 6 : 5 }}" style="text-align: end">{{translate('Total')}} =</td>
                            <td>{{ number_format($total_items) }}</td>
                            <td>{{ number_format($total_quantity) }} {{ translate('pcs')}}</td>
                            <td>{{ formatWithComma($total_sell) }} {{getsetting('currency_symbol')}}</td>
                            @if (request()->get('filter') == 'returned')
                                <td class="text-center text-red">-{{ formatWithComma($total_delivery_return) }}</td>
                            @endif
                            <td></td>
                            <td></td>

                        </tr>
                    </tbody>
                </table>
                {{ $results->withQueryString()->links() }}
            </div>
        </section>
    </div>


@endsection
