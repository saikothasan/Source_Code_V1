<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="{{ asset('public/images/Icon.png') }}">
    <title>@yield('title')</title>
    @include('layouts.head')
    @stack('css')
    <style>
        .option {
            padding-top: 20px;
        }

        .none-border {
            border: none !important;
        }

        .corner {
            border-radius: 7px;
            text-align: center;
        }

        .selectBox {
            border-radius: 4px;
            border: 1px solid #AAAAAA;
        }


        .invoice-font {
            font-size: 12px;
            font-family: 'Times New Roman';
        }

        td.description,
        th.description {
            width: 120px;
            max-width: 120px;
        }

        td.mrp,
        tr.mrp {
            width: 30px;
        }

        td.quantity,
        th.quantity {
            text-align: center;
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }

        td.price,
        th.price {
            text-align: right;
            /* width: 40px; */
            max-width: 40px;
            word-break: break-all;
        }

        .bill {
            border: 2px solid black;
            background-color: #000;
            color: #ffff;
            border-radius: 8px;
            padding: 4px;
            text-align: center;

        }

        .centered {
            text-align: center;
            align-content: center;
        }

        .left {
            text-align: right;
        }

        .ticket {
            width: 280px;
        }

        .text-end {
            margin-left: 56px;
        }

        .image {
            max-width: inherit;
            width: inherit;
            width: 85%;
        }


        .footer {
            text-align: center;
        }

        .row {
            display: flex;
            font-weight: 600;
        }

        @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }

        .invoice {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 1.42857143;
            color: #000 !important;
            background-color: #fff;
        }

        .barcode {
            width: 40%;
            margin-top: 10px;
        }

        .invoice-border {
            border: 2px solid #000;
            padding: 10px;
            border-radius: 10px;
        }

        .selectBoxmargin {
            margin-top: 31px
        }

        .selectBoxmargin2 {
            margin-top: 24px;
        }

        .example-table tr:nth-child(2n+1) {
            background-color: #ddd;
        }

        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
        }

        .table-outline {
            border: 2px solid rgb(38, 169, 224);
            padding: 0px;
            border-radius: 10px;
        }

        .table-head {
            background-color: rgb(38, 169, 224);
            color: #fff;
        }

        .image-size {
            width: 1.5em;
            height: 1.5em;
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini @if (Request::path() === 'admin/purchases/create' ||
        Request::path() === 'admin/sales/create' ||
        Request::path() === 'user/purchase/create' ||
        Request::path() === 'user/sale/create' ||
        Request::path() === 'user/product/create' ||
        Request::path() === 'admin/quotations/create') {{ 'sidebar-collapse' }} @endif">
    <div class="wrapper">
        @include('layouts.header')
        @include('layouts.sidebar')
        <div class="text-center">
            <h3>{{ date('l - F - Y') }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span
                    id="currentTime">{{ date('h:i:s A') }}</span></h3>
        </div>
        <div class="content-wrapper">
            <section class="content">
                <div class="dashboard">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8">
                                <!-- general form elements -->
                                <div class="box box-primary none-border">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">NEW SELL</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <form role="form">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="phonenumber">Phone Number</label>
                                                    <input type="number" class="form-control corner" id="phonenumber"
                                                        placeholder="Enter Phone Number">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="Name">Name</label>
                                                    <input type="text" class="form-control corner" id="name"
                                                        placeholder="Enter Name">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="address">Address</label>
                                                    <input type="text" class="form-control corner" id="Address"
                                                        placeholder=" Enter Address">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="Product">Product</label>
                                                    <input type="text" class="form-control corner" id="Product"
                                                        placeholder="Enter Name">
                                                </div>
                                                <div class="form-group col-md-2 selectBoxmargin">
                                                    <input type="checkbox" id="option" name="option" value="option">
                                                    <label for="option">Option</label>
                                                </div>
                                                <div class="form-group col-md-4 selectBoxmargin2" id="option_show"
                                                    style="display: none;">
                                                    <select name="option_show" id="option_show"
                                                        class="form-control select2 " style="width: 100%">
                                                        <option value="">Select
                                                            Delivery Man</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="Product">Details</label>
                                                    <div class="table-outline">
                                                        <table class="table table-striped  w-auto">
                                                            <thead class="table-head">
                                                                <tr>
                                                                    <th>S.N</th>
                                                                    <th>Product Name</th>
                                                                    <th>In Stock </th>
                                                                    <th>Unit Prices</th>
                                                                    <th>Quantity</th>
                                                                    <th>Price</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <tr class="table-info">
                                                                        <td>{{ $i }}.</td>
                                                                        <td>Pocket Sleeve Abaya</td>
                                                                        <td>125 Pcs</td>
                                                                        <td>1750.00</td>
                                                                        <td>1</td>
                                                                        <td>1750.00</td>
                                                                        <td style=" margin-bottom: 2px;">
                                                                            <img class="image-size"
                                                                                src="{{ asset('images/sales/04.png') }}"
                                                                                alt="edit" />
                                                                        </td>
                                                                    </tr>
                                                                @endfor
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="row" style="margin-top: 10px;">
                                                        <div class="col-md-10 text-right">
                                                            Total
                                                        </div>
                                                        <div class="col-md-2">9,930.00</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-10 text-right">
                                                            Vat (7.5%)
                                                        </div>
                                                        <div class="col-md-2">744.75</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-10 text-right">
                                                            Discount
                                                        </div>
                                                        <div class="col-md-2">744.75</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6"> </div>
                                                        <div class="col-md-6">
                                                            <hr
                                                                style="margin-top: 5px;
                                                             margin-bottom: 5px;
                                                            border: 0;border-top: 1px solid #000000" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-10 text-right">
                                                            Total Amount
                                                        </div>
                                                        <div class="col-md-2">744.75</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="row" style="margin-top:  20px">
                                    <div class="col-md-12 ">
                                        <h2 style="text-align: center;">Payment</h2>
                                    </div>
                                </div>
                                <hr
                                    style="margin-top: 20px;margin-bottom: 20px;border: 0;border-top: 2px solid #7c34db;" />
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="row">
                                            <div class="col-md-6 row">
                                                <div class="col-md-6">
                                                    Total Paid Amount
                                                </div>
                                                <div class="col-md-6">
                                                    10,674.75
                                                </div>
                                            </div>
                                            <div class="col-md-6 row">
                                                <div class="col-md-4">Payment Method</div>
                                                <div class="col-md-4">CASH</div>
                                                <div class="col-md-4">11,000.00</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-right text-red">Due</div>
                                            <div class="col-md-2 text-red">0.00</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-right " style="color: #eee">Discount</div>
                                            <div class="col-md-2" style="color: #eee">0.00</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 text-right text-blue">Return</div>
                                            <div class="col-md-2 text-blue">0.00</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box -->
                            <div class="col-md-4 ">
                                <!-- general form elements -->
                                <div class="box box-primary none-border">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Showing Bill</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <div class="ticket invoice invoice-font invoice-border">
                                        <div class="text-center">
                                            <img src="{{ asset(getSetting('print_logo', 'images/logoheader.png')) }}"
                                                onerror="this.src='{{ asset('ecommerce/error-img.jpg') }}'"
                                                alt="">
                                        </div>
                                        <p class="centered"><br>
                                            <strong>
                                                H # 14, Block # A, Main Road <br>
                                                Rampura, Banasree
                                            </strong>

                                        </p>
                                        <div class="row" style="margin-bottom: 7px;">
                                            <div class="col-md-9" style="font-size: 10px;">
                                                Vat Reg No# 004452563-0202
                                            </div>

                                            <div class="col-md-5" style="font-size: 11px;">
                                                Mushak-6.3
                                            </div>

                                        </div>

                                        <p class="bill">Invoice</p>
                                        <h4 class="text-center"><strong> CFF-061822001 </strong>
                                        </h4>
                                        <div class="row ">
                                            <div class="col-md-6">
                                                01708666655
                                            </div>
                                            <div class="col-md-6">
                                                21 Jun, 2022
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                Khalid Riaz
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-left">
                                                Banasree, Rampura, Dhaka-1219
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 text-left"> Delivery :</div>
                                        </div>
                                        <br>

                                        <table style="width: 250px; ">
                                            {{-- <thead>
                                                <tr>
                                                    <th class="description">Product</th>
                                                    <th class="mrp">MRP</th>
                                                    <th class="quantity">Qty</th>
                                                    <th class="price">Taka</th>
                                                </tr>
                                            </thead> --}}
                                            <tbody>
                                                @for ($x = 0; $x <= 5; $x++)
                                                    <tr
                                                        style="  border-bottom: 1px dashed black;
                                                    border-collapse: collapse;">
                                                        <td class="mrp">{{ $x }} .</td>
                                                        <td class="description">Pocket Sleeve Abaya
                                                            Red-54” X 1</td>
                                                        <td class="price"> = 1750.00</td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>

                                        <table style="width: 250px;" class="not-dashed">
                                            <thead>
                                                <tr>
                                                    <th class="mrp"><u>Cash</u></th>
                                                    <th class="description">Amount</th>
                                                    <th class="price">9,930.00</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <p>Vat (7.5%)</p>
                                                        <p>Total</p>
                                                        <p>Discount</p>
                                                        <p>Paid</p>
                                                        <p>Due</p>
                                                    </td>
                                                    <td>
                                                        <p class="left">744.75</p>
                                                        <p class="left">10,674.75</p>
                                                        <p class="left">0.75</p>
                                                        <p class="left">10,674.00</p>
                                                        <p class="left">0.00</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        {{-- <b>Return Products</b>

                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="description">Description</th>
                                                    <th class="quantity">Q.</th>
                                                    <th class="price">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @for ($x = 0; $x <= 5; $x++)
                                                    <tr>
                                                        <td class="description">Dummy</td>
                                                        <td class="quantity">100</td>
                                                        <td class="price">100</td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>


                                        <br>
                                        <table style=" margin-left: 95px;">
                                            <tbody>

                                                <tr>
                                                    <td class="description">Subtotal:</td>
                                                    <td class="quantity"></td>
                                                    <td class="price">5000</td>
                                                </tr>

                                                <tr>
                                                    <td class="description">Vat total:</td>
                                                    <td class="quantity"></td>
                                                    <td class="price">220</td>
                                                </tr>



                                                <tr>
                                                    <td class="description">Discount percent:</td>
                                                    <td class="quantity"></td>
                                                    <td class="price">15%</td>
                                                </tr>


                                                <tr>
                                                    <td class="description">Discount Amount:</td>
                                                    <td class="quantity"></td>
                                                    <td class="price">600</td>
                                                </tr>
                                                <tr>
                                                    <td class="description">Vat parcent:</td>
                                                    <td class="quantity"></td>
                                                    <td class="price">60%</td>
                                                </tr>
                                                <tr>
                                                    <td class="description">Payable Vat:</td>
                                                    <td class="quantity"></td>
                                                    <td class="price">600</td>
                                                </tr>


                                                <tr>
                                                    <td class="description">Return:</td>
                                                    <th class="quantity"></th>
                                                    <td>900</td>
                                                </tr class="price">


                                                <tr>
                                                    <td class="description">Total:</td>
                                                    <th class="quantity"></th>
                                                    <td class="price" style="white-space: nowrap;">600</td>
                                                </tr>



                                                <tr>
                                                    <td class="description">Return:</td>
                                                    <th class="quantity"></th>
                                                    <td class="price">600</td>
                                                </tr>


                                                <tr>
                                                    <td class="description">Return:</td>
                                                    <th class="quantity"></th>
                                                    <td class="price">600</td>
                                                </tr>


                                                <tr>
                                                    <td class="description">Paid:</td>
                                                    <th class="quantity"></th>
                                                    <td class="price">
                                                        600
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="description">Due:</td>
                                                    <th class="quantity"></th>
                                                    <td class="price">600</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                        <br> --}}
                                        <div class=" footer">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <img class="centered barcode mt-2"
                                                        src="{{ asset('images/barcode-306926__480.png') }}" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12"
                                                    style="    font-size: 8px;
                                                margin-top: -5px;">
                                                    <span class="centered"> www.colourful.com.bd </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span class="centered" style="font-size: 8px;">NEW SELL
                                                        CUSTOMER COPY </span>
                                                </div>
                                            </div>
                                            {{-- <span class="centered"> www.facebook.com/ColourFulIslamicWear/</span>
                                            <span class="centered"> PHONE : 01785992233 </span> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding: 30px;">
                                    <div class="col-md-6">
                                        <button id="btnPrint"
                                            class="hidden-print btn btn-warning btn-sm
                                            btn-block">Print</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button id="btnPrint"
                                            class="hidden-print btn btn-success btn-sm
                                        btn-block">Confirm
                                            Order</button>
                                    </div>
                                </div>
                                <!-- /.box -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@show
@include('layouts.footer')
</div>
@stack('js')
<script src="{{ asset('js/print.js') }}"></script>
<script>
    $('#option').change(function() {
        if (this.checked) {
            $("#option_show").show();
        } else {
            $("#option_show").hide();
        }
    });
</script>
</body>

</html>
