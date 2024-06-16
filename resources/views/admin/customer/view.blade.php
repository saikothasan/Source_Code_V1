@extends('layouts.app')
@section('title', 'Customer Sale List')
@section('content')

    @push('css')
        <style>
            .image-size {
                width: 1.5em;
                height: 1.5em;
            }

            .groupedInput {
                border: 1px solid #e1cdcd;
                border-radius: 7px;
                /*border-radius: 10px;*/
            }

            .groupedLabel {
                margin-top: 7px;
            }

            #customer_photo {
                height: 120px;
                width: 120px;
            }
        </style>
    @endpush
    <div class="content-wrapper">
        <div class="content supplier_content">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 row" style="background-color: rgb(96,57,19)">
                    <div class="col-md-6 image">
                        @if ($customer->photo)
                            <img style="margin-top: -30px;" src="{{ asset($customer->photo) }}" alt=""
                                id="customer_photo">
                        @else
                            <img style="margin-top: -30px;" src="{{ asset('images/blank.jpg') }}" alt=""
                                id="customer_photo">
                        @endif
                    </div>
                    <div class="col-md-6" style="margin-bottom: 10px">
                        <div style="color: white;">
                            <h3><strong>{{ $customer->name }}</strong></h3>
                        </div>
                        <div style="color: white;">
                            <h4>{{ $customer->phone }}</h4>
                        </div>
                        <div style="color: white;">
                            <h4>{{ $customer->address }}</h4>
                        </div>
                        <div style="color: white;">
                            <i class="fa fa-fw fa-star"></i>
                            <i class="fa fa-fw fa-star"></i>
                            <i class="fa fa-fw fa-star"></i>
                            <i class="fa fa-fw fa-star-half-o"></i>
                            <i class="fa fa-fw fa-star-half-o"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-12"></div>
            </div>
            <div class="row" style="margin-top: 2%">
                <form action="{{ route('customers.show', $customer->id) }}" method="get">
                    <div>
                        <div class="col-md-2 col-sm-2">
                            <div class="form-group">
                                <label>
                                    <input value="{{ request()->get('search') }}" name="search" class="form-control corner"
                                        placeholder="Search">
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 groupedInput">
                            <div class="row form-inline">
                                <div class="col-md-1 col-sm-12 text-center">
                                    <label class="groupedLabel">From</label>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <input value="{{ request()->get('from-date') }}" name="from-date" type="date"
                                            class="form-control corner col-sm-12">
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-12 text-center" style="margin-left: 25px;">
                                    <label class="groupedLabel">To</label>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group col-sm-12">
                                        <input value="{{ request()->get('to-date') }}" name="to-date" type="date"
                                            class="form-control col-sm-12 corner">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <div class="form-group">
                                <select name="sorting" class="form-control select2" id="sorting" style="width: 100%">
                                    <option value="">Select Shorts</option>
                                    <option {{ request()->get('sorting') == 'high-sell' ? 'selected' : '' }}
                                        value="high-sell">
                                        {{translate('High Sell to low Sell')}}
                                    </option>
                                    <option {{ request()->get('sorting') == 'low-sell' ? 'selected' : '' }}
                                        value="low-sell">
                                        {{translate('Low Sell to High Sell')}}
                                    </option>
                                    <option {{ request()->get('sorting') == 'high-exchange' ? 'selected' : '' }}
                                        value="high-exchange">
                                        {{translate('High Exchange to Low Exchange')}}
                                    </option>
                                    <option {{ request()->get('sorting') == 'low-exchange' ? 'selected' : '' }}
                                        value="low-exchange">
                                        {{translate('Low Exchange to High Exchange')}}
                                    </option>
                                    <option {{ request()->get('sorting') == 'high-return' ? 'selected' : '' }}
                                        value="high-return">
                                        {{translate('High Return to Low Return')}}
                                    </option>
                                    <option {{ request()->get('sorting') == 'low-return' ? 'selected' : '' }}
                                        value="low-return">
                                        {{translate('Low Return to High Return')}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button class="form-control">{{translate('Submit')}}</button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" >
                                <x-url-param-clear></x-url-param-clear>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row" style="margin-top: 2%">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <table class="table table-striped table-responsive example-table">
                        <thead>
                            <tr>
                                <th>{{translate('SL')}}.</th>
                                <th>{{translate('Date')}}</th>
                                <th>{{translate('Invoice')}} {{translate('No')}}</th>
                                <th>{{translate('Branch')}} {{translate('Name')}}</th>
                                <th>{{translate('Quantity')}}</th>
                                <th>{{translate('Sell')}} {{translate('Amount')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $value)
                                <tr>
                                    <td>{{ serialNumber($sales, $loop) }}</td>
                                    <td>{{ date('d F y', strtotime($value->date)) }}</td>
                                    <td>{{ $value->invoice_code }}</td>
                                    <td>{{ $value->branch->name ?? '' }}</td>
                                    <td>
                                        <div> {{translate('New')}} {{translate('Sell')}}-{{ $value->sale_quantity_total ?? 0 }} {{translate('pcs')}}</div>
                                        <div> {{translate('Return')}}-{{ $value->return_quantity_total ?? 0 }} {{translate('pcs')}}</div>
                                        <div> {{translate('Exchange')}}-{{ $value->exchange_quantity_total ?? 0 }} {{translate('pcs')}}</div>
                                    </td>
                                    <td>{{ formatWithComma($value->final_total) }}</td>
                                    <td>
                                        <a href="{{ route('sales.show', $value->id) }}">
                                            <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                alt="edit" />
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="9">
                                        <h4 class="font-weight-bold">{{translate('No sale available')}}</h4>
                                    </td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="2"></td>
                                <td>
                                    {{translate('Total')}} {{translate('Sell')}} {{ $total_sell }}
                                </td>
                                <td>{{translate('Total')}}{{translate('Return')}} {{ $total_return }}</td>
                                <td>{{translate('Exechange')}} {{ $total_exchange }}</td>
                                <td>{{translate('Total')}} {{translate('Sell')}} {{ formatWithComma($total_amount) }} {{get_settings('currency_symbol')}}</td>
                                <td></td>
                            </tr>
                        </tbody>

                    </table>
                    {{ $sales->withQueryString()->links() }}
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>

@endsection
