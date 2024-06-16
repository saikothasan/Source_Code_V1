@extends('layouts.app')
@section('title', 'New product add')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('product.index')}}"><i class="fa fa-group"></i> Products</a></li>
            <li class="active">New product</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (product header) -->
                <div class="box box-teal box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">New product</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('product.index')}}" class="btn btn-sm bg-green"><i class="fa fa-list"></i> Product list</a>
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                    	@include('includes.errormessage')
                    	<form action="{{route('product.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data" id="form-product">
                    		@csrf
                    		<div class="col-md-9">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="">Date</label>
                                            <input type="text" name="date" class="form-control" id="date" placeholder="purchase date" required="" value="{{date('d-m-Y')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="">Invoice</label>
                                            <input type="text" name="invoice" class="form-control" id="invoice" placeholder="purchase invoice" value="{{date('Y-m-d-H-i-s')}}" readonly="">
                                            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
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
                                                <label for="">Supplier Name</label>
                                                <input type="text" name="supplier_name" class="form-control" id="name" placeholder="Supplier name" value="{{old('supplier_name')}}" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Phone</label>
                                                <input type="text" name="phone" class="form-control"
                                                id="phone" placeholder="phone" value="{{old('phone')}}" autocomplete="off">
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
                                            <label for="">Purchase Note</label>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="radio" id="option" name="category" value="old_category" checked="">
                                            <label for="option">Old category</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">

                                            <input type="radio" id="option2" name="category" value="new_category">
                                            <label for="option2">New category</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" id="old-category">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Category</label>
                                            <select name="category_id" class="form-control select2" style="width: 100%;" id="category_id" required="">
                                                @foreach ($categories as $key => $category)
                                                    <option value="{{$category->id}}" {{ (old("category_id") == $category->id ? "selected":"") }}>{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="new-category" style="display: none;">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Category Name</label>
                                                <input type="text" name="category_name" class="form-control" id="category_name" placeholder="Category name" value="{{old('category_name')}}" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Code</label>
                                            <input name="product_code" placeholder="Product code" class="form-control" type="text" value="{{ old('product_code') }}" autocomplete="off" id="code" onfocusout="getProductDetail()">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Name</label>
                                            <input name="name" placeholder="name" class="form-control" required="" type="text" value="{{ old('name') }}" autocomplete="off" id="product_name">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Quantity</label>
                                            <input name="quantity" placeholder="Quantity" class="form-control" required="" type="number" id="quantity" value="1" onchange="amountShow()">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Buy</label>
                                            <input name="buy_price" placeholder="Buy Price" class="form-control" required="" type="number" id="buy_price" onchange="amountShow()" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Sell</label>
                                            <input name="sell_price" placeholder="Sell Price" class="form-control" required="" type="number" value="{{ old('sell_price') }}" autocomplete="off" id="sell_price">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Description</label>
                                            <textarea name="description" placeholder="Product Description" class="form-control" id="" rows="9">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="box box-primary box-solid">
                                    <div class="box-body box-profile">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Subtotal</label>
                                                <input type="text" name="subtotal" class="form-control" id="subtotal" placeholder="subtotal" value="0" autocomplete="off" readonly="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Cost Name</label>
                                                <input type="text" name="extra_cost_name" class="form-control" placeholder="Cost Name" autocomplete="off" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Cost Amount</label>
                                                <input type="text" name="extra_cost" class="form-control" id="extra_cost" placeholder="Cost Amount" value="0" autocomplete="off" onkeyup="amountShow();" autocomplete="off">
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
                                    <label>Photo</label><br>
                                    <img src="//placehold.it/200x200" alt="product Photo" id="product_photo"><br><br>
                                    <input type="file" name="photo" onchange="readPicture(this)">
                                    <br> <br>
	                        		<button type="reset" class="btn btn-sm bg-red">Reset</button>
	                        		<button type="button" onclick="$('#form-product').submit();" class="btn btn-sm bg-teal">Save</button>
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
    // profile picture change
    function readPicture(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
    
          reader.onload = function (e) {
            $('#product_photo')
            .attr('src', e.target.result)
            .width(200)
            .height(200);
        };
    
        reader.readAsDataURL(input.files[0]);
    }
    }

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

        $("input[name$='category']").click(function() {
            var test = $(this).val();

            if(test == 'new_category') {
              $("#old-category").hide();
              //$("#false-div").hide();
              $("#new-category").show();
              $("#category_id").prop("required", false);
              $("#category_name").prop("required", true);
            } else {
              $("#old-category").show();
              $("#new-category").hide(); 
              $("#category_id").prop("required", true);              
              $("#category_name").prop("required", false);
              //$("#false-div").show();
            }

        });
    });

    function amountShow() {

        var quantity  = $('#quantity').val();
        var buy_price = $('#buy_price').val();
        var total     = quantity * buy_price ;

        $('#subtotal').val(total);

        var extra_cost     = $('#extra_cost').val();
        var vat_percentage = $('#vat_percentage').val();
        var vat            = (parseInt(total) * parseInt(vat_percentage)) / 100;
        $('#vat').val(vat);

        var discount       = $('#discount').val();

        var net_total      = (parseInt(total) + parseInt(vat) + parseInt(extra_cost)) - parseInt(discount);

        $('#net_total').val(net_total);

        var paid       = $('#paid').val();
        
        var due       = parseInt(net_total) - parseInt(paid);

        $('#due').val(due);
    }

    function getProductDetail() {

        var productCode = $('#code').val();

        var url = '{{route("add.cart")}}';

        $.ajaxSetup({

            headers: {'X-CSRF-Token' : '{{csrf_token()}}'}

        });

        $.ajax({

            url: url,
            method: 'POST',
            data: { 'productCode' : productCode, },

            success: function(data2){

                var data     = JSON.parse(data2);

                if (data.product != null) {

                    var quantity = $('#quantity').val();

                    var total    = data.product.buy_price * quantity;

                    $('#product_name').val(data.product.name);
                    $('#buy_price').val(data.product.buy_price);
                    $('#sell_price').val(data.product.sell_price);

                    $('#subtotal').val(total);

                } else {

                    $('#product_name').val('');
                    $('#buy_price').val('');
                    $('#sell_price').val('');

                    $('#subtotal').val('');
                }
            },

            error: function(error) {

                console.log(error);
            }


        });
    }
    
</script>

@endsection