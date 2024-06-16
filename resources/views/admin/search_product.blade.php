@extends('layouts.app')
@section('title', 'Product List')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('products.index')}}"><i class="fa fa-group"></i> Products</a></li>
            <li class="active">List</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (user header) -->
                <div class="box box-teal box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Product list</h3>
                        <div class="box-tools pull-right">
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{route('product.search')}}" method="get" class="form-horizontal">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label for="">Supplier</label>
                                                <select name="supplier_id" id="supplier_id" class="form-control select2" style="width: 100%" >
                                                    <option value="">Select Supplier</option>
                                                    @foreach ($suppliers as $key => $supplier)
                                                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <label for="">Product</label>
                                         
                                                <input name="product" placeholder="Product Name" class="form-control"  type="text" value="{{ old('product') }}">
                                        
                                        </div>
                                   
                                    </div>
                                    <div class="col-md-2">
                                        <label for=""></label>
                                        <button type="submit" class="btn btn-sm bg-teal form-control">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col-md-12">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%;">Sl.</th>
                                            <th style="width: 15 %;">Name</th>
                                            <th style="width: 15 %;">Size</th>

                                            <th style="width:15%;">Stock</th>
                                            <th style="width:15 %;">Seal</th>

                                            <th style="width: 25%;">Available</th>
                                            <th style="width: 15%;">Sell Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $total_stock = 0;
                                           $total_sale =0;
                                           
                                           $total_available = 0;
                                         
                                     @endphp
                                        @foreach ($products->sortByDesc('available') as $key => $product)
                                        
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>
                                           
                                            <td>{{$product->name}}</td>
                                            <td>{{$product->size}}</td>
                                            <td>{{$product->product_stock}}</td>
                                            <td>{{$product->sales_quantity}}</td>
                                            <td>{{$product->available}} ({{$product->value}}) </td>
                                            <td>{{$product->sell_price}}</td>
                                        </tr>
                                        @php
                                       
                                
                                        $total_stock +=$product->product_stock;
                                        $total_sale +=$product->sales_quantity;
                                      
                                        $total_available +=$product->available;
    
    
                                    @endphp
                                        @endforeach
                                        
                                    </tbody>
                                    <tr style="margin-top: 10px;">
                                        <td colspan="2" style="text-align: right; font-weight: bold;">Total=</td>
                                        <td>{{$total_stock}}</td>
                                       
                                        
                                        <td>{{$total_sale}}</td>
                                        
                                        
                                        
        
                                        <td>{{$total_available}}</td>
        
                                        
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection