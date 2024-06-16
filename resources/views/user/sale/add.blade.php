

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
            <li><a href="{{route('sale.index')}}"><i class="fa fa-group"></i> sales</a></li>
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
                            <a href="{{route('sale.index')}}" class="btn btn-sm bg-purple"><i class="fa fa-list"></i> sale list</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                        @include('includes.errormessage')
                        <form action="{{route('sale.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data" id="sale-form">
                            @csrf
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="">Date</label>
                                            <input type="text" name="date" class="form-control" id="date" placeholder="sale date" required="" value="{{date('Y-m-d')}}" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="">Invoice</label>
                                            <input type="text" name="invoice" class="form-control" id="invoice" placeholder="sale invoice" value="{{date('Y-m-d-H-i-s')}}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="">User</label>
                                            <select name="user_id" id="" class="form-control select2" style="width: 100%">
                                                <option value="">Select User</option>
                                                @foreach ($users as $key => $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="radio" id="other" name="customer" value="old">
                                            <label for="other">Old Customer</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="radio" id="other2" name="customer" value="new">
                                            <label for="other2">New Customer</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="new-supplier" style="display: none;">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Name</label>
                                                <input type="text" name="name" class="form-control" id="name" placeholder="name" value="{{old('name')}}" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Phone</label>
                                                <input type="text" name="phone" class="form-control" id="phone" placeholder="phone" value="{{old('phone')}}" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="old-supplier">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Customer</label>
                                                <select name="customer_id" id="customer_id" class="form-control select2" style="width: 100%">
                                                    <option value="">Select customer</option>
                                                    @foreach ($customers as $key => $customer)
                                                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="">Note</label>
                                            <input type="text" name="note" class="form-control" placeholder="Note" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" id="false-div" style="visibility: hidden;">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="">Note</label>
                                            <input type="text" class="form-control" placeholder="Note" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group table-responsive">
                                        <table class="table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 15%;">Product code</th>
                                                    <th style="width: 20%;">Name</th>
                                                    <th style="width: 10%;">Unit</th>
                                                    <th style="width: 10%;">In stock</th>
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
                                                    
                                                    for ($i=1; $i < 11 ; $i++) { ?>
                                                <tr id="trid<?= $i; ?>" style="<?php if($i > 1) echo 'display: none'; ?>">
                                                    <td>
                                                        <input type="text" class="form-control" name="code[]" id="code<?= $i; ?>" placeholder="product code"  onfocusout="getProductDetails(<?= $i; ?>)" autocomplete="off">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="name<?= $i; ?>" placeholder="product name" autocomplete="off">
                                                        <input type="hidden" class="form-control" id="product_id<?= $i; ?>" placeholder="product name" name="product_id[]">
                                                    </td>
                                                    <td>

                                                        <select name="unit_id[]" id="unit_id<?= $i; ?>" class="form-control" style="width:100%;">
                                                            @foreach ($units as $unit)
                                                                <option value="{{$unit->id}}">{{$unit->value}}</option>
                                                                    
                                                            @endforeach
                                                        </select>

                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" id="stock<?= $i; ?>" placeholder="stock" value="0" autocomplete="off">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="quantity[]" value="1" id="quantity<?= $i; ?>" placeholder="quantity" onchange="amountShow(<?= $i; ?>)" autocomplete="off">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control" name="rate[]" value="0" id="rate<?= $i; ?>" min="0" placeholder="rate" onchange="amountShow(<?= $i; ?>)" autocomplete="off">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control" name="price[]" value="0" id="total<?= $i; ?>" min="0" placeholder="total" readonly>
                                                    </td>
                                                    <td>
                                                        <a onclick="hideSaleRow(<?= $i; ?>)" class="btn btn-sm bg-red"> <i class="fa fa-close"></i> </a>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="6" style="text-align: right; font-size: 18px; font-weight: bold; width: 80%"> Subtotal</td>
                                                    <td style="width: 10%">
                                                        <input type="text" readonly id="total_amount_id" name="subtotal" value="0">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" style="text-align: right; font-size: 18px; font-weight: bold; width: 80%"></td>
                                                    <td style="width: 10%">
                                                        <a class="btn btn-sn bg-purple" id="return-product-show" onclick="showReturnProduct()">Return Product</a>
                                                        <a class="btn btn-sn bg-purple" id="return-product-hide" onclick="hideReturnProduct()" style="display: none">Hide Return Product</a>
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
                                                    <th style="width: 25%;">Product name</th>
                                                    <th style="width: 10%;">Unit</th>
                                                    <th style="width: 10%;">Quantity</th>
                                                    <th style="width: 15%;">Price</th>
                                                    <th style="width: 15%;">Total</th>
                                                    <th style="width: 10%;">Remove</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <input type="hidden" id="returnshowrowid" value="2">
                                                <?php
                                                    // 61 is the max limit, change to javascript also from botom of the code.
                                                    
                                                    for ($j=1; $j < 11 ; $j++) { ?>
                                                <tr id="returntrid<?= $j; ?>" style="<?php if($j > 1) echo 'display: none'; ?>">
                                                    <td>
                                                        <input type="text" class="form-control" name="returncode[]" id="returncode<?= $j; ?>" placeholder="product code"  onfocusout="getReturnProductDetails(<?= $j; ?>)" autocomplete="off">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="returnname<?= $j; ?>" placeholder="product name" autocomplete="off">
                                                        <input type="hidden" class="form-control" id="returnproduct_id<?= $j; ?>" placeholder="product name" name="returnproduct_id[]">
                                                    </td>
                                                    <td>

                                                        <select name="returnunit_id[]" id="returnunit_id<?= $j; ?>" class="form-control" style="width:100%;">
                                                            @foreach ($units as $unit)
                                                                <option value="{{$unit->id}}">{{$unit->value}}</option>
                                                                    
                                                            @endforeach
                                                        </select>

                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="returnquantity[]" value="1" id="returnquantity<?= $j; ?>" placeholder="quantity" onchange="returnAmountShow(<?= $j; ?>)" autocomplete="off">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control" name="returnrate[]" value="0" id="returnrate<?= $j; ?>" min="0" placeholder="rate" onchange="returnAmountShow(<?= $j; ?>)" autocomplete="off">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control" name="returnprice[]" value="0" id="returntotal<?= $j; ?>" min="0" placeholder="total" readonly>
                                                    </td>
                                                    <td>
                                                        <a onclick="hideReturnSaleRow(<?= $j; ?>)" class="btn btn-sm bg-red"> <i class="fa fa-close"></i> </a>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="5" style="text-align: right; font-size: 18px; font-weight: bold;">Return Subtotal</td>
                                                    <td>
                                                        <input type="text" readonly id="returntotal_amount_id" name="returnsubtotal" value="0">
                                                    </td>
                                                    <td>
                                                        <a onclick="makereturnrowvisible()" class="btn btn-sm bg-teal"> <i class="fa fa-plus"></i></a>
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
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Cost name</label>
                                                <input type="text" name="extra_cost_name" class="form-control" placeholder="Cost name" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Cost Amount</label>
                                                <input type="text" name="extra_cost" class="form-control" id="extra_cost" placeholder="Cost Amount" value="0" onkeyup="amountShow();" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="" style="margin-left: 15px;">Vat</label>
                                                <br>
                                                <div class="col-md-4">
                                                    <input type="text" name="vat_percentage" class="form-control" id="vat_percentage" placeholder="Vat" value="0" onkeyup="amountShow();" autocomplete="off">
                                                </div>
                                                <div class="col-md-2" style="border: 1px solid white; padding: 5px; text-align: center;">%</div>
                                                <div class="col-md-6">
                                                    <input type="text" name="vat" class="form-control" id="vat" placeholder="Vat" value="0" readonly="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Discount</label>
                                                <input type="text" name="discount" class="form-control" id="discount" placeholder="Discount" value="0" autocomplete="off" onkeyup="amountShow();">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Total</label>
                                                <input type="text" name="total" class="form-control" id="net_total" placeholder="Total" value="0" required="" readonly="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Cash</label>
                                                <input type="text" name="cash" class="form-control" id="cash" placeholder="Cash" value="0" required="" onkeyup="amountShow();"autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Payment Method</label>
                                                <select name="payment_method" class="form-control" id="">
                                                    <option value="0">Select Method</option>
                                                    <option value="2">Bank</option>
                                                    <option value="3">Bkash</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Bank name</label>
                                                <input type="text" name="bank_name" class="form-control" placeholder="Bank name" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Paid</label>
                                                <input type="text" name="paid" class="form-control" id="paid" placeholder="Paid" value="0" required="" onkeyup="amountShow();" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Due</label>
                                                <input type="text" name="due" class="form-control" id="due" placeholder="Due" value="0" required="" readonly="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm bg-red">Reset</button>
                                    <!--<button type="button" class="btn btn-sm btn-6a8d9d" onclick="$('#sale-form').submit(); $('#sale-form')[0].reset(); ">Save</button>-->
                                    <button type="button" class="btn btn-sm btn-6a8d9d" onclick="saveSale(); ">Save</button>
                                    
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
            autoclose:   true,
            changeYear:  true,
            changeMonth: true,
            dateFormat:  "dd-mm-yy",
            yearRange:   "-10:+10"
        });
    
        $("input[name$='customer']").click(function() {
            var test = $(this).val();
    
            if(test == 'new') {
              $("#old-supplier").hide();
              $("#false-div").hide();
              $("#new-supplier").show();
            } else {
              $("#old-supplier").show();
              $("#new-supplier").hide(); 
              $("#false-div").show();
            }
    
        });
    });
    
    function makerowvisible(){
        
        var nextrownumber = $("#showrowid").val();
        $("#trid"+Number(nextrownumber)).show();
        $("#showrowid").val(Number(nextrownumber)+1);
    }
    
    function getProductDetails(id) {
    
        var productCode = $('#code' + id).val();
    
        var url = '{{route("add.cart")}}';
    
        $.ajaxSetup({
    
            headers: {'X-CSRF-Token' : '{{csrf_token()}}'}
    
        });
    
        $.ajax({
    
            url: url,
            method: 'POST',
            data: { 'productCode' : productCode, },
    
            success: function(data2){
    
                var data = JSON.parse(data2);
                var quantity = $('#quantity' + id).val();
    
                var total = data.product.sell_price * quantity;
    
                $('#name' + id).val(data.product.name);
                $('#product_id' + id).val(data.product.id);
                $('#rate' + id).val(data.product.sell_price);
                $('#unit_id' + id).val(data.product.unit_id);
                $('#total' + id).val(total);
                $('#stock' + id).val(data.available);
    
                var total_amount = 0;
    
                // same as php for loop from up.
    
                for(var i = 1; i < 11; i++){
    
                    var tempamount = $('#total'+i).val(); 
                    total_amount+= Number(tempamount);
                }
    
                $('#total_amount_id').val(total_amount);
    
                var return_total = $('#returntotal_amount_id').val();
                var net_amount = parseInt(total_amount) - parseInt(return_total);
    
    
                $('#net_total').val(net_amount);
                $('#due').val(net_amount);
                
            },
    
            error: function(error) {
    
                console.log(error);
            }
    
    
        });
    }
    
    function amountShow(id) {
    
        var quantity = $('#quantity' + id).val();
        var rate     = $('#rate' + id).val();
        var total    = quantity * rate ;
    
        $('#total' + id).val(total);
    
        var total_amount = 0;
    
        // same as php for loop from up.
    
        for(var i = 1; i < 11; i++){
    
            var tempamount = $('#total'+i).val(); 
            total_amount+= Number(tempamount);
        }
    
        $('#total_amount_id').val(total_amount);
    
        var extra_cost     = $('#extra_cost').val();
        var vat_percentage = $('#vat_percentage').val();
        var vat            = (parseInt(total_amount) * parseInt(vat_percentage)) / 100;
        $('#vat').val(vat);
    
        var discount       = $('#discount').val();
    
        var return_total = $('#returntotal_amount_id').val();
    
        var net_total = (parseInt(total_amount) + parseInt(vat) + parseInt(extra_cost)) - (parseInt(discount) + parseInt(return_total));
    
        $('#net_total').val(net_total);
    
        var paid       = $('#paid').val();
        var cash       = $('#cash').val();
        var due       = parseInt(net_total) - parseInt(paid) - parseInt(cash);
    
        $('#due').val(due);
    }
    
    function getReturnProductDetails(id) {
        
        var productCode = $('#returncode' + id).val();
    
        var url = '{{route("add.cart")}}';
    
        $.ajaxSetup({
    
            headers: {'X-CSRF-Token' : '{{csrf_token()}}'}
    
        });
    
        $.ajax({
    
            url: url,
            method: 'POST',
            data: { 'productCode' : productCode, },
    
            success: function(data2){

                var data = JSON.parse(data2);

                var quantity = $('#returnquantity' + id).val();
    
                var total = data.product.sell_price * quantity;
    
                $('#returnname' + id).val(data.product.name);
                $('#returnproduct_id' + id).val(data.product.id);
                $('#returnrate' + id).val(data.product.sell_price);
                $('#returnunit_id' + id).val(data.product.unit_id);
                $('#returntotal' + id).val(total);
    
                var returntotal_amount = 0;

                // same as php for loop from up.

                for(var j = 1; j < 11; j++){

                    var returntempamount = $('#returntotal'+j).val(); 
                    returntotal_amount+= Number(returntempamount);
                }

                $('#returntotal_amount_id').val(returntotal_amount);

                var totalAmount = $('#total_amount_id').val(); 

                var net_amount = parseInt(totalAmount) - parseInt(returntotal_amount);

                $('#net_total').val(net_amount);
                $('#due').val(net_amount);
            },
    
            error: function(error) {
    
                console.log(error);
            }
    
    
        });
    }
    
    function returnAmountShow(id) {
    
        var quantity = $('#returnquantity' + id).val();
        var rate     = $('#returnrate' + id).val();
        var total    = quantity * rate ;
    
        $('#returntotal' + id).val(total);
    
        var returntotal_amount = 0;
    
        // same as php for loop from up.
    
        for(var j = 1; j < 11; j++){
    
            var returntempamount = $('#returntotal'+j).val(); 
            returntotal_amount+= Number(returntempamount);
        }
    
        $('#returntotal_amount_id').val(returntotal_amount);
        
        var total_amount   = $('#total_amount_id').val();
        var extra_cost     = $('#extra_cost').val();
        var vat_percentage = $('#vat_percentage').val();
        var vat            = (parseInt(total_amount) * parseInt(vat_percentage)) / 100;
        $('#vat').val(vat);
    
        var discount       = $('#discount').val();
    
        var return_total   = returntotal_amount;
    
        var net_total = (parseInt(total_amount) + parseInt(vat) + parseInt(extra_cost)) - (parseInt(discount) + parseInt(return_total));
    
        $('#net_total').val(net_total);
    
        var paid       = $('#paid').val();
        var cash       = $('#cash').val();
        var due       = parseInt(net_total) - parseInt(paid) - parseInt(cash);
    
        $('#due').val(due);
    
    }
    
    $(document).keypress(function(event){
    
        var keycode = (event.keyCode ? event.keyCode : event.which);
    
        if(keycode == '13') {
    
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
    
    function makereturnrowvisible(){
        
        var returnnextrownumber = $("#returnshowrowid").val();
        $("#returntrid"+Number(returnnextrownumber)).show();
        $("#returnshowrowid").val(Number(returnnextrownumber)+1);
    }
    
    function hideSaleRow(id) {
        
         $("#trid"+id).hide();
         $('#quantity' + id).val('0');
         $('#rate' + id).val('0');
         $('#total' + id).val('0');
         $('#unit_id' + id).val('0');
         amountShow(id);
    }
    
    function hideReturnSaleRow(id) {
    
        $("#returntrid"+id).hide();
        $('#returnquantity' + id).val('0');
        $('#returnrate' + id).val('0');
        $('#returntotal' + id).val('0');
        $('#returnunit_id' + id).val('0');
        returnAmountShow(id);
    
    }
    
    function saveSale() {

        let due = $('#due').val();

        if (due > 0 && $('#other2').prop("checked") == false && $('#other').prop("checked") == false) {

            alert('You need to Select Old Or New Customer!');
            
        }else if (due > 0 && $('#other2').prop("checked")) {

            let name = $('#name').val();
            let phone = $('#phone').val();

            if (name == '' || phone == '') {

                alert('You need to give New Customer Phone And Name!');

            } else{
                $('#sale-form').submit();
            }
            
        } else if (due > 0 && $('#other').prop("checked")) {

            let customer = $('#customer_id').val();

            if (customer == '') {

                alert('You need to Select Customer');
            } else{
                $('#sale-form').submit();
            }
            
        }  else {
            
        $('#sale-form').submit();

        }
    }
    
    
</script>
@endsection

