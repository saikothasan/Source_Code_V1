@extends('layouts.app')
@section('title', 'New sale add')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Dashboard

                @php
                    if (((int) date('H')) >= 19) {
                        echo '
                                                                                                                                                                                                                        <marquee> <b>কম্পিউটার বন্ধের পূর্বে আজকের হিসাব মিলিয়ে নিন! </b></marquee>
                                                                                                                                                                                    ';
                    }
                @endphp
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('sales.index') }}"><i class="fa fa-group"></i> sales</a></li>
                <li class="active">New sale</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <!-- Content Header (sale header) -->
                    <div class="box box-6a8d9d box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">New sale</h3>
                            <div class="box-tools pull-right">
                                <a href="{{ route('sales.index') }}" class="btn btn-sm bg-purple"><i
                                        class="fa fa-list"></i> sale list</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <br>
                            @include('includes.errormessage')
                            <form action="{{ route('sales.store') }}" method="POST" class="form-horizontal"
                                  enctype="multipart/form-data" id="sale-form">
                                @csrf
                                <div class="col-md-9">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Date</label>
                                                <input type="text" name="date" class="form-control" id="date"
                                                       placeholder="sale date" required="" value="{{ date('d-m-Y') }}"
                                                       autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Invoice</label>
                                                <input type="text" readonly name="invoice" class="form-control" id="invoice"
                                                       placeholder="sale invoice" value="{{$invoiceCode}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">User</label>
                                                <input type="hidden" name="user_id" class="form-control" id="invoice"
                                                       placeholder="sale invoice" value="{{ auth()->user()->id }}">
                                                <input type="text" readonly name="" class="form-control" id="invoice"
                                                       placeholder="sale invoice" value="{{ auth()->user()->name }}">


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input type="radio" id="other" name="customer" value="old">
                                                    <label for="other">Old Customer</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input type="radio" id="other2" name="customer" value="new">
                                                    <label for="other2">New Customer</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="deliveryman" name="deliveryman"
                                                           value="deliveryman">
                                                    <label for="deliveryman">Delivery Man</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="col-md-4" id="delivery_man_show" style="display: none;">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <select name="delivery_id" id="delivery_id"
                                                                onchange="getDeliveryCharge()"
                                                                class="form-control select2"
                                                                style="width: 100%">
                                                            <option value="">Select Delivery Man</option>
                                                            @foreach ($deliveryMans as $key => $deliveryMan)
                                                                <option value="{{ $deliveryMan->id }}">
                                                                    {{ $deliveryMan->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="new-supplier">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Name</label>
                                                    <input type="text" name="name" class="form-control" id="name"
                                                           placeholder="Name" value="{{ old('name') }}"
                                                           autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Phone</label>
                                                    <input type="text" name="phone" class="form-control" id="phone"
                                                           placeholder="Phone" value="{{ old('phone') }}"
                                                           autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="old-supplier" style="display: none;">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Customer</label>
                                                    <select name="customer_id" id="customer_id"
                                                            class="form-control select2"
                                                            style="width: 100%">
                                                        <option value="">Select customer</option>
                                                        @foreach ($customers as $key => $customer)
                                                            <option value="{{ $customer->id }}">{{$customer->phone}} ({{ $customer->name }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Address</label>
                                                <input type="text" name="address" class="form-control"
                                                       placeholder="Address"
                                                       autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="false-div" style="visibility: hidden;">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Address</label>
                                                <input type="text" name="address" class="form-control"
                                                       placeholder="Address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group table-responsive">
                                            <table class="table" style="width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th style="width: 15%;">Product code</th>
                                                    <th style="width: 30%;">Name</th>
                                                    <th style="width: 10%;">In stock</th>
                                                    <th style="width: 10%;white-space: nowrap;">Product Size</th>
                                                    <th style="width: 10%;">Quantity</th>
                                                    <th style="width: 15%;">Price</th>
                                                    <th style="width: 10%;">Total</th>
                                                    <th style="width: 10%;">Remove</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <input type="hidden" name="showrowid" id="showrowid" value="2">
                                                <?php
                                                // 61 is the max limit, change to javascript also from botom of the code.

                                                for ($i = 1; $i < 11 ; $i++) { ?>
                                                <tr id="trid<?= $i ?>" style="<?php if ($i > 1) {
                                                        echo 'display: none';
                                                    } ?>">
                                                    <td>
                                                        <input type="text" class="form-control" name="code[]"
                                                               id="code<?= $i ?>" placeholder="Product code"
                                                               onkeyup="debounce(<?= $i ?>)"
                                                               autocomplete="off">
                                                    </td>
                                                    <td>

                                                        <select name="product_id[]" id="product_id<?= $i ?>"
                                                                class="form-control select2" style="width: 100%"
                                                                onchange="getProductDetailsById(<?= $i ?>)">
                                                            <option value="">Select Product</option>
                                                            @foreach ($products as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->name }}</option>
                                                            @endforeach

                                                        </select>

                                                    </td>
                                                    <input type="hidden" step="0.01" class="form-control"
                                                           name="supplier_id[]" value="0" id="supplier_id<?= $i ?>">
                                                    <td>
                                                        <input readonly type="text" class="form-control text-center"
                                                               id="stock<?= $i ?>"
                                                               placeholder="stock" value="0" autocomplete="off">
                                                    </td>

                                                    <td>
                                                        <input type="text" class="form-control text-center text-center" id="size<?= $i ?>"
                                                               placeholder="size" value="size" autocomplete="off"
                                                               readonly>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="quantity[]"
                                                               value="1" id="quantity<?= $i ?>" placeholder="quantity"
                                                               onchange="amountShow(<?= $i ?>)" autocomplete="off">
                                                    </td>
                                                    <td>
                                                        <input type="text" step="0.01" class="form-control text-center"
                                                               name="rate[]" value="0" id="rate<?= $i ?>" min="0"
                                                               placeholder="rate" onchange="amountShow(<?= $i ?>)"
                                                               autocomplete="off" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="number"  step="0.01" class="form-control text-center"
                                                               name="price[]" value="0" id="total<?= $i ?>" min="0"
                                                               placeholder="total" readonly>
                                                    </td>
                                                    <td>
                                                        <a onclick="makerowvisible(<?= $i ?>)" style="width: 31px;display: flex;" class="visible-xs visible-sm btn btn-success">
                                                            <i class="fa fa-plus"></i> </a>
                                                        <a onclick="hideSaleRow(<?= $i ?>)" class="btn btn-sm bg-red">
                                                            <i class="fa fa-close"></i> </a>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="6"
                                                        style="text-align: right; font-size: 18px; font-weight: bold; width: 80%">
                                                        Subtotal
                                                    </td>
                                                    <td style="width: 10%">
                                                        <input type="text" readonly id="total_amount_id"
                                                               class="form-control" name="subtotal" value="0">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"
                                                        style="text-align: right; font-size: 18px; font-weight: bold; width: 80%">
                                                    </td>
                                                    <td style="width: 10%">
                                                        <a class="btn btn-sn bg-purple" id="return-product-show"
                                                           onclick="showReturnProduct()">Return Product</a>
                                                        <a class="btn btn-sn bg-purple" id="return-product-hide"
                                                           onclick="hideReturnProduct()" style="display: none">Hide
                                                            Return Product</a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="return-product" style="display:none">
                                        <div class="form-group table-responsive">
                                            <table class="table" style="width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th style="width: 15%;">Product code</th>
                                                    <th style="width: 30%;">Product name</th>
                                                    <th style="width: 15%;">Quantity</th>
                                                    <th style="width: 15%;">Price</th>
                                                    <th style="width: 15%;">Total</th>
                                                    <th style="width: 10%;">Remove</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <input type="hidden" id="returnshowrowid" value="2">
                                                <?php
                                                // 61 is the max limit, change to javascript also from botom of the code.

                                                for ($j = 1; $j < 11 ; $j++) { ?>
                                                <tr id="returntrid<?= $j ?>" style="<?php if ($j > 1) {
                                                        echo 'display: none';
                                                    } ?>">
                                                    <td>
                                                        <input type="text" class="form-control" name="returncode[]"
                                                               id="returncode<?= $j ?>" placeholder="product code"
                                                               onfocusout="getReturnProductDetails(<?= $j ?>)"
                                                               autocomplete="off">
                                                    </td>
                                                    <td>

                                                        <select name="returnproduct_id[]" id="returnproduct_id<?= $j ?>"
                                                                class="form-control select2" style="width: 100%"
                                                                onchange="getProductDetailById(<?= $j ?>)">
                                                            <option value="">Select Product</option>
                                                            @foreach ($products as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->name }}</option>
                                                            @endforeach

                                                        </select>

                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control"
                                                               name="returnquantity[]" value="1"
                                                               id="returnquantity<?= $j ?>" placeholder="quantity"
                                                               onchange="returnAmountShow(<?= $j ?>)"
                                                               autocomplete="off">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control"
                                                               name="returnrate[]" value="0" id="returnrate<?= $j ?>"
                                                               min="0" placeholder="rate"
                                                               onchange="returnAmountShow(<?= $j ?>)"
                                                               autocomplete="off">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control"
                                                               name="returnprice[]" value="0" id="returntotal<?= $j ?>"
                                                               min="0" placeholder="total" readonly>
                                                    </td>
                                                    <td>
                                                        <a onclick="hideReturnSaleRow(<?= $j ?>)"
                                                           class="btn btn-sm bg-red"> <i class="fa fa-close"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="4"
                                                        style="text-align: right; font-size: 18px; font-weight: bold;">
                                                        Return Subtotal
                                                    </td>
                                                    <td>
                                                        <input type="text" readonly id="returntotal_amount_id"
                                                               name="returnsubtotal" class="form-control" value="0">
                                                    </td>
                                                    <td>
                                                        <a onclick="makereturnrowvisible()" class="btn btn-sm bg-teal">
                                                            <i class="fa fa-plus"></i></a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="box box-primary box-solid">
                                        <div class="box-body box-profile">
                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <div class="col-md-12">--}}
                                            {{--                                                    <label for="">Cost name</label>--}}
                                            {{--                                                    <input type="text" name="extra_cost_name" class="form-control"--}}
                                            {{--                                                        placeholder="Cost name" autocomplete="off">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <div class="col-md-12">--}}
                                            {{--                                                    <label for="">Cost Amount</label>--}}
                                            {{--                                                    <input type="text" name="extra_cost" class="form-control"--}}
                                            {{--                                                        id="extra_cost" placeholder="Cost Amount" value="0"--}}
                                            {{--                                                        onkeyup="amountShow();" autocomplete="off">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="" style="margin-left: 15px;">Vat</label>
                                                    <br>
                                                    <div class="col-md-4">
                                                        <input type="text" name="vat_percentage" class="form-control"
                                                               id="vat_percentage" placeholder="Vat" value="0"
                                                               onkeyup="amountShow();" autocomplete="off">
                                                    </div>
                                                    <div class="col-md-2"
                                                         style="border: 1px solid white; padding: 5px; text-align: center;">
                                                        %
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="vat" class="form-control" id="vat"
                                                               placeholder="Vat" value="0" readonly="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="" style="margin-left: 15px;">Discount</label>
                                                    <br>
                                                    <div class="col-md-4">
                                                        <input type="text" name="discount_percentage"
                                                               class="form-control" id="discount_percentage"
                                                               placeholder="Discount" value="0" onkeyup="amountShow();"
                                                               autocomplete="off">
                                                    </div>
                                                    <div class="col-md-2"
                                                         style="border: 1px solid white; padding: 5px; text-align: center;">
                                                        %
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="discount" class="form-control"
                                                               id="discount" placeholder="Discount" value="0"
                                                               readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Discount</label>
                                                <input type="" name="discount" class="form-control" id="discount" placeholder="Discount" value="0" readonly="" autocomplete="off" onkeyup="amountShow();">
                                            </div>
                                        </div> --}}
                                            <div class="form-group" id="delivery_charge_show" style="display: none">
                                                <div class="col-md-12">
                                                    <label for="">Delivery Charge</label>
                                                    <input type="text" name="delivery_charge" class="form-control"
                                                           id="delivery_charge" placeholder="Delivery Charge" value="0"
                                                           required="" readonly="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Total</label>
                                                    <input type="text" name="total" class="form-control" id="net_total"
                                                           placeholder="Total" value="0" required="" readonly="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Payment Method</label>
                                                    <select name="payment_method" onchange="handlePaymentMethod()"
                                                            class="form-control" id="payment_method">
                                                        @foreach($paymentMethod as $key => $value)
                                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group" id="reference">
                                                <div class="col-md-12">
                                                    <label for="">Reference</label>
                                                    <input type="text" name="reference_code" class="form-control"
                                                           id="reference_code"
                                                           placeholder="Reference"  required="required"
                                                           autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Paid</label>
                                                    <input type="text" name="paid" class="form-control" id="paid"
                                                           placeholder="Paid" value="0" required=""
                                                           onkeyup="amountShow();"
                                                           autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label for="">Due</label>
                                                    <input type="text" name="due" class="form-control" id="due"
                                                           placeholder="Due" value="0" required="" readonly="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <center>
                                        <button type="reset" class="btn btn-sm bg-red">Reset</button>
                                        <!--<button type="button" class="btn btn-sm btn-6a8d9d" onclick="$('#sale-form').submit(); $('#sale-form')[0].reset(); ">Save</button>-->
                                        <button type="button" class="btn btn-sm btn-success"
                                                onclick="saveSale(); ">Order Confirm
                                        </button>
                                        <button type="button" class="btn btn-sm btn-6a8d9d">Temp</button>

                                    </center>
                                </div>
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerSection')
    <script>
        $(function () {
            $('#date').datepicker({
                autoclose: true,
                changeYear: true,
                changeMonth: true,
                dateFormat: "dd-mm-yy",
                yearRange: "-10:+10"
            });

            $("input[name$='customer']").click(function () {
                var test = $(this).val();
                if (test == 'new') {
                    $("#old-supplier").hide();
                    $("#false-div").hide();
                    $("#new-supplier").show();
                } else {
                    $("#old-supplier").show();
                    $("#new-supplier").hide();
                    $("#false-div").show();
                }

            });

            $('#deliveryman').change(function () {
                if (this.checked) {
                    $("#delivery_man_show").show();
                } else {
                    $("#delivery_man_show").hide();
                    $("#delivery_charge_show").hide();
                    let delivery_id = $('#delivery_id').val(0);
                    let delivery_charge = $("#delivery_charge").val();
                    let net_total = $('#net_total').val();
                    let total = parseFloat(net_total) - parseFloat(delivery_charge);
                    $('#net_total').val(total);
                    $("#delivery_charge").val(0);
                    $("#delivery_id").val('');
                }
            });
            handlePaymentMethod();

        });

        function getDeliveryCharge() {
            let delivery_id = $('#delivery_id').val();
            let delivery_charge = $("#delivery_charge").val();
            if (delivery_charge > 0) {
                let net_total = $('#net_total').val();
                let total = parseFloat(net_total) - parseFloat(delivery_charge);
                $('#net_total').val(total);
            }
            let url = '{{ route('delivery.charge') }}';
            $.ajaxSetup({

                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}'
                }

            });

            $.ajax({

                url: url,
                method: 'GET',
                data: {
                    'delivery_id': delivery_id,
                },
                success: function (data) {
                    $("#delivery_charge_show").show();
                    if (data.delivery_charge) {
                        $("#delivery_charge").val(data.delivery_charge);
                        let net_total = $('#net_total').val();
                        let total = parseFloat(net_total) + parseFloat(data.delivery_charge);
                        $('#net_total').val(total);
                    }

                },

                error: function (error) {

                    console.log(error);
                }


            });
        }

        function handlePaymentMethod() {
            let paymentMethod = {!! json_encode($paymentMethod) !!};
            let payment_method_id = $("#payment_method").val();
            let find = paymentMethod.find(element => element.id == payment_method_id);
            if (find && find.reference_status != 0) {
                $("#reference").show();
            } else {
                $("#reference").hide();
            }
        }


        function makerowvisible() {

            var nextrownumber = $("#showrowid").val();
            $("#trid" + Number(nextrownumber)).show();
            $("#showrowid").val(Number(nextrownumber) + 1);
        }
        var timer;
        function debounce(id) {
            clearTimeout(timer);
            timer = setTimeout(function() {
                getProductDetails(id)
            }, 250);
        }
        function getProductDetails(id) {

            var productCode = $('#code' + id).val();

            var url = '{{ route('add.cart') }}';

            $.ajaxSetup({

                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}'
                }

            });

            $.ajax({

                url: url,
                method: 'POST',
                data: {
                    'productCode': productCode,
                },

                success: function (data2) {

                    var data = JSON.parse(data2);
                    var quantity = $('#quantity' + id).val();

                    var total = data.product.sell_price * quantity;

                    $('#name' + id).val(data.product.name);
                    $('#product_id' + id).val(data.product.id);
                    $('#rate' + id).val(data.product.sell_price);
                    $('#total' + id).val(total);
                    $('#stock' + id).val(data.available);
                    $('#product_id' + id).trigger('change');

                    var total_amount = 0;

                    // same as php for loop from up.

                    for (var i = 1; i < 11; i++) {

                        var tempamount = $('#total' + i).val();
                        total_amount += Number(tempamount);
                    }

                    $('#total_amount_id').val(total_amount);

                    var return_total = $('#returntotal_amount_id').val();
                    var net_amount = parseFloat(total_amount) - parseFloat(return_total);


                    $('#net_total').val(net_amount);
                    $('#due').val(net_amount);

                    amountShow();
                    let focusId = parseInt(id) +1;

                    if (productCode) {
                        makerowvisible();
                    }

                    $('#code' + focusId).focus();

                },

                error: function (error) {

                    console.log(error);
                }


            });
        }

        function amountShow(id) {

            var quantity = $('#quantity' + id).val();
            var rate = $('#rate' + id).val();
            var total = quantity * rate;

            $('#total' + id).val(total);

            var total_amount = 0;

            // same as php for loop from up.

            for (var i = 1; i < 11; i++) {

                var tempamount = $('#total' + i).val();
                total_amount += Number(tempamount);
            }

            $('#total_amount_id').val(total_amount);

            // var extra_cost = $('#extra_cost').val();

            var vat_percentage = $('#vat_percentage').val();
            var vat = (parseFloat(total_amount) * parseFloat(vat_percentage)) / 100;
            $('#vat').val(vat);


            //discount percentage wise added
            let discount_percentage = $('#discount_percentage').val();
            let discount = (parseFloat(total_amount) * parseFloat(discount_percentage)) / 100;
            $('#discount').val(discount);

            // var discount       = $('#discount').val();


            var return_total = $('#returntotal_amount_id').val();
            let delivery_charge = $("#delivery_charge").val() ?? 0;
            var net_total = (parseFloat(total_amount) + parseFloat(delivery_charge) + parseFloat(vat)) - (parseFloat(discount) +
                parseFloat(return_total));
            // var net_total = (parseFloat(total_amount) + parseFloat(extra_cost)) - (parseFloat(discount) + parseFloat(return_total));
            $('#net_total').val(net_total);

            var paid = $('#paid').val();
            // var cash = $('#cash').val();
            var due = parseFloat(net_total) - parseFloat(paid);

            $('#due').val(due);
        }

        function getProductDetailsById(id) {

            var productid = $('#product_id' + id).val();


            var url = '{{ route('get.product') }}';

            $.ajaxSetup({

                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}'
                }

            });

            $.ajax({

                url: url,
                method: 'POST',
                data: {
                    'productid': productid,
                },

                success: function (data2) {

                    var data = JSON.parse(data2);
                    var quantity = $('#quantity' + id).val();

                    var total = data.product.sell_price * quantity;

                    $('#name' + id).val(data.product.name);
                    $('#code' + id).val(data.product.product_code);
                    $('#rate' + id).val(data.product.sell_price);
                    $('#total' + id).val(total);
                    $('#stock' + id).val(data.available);
                    $('#size' + id).val(data.size);
                    $('#supplier_id' + id).val(data.supplier_id);

                    var total_amount = 0;

                    // same as php for loop from up.

                    for (var i = 1; i < 11; i++) {

                        var tempamount = $('#total' + i).val();
                        total_amount += Number(tempamount);
                    }

                    $('#total_amount_id').val(total_amount);
                    $('#net_total').val(total_amount);
                    $('#due').val(total_amount);
                    amountShow();
                },

                error: function (error) {

                    console.log(error);
                }


            });
        }

        function getReturnProductDetails(id) {

            var productCode = $('#returncode' + id).val();

            var url = '{{ route('add.cart') }}';

            $.ajaxSetup({

                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}'
                }

            });

            $.ajax({

                url: url,
                method: 'POST',
                data: {
                    'productCode': productCode,
                },

                success: function (data2) {

                    var data = JSON.parse(data2);

                    var quantity = $('#returnquantity' + id).val();

                    var total = data.product.sell_price * quantity;

                    $('#returnname' + id).val(data.product.name);
                    $('#returnproduct_id' + id).val(data.product.id);
                    $('#returnrate' + id).val(data.product.sell_price);
                    $('#returntotal' + id).val(total);
                    $('#returnproduct_id' + id).trigger('change');

                    //var returntotal_amount = 0;

                    // same as php for loop from up.

                    // for(var j = 1; j < 11; j++){

                    //     var returntempamount = $('#returntotal'+j).val();
                    //     returntotal_amount+= Number(returntempamount);
                    // }

                    //$('#returntotal_amount_id').val(returntotal_amount);

                    // var return_amount = $('#returntotal_amount_id').val();

                    // alert(return_amount);

                    // var totalAmount = $('#total_amount_id').val();

                    // var net_amount = parseFloat(totalAmount) - parseFloat(returntotal_amount);

                    // $('#net_total').val(net_amount);
                    // $('#due').val(net_amount);
                },

                error: function (error) {

                    console.log(error);
                }


            });
        }

        function getProductDetailById(id) {

            var productid = $('#returnproduct_id' + id).val();


            var url = '{{ route('get.product') }}';

            $.ajaxSetup({

                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}'
                }

            });

            $.ajax({

                url: url,
                method: 'POST',
                data: {
                    'productid': productid,
                },

                success: function (data2) {

                    //alert(data2);

                    var data = JSON.parse(data2);
                    var quantity = $('#returnquantity' + id).val();

                    var total = data.product.sell_price * quantity;

                    $('#returncode' + id).val(data.product.product_code);
                    $('#returnproduct_id' + id).val(data.product.id);
                    $('#returnrate' + id).val(data.product.sell_price);
                    $('#returntotal' + id).val(total);

                    var returntotal_amount = 0;

                    // same as php for loop from up.

                    for (var j = 1; j < 11; j++) {

                        var tempamount = $('#returntotal' + j).val();
                        returntotal_amount += Number(tempamount);
                    }

                    $('#returntotal_amount_id').val(returntotal_amount);

                    var totalAmount = $('#total_amount_id').val();

                    var net_amount = parseFloat(totalAmount) - parseFloat(returntotal_amount);

                    $('#net_total').val(net_amount);
                    $('#due').val(net_amount);
                },

                error: function (error) {

                    console.log(error);
                }


            });
        }

        function returnAmountShow(id) {

            var quantity = $('#returnquantity' + id).val();
            var rate = $('#returnrate' + id).val();
            var total = quantity * rate;

            $('#returntotal' + id).val(total);

            var returntotal_amount = 0;

            // same as php for loop from up.

            for (var j = 1; j < 11; j++) {

                var returntempamount = $('#returntotal' + j).val();
                returntotal_amount += Number(returntempamount);
            }

            $('#returntotal_amount_id').val(returntotal_amount);

            var total_amount = $('#total_amount_id').val();
            // var extra_cost = $('#extra_cost').val();
            // var vat_percentage = $('#vat_percentage').val();
            // var vat            = (parseFloat(total_amount) * parseFloat(vat_percentage)) / 100;
            // $('#vat').val(vat);

            var discount = $('#discount').val();

            var return_total = returntotal_amount;

            //var net_total = (parseFloat(total_amount) + parseFloat(vat) + parseFloat(extra_cost)) - (parseFloat(discount) + parseFloat(return_total));
            var net_total = (parseFloat(total_amount)) - (parseFloat(discount) + parseFloat(
                return_total));

            $('#net_total').val(net_total);

            var paid = $('#paid').val();
            // var cash = $('#cash').val();
            var due = parseFloat(net_total) - parseFloat(paid);

            $('#due').val(due);

        }

        $(document).keypress(function (event) {

            var keycode = (event.keyCode ? event.keyCode : event.which);

            if (keycode == '13') {

                makerowvisible();
            }
        });

        // return product code start

        function showReturnProduct() {

            $('#return-product-show').hide();
            $('#return-product-hide').show();
            $('#return-product').show();
        }

        function hideReturnProduct() {

            $('#return-product-show').show();
            $('#return-product-hide').hide();
            $('#return-product').hide();
        }

        function makereturnrowvisible() {

            var returnnextrownumber = $("#returnshowrowid").val();
            $("#returntrid" + Number(returnnextrownumber)).show();
            $("#returnshowrowid").val(Number(returnnextrownumber) + 1);
        }
        function hideSaleRow(id) {

            $("#trid" + id).hide();
            $('#quantity' + id).val('0');
            $('#rate' + id).val('0');
            $('#total' + id).val('0');
            amountShow(id);
        }

        function hideReturnSaleRow(id) {

            $("#returntrid" + id).hide();
            $('#returnquantity' + id).val('0');
            $('#returnrate' + id).val('0');
            $('#returntotal' + id).val('0');
            returnAmountShow(id);

        }

        function saveSale() {

            let due = $('#due').val();

            if (due > 0 && $('#other2').prop("checked") == false && $('#other').prop("checked") == false) {

                alert('You need to Select Old Or New Customer!');

            } else if (due > 0 && $('#other2').prop("checked")) {

                let name = $('#name').val();
                let phone = $('#phone').val();

                if (name == '' || phone == '') {

                    alert('You need to give New Customer Phone And Name!');

                } else {

                    $('#sale-form').submit();
                }

            } else if (due > 0 && $('#other').prop("checked")) {

                let customer = $('#customer_id').val();

                if (customer == '') {

                    alert('You need to Select Customer');

                } else {

                    $('#sale-form').submit();
                }

            } else {

                $('#sale-form').submit();

            }
        }
    </script>
@endsection
