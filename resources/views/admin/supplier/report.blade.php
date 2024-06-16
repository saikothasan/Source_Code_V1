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
                border-radius: 70px;
            }

            .heading {
                margin-top: -150px;
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
                background-image: linear-gradient(to right, red, yellow);
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
                                        <h2 style="color: #fff"><strong> R Craft </strong><span>Suppliers</span></h2>
                                        <div class="progress" style="border-radius: 10px;width: 65%">
                                            <div class="progress-bar" style="width: 95%">
                                            <span class="progress-description text-center"
                                                  style="background-color: rgb(0,214,0)">
                                                Profit level 95%
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
                                        <img src="{{ asset('images/blank.jpg') }}" class="right-image" alt=""/>
                                    </div>
                                </div>

                                <div class="pad margin heading"> Starting 22 Jan 2016</div>
                                <hr class="hr"/>
                                <div>
                                    <div class="row">

                                        <div class="col-md-2" onclick="openNav()">
                                            <i class="fa fa-fw fa-bars text-color"></i>
                                            Purchase
                                        </div>
                                        <div class="col-md-8 row">
                                            <div class="form-control">
                                                <div class="col-md-3 text-center text-color">
                                                    From
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
                                            Clear
                                        </div>
                                    </div>
                                    <div id="mySidepanel" class="sidepanel">
                                        <ul class="sidebar-menu tree" data-widget="tree">
                                            <li class="active treeview ">
                                                <a href="javascript:void(0)" onclick="closeNav()">
                                                    <span class="white-text">More Options</span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-fw fa-bars white-text"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="white-text">Payable Amount</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="white-text">Product</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="white-text">View Purchase</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="white-text">Stockwise Positon</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="white-text">Accounts</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="white-text">Overview</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="white-text">View Payment </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="white-text">Payment</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="white-text">Suppliers Details</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <table class="table table-spacing">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Invoice</th>
                                            <th>Items</th>
                                            <th>Quantity</th>
                                            <th>Buy Price</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>22 April 22</td>
                                            <td>CFP-130612001</td>
                                            <td>2</td>
                                            <td>75 pcs</td>
                                            <td>93750/-</td>
                                            <td>
                                                <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                     alt="edit"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>22 April 22</td>
                                            <td>CFP-130612001</td>
                                            <td>2</td>
                                            <td>75 pcs</td>
                                            <td>93750/-</td>
                                            <td>
                                                <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                     alt="edit"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>22 April 22</td>
                                            <td>CFP-130612001</td>
                                            <td>2</td>
                                            <td>75 pcs</td>
                                            <td>93750/-</td>
                                            <td>
                                                <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                     alt="edit"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>22 April 22</td>
                                            <td>CFP-130612001</td>
                                            <td>2</td>
                                            <td>75 pcs</td>
                                            <td>93750/-</td>
                                            <td>
                                                <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                     alt="edit"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>22 April 22</td>
                                            <td>CFP-130612001</td>
                                            <td>2</td>
                                            <td>75 pcs</td>
                                            <td>93750/-</td>
                                            <td>
                                                <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                     alt="edit"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>22 April 22</td>
                                            <td>CFP-130612001</td>
                                            <td>2</td>
                                            <td>75 pcs</td>
                                            <td>93750/-</td>
                                            <td>
                                                <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                     alt="edit"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>22 April 22</td>
                                            <td>CFP-130612001</td>
                                            <td>2</td>
                                            <td>75 pcs</td>
                                            <td>93750/-</td>
                                            <td>
                                                <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                     alt="edit"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>22 April 22</td>
                                            <td>CFP-130612001</td>
                                            <td>2</td>
                                            <td>75 pcs</td>
                                            <td>93750/-</td>
                                            <td>
                                                <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                     alt="edit"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>22 April 22</td>
                                            <td>CFP-130612001</td>
                                            <td>2</td>
                                            <td>75 pcs</td>
                                            <td>93750/-</td>
                                            <td>
                                                <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                     alt="edit"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>22 April 22</td>
                                            <td>CFP-130612001</td>
                                            <td>2</td>
                                            <td>75 pcs</td>
                                            <td>93750/-</td>
                                            <td>
                                                <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                     alt="edit"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>22 April 22</td>
                                            <td>CFP-130612001</td>
                                            <td>2</td>
                                            <td>75 pcs</td>
                                            <td>93750/-</td>
                                            <td>
                                                <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                     alt="edit"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>22 April 22</td>
                                            <td>CFP-130612001</td>
                                            <td>2</td>
                                            <td>75 pcs</td>
                                            <td>93750/-</td>
                                            <td>
                                                <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                     alt="edit"/>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td>
                                                DD Jan 22 To DD Jan 22 Total
                                                <br/>
                                                Items : 2, Quantity : 75 pcs, Buy Price : 93750/
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
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">View Supplier</button>
                            <button type="submit" class="btn btn-success">SUBMIT</button>
                            <button type="submit" class="btn btn-primary">Home</button>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal">
                                Launch demo modal
                            </button>
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
                                        <strong>R Craft</strong>
                                    </h2>
                                    <h4>
                                        Payment Receipt
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
