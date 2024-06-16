@extends('layouts.app')
@section('title', 'View Payment')
@section('content')
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
        </style>
    @endpush
    <div class="content-wrapper">
        <div class="content supplier_content">
            <div class="row">

                <div class="col-md-12">
                    <form class="form-horizontal">
                        <div class="box-body">
                            @include('supplier.layout.header')
                            <div>
                                <div class="row">

                                    <div class="col-md-2" onclick="openNav()" style="white-space: nowrap">
                                        <i class="fa fa-fw fa-bars text-color"></i>
                                        Payments
                                    </div>
                                    <div class=" col-lg-7 col-md-7 col-sm-12 col-xs-12 groupedInput" style="height: 38px">
                                        <div class="row form-inline">
                                            <div class="col-md-2 text-center">
                                                <label class="groupedLabel">From</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input value="{{ request()->get('from-date') }}" name="from-date"
                                                        type="date" class="form-control corner">
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center" style="margin-left: 25px;">
                                                <label class="groupedLabel">To</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input value="{{ request()->get('to-date') }}" name="to-date"
                                                        type="date" class="form-control corner">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                        <div class="form-group" style="width: 72px;">
                                            <button class="form-control">Submit</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center text-color">
                                        <a href="{{ request()->url() }}">Clear</a>
                                    </div>
                                </div>
                                @include('supplier.layout.sidebar')
                                <table class="table table-striped table-responsive example-table" style="margin-top: 10px">
                                    <thead>
                                        <tr>
                                            <th>Receipt No </th>
                                            <th>Payment Date</th>
                                            <th>Payable Amount</th>
                                            <th>Paid Amount</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchasePayments as $purchasePayment)
                                            <tr>
                                                <td>{{ $purchasePayment->receipt_no }}</td>
                                                <td>{{ date('d F Y', strtotime($purchasePayment->date)) }}</td>
                                                <td>{{ $purchasePayment->total_payable }}</td>
                                                {{--                                            <td>{{ $purchasePayment->total_advance }}</td> --}}
                                                <td>{{ $purchasePayment->paid_amount_sum_total_pay }} </td>
                                                <td>
                                                    <a href="{{ route('supplier.payment-details', $purchasePayment->id) }}">
                                                        <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                            alt="edit" />
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $purchasePayments->withQueryString()->links() }}
                            </div>
                        </div>
                        <div class="text-center ">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="{{ route('suppliers.index') }}">
                                        <button type="button" class="btn btn-primary">View Supplier</button>

                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('home') }}">
                                        <button type="button" class="btn btn-primary">Home</button>

                                    </a>
                                </div>
                            </div>
                        </div>
                </div>
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
