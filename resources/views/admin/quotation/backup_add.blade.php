@extends('layouts.app')
@section('title', 'New Quotation add')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('quotations.index')}}"><i class="fa fa-group"></i> Quotations</a></li>
            <li class="active">New Quotation</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (Quotation header) -->
                <div class="box box-purple box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">New Quotation</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('quotations.index')}}" class="btn btn-sm bg-green"><i class="fa fa-list"></i> Quotation list</a>
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                    	@include('includes.errormessage')
                    	<form action="{{route('quotations.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data" id="purchase-form">
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
                                            <label for="">Company</label>
                                            <input type="text" name="company" class="form-control" id="company" placeholder="Company" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="">Phone</label>
                                            <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="">E-mail</label>
                                            <input type="email" name="email" class="form-control" id="email" placeholder="E-mail">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="">Address</label>
                                            <input type="text" name="address" class="form-control" id="address" placeholder="Address">
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

                                                    <th style="width: 32%;">Name</th>

                                                    <th style="width: 12%;">Quantity</th>

                                                    <th style="width: 12%;">Price</th>

                                                    <th style="width: 15%;">Total</th>

                                                    <th style="width: 4%;">Remove</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                <input type="hidden" name="showrowid" id="showrowid" value="2">
                                                
                                                <?php exit(); for ($i=1; $i < 51 ; $i++) { ?>
                                                    <tr id="trid<?= $i; ?>" style="<?php if($i > 1) echo 'display: none'; ?>">

                                                        <td>

                                                            <input type="text" class="form-control" name="code[]" id="code<?= $i; ?>" placeholder="product code"  onfocusout="getProductDetails(<?= $i; ?>)">

                                                        </td>

                                                        <td>

                                                            <select name="product_id[]" id="product_id<?= $i; ?>" class="form-control select2" style="width: 100%" onchange="getProductDetailsById(<?= $i; ?>)">
                                                                <option value="">Select Product</option>
                                                                @foreach ($products as $item)
                                                                   <option value="{{$item->id}}">{{$item->name}}</option> 
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
                                                    <td colspan="4" style="text-align: right; font-size: 18px; font-weight: bold;"> Subtotal</td>
                                                    <td>
                                                        <input type="text" readonly id="total_amount_id" name="subtotal" class="form-control" value="0">
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
                $('#product_id' + id).trigger('change');

                var total_amount = 0;

                // same as php for loop from up.

                for(var i = 1; i < 51; i++){

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

    function getProductDetailsById(id) {

        var productid = $('#product_id' + id).val();


        var url = '{{route("get.product")}}';

        $.ajaxSetup({

            headers: {'X-CSRF-Token' : '{{csrf_token()}}'}

        });

        $.ajax({

            url: url,
            method: 'POST',
            data: { 'productid' : productid, },

            success: function(data2){

                //alert(data2);

                var data = JSON.parse(data2);
                var quantity = $('#quantity' + id).val();
                
                var total = data.product.buy_price * quantity;

                $('#name' + id).val(data.product.name);
                $('#code' + id).val(data.product.product_code);
                $('#rate' + id).val(data.product.buy_price);
                $('#total' + id).val(total);

                var total_amount = 0;

                // same as php for loop from up.

                for(var i = 1; i < 51; i++){

                    var tempamount = $('#total'+i).val(); 
                    total_amount+= Number(tempamount);
                }

                $('#total_amount_id').val(total_amount);
                $('#net_total').val(total_amount);
                $('#due').val(total_amount);
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

        for(var i = 1; i < 51; i++){

            var tempamount = $('#total'+i).val(); 
            total_amount+= Number(tempamount);
        }

        $('#total_amount_id').val(total_amount);

        var vat_percentage = $('#vat_percentage').val();
        var vat            = (parseInt(total_amount) * parseInt(vat_percentage)) / 100;
        $('#vat').val(vat);

         var discount = $('#discount').val();

        var net_total = (parseInt(total_amount) + parseInt(vat)) - parseInt(discount);
        $('#net_total').val(net_total);
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
        $('#quantity' + id).val(0);
        $('#rate' + id).val(0);
        $('#total' + id).val(0);
        amountShow(id)
    }

    function savePurchase() {

        $('#purchase-form').submit();
    }


</script>
@endsection