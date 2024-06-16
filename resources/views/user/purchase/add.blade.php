@extends('layouts.app')
@section('title', 'New purchase add')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('purchase.index')}}"><i class="fa fa-group"></i> Purchases</a></li>
            <li class="active">New purchase</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (purchase header) -->
                <div class="box box-purple box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">New purchase</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('purchase.index')}}" class="btn btn-sm bg-green"><i class="fa fa-list"></i> purchase list</a>
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                    	@include('includes.errormessage')
                    	<form action="{{route('purchase.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data" id="purchase-form">
                    		@csrf
                            <div class="col-md-9">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="">Date</label>
                                            <input type="text" name="date" class="form-control" id="date" placeholder="purchase date" required="" value="{{date('d-m-Y')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="">Invoice</label>
                                            <input type="text" name="invoice" class="form-control" id="invoice" placeholder="purchase invoice" value="{{date('Y-m-d-H-i-s')}}">
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
                                            <input type="radio" id="other" name="supplier" value="old" checked="">
                                            <label for="other">Old Supplier</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">

                                            <input type="radio" id="other2" name="supplier" value="new">
                                            <label for="other2">New Supplier</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="new-supplier" style="display: none;">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Name</label>
                                                <input type="text" name="name" class="form-control" id="name" placeholder="name" value="{{old('name')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Phone</label>
                                                <input type="text" name="phone" class="form-control" id="phone" placeholder="name" value="{{old('phone')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="old-supplier">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Supplier</label>
                                                <select name="supplier_id" id="supplier_id" class="form-control select2" style="width: 100%" required="">
                                                    <option value="">Select Supplier</option>
                                                    @foreach ($suppliers as $key => $supplier)
                                                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
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
                                            <input type="text" name="note" class="form-control" placeholder="Note" >
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

                                    <div class="form-group">

                                        <table class="table" style="width: 100%;">

                                            <thead>
                                                <tr>
                                                    <th style="width: 20%;">Product code</th>

                                                    <th style="width: 20%;">Name</th>

                                                    <th style="width: 10%;">Unit</th>

                                                    <th style="width: 10%;">Quantity</th>

                                                    <th style="width: 10%;">Price</th>

                                                    <th style="width: 20%;">Total</th>

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

                                                            <input type="text" class="form-control" name="code[]" id="code<?= $i; ?>" placeholder="product code"  onfocusout="getProductDetails(<?= $i; ?>)">

                                                        </td>

                                                        <td>

                                                            <input type="text" class="form-control" id="name<?= $i; ?>" placeholder="product name">

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

                                                            <input type="number" class="form-control" name="quantity[]" value="1" id="quantity<?= $i; ?>" placeholder="quantity" onkeyup="amountShow(<?= $i; ?>)">

                                                        </td>

                                                        <td>

                                                            <input type="number" step="0.01" class="form-control" name="rate[]" value="0" id="rate<?= $i; ?>" min="0" placeholder="rate" onkeyup="amountShow(<?= $i; ?>)">

                                                        </td>

                                                        <td>

                                                            <input type="number" step="0.01" class="form-control" name="price[]" value="0" id="total<?= $i; ?>" min="0" placeholder="total" readonly>

                                                        </td>

                                                        <td>
                                                            <a onclick="hideProductRow(<?= $i; ?>)" class="btn btn-sm bg-red"> <i class="fa fa-close"></i> </a>
                                                        </td>

                                                    </tr>

                                                <?php } ?>

                                                <tr>
                                                    <td colspan="5" style="text-align: right; font-size: 18px; font-weight: bold;"> Subtotal</td>
                                                    <td>
                                                        <input type="text" readonly id="total_amount_id" name="subtotal" value="0">
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
                                                <label for="">Cost Name</label>
                                                <input type="text" name="extra_cost_name" class="form-control" id="extra_cost_name" placeholder="Cost Name" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Cost Amount</label>
                                                <input type="text" name="extra_cost" class="form-control" id="extra_cost" placeholder="Cost Amount" value="0" autocomplete="off" onkeyup="amountShow();">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Vat</label>
                                                <br>
                                                <div class="col-md-4">
                                                    <input type="text" name="vat_percentage" class="form-control" id="vat_percentage" placeholder="Vat" value="0" autocomplete="off" onkeyup="amountShow();">
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
                                                <input type="text" name="discount" class="form-control" id="discount" placeholder="Discount" value="0" onkeyup="amountShow();">
                                                
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
                                                <label for="">Paid</label>
                                                <input type="text" name="paid" class="form-control" id="paid" placeholder="Paid" autocomplete="off" value="0" required="" onkeyup="amountShow();">
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
	                        		<button type="button" onclick="savePurchase()" class="btn btn-sm bg-purple">Save</button>
                                    {{-- <a class="btn btn-info" onclick="makerowvisible();"><i class="fa fa-plus"></i> </a> --}}
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

        $("input[name$='supplier']").click(function() {
            var test = $(this).val();

            if(test == 'new') {
              $("#old-supplier").hide();
              $("#false-div").hide();
              $("#new-supplier").show();
              $("#supplier_id").prop("required", false);
              $("#name").prop("required", true);
              $("#phone").prop("required", true);
            } else {
              $("#old-supplier").show();
              $("#new-supplier").hide(); 
              $("#supplier_id").prop("required", true);              
              $("#name").prop("required", false);
              $("#phone").prop("required", false);
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
                
                var total = data.product.buy_price * quantity;

                $('#name' + id).val(data.product.name);
                $('#product_id' + id).val(data.product.id);
                $('#rate' + id).val(data.product.buy_price);
                $('#total' + id).val(total);
                $('#unit_id' + id).val(data.product.unit_id);

                var total_amount = 0;

                // same as php for loop from up.

                for(var i = 1; i < 11; i++){

                    var tempamount = $('#total'+i).val(); 
                    total_amount+= Number(tempamount);
                }

                $('#total_amount_id').val(total_amount);
                $('#net_total').val(total_amount);
                $('#due').val(total_amount);

                //alert(data2);
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

        // var discount_percentage = $('#discount_percentage').val();
        // var discount            = (parseInt(total_amount) * parseInt(discount_percentage)) / 100;
         var discount = $('#discount').val();

        var net_total = (parseInt(total_amount) + parseInt(vat) + parseInt(extra_cost)) - parseInt(discount);
        $('#net_total').val(net_total);
        var paid       = $('#paid').val();
        var due       = parseInt(net_total) - parseInt(paid);

        $('#due').val(due);
    }
    
     $(document).keypress(function(event){

        var keycode = (event.keyCode ? event.keyCode : event.which);

        if(keycode == '13') {

            makerowvisible();    
        }
    });

    function hideProductRow(id) {
        
        $("#trid"+id).hide();

        $('#code' + id).val('');
        $('#product_id' + id).val('');
        $('#unit_id' + id).val('');
        $('#quantity' + id).val(0);
        $('#rate' + id).val(0);
        $('#total' + id).val(0);
        amountShow(id)
    }

    function savePurchase() {

        if ($('#other2').prop("checked") == false && $('#other').prop("checked") == false) {

            alert('You need to Select Old Or New Supplier!');
            
        }else if ($('#other2').prop("checked")) {

            let name = $('#name').val();
            let phone = $('#phone').val();

            if (name == '' || phone == '') {

                alert('You need to give New Supplier Phone And Name!');

            } else{
                $('#purchase-form').submit();
            }
            
        } else if ($('#other').prop("checked")) {

            let customer = $('#supplier_id').val();

            if (customer == '') {

                alert('You need to Select Supplier');

            } else{

                $('#purchase-form').submit();
            }
            
        }  else {
            
        $('#purchase-form').submit();

        }
    }


</script>
@endsection