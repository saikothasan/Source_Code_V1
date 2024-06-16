@extends('layouts.app')
@section('title', 'report')
@push('css')
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



        .custom-home {
            padding: 8px 59px;
            font-size: 18px;
            line-height: 1.3333333;
        }

        .image-size {
            width: 1.5em;
            height: 1.5em;
        }

        .corner {
            border-radius: 7px;
            text-align: center;
        }

        .second-section {
            text-align: center;
        }

        .header-logo img {
            width: 40%;
        }

        .header tr {
            background: black !important;
            color: white;
            border: 1px solid black !important;

        }

        .header th {
            border-bottom: 2px solid #000000 !important;
        }

        td {
            border: 1px solid black !important;
        }

        .autority-section hr {
            margin-top: 20px;
            margin-bottom: 10px;
            border: 0;
            border-top: 2px solid #1d1c1c;
            width: 50%;
        }

        .signature-generator,
        .autority-section,
        .footer-section {
            text-align: center;
        }

        .confirm-section p {
            font-size: 16px;
        }

        .confirm-section {
            margin-top: 7%;
            margin-bottom: 5%;
            text-align: center;
        }

        .confirm-section hr {
            margin-top: 20px;
            margin-bottom: 5px;
            border: 0;
            border-top: 2px solid #000;
        }

        .signature-generator hr {
            margin-top: 20px;
            margin-bottom: 5px;
            border: 0;
            border-top: 2px solid #000;
        }

        .second-section h3 strong {
            text-decoration: underline;
        }


        .box-header {
            border: 1px solid #00c0ef;
            border-radius: 17px;
        }

        .groupedInput {
            border: 1px solid #e1cdcd;
            border-radius: 7px;
            /*border-radius: 10px;*/
        }

        footer {
            margin-top: 5%;
        }

        .spacer {
            margin-top: 20px;
        }

        .groupedLabel {
            margin-top: 7px;
            color: rgb(153, 153, 153);
        }


        .action {
            color: rgb(167, 169, 172);

        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: #f9f9f9;
            color: black !important;
        }

        .tbody td {
            color: black;
        }

        .image-size {
            width: 1.5em;
            height: 1.5em;
        }

        .individual {
            margin-bottom: 10%;
        }

        .card-sale {
            border: 2px solid #1cb24d;
        }

        .card-cost {
            border: 2px solid #F15A29;
        }

        .card-blance {
            margin-top: 5%;
            border: 2px solid gray;
        }

        .card-other-cost {
            margin-top: 4%;
            border: 2px solid #ED1E24;
            background: #ED1E24;
        }

        .card-profit {
            border: 2px solid rgb(0, 118, 150);
        }

        .card-header,
        .card-footer {
            padding: 10px;
            text-align: center;
            color: white;
        }

        .card-sale .card-header,
        .card-footer {
            background: #1cb24d;
        }

        .card-sale {
            background: #1cb24d;
        }

        .delivery {
            padding: 18px;
            border-bottom: 1px solid black;
        }

        .card-profit {
            background: rgb(0, 118, 150);
        }

        .card-blance {
            background: gray;
        }

        .card-cost {
            background: #F15A29;
        }

        .for-title-branch {
            font-size: 19px;
            text-decoration: underline;
        }

        .list-group-item {
            position: relative;
            display: block;
            padding: 10px 15px;
            margin-bottom: -1px;
            background-color: #fff;
            border-bottom: 3px solid #a59e9e;
        }

        .list-group-item p {
            font-family: 'Source Sans Pro', sans-serif;
        }

        .list-group {
            margin-bottom: 0;
            background: white;
        }

        .amount-margin {
            margin-top: 18%;
        }

        .total_pices {
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 16px;
        }

        .cost-row {
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 16px;
        }

        .paddin-dicress {
            padding-right: 0px;
            padding-left: 10px;
        }
    </style>
