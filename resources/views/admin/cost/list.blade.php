@extends('layouts.app')
@section('title', 'Cost List')
@section('content')
    <style>
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
            min-height: 38px;
        }

        .spacer {
            margin-top: 20px;
        }

        .groupedLabel {
            margin-top: 7px;
            color: rgb(153, 153, 153);
        }

        /*.example-table tr:nth-child(2n+1) {*/
        /*    background-color: #ddd;*/
        /*}*/

        /*.example-table tr:nth-child(2n+0) {*/
        /*    background-color: #eee;*/
        /*}*/

        .action {
            color: rgb(167, 169, 172);
            font-family: 'Roboto Light';
        }

        .image-size {
            width: 1.5em;
            height: 1.5em;
        }

        .example-table tr:nth-child(2n+1) {
            background-color: #ddd;
        }

        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
        }
        .form-inline{
            display: flex;
            margin:5px 0px;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h2><strong> {{translate('View')}} {{translate('Cost')}} </strong></h2>
                        </div>
                    </div>
                    <form action="{{ route('costs.index') }}" method="get" class="bg-none">
                        <div class="row text-center spacer filter">
                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <select name="cost_type" class="form-control select2" style="width: 100%">
                                        <option value="">{{translate('Select')}} {{translate('Cost')}} {{translate('type')}}</option>
                                        <option value="daily_cost"
                                            {{ request()->get('cost_type', '') == 'daily_cost' ? 'selected' : '' }}>
                                            {{translate('Daily')}} {{translate('Cost')}}
                                        </option>
                                        <option value="monthly_cost"
                                            {{ request()->get('cost_type', '') == 'monthly_cost' ? 'selected' : '' }}>
                                            {{translate('Monthly')}} {{translate('Cost')}}
                                        </option>
                                        <option value="one_time_cost"
                                            {{ request()->get('cost_type', '') == 'one_time_cost' ? 'selected' : '' }}>
                                            {{translate('One')}} {{translate('Time')}} {{translate('Cost')}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            @if (isMainBranch())
                                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <select name="branch" class="form-control select2" id="branch"
                                            style="width: 100%">
                                            <option value="">{{translate('Select')}} {{translate('Branch')}}</option>
                                            @foreach (getAllBranch() as $key => $branch)
                                                <option value="{{ $branch->value }}"
                                                    {{ request()->get('branch', '') == $branch->value ? 'selected' : '' }}>
                                                    {{ $branch->text }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
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
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mb-2">
                                <div class="form-group">
                                    <button class="form-control">{{translate('Submit')}}</button>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mb-2">
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
                                <th>{{translate('SN')}}.</th>
                                <th>{{translate('Date')}}</th>
                                @if (isMainBranch())
                                    <th>{{translate('Branch')}}</th>
                                @endif
                                <th>{{translate('Type')}}</th>
                                <th>{{translate('Details')}}</th>
                                <th class="text-right">{{translate('Amount')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($costs as $value)
                                <tr>
                                    <td>{{ serialNumber($costs, $loop) }}</td>
                                    <td>
                                        <p>{{ date('d M Y', strtotime($value->created_at)) }}</p>
                                        <p>{{ date('h : i A', strtotime($value->created_at)) }}</p>

                                    </td>
                                    @if (isMainBranch())
                                        <td>{{ $value->branch->name }} @if ($value->cost_branch_id != 0 && $value->branch_id != $value->cost_branch_id)
                                                ({{ $value->costBranch?->name }})
                                            @endif
                                        </td>
                                    @endif
                                    <td>
                                        {{ ucwords(str_replace('_', ' ', $value->cost_type)) }}
                                    </td>
                                    <td style="width: 40%;">
                                        @forelse($value->details as $key=>  $option)
                                            <div>
                                                {{ ucwords(str_replace(['_', 'selected'], ' ', $key)) }}
                                                : @if ($key == 'selected_month')
                                                    {{ monthName($option) }}
                                                @elseif($key == 'selected_employee')
                                                    {{ $value->employee->name ?? '' }}
                                                @elseif($key == 'selected_payment_method')
                                                    {{ $value->paymentMethod->name ?? '' }}
                                                @else
                                                    {{ $option }}
                                                @endif
                                            </div>
                                        @empty
                                            <div>
                                                {{translate('No')}} {{translate('Details')}}
                                            </div>
                                        @endforelse
                                    </td>
                                    <td class="text-right">{{ formatWithComma($value->amount) }}</td>
                                    <td class="action">
                                        <a href="{{ route('costs.show', $value->id) }}"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="9">
                                        <h4 class="font-weight-bold">{{translate('No')}} {{translate('Costs')}} {{translate('available')}}</h4>
                                    </td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="{{ isMainBranch() ? 6 : 5 }}" class="text-right">{{translate('Total')}}:
                                    {{ formatWithComma($total_amount) }}  {{get_settings('currency_symbol')}}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    {{ $costs->withQueryString()->links() }}
                </div>
            </div>
    </div>
    </section>
    </div>

@endsection
