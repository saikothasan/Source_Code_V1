@extends('layouts.app')
@section('title', 'Product Sort List')
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
                        <h3 class="box-title">Product Sort list</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('products.create')}}" class="btn btn-sm bg-green no-print"><i class="fa fa-plus"></i> New Product</a>
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    	@include('includes.errormessage')
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">Sl.</th>
                                    <th style="width: 60%;">Name</th>
                                    <th style="width: 20%;">Code</th>
                                    <th class="no-print" style="width: 10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $key => $product)
                                <tr >
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->product_code}}</td>
                                    <td class="no-print">
                                        @if ($product->available < 10)
                                            <a class="btn btn-sm btn-danger" href="{{route('products.sort',[$product->id, 0] )}}"><span class="fa fa-times"></span></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection