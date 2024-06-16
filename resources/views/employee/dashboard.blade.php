@extends('layouts.app')
@section('title', 'Employee')
@section('content')
    <style>
        .dashboard .container {
            width: 95%;
        }

        .content-center {
            display: flex;
            justify-content: center;
        }

        .header {
            font-weight: bold;
            text-align: center;
            /* font-family: 'RobotoLight';  */
            letter-spacing: 8px;
        }

        .attendance {
            letter-spacing: 3px;
        }

        .second-box {
            background: white;
            margin: 8px;
            border: 2px solid white;
            border-radius: 10px;
            color: #005E7E;
        }

        .third-box-font {
            background: #659DB1;
            margin: -2px;
            color: white;
            border-bottom-left-radius: 7px;
            border-bottom-right-radius: 7px;
        }

        .third-box-font p {
            font-family: 'RobotoLight';
            font-size: 22px;
            margin: 2px;
        }

        .second-box-font p {
            font-size: 55px;
            font-family: 'RobotoLight';

        }



        .small-box:hover {
            text-decoration: none;
            color: black;
        }

        .small-box {
            border-radius: 25px;
            background: #005E7E !important;
        }

        .box-header {
            background: #005E7E !important;
            border-top-left-radius: 13px;
            border-top-right-radius: 13px;
            padding: 10px !important;
            color: white !important;
            padding: 10px;
        }

        .box-footer-f {
            background: #005E7E !important;
            padding: 3px !important;
            border-bottom-left-radius: 13px;
            border-bottom-right-radius: 13px;
            font-family: 'Arial';
            padding: 5px !important;
        }

        .inner-body {
            padding: 5px;
            text-align: center;
        }

        /* .header-title {
                                                                padding: 10px;
                                                            } */

        hr.new {
            border: 1px solid white;
            border-radius: 5px;
            margin-top: 0px;
            margin-bottom: 8px;
        }

        .left-align {
            font-family: 'RobotoLight';
            text-align: left;
        }

        .center-align {
            font-family: 'RobotoLight';
            text-align: center;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">kjdfsk
            <div class="dashboard">
                <div class="container">
                    <div class="row content-center">
                        <div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">
                            <h2 class="header">EMPLOYEE</h2>

                            <div class="small-box" style="margin-top: 20px">
                                <h4 class="small-box-footer box-header attendance">ATTENDANCE</h4>
                                <div class="second-box">
                                    <div class="row center text-center  second-box-font">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <p class="">20</p>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <p class="">21</p>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <p class="">22</p>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <p class="">23</p>
                                        </div>
                                    </div>
                                    <div class="row center text-center  third-box-font">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <p class="">Present</p>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <p class="">Absent</p>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <p class="">Missing</p>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <p class="">Day Off</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('products.index') }}"
                                    class="attendance center-align small-box-footer box-footer-f"
                                    style="font-size: 15px">More
                                    info
                                </a>
                            </div>


                            <div class="row content-center" style=" text-align: center;
                            margin-top: 55px;">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <img src="{{ asset('employee/two.png') }}" style="height: 62%;" alt="employee">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <img src="{{ asset('employee/one.png') }}" style="height: 62%;" alt="employee">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <img src="{{ asset('employee/three.png') }}" style="height: 62%;" alt="employee">
                                </div>
                            </div>

                            {{-- <div class="small-box bg-green" style="margin-top: 20px">
                                <h4 class="small-box-footer box-header attendance">ATTENDANCE</h4>
                                <div class="inner-body">
                                    <div class="row">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <p class="left-align" style="white-space: nowrap;">TOTAL SELL</p>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <p class="left-align" style="white-space: nowrap;">TOTAL SELL</p>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <p class="left-align" style="white-space: nowrap;">TOTAL AVAILABLE</p>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                                    </div>
                                </div>
                                <a href="{{ route('products.index') }}" class="center-align small-box-footer box-footer-f"
                                    style="font-size: 15px">More
                                    info
                                </a>

                            </div> --}}
                        </div>
                    </div>
                </div>
        </section>
    </div>

@endsection
