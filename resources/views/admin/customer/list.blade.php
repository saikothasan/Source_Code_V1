@extends('layouts.app')
@section('title', 'Customer List')
@section('content')

    @push('css')
        <style>
            .dashboard .container {
                width: 86%;
            }

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

            .filter {
                display: flex;
                justify-content: center;
            }

            .example-table tr:nth-child(2n+1) {
                background-color: #ddd;
            }

            .example-table tr:nth-child(2n+0) {
                background-color: #eee;
            }
        </style>
    @endpush
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h3 class="header">{{translate('View')}} {{translate('Customer')}}</h3>
                            <br>

                        </div>
                    </div>
                    <form action="{{ route('customers.index') }}" method="get" class="bg-none">
                        <div class="col-md-12 row text-center spacer ">
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                <label>
                                    <input value="{{ request()->get('search') }}" name="search"
                                        class="form-control corner" placeholder="{{translate('Search')}}">
                                </label>
                            </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="branch" class="form-control select2" id="branch" style="width: 100%">
                                        <option value="">{{translate('Select')}} {{translate('Branch')}}</option>
                                        @foreach (getAllBranch() as $branch)
                                            <option value="{{ $branch->value }}"
                                                {{ request()->get('branch') == $branch->value ? 'selected' : '' }}>
                                                {{ $branch->text }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{--                                <div class="col-md-4 groupedInput"> --}}
                            {{--                                    <div class="row form-inline"> --}}
                            {{--                                        <div class="col-md-1 text-center"> --}}
                            {{--                                            <label class="groupedLabel">From</label> --}}
                            {{--                                        </div> --}}
                            {{--                                        <div class="col-md-4"> --}}
                            {{--                                            <div class="form-group"> --}}
                            {{--                                                <input value="{{ request()->get('from-date') }}" name="from-date" --}}
                            {{--                                                       type="date" class="form-control corner"> --}}
                            {{--                                            </div> --}}
                            {{--                                        </div> --}}
                            {{--                                        <div class="col-md-1 text-center" style="margin-left: 25px;"> --}}
                            {{--                                            <label class="groupedLabel">To</label> --}}
                            {{--                                        </div> --}}
                            {{--                                        <div class="col-md-4"> --}}
                            {{--                                            <div class="form-group"> --}}
                            {{--                                                <input value="{{ request()->get('to-date') }}" name="to-date" type="date" --}}
                            {{--                                                       class="form-control corner"> --}}
                            {{--                                            </div> --}}
                            {{--                                        </div> --}}
                            {{--                                    </div> --}}
                            {{--                                </div> --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="sorting" class="form-control select2" id="sorting" style="width: 100%">
                                        <option value="">{{translate('Select')}} {{translate('Shorts')}}</option>
                                        <option {{ request()->get('sorting') == 'high-sell' ? 'selected' : '' }}
                                            value="high-sell">{{translate('High Sell to low Sell')}}</option>
                                        <option {{ request()->get('sorting') == 'low-sell' ? 'selected' : '' }}
                                            value="low-sell">{{translate('Low Sell to High Sell')}}</option>
                                        <option {{ request()->get('sorting') == 'high-exchange' ? 'selected' : '' }}
                                            value="high-exchange">{{translate('High Exchange to Low Exchange')}}</option>
                                        <option {{ request()->get('sorting') == 'low-exchange' ? 'selected' : '' }}
                                            value="low-exchange">{{translate('Low Exchange to High Exchange')}}</option>
                                        <option {{ request()->get('sorting') == 'high-return' ? 'selected' : '' }}
                                            value="high-return">{{translate('High Return to Low Return')}}</option>
                                        <option {{ request()->get('sorting') == 'low-return' ? 'selected' : '' }}
                                            value="low-return">{{translate('Low Return to High Return')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <button class="form-control">{{translate('Submit')}}</button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group" >
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
                                <th>S.No</th>
                                <th>{{translate('Phone')}}</th>
                                <th>{{translate('Name')}}</th>
                                <th>{{translate('Address')}}</th>
                                <th>{{translate('Total')}} {{translate('Sale')}}</th>
                                <th>{{translate('Total')}} {{translate('Return')}}</th>
                                <th>{{translate('Total')}} {{translate('Exchange')}}</th>
                                <th>{{translate('Total')}} {{translate('Amount')}}</th>
                                <th>{{translate('action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                                <tr>
                                    <td>{{ serialNumber($customers, $loop) }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td style="width: 10%">{{ $customer->address }}</td>
                                    <td>{{ $customer->sale_quantity_total ?? 0 }} {{translate('pcs')}}</td>
                                    <td>{{ $customer->return_quantity_total ?? 0 }} {{translate('pcs')}}</td>
                                    <td>{{ $customer->exchange_quantity_total ?? 0 }} {{translate('pcs')}}</td>
                                    <td>{{ formatWithComma($customer->sale_total) }} {{get_settings('currency_symbol')}}</td>
                                    <td>
                                        <a href="{{ route('customers.show', $customer->id) }}">
                                            <img class="image-size" src="{{asset('images/sales/02.png')}}"
                                                alt="edit">
                                        </a>
                                        <a href="{{ route('customers.edit', $customer->id) }}">
                                            <i class="fa fa-fw fa-pencil-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="9">
                                        <h4 class="font-weight-bold">{{translate('No')}} {{translate('Customer')}} {{translate('available')}}</h4>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $customers->withQueryString()->links() }}
                </div>
            </div>
    </div>
    </section>
    </div>



@endsection
