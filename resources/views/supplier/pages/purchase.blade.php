@extends('layouts.app')
@section('title', 'Supplier Purchase')
@push('css')
    <style>
        .image img {
            width: 102px;
            border-radius: 50px;
        }

        .image-sm {
            width: 56px;
            border-radius: 25px;
        }

        .image-size {
            width: 1.5em;
            height: 1.5em;
        }

        .image-div {
            text-align: right;
            padding: 100px;
            margin-top: -160px;
        }

        .right-image {
            height: 50%;
            width: 19%;
            border: 4px solid #FF7200;
            border-radius: 100%;
        }

        .heading {
            margin-top: -150px;
        }

        .fa-fw {
            width: 2.285714em;
            text-align: center;
            font-size: 24px;
            color: gray;
        }

        .hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 0;
            border-top: 3px solid black;
        }

        .text-color {
            style="color: gray";
        }

        .table-spacing {
            font-family: 'Roboto Light';
            padding-top: 10px;
        }

        .sidepanel {
            height: auto;
            width: 0;
            position: absolute;
            z-index: 1;
            background-color: rgb(75, 75, 113);
            overflow-x: hidden;
            transition: 0.5s;
            margin-top: -57px;
        }

        .white-text {
            color: #ffffff;
        }

        .modal-radious {
            border: 0px solid #ededed;
            border-radius: 25px;
        }

        .custom-modal-header {
            background-image: linear-gradient(to right, #EC1D24, #e6e691);
            border-top-right-radius: 20px;
            border-top-left-radius: 20px;
        }

        .custom-modal-footer {
            background-color: rgb(255, 226, 201);
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .tablet {
            border: 2px solid #0a0606;
            border-radius: 8px;
            background-color: black;
            color: white;
        }

        .custom-circle {
            font-size: 50px;
            color: rgb(255, 77, 0);
        }

        .custom-footer {
            padding: 15px;
            text-align: right;
        }

        .d-flex {
            display: flex;
        }

        .example-table tr:nth-child(2n+1) {
            background-color: #ddd;
        }

        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
        }

        @media only screen and (max-width: 768px) {
            .buttons button {
                width: 100%;
                margin-bottom: 5px;
            }

            .sidepanel {
                top: 200px;
            }
        }
    </style>
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="content supplier_content">
            <div class="row">

                <div class="col-md-12">
                    <form class="form-horizontal">
                        <div class="box-body">
                            <div class="pad margin">
                                <div class="row"
                                    style="margin-bottom: 0!important; background-color: rgb(0,0,0);border-radius: 3px;margin: 0 0 20px 0;padding: 15px 30px 15px 15px;">
                                    <div class="col-md-6">
                                        <h2 style="color: #fff"><strong> {{ $supplier_info->name }}
                                            </strong><span>{{ translate('Suppliers') }}</span>
                                        </h2>
                                    </div>


                                    <div class="col-md-6 row">

                                        <div class="col-md-4"></div>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4 image text-center">

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 image-div">
                                        @if ($user_info->photo)
                                            <img src="{{ asset($user_info->photo) }}" class="right-image" alt="" />
                                        @else
                                            <img src="{{ asset('images/blank.jpg') }}" class="right-image" alt="" />
                                        @endif

                                    </div>
                                </div>

                                <div class="pad margin heading">
                                    {{ translate('Starting') }} {{ date('d F Y', strtotime($supplier_info->created_at)) }}
                                </div>
                                <hr class="hr" />
                                <div>
                                    <form action="{{ route('suppliers.show', $supplier_info->id) }}" method="get">
                                        <div class="row">

                                            <div class="col-md-2" onclick="openNav()" style="white-space: nowrap">
                                                <i class="fa fa-fw fa-bars text-color"></i>
                                                {{ translate('Purchase') }}
                                            </div>
                                            <div class="col-md-8 col-sm-12 row">
                                                <div class="form-group row col-md-6 col-sm-12">
                                                    <label for="from_date"
                                                        class="col-sm-2 col-form-label">{{ translate('From') }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" name="from_date" type="date"
                                                            id="from_date" />
                                                    </div>
                                                </div>
                                                <div class="form-group row col-md-6 col-sm-12">
                                                    <label for="to_date" cl
                                                        ass="col-sm-2 col-form-label">{{ translate('To') }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" name="to_date" type="date"
                                                            id="to_date" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <x-url-param-clear></x-url-param-clear>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <button class="form-control">{{ translate('Submit') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    @include('supplier.layout.sidebar')

                                    <table class="table table-striped table-responsive example-table"
                                        style="margin-top: 10px">
                                        <thead>
                                            <tr>
                                                <th>{{ translate('SL') }}.</th>
                                                <th style="width: 14%;">{{ translate('Date') }}</th>
                                                <th>{{ translate('Invoice') }}</th>
                                                <th>{{ translate('Items') }}</th>
                                                <th>{{ translate('Quantity') }}</th>
                                                <th>{{ translate('Buy') }} {{ translate('Price') }}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($purchases as $purchase)
                                                <tr>
                                                    <td>{{ serialNumber($purchases, $loop) }}</td>
                                                    <td>{{ date('d F Y', strtotime($purchase->date)) }}</td>
                                                    <td>{{ $purchase->invoice }}</td>
                                                    <td>{{ $purchase->total_items }}</td>
                                                    <td>{{ $purchase->total_quantity }} pcs</td>
                                                    <td>{{ $purchase->subtotal }} {{ getsetting('currency_symbol') }}</td>
                                                    <td>
                                                        <a href="{{ route('purchases.show', $purchase->id) }}">
                                                            <img class="image-size"
                                                                src="{{ asset('images/sales/02.png') }}" alt="edit" />
                                                        </a>

                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td>{{ translate('Total') }} : </td>
                                            <td> {{ $total_quantity }}</td>
                                            <td>{{ $total_buy_price }} {{ get_settings('currency_symbol') }}</td>
                                            <td></td>
                                        </tr>
                                    </table>
                                    {{ $purchases->withQueryString()->links() }}
                                </div>
                            </div>
                            <div class="text-center buttons ">
                                <div class="row">
                                    <div class="row text-center form-group mt-5">
                                        <div class="col-md-4 col-xs-12">
                                            <a href="{{ route('suppliers.index') }}">
                                                <button type="button" class="btn btn-primary">{{ translate('View') }}
                                                    {{ translate('Supplier') }}</button>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            {{-- <button type="submit"
                                                class="btn btn-success">{{ translate('Submit') }}</button> --}}

                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <a href="{{ route('home') }}">
                                                <button type="button"
                                                    class="btn  btn-primary">{{ translate('Home') }}</button>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Button trigger modal -->
                                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal">
                                    Launch demo modal
                                </button> --}}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function openNav() {
            document.getElementById("mySidepanel").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }
    </script>
@endpush
