@extends('layouts.app')
@section('title', 'New transfer add')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('transfers.index')}}"><i class="fa fa-group"></i> Product transfers</a></li>
            <li class="active">New product transfer</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (transfer header) -->
                <div class="box box-purple box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">New Product transfer</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('transfers.index')}}" class="btn btn-sm bg-green"><i class="fa fa-list"></i> Product transfer list</a>
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                    	@include('includes.errormessage')
                    	<form action="{{route('transfers.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        
                                            <label>Date</label>
                                            <input name="date" placeholder="Date" class="form-control" required="" type="text" value="{{ old('date') }}" autocomplete="off" id="date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        
                                            <label>Users</label>
                                            <select name="user_id" class="form-control select2" id="">
                                                <option value="">Select user</option>
                                                @foreach ($users as $user)
                                            <option value="{{$user->id}}"> {{$user->name}} </option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        
                                            <label>Code</label>
                                            <input type="text" name="product_code" onchange="getProductDetail()" class="form-control" id="code" required="" autocomplete="off" value="{{ old('product_code') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        
                                            <label>Product</label>
                                            <input name="ProductName" placeholder="Product Name" class="form-control" required="" type="text" value="{{ old('ProductName') }}" autocomplete="off" id="product_name">
                                            <input type="hidden" name="product_id" id="product_id">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        
                                            <label>Quantity</label>
                                            <input name="quantity" placeholder="Quantity" class="form-control" required="" type="number" value="{{ old('quantity') }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            
	                        <div class="col-md-12">
	                        	<center>
	                        		<button type="reset" class="btn btn-sm bg-red">Reset</button>
	                        		<button type="submit" class="btn btn-sm bg-purple">Save</button>
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

                        $('#product_name').val(data.product.name);
                        $('#product_id').val(data.product.id);

                    } else {

                        $('#product_name').val('');
                        $('#product_id').val('');
                    }
                },

                error: function(error) {

                    console.log(error);
                }


            });
        }
    </script>
@endsection