@endpush
@section('content')

    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="container" id="report-print">

                    <div class="">
                        <div class="">
                            <div class="row">

                                <div class="col-md-6 header-logo">
                                    <img class="logo"
                                        src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path(getSetting('site_logo', 'images/logoheader.png')))) }}"
                                        alt="">

                                </div>
                                <div class="col-md-6" style="text-align: right;">
                                    <div> Report Generate
                                        Samira Jasi
                                    </div>
                                    <div>
                                        Tuesday, September-22
                                    </div>
                                    <div> 02 : 01 : 56 PM</div>
                                    <div> Report ID : RC-270922010</div>
                                </div>
                            </div>

                            <div class="center second-section">
                                <h3><strong> Sales Report </strong></h3>
                                <p>27-09-2022 to 30-09-2022</p>
                                <p>
                                    This report is generated with this
                                    payment Method, &amp; Only Showing Profit Amount
                                    Report Mode is
                                    Total Pieces

                                </p>
                            </div>

                            <div>
                                <div class="sale-table">
                                    <div class="card-body p-0 spacer" style="overflow-x: auto" >
                                        <table class="table table-striped table-responsive example-table">
                                            <thead class="header">
                                                <tr class="table-head">
                                                    <th class="text-center">Total Sales </th>
                                                    <th class="text-center">Total Cost</th>
                                                    <th class="text-center">Profit</th>

                                                </tr>

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">41,03,700/-</td>
                                                    <td class="text-center">41,03,700/-</td>
                                                    <td class="text-center">41,03,700/-</td>

                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 paddin-dicress ">
                                        <div class="card card-sale">
                                            <div class="card-header">
                                                Sale Details
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <span class="for-title-branch">
                                                                Online Branch
                                                            </span>
                                                            <p>All Payment Mathood</p>

                                                            <div class="total_pices">1952 pcs</div>
                                                        </div>
                                                        <div class="col-md-4 amount-margin">
                                                            <strong>31,23,200/-</strong>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <span class="for-title-branch">
                                                                B blcok Branch
                                                            </span>
                                                            <p>All Payment Mathood</p>

                                                            <div class="total_pices">232 pcs</div>
                                                        </div>
                                                        <div class="col-md-4 amount-margin">
                                                            <strong>5,77,500/-</strong>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <span class="for-title-branch">
                                                                F Block Branch
                                                            </span>
                                                            <p>All Payment Mathood</p>

                                                            <div class="total_pices">322 pcs</div>
                                                        </div>
                                                        <div class="col-md-4 amount-margin">
                                                            <strong>4,03,000/-</strong>
                                                        </div>
                                                    </div>
                                                </li>
                                                <div class="row" style="padding:14px;">
                                                    <div class="col-md-8">

                                                        <div class="total_pices">322 pcs</div>
                                                    </div>
                                                    <div class="col-md-4 ">
                                                        <strong>4,03,000/-</strong>
                                                    </div>
                                                </div>
                                            </ul>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <span> Return - 00 pcs</span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <span> Exchange - 00 pcs</span>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="card card-other-cost">
                                            <div class="card-header ">
                                                Others Cost
                                            </div>
                                            <ul class="list-group list-group-flush">

                                                <table class="table table-bordered">

                                                    <tbody>
                                                        <tr>

                                                            <td rowspan="3" style="padding-top: 12%;"> <span> Delivery
                                                                </span> </td>
                                                            <td colspan="4">Normal (no cost) <span
                                                                    style="float: right">1,85,440/-</span></td>

                                                        </tr>

                                                        <tr>
                                                            <td colspan="4">Return <span
                                                                    style="float: right">22,450/-</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4">Exechange <span
                                                                    style="float: right">400/-</span></td>
                                                        </tr>
                                                        <tr>

                                                            <td> <span> Discount </span> </td>
                                                            <td colspan="4"><span style="float: right">26,700/-</span>
                                                            </td>

                                                        </tr>
                                                    </tbody>
                                                </table>


                                            </ul>
                                        </div>

                                    </div>

                                    <div class="col-md-4  paddin-dicress ">
                                        <div class="card card-cost">
                                            <div class="card-header">
                                                Cost Details
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <span class="for-title-branch">
                                                                Online Branch
                                                            </span>
                                                        </div>
                                                        <div class="col-md-4 ">

                                                        </div>
                                                    </div>
                                                    <div class="row cost-row">
                                                        <div class="col-md-8">
                                                            <div>Daily Cost</div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div>2,670/-</div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div>Monthly Cost</div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div> 80,450/-</div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div> One Time Cost</div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div>3,500/-</div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div>Salary</div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div>35,000/-</div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div>Sales Product Purchase</div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div> 12,85,152/-</div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center" style="color:red; margin-top:10px;">
                                                        <center>online branch total cost - 14,16,772/-</center>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <span class="for-title-branch">
                                                                Online Branch
                                                            </span>
                                                        </div>
                                                        <div class="col-md-4 ">

                                                        </div>
                                                    </div>
                                                    <div class="row cost-row">
                                                        <div class="col-md-8">
                                                            <div>Daily Cost</div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div>2,670/-</div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div>Monthly Cost</div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div> 80,450/-</div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div> One Time Cost</div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div>3,500/-</div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div>Salary</div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div>35,000/-</div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div>Sales Product Purchase</div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div> 12,85,152/-</div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center" style="color:red; margin-top:10px;">
                                                        <center>online branch total cost - 14,16,772/-</center>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <span class="for-title-branch">
                                                                Online Branch
                                                            </span>
                                                        </div>
                                                        <div class="col-md-4 ">

                                                        </div>
                                                    </div>
                                                    <div class="row cost-row">
                                                        <div class="col-md-8">
                                                            <div>Daily Cost</div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div>2,670/-</div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div>Monthly Cost</div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div> 80,450/-</div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div> One Time Cost</div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div>3,500/-</div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div>Salary</div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div>35,000/-</div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div>Sales Product Purchase</div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <div> 12,85,152/-</div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center" style="color:red; margin-top:10px;">
                                                        <center>online branch total cost - 14,16,772/-</center>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="card card-profit">
                                            <div class="card-header ">
                                                Profit Details
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <span> Online Branch</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span> 00/-</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <span> B-Block Branch</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span> 00/-</span>
                                                        </div>
                                                    </div>

                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <span> F-block Branch</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span> 00/-</span>
                                                        </div>
                                                    </div>

                                                </li>
                                            </ul>
                                        </div>

                                        <div class="card card-blance">
                                            <div class="card-header ">
                                                Bank Blance
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <span> Bangladesh Bank</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span> 00/-</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <span> Islamic Bank</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span> 00/-</span>
                                                        </div>
                                                    </div>

                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <span> South East bank</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span> 34,00/-</span>
                                                        </div>
                                                    </div>

                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>

                                <div class="inword row">
                                    <div class="col-md-4" style="width: 50%;">
                                        <h4><strong> in words </strong></h4>
                                        <span> Total sales Zero &amp;
                                            Profit Amount Zero </span>
                                    </div>
                                </div>
                            </div>




                            <div class="signature-generator row">
                                <div class="col-md-8" style="width: 60%;"></div>
                                <div class="col-md-4" style="width: 40%; float: right;">
                                    <hr>
                                    <p>Samira Jasi</p>
                                    <p>Generator Signature</p>
                                </div>
                            </div>
                            <div class="confirm-section row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <p>C O N F I R M E D</p>
                                    <hr>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="autority-section row" style="display: flex;">
                                <div class="col-md-2"></div>
                                <div class="col-md-4" style="width: 50%;">
                                    <hr>
                                    <p>Authority</p>
                                </div>
                                <div class="col-md-4" style="width: 50%;">
                                    <hr>
                                    <p>Receiver</p>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>
                        <footer>
                            <div class="footer-section">
                                <p>House-36, Road-05, Block-B, Banasree, Rampura.</p>
                                <span>www.colourful.com.bd</span> <span>01785-992233</span>
                                <span>collourfuloffice@gmail.com</span>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </section>
        <div class="text-center" style="margin: 2%;">
            <button class="btn text-black print pointer hidden-print"
                style=" margin-right:20px; color: black;border-color: #000000;background: white;">Print</button>
            <a href="" class="btn text-black print pointer hidden-print"
                style=" margin-right:20px; color: black;border-color: #000000;background: white;">Download</a>
        </div>
    </div>
@endsection
