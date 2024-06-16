@extends('layouts.app')
@section('title', 'supplier List')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('supplier.index')}}"><i class="fa fa-group"></i> Suppliers</a></li>
            <li class="active">List</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (user header) -->
                <div class="box box-danger box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Supplier list</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('supplier.create')}}" class="btn btn-sm bg-green"><i class="fa fa-plus"></i> New supplier</a>
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    	@include('includes.errormessage')
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">Sl.</th>
                                    <th style="width: 13%;">Name</th>
                                    <th style="width: 13%;">Email</th>
                                    <th style="width: 10%;">Phone</th>
                                    <th style="width: 14%;">Area</th>
                                    <th style="width: 15%;">Address</th>
                                    <th style="width: 15%;">Company info</th>
                                    <th style="width: 15%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $key => $supplier)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$supplier->name}}</td>
                                    <td>{{$supplier->email}}</td>
                                    <td>{{$supplier->phone}}</td>
                                    <td>{{$supplier->area}}</td>
                                    <td>{{$supplier->address}}</td>
                                    <td>Name: {{$supplier->company}} <br> Phone: {{$supplier->company_phone}} </td>
                                    <td>
                                    	<a class="btn btn-sm btn-success" href="{{route('supplier.edit',$supplier->id)}}"><span class="glyphicon glyphicon-edit"></span></a>

                                    	<form action="{{route('supplier.destroy',$supplier->id)}}" method="post" style="display: none;" id="delete-form-{{$supplier->id}}">
                                            @csrf
                                            {{method_field('DELETE')}}
                                        </form>
                                        <a class="btn btn-sm bg-red" href="" onclick="if(confirm('Are You Sure To Delete?')){
                                            event.preventDefault();
                                            getElementById('delete-form-{{$supplier->id}}').submit();
                                            }else{
                                            event.preventDefault();
                                            }"><span class="glyphicon glyphicon-trash"></span></a>
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

        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (supplier header) -->
                <div class="box box-teal box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Due supplier</h3>
                        <div class="box-tools pull-right">
                          
                        </div>    
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
 
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th style="width: 10%;">Sl.</th>
                                  <th style="width: 15%;">Supplier</th>
                                  <th style="width: 15%;">Phone</th>
                                  <th style="width: 30%;">Note</th>
                                  <th style="width: 10%;">Total</th>
                                  <th style="width: 10%;">Paid</th>
                                  <th style="width: 10%;">Due</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $value)
                                    <tr style="display: @if ($value->due < 1) {{'none'}} @endif">
                                      <td>{{$loop->index+1}}</td>
                                      <td>{{$value->name}}</td>
                                      <td>{{$value->phone}}</td>
                                      <td>{{$value->supplier_note}}</td>
                                      <td>{{$value->total_buy}}</td>
                                      <td>{{$value->total_paid}}</td>
                                      <td>{{$value->due}}</td>
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