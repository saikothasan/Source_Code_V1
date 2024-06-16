@extends('layouts.app')
@section('title', 'New Bar Code')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (user header) -->
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">New Bar Code</h3>
                        <div class="box-tools pull-right">
                        	
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                    	@include('includes.errormessage')
                    	<form action="{{route('codes')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    		@csrf
                            
                            {{-- <div class="form-group">
                                <label class="control-label col-md-2">Category</label>
                                <div class="col-sm-9">
                                    <select name="category_id" class="form-control select2" id="category_id" style="width: 100%;" required="" onchange="getAllProductsByCategory()"> 
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $key => $category)
                                            <option value="{{$category->id}}" @if (old('category_id') == $category->id) {{'selected'}}
                                            @endif >{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <label class="control-label col-md-2">Product</label>
                                <div class="col-sm-9">
                                    <select name="product_id" class="form-control select2" id="product_id" style="width: 100%;" required=""> 
                                        <option value="">Select Product</option>
                                        @foreach ($products as $key => $product)
                                            <option value="{{$product->id}}" @if (old('product_id') == $product->id) {{'selected'}}
                                            @endif >{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Quantity</label>
                                <div class="col-sm-9">
                                    <input name="quantity" placeholder="Quantity" class="form-control" required="" type="number" value="{{ old('quantity') }}">
                                </div>
                            </div>
	                        <div class="col-md-12">
	                        	<center>
	                        		<button type="reset" class="btn btn-sm bg-red">Reset</button>
	                        		<button type="submit" class="btn btn-sm bg-blue">Generate</button>
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

<script>
    // function getAllProductsByCategory() {

    //     var category_id = $('#category_id').val();
    //     var category = $('#category_id option:selected').text();

    //     var url = '{{route("find.product")}}';

    //     $.ajaxSetup({

    //         headers: {'X-CSRF-Token' : '{{csrf_token()}}'}

    //     });

    //     $.ajax({

    //         url: url,
    //         method: 'POST',
    //         data: { 'category_id' : category_id, },

    //         success: function(data2){

    //             //alert(data2);

    //             var data = JSON.parse(data2);

    //             $('#product_id').find('option').remove().end().append("<option value=''>Select " + category + "\'s Products</option>");

    //             $.each(data, function (i, item) {

    //                 $("#product_id").append($('<option>', {
    //                     value: this.id,
    //                     text: this.name,
    //                 }));
    //             }); 
                
    //         },

    //         error: function(error) {

    //             console.log(error);
    //         }


    //     });
    // }
</script>