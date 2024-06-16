@extends('layouts.app')
@section('title', 'Supplier Report')
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
                style = "color: gray";
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
            .custom-footer{
                padding: 15px;
                text-align: right;
            }
            .d-flex{
                display: flex;
            }
        </style>
    @endpush
    <div class="content-wrapper">
        <div class="content supplier_content">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form class="form-horizontal">
                        <div class="box-body">
                            <div class="pad margin">
                                <div class="row"
                                     style="margin-bottom: 0!important; background-color: rgb(0,0,0);border-radius: 3px;margin: 0 0 20px 0;padding: 15px 30px 15px 15px;">
                                    <div class="col-md-6">
                                        <h2 style="color: #fff"><strong> {{ $supplier_info->name }} </strong><span>{{ translate('Suppliers')}}</span></h2>
                                        <div class="progress" style="border-radius: 10px;width: 65%">
                                            <div class="progress-bar" style="width: 95%">
                                            <span class="progress-description text-center"
                                                  style="background-color: rgb(0,214,0)">
                                                {{ translate('Profit')}} {{ translate('level')}} 95%
                                            </span>
                                            </div>
                                        </div>
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
                                        @if($supplier_info->photo)
                                        <img src="{{ asset($supplier_info->photo) }}" class="right-image" alt=""/>
                                           @else
                                           <img src="{{ asset('images/blank.jpg') }}" class="right-image" alt=""/>
                                        @endif

                                    </div>
                                </div>

                                <div class="pad margin heading"> {{ translate('Starting')}} {{date('d F Y',strtotime($supplier_info->created_at))}} </div>
                                <hr class="hr"/>
                                <div>
                                    <div class="row">

                                        <div class="col-md-2" onclick="openNav()">
                                            <i class="fa fa-fw fa-bars text-color"></i>
                                            {{ translate('Purchase')}}
                                        </div>
                                        <div class="col-md-8 row">
                                            <div class="form-control">
                                                <div class="col-md-3 text-center text-color">
                                                    {{ translate('From')}}
                                                </div>
                                                <div class="col-md-3 text-center">
                                                    <input type="date"/>
                                                </div>
                                                <div class="col-md-3 text-center text-color">To</div>
                                                <div class="col-md-3 text-center">
                                                    <input type="date"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-center text-color">
                                            {{ translate('Clear')}}
                                        </div>
                                    </div>

                                    @include('supplier.layout.sidebar')

                                    <table class="table table-spacing">
                                        <thead>
                                        <tr>
                                            <th>{{ translate('Date')}}</th>
                                            <th>{{ translate('Invoice')}}</th>
                                            <th>{{ translate('Items')}}</th>
                                            <th>{{ translate('Quantity')}}</th>
                                            <th>{{ translate('Buy')}} {{ translate('Price')}}</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $total_items = 0;
                                            $total_quantity = 0;
                                            $total_available = 0;
                                            $buy_price = 0;
                                          @endphp
                                            @foreach ($purchases as $purchase )
                                            <tr>
                                                <td>{{date('d F Y',strtotime($purchase->date))}}</td>
                                                <td>{{ $purchase->invoice }}</td>
                                                <td>{{ $purchase->purchase_details_count }}</td>
                                                <td>{{ $purchase->total_quantity }} pcs</td>
                                                <td>{{ $purchase->subtotal }}</td>
                                                <td>

                                                        <a href="{{route('purchases.show',$purchase->id)}}"><i class="fa fa-eye"></i></a>
                                                        <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                             alt="edit"/>

                                                </td>
                                            </tr>
                                            @php
                                            $total_items += $purchase->purchase_details_count;
                                            $total_quantity += $purchase->total_quantity;
                                            $total_available += $purchase->stocks_count;
                                            $buy_price += $purchase->total;
                                        @endphp
                                            @endforeach


                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td>
                                                DD Jan 22 To DD Jan 22 Total
                                                <br/>
                                                {{ translate('Items')}} : {{ $total_items }}, {{ translate('Quantity')}} : {{ $total_quantity }} {{ translate('pcs')}}, {{ translate('Buy')}} {{ translate('Price')}} : {{ $buy_price }}/
                                            </td>
                                            <td colspan="4">
                                                <div class="dataTables_paginate paging_simple_numbers"
                                                     id="example2_paginate">
                                                    <ul class="pagination">
                                                        <li class="paginate_button previous disabled"
                                                            id="example2_previous"><a href="#" aria-controls="example2"
                                                                                      data-dt-idx="0" tabindex="0">Previous</a>
                                                        </li>
                                                        <li class="paginate_button active"><a href="#"
                                                                                              aria-controls="example2"
                                                                                              data-dt-idx="1"
                                                                                              tabindex="0">1</a></li>
                                                        <li class="paginate_button "><a href="#"
                                                                                        aria-controls="example2"
                                                                                        data-dt-idx="2"
                                                                                        tabindex="0">2</a></li>
                                                        <li class="paginate_button "><a href="#"
                                                                                        aria-controls="example2"
                                                                                        data-dt-idx="3"
                                                                                        tabindex="0">3</a></li>
                                                        <li class="paginate_button "><a href="#"
                                                                                        aria-controls="example2"
                                                                                        data-dt-idx="4"
                                                                                        tabindex="0">4</a></li>
                                                        <li class="paginate_button "><a href="#"
                                                                                        aria-controls="example2"
                                                                                        data-dt-idx="5"
                                                                                        tabindex="0">5</a></li>
                                                        <li class="paginate_button "><a href="#"
                                                                                        aria-controls="example2"
                                                                                        data-dt-idx="6"
                                                                                        tabindex="0">6</a></li>
                                                        <li class="paginate_button next" id="example2_next"><a href="#"
                                                                                                               aria-controls="example2"
                                                                                                               data-dt-idx="7"
                                                                                                               tabindex="0">Next</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="text-center ">
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">{{ translate('View')}} {{ translate('Supplier')}}</button>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success">{{ translate('SUBMIT')}}</button>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">{{ translate('Home')}}</button>
                                    </div>


                                </div>

                                <!-- Button trigger modal -->
                                {{-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal">
                                    Launch demo modal
                                </button> --}}
                            </div>
                        </div>

                    </form>
                </div>
                <div class="col-md-2"></div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal-radious">
                        <div class="modal-header custom-modal-header">
                            <div class="text-center row">
                                <div class="col-md-2">
                                    <img class="image-sm" src="{{ asset('images/blank.jpg') }}"/>
                                </div>
                                <div class="col-md-4 text-center" style="color: white">
                                    <h2>
                                        <strong>{{ translate('R Craft')}}</strong>
                                    </h2>
                                    <h4>
                                        {{ translate('Payment')}} {{ translate('Receipt')}}
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="modal-body custom-modal-footer" style="background-color: rgb(255,226,201);">
                            <div class="row">
                                <div class="col-md-6 text-left">20 June 22</div>
                                <div class="col-md-6  text-right">10 to 22 June 22</div>
                            </div>
                            <div class="row text-center" style="margin-top: 15px">
                                <div class="col-md-2"></div>
                                <div class="col-md-8 row">
                                    <div class="row">
                                        <div class="col-md-6 text-left">Total Product</div>
                                        <div class="col-md-6">75 pcs</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 text-left">Iteams</div>
                                        <div class="col-md-6">2</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 text-left">Invoice</div>
                                        <div class="col-md-6">CFP-2215001</div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row text-center">
                                <div class="col-md-2"></div>
                                <div class="col-md-8 row">
                                    <div class="row">
                                        <div class="col-md-6 text-left">Total Product</div>
                                        <div class="col-md-6">75 pcs</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 text-left">Iteams</div>
                                        <div class="col-md-6">2</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 text-left">Invoice</div>
                                        <div class="col-md-6">CFP-2215001</div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row text-center" style="margin-top: 10px">
                                <div class="col-md-4"></div>
                                <div class="col-md-4 tablet">
                                    Receipt No : SP-R-20001
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="row text-center" style="margin-top: 10px">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <i class="fa fa-check-circle custom-circle"></i>
                                    <br/>
                                    <span>PAYMENT SUCCESSFUL</span>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </div>

                        <div class="custom-footer row">
                            <div class="col-md-6 row">
                                <button type="button" class="btn btn-primary">Download</button>
                            </div>
                            <div class="col-md-6 row">
                                <button type="button" class="btn btn-success">Screenshot</button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-primary" style="width: 75%;">View Payment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
@endsection
