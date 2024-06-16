@extends('layouts.app')
@section('title', 'User Profile')
@section('content')
    @push('css')
        <style>
            .profile-image {
                width: 102px;
                border-radius: 50px;
            }

            .table-spacing {
                font-family: 'Roboto Light';
                padding-top: 10px;
            }

            .heading {
                margin-left: 8px;
                color: blue;
                margin-top: 20px;
            }
            tr{
                border-bottom:2px solid black;
            }
            .botom-border{
                border-bottom:2px solid black;
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
                            <div class="text-center">
                                User Profile
                            </div>
                            <div class="pad margin">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img class="profile-image" src="{{ asset('images/blank.jpg') }}" alt=""/>
                                    </div>
                                    <div class="col-md-4 row" style="margin-top: 10px;">
                                        <div class="col-md-12" style="margin-top: 5px;">Ruposh Alam</div>
                                        <div class="col-md-12" style="margin-top: 5px;">CEO</div>
                                        <div class="col-md-12" style="margin-top: 5px;">Joining Date : 20 Feb 2019</div>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <i class="fa fa-fw fa-remove" style="color: red;font-size: 50px;"></i>
                                            <br/>
                                            <span style="font-size: 11px;">Temporary Block</span>
                                        </div>
                                        <div class="col-md-6">
                                            <i class="fa fa-fw fa-trash" style="color: red;font-size: 50px;"></i>
                                            <br/>
                                            <span style="font-size: 11px;">Permanent Delete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="heading row botom-border">
                                    <div class="col-md-6 text-left text-danger">Permission</div>
                                    <div class="col-md-6 text-right">Edit</div>
                                </div>
                                <div class="form-control" style="margin-top: 5px">
                                   Permissions
                                </div>

                                <div class="heading">Login History</div>
                                <table class="table table-spacing">
                                        <tr>
                                            <th>IP Address</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Duration</th>
                                            <th></th>
                                        </tr>

                                    <tr>
                                        <td>155.22.1523</td>
                                        <td>3 July 2022</td>
                                        <td>2:44 AM</td>
                                        <td>02:12:12</td>
                                        <td>
                                            <i class="fa fa-fw fa-close"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>155.22.1523</td>
                                        <td>3 July 2022</td>
                                        <td>2:44 AM</td>
                                        <td>02:12:12</td>
                                        <td>
                                            <i class="fa fa-fw fa-close"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>155.22.1523</td>
                                        <td>3 July 2022</td>
                                        <td>2:44 AM</td>
                                        <td>02:12:12</td>
                                        <td>
                                            <i class="fa fa-fw fa-close"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>155.22.1523</td>
                                        <td>3 July 2022</td>
                                        <td>2:44 AM</td>
                                        <td>02:12:12</td>
                                        <td>
                                            <i class="fa fa-fw fa-close"></i>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" style="width: 20%;">View User</button>
                    <button type="submit" class="btn btn-success" style="width: 20%;">Update</button>
                </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>

    </div>
    </div>
@endsection
