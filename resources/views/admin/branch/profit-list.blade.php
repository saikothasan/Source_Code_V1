@push('css')
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
            height: 38px;
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
    </style>
@endpush


<div class="">
    <section class="content">
        <div class="dashboard">

            <div class="row">

                <form action="{{ route('branch.sale', ['branch' => $branch->id, 'type' => 'profit']) }}" method="get">
                    <div class="col-md-12 row text-center spacer filter">

                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="cost_type" class="form-control select2" style="width: 100%">
                                    <option value="">{{translate('Select')}} {{translate('Cost')}} {{translate('type')}}</option>
                                    <option value="daily_cost">{{translate('Daily')}} {{translate('Cost')}}</option>
                                    <option value="monthly_cost">{{translate('Monthly')}} {{translate('Cost')}}</option>
                                    <option value="one_time_cost">{{translate('One')}} {{translate('Time')}} {{translate('Cost')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 groupedInput">
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
                        <div class="col-md-1">
                            <div class="form-group" style="width: 72px;">
                                <button class="form-control">{{translate('Submit')}}</button>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <div class="form-group" style="width: 72px;">
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
                            <th>S.N</th>
                            <th>{{translate('Date')}}</th>
                            <th>{{translate('Type')}}</th>
                            <th>{{translate('Details')}}</th>
                            <th>{{translate('Amount')}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_cost = 0;
                            $total_sale_cost = 0;

                        @endphp
                        @forelse($branch_cost as $value)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>
                                    <p>{{ date('d M Y', strtotime($value->created_at)) }}</p>
                                    <p>{{ date('h : i A', strtotime($value->created_at)) }}</p>
                                </td>
                                <td>
                                    {{ ucwords(str_replace('_', ' ', $value->cost_type)) }}
                                </td>
                                <td>
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
                                <td class="text-right">{{ $value->amount }}</td>
                                <td class="action">
                                    <a href="{{ route('costs.show', $value->id) }}">
                                        <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                            alt="edit" />
                                    </a>
                                </td>
                            </tr>
                            @php
                                $total_cost += $value->amount;
                            @endphp
                        @empty
                            <tr class="text-center">
                                <td colspan="9">
                                    <h4 class="font-weight-bold">{{translate('No Costs available')}}</h4>
                                </td>
                            </tr>
                        @endforelse
                        @forelse($sales as $value)
                            @php
                                $total_sale_cost += $value->total_buy_price;
                            @endphp
                            <tr>
                                <td>{{ count($branch_cost) + 1 }}</td>
                                <td>{{ date('d M Y', strtotime($value->date)) }}</td>
                                <td>Sell</td>
                                <td>

                                </td>
                                <td>{{ number_format($value->total_buy_price) }}</td>
                                <td class="action">

                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="9">
                                    <h4 class="font-weight-bold">{{translate('No Sales available')}}</h4>
                                </td>
                            </tr>
                        @endforelse

                        @php
                            $sub_total_cost = $total_sale_cost + $total_cost;

                        @endphp

                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
</div>
</section>
</div>
