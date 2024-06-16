@extends('layouts.app')
@section('title', 'Report History')
@section('content')
    <style>
        .corner {
            border-radius: 7px;
            text-align: center;
        }

        .spacer {
            margin-top: 20px;
        }

        .example-table tr:nth-child(2n+1) {
            background-color: #ddd;
        }

        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
        }

        .action {
            color: rgb(167, 169, 172);
            /* font-family: 'Roboto Light'; */
        }

        .button-size {
            padding: 2px 13px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .custom-btn {
            position: relative;
        }

        .custom-add {
            position: absolute;
            top: 0;
            border-radius: 5px;
            right: 35px;
            z-index: 9;
            border: none;
            top: 2px;
            height: 30px;
            cursor: pointer;
            color: #423030;
            background-color: transparent;
            transform: translateX(2px);
        }

        .font {
            font-family: 'Roboto Light';
        }

        .custom-home {
            padding: 8px 59px;
            font-size: 18px;
            line-height: 1.3333333;
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
                            <h1 class="text-uppercase">{{translate('Reports')}} {{translate('History')}}</h1>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 spacer" style="overflow-x: auto" >
                    {{-- @include('includes.errormessage') --}}
                    <table class="table table-striped table-responsive example-table">
                        <thead>
                            <tr>
                                <th>{{translate('SN')}}#</th>
                                <th>{{translate('Report')}} {{translate('ID')}}</th>
                                <th>{{translate('Report')}} {{translate('Name')}}</th>
                                <th>{{translate('Report')}} {{translate('Generator')}}</th>
                                <th>{{translate('Date')}} {{translate('&')}} {{translate('Time')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $key => $value)
                                <tr>
                                    <td>{{ serialNumber($reports, $loop) }}</td>
                                    <td>{{ $value->report_id }}</td>
                                    <td>{{ $value->report_name }}</td>
                                    <td>{{ $value['details']['generator_name'] }}</td>
                                    <td>
                                        <div style="display: grid;">
                                            <span>
                                                {{ date('l, F-y', strtotime($value['created_at'])) }}
                                            </span>
                                            <span> {{ date('h : i : s A', strtotime($value['created_at'])) }}</span>
                                        </div>
                                    </td>
                                    <td class="action">
                                        <a href="{{ route('report-history.show', $value->id) }}">
                                            <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                alt="edit" />
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="6">
                                        <h4 class="font-weight-bold"> {{translate('No')}} {{translate('Report')}} {{translate('History')}}</h4>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $reports->withQueryString()->links() }}
                </div>
            </div>
    </div>
    </section>

    </div>
@endsection
