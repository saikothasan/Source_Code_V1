@extends('layouts.app')
@section('title', 'Supplier Payable Amount')
@section('content')

    @push('css')
        <style>
            .example-table tr:nth-child(2n+1) {
                background-color: #ddd;
            }

            .example-table tr:nth-child(2n+0) {
                background-color: #eee;
            }

            .vm--modal {
                position: relative;
                overflow: hidden;
                box-sizing: border-box;
                background-color: #cccccc00 !important;
                border-radius: 3px;
                box-shadow: 0 0px 0px 0px rgb(27 33 58 / 40%) !important;
            }

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
                font-size: 13px;
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

            .groupedInput {
                border: 1px solid #e1cdcd;
                border-radius: 7px;
                /*border-radius: 10px;*/
            }


            .groupedLabel {
                margin-top: 7px;
                color: rgb(153, 153, 153);
            }

            .filter {
                display: flex;
                justify-content: center;
            }
        </style>
    @endpush
    <div class="content-wrapper">
        <div class="content supplier_content">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-horizontal">
                        <div class="box-body">
                            <div class="pad margin">
                                <div class="row"
                                    style="margin-bottom: 0!important; background-color: rgb(0,0,0);border-radius: 3px;margin: 0 0 20px 0;padding: 15px 30px 15px 15px;">
                                    <div class="col-md-6">
                                        <h2 style="color: #fff"><strong> {{ $supplier_info->name }}
                                            </strong><span>Suppliers</span></h2>
                                        {{-- <div class="progress" style="border-radius: 10px;width: 65%">
                                            <div class="progress-bar" style="width: 50%">
                                                <span class="progress-description text-center"
                                                    style="background-color: rgb(0,214,0)">
                                                    Profit level 50%
                                                </span>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="col-md-6 row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4 image text-center"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 image-div">
                                        @if ($supplier_info->photo)
                                            <img src="{{ asset($supplier_info->photo) }}" class="right-image"
                                                alt="" />
                                        @else
                                            <img src="{{ asset('images/blank.jpg') }}" class="right-image" alt="" />
                                        @endif
                                    </div>
                                </div>
                                <div class="pad margin heading"> Starting
                                    {{ date('d F Y', strtotime($supplier_info->created_at)) }} </div>
                                <hr class="hr" />

                                <div class="row">
                                    <div class="col-md-2" onclick="openNav()" style="white-space: nowrap;">
                                        <i class="fa fa-fw fa-bars text-color"></i>
                                        Payable Amount
                                    </div>
                                    <form method="get" action="{{ route('supplier.payable', $supplier_info->id) }}"
                                        class="form-horizontal" style="background:none;">
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 row text-center spacer filter">
                                            <div class=" col-lg-7 col-md-7 col-sm-7 col-xs-7 groupedInput"
                                                style="height: 38px">
                                                <div class="row form-inline">
                                                    <div class="col-md-1 text-center">
                                                        <label class="groupedLabel">From</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input value="{{ request()->get('from_date') }}"
                                                                name="from_date" type="date" class="form-control corner">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 text-center" style="margin-left: 25px;">
                                                        <label class="groupedLabel">To</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input value="{{ request()->get('to_date') }}" name="to_date"
                                                                type="date" class="form-control corner">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                                <div class="form-group" style="width: 72px;">
                                                    <x-url-param-clear></x-url-param-clear>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                                <div class="form-group" style="width: 72px;">
                                                    <button class="form-control">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @include('supplier.layout.sidebar')
                                <br>
                                <div id="app">
                                    <add-payable-amount-component :purchases="{{ json_encode($purchases) }}"
                                        :supplier="{{ json_encode($supplier_info) }}"
                                        :from-date="{{ json_encode($from_date) }}" :to-date="{{ json_encode($to_date) }}"
                                        :sender-account="{{ json_encode($senderAccount) }}"
                                        :supplier-banks="{{ json_encode($supplierBanks) }}">
                                    </add-payable-amount-component>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">

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
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'baseUrl' => url('/'),
            'routes' => collect(\Route::getRoutes())->mapWithKeys(function ($route) {
                return [$route->getName() => $route->uri()];
            }),
        ]) !!};
    </script>
    <script src="{{ mix('js/app.js') }}"></script>
@endpush
