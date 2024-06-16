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
                    		<div class="col-md-12">
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
                                                <option value="">Select Category</option>
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

                                <div class="col-md-12">

                                    <div class="form-group">

                                        <table class="table" style="width: 100%;">

                                            <thead>
                                                <tr>
                                                    <th style="width: 15%;">Code</th>

                                                    <th style="width: 20%;">Name</th>

                                                    <th style="width: 10%;">Unit</th>

                                                    <th style="width: 15%;">Buy</th>

                                                    <th style="width: 15%;">Sell</th>

                                                    <th style="width: 20%;">Description</th>
                                                    
                                                    <th style="width: 5%;">Remove</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                <input type="hidden" name="showrowid" id="showrowid" value="2">
                                                <?php
                                                
                                                // 61 is the max limit, change to javascript also from botom of the code.

                                                for ($i=1; $i < 21 ; $i++) { ?>
                                                    <tr id="trid<?= $i; ?>" style="<?php if($i > 1) echo 'display: none'; ?>">

                                                        <td>

                                                            <input type="text" class="form-control" name="product_code[]" id="code<?= $i; ?>" placeholder="product code" >

                                                        </td>

                                                        <td>

                                                            <input type="text"  class="form-control" id="name<?= $i; ?>" placeholder="product name" name="name[]">

                                                        </td>

                                                        <td>

                                                            <select name="unit_id[]" id="unit_id<?= $i; ?>" class="form-control select2" style="width:100%;">
                                                                @foreach ($units as $unit)
                                                                    <option value="{{$unit->id}}">{{$unit->value}}</option>
                                                                    
                                                                @endforeach
                                                            </select>

                                                        </td>

                                                        <td>

                                                            <input type="number" class="form-control" name="buy_price[]" id="buy_price<?= $i; ?>" placeholder="Buy Price">

                                                        </td>

                                                        <td>

                                                            <input type="number" class="form-control" name="sell_price[]" id="sell_price<?= $i; ?>" min="0" placeholder="Sell Price">

                                                        </td>

                                                        <td>

                                                            <input type="text" class="form-control" name="description[]" id="description<?= $i; ?>" placeholder="Description">

                                                        </td>

                                                        <td>
                                                            <a onclick="hideProductRow(<?= $i; ?>)" class="btn btn-sm bg-red"> <i class="fa fa-close"></i> </a>
                                                        </td>

                                                    </tr>

                                                <?php } ?>

                                            </tbody>

                                        </table>

                                    </div>

                                </div>
                            </div>
                            
	                        <div class="col-md-12">
	                        	<center>
	                        		<button type="reset" class="btn btn-sm bg-red">Reset</button>
	                        		<button type="button" class="btn btn-sm bg-teal" onclick="$('#form-product').submit();">Save</button>
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

        $("input[name$='category']").click(function() {
            var test = $(this).val();

            if(test == 'new_category') {

              $("#old-category").hide();
              $("#new-category").show();
              $("#category_id").prop("required", false);
              $("#category_name").prop("required", true);

            } else {

              $("#old-category").show();
              $("#new-category").hide(); 
              $("#category_id").prop("required", true);              
              $("#category_name").prop("required", false);

            }

        });
    });

    function makerowvisible(){
        
        var nextrownumber = $("#showrowid").val();
        $("#trid"+Number(nextrownumber)).show();
        $("#showrowid").val(Number(nextrownumber)+1);
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
         $('#name' + id).val('');
         $('#buy_price' + id).val(' ');
         $('#sell_price' + id).val(' ');
         $('#description' + id).val(' ');
    }

</script>

@endsection