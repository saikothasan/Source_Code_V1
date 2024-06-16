@extends('layouts.app')
@section('title', 'Delivery Man List')
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
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h1>Delivery Man List</h1>
                        </div>
                    </div>
                </div>

                <form action="" method="get">
                    <div class="col-md-12 row text-center spacer filter" style="display: flex;justify-content: center">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>
                                    <input value="{{ request()->get('search') }}" name="search" class="form-control corner"
                                        placeholder="Search">
                                </label>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group" style="width: 72px;">
                                <button class="form-control">Submit</button>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group" style="width: 72px;">
                                <x-url-param-clear></x-url-param-clear>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body p-0 spacer" style="overflow-x: auto" >
                    <div>
                        <table class="table table-striped table-responsive example-table">
                            <thead>
                                <tr>
                                    <th>S.L</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>NID</th>
                                    <th>Delivery Charge</th>
                                    <th>Address</th>
                                    <th>Delivery Area</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($delivery_mans as $key => $delivery_man)
                                    <tr>
                                        <td>{{ serialNumber($delivery_mans, $loop) }}</td>
                                        <td>
                                            <p> {{ $delivery_man->name }}</p>
                                            <p>Inside Dhaka Additional Charge : {{ $delivery_man->inside_dhaka_charge }}  {{get_settings('currency_symbol')}}
                                            </p>
                                            <p>Outside Dhaka Additional Charge : {{ $delivery_man->outside_dhaka_charge }}
                                                 {{get_settings('currency_symbol')}}</p>
                                        </td>
                                        <td>{{ $delivery_man->phone }}</td>
                                        <td>{{ $delivery_man->nid }}</td>
                                        <td>{{ $delivery_man->delivery_charge }}  {{get_settings('currency_symbol')}}</td>
                                        <td>{{ $delivery_man->address }}</td>
                                        <td>
                                            <table>
                                                @if (isset($delivery_man->delivery_area))
                                                    @foreach (str_split($delivery_man->delivery_area, 1000) as $chunk)
                                                        <div class="col-md-12">
                                                            <span>{{ $chunk }}</span>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </table>
                                        </td>
                                        <td class="action">
                                            <a href="{{ route('delivery-man.edit', $delivery_man->id) }}">
                                                <button class="button-size font"> Edit</button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $delivery_mans->withQueryString()->links() }}
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection
