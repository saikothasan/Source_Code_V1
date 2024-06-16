@extends('layouts.app')
@section('title', 'Product Update')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('product.index')}}"><i class="fa fa-group"></i> Products</a></li>
            <li class="active">Product Update</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (product header) -->
                <div class="box box-teal box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Product Update</h3>
                        <div class="box-tools pull-right">
                            <a href="{{route('product.index')}}" class="btn btn-sm bg-green"><i class="fa fa-list"></i> Product list</a>
                        </div>      
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                        @include('includes.errormessage')
                        <form action="{{route('product.update',$product->id)}}" method="POST" class="form-horizontal" enctype="multipart/form-data" id="form-product">
                            @csrf
                            @method('PUT')
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
                                            <select name="category_id" class="form-control select2" style="width: 100%;" id="" required="">
                                                @foreach ($categories as $key => $category)
                                                    <option value="{{$category->id}}" @if ($product->category_id == $category->id)  {{'selected'}}  @endif>{{$category->name}}</option>
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
                                            <label>Unit</label>
                                            <select name="unit_id" class="form-control select2" style="width: 100%;" id="" required="">
                                                @foreach ($units as $key => $unit)
                                                    <option value="{{$unit->id}}" @if ($product->unit_id == $unit->id)  {{'selected'}}  @endif>{{$unit->value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Code</label>
                                            <input name="product_code" placeholder="Product code" class="form-control" type="text" value="{{ $product->product_code }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Name</label>
                                            <input name="name" placeholder="name" class="form-control" required="" type="text" value="{{ $product->name }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Buy</label>
                                            <input name="buy_price" placeholder="Buy Price" class="form-control" required="" type="number" value="{{$product->buy_price}}" id="buy_price">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Sell</label>
                                            <input name="sell_price" placeholder="Sell Price" class="form-control" required="" type="number" value="{{ $product->sell_price }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Description</label>
                                            <textarea name="description" placeholder="Product Description" class="form-control" id="" rows="3">{{ $product->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm bg-red">Reset</button>
                                    <button type="submit" class="btn btn-sm bg-teal">Update</button>
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
    
</script>

@endsection