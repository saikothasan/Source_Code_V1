@extends('layouts.app')

@section('title', 'Sale due collection list')

@section('content')
	<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('sales.index')}}"><i class="fa fa-shopping-cart"></i> Sales</a></li>
            <li><a href="{{route('sale-dues.index')}}"><i class="fa fa-money"></i> Sale due collection</a></li>
            <li class="active">List</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (user header) -->
                <div class="box box-6a8d9d box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sale due collection list</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('sale-dues.create')}}" class="btn btn-sm bg-purple"><i class="fa fa-plus"></i> New sale due collection</a>
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    	@include('includes.errormessage')
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">Sl.</th>
                                    <th style="width: 15%;">Date</th>
                                    <th style="width: 10%;">Supplier</th>
                                    <th style="width: 15%;">User</th>
                                    <th style="width: 15%;">Paid</th>
                                    <th style="width: 10%;">Due</th>
                                    <th style="width: 10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $net_total = 0;
                                @endphp
                                @foreach ($sale_due_collection as $key => $due)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{date('d M, Y', strtotime($due->date))}}</td>
                                    <td>{{$due->supplier}}</td>
                                    <td>{{$due->user}}</td>
                                    <td>{{$due->paid}} <?php $net_total +=$due->paid; ?></td>
                                    <td>{{$due->due}}</td>
                                    <td>
                                    	{{-- <a class="btn btn-sm bg-6a8d9d" href="{{route('sale-dues.edit',$due->id)}}"><span class="fa fa-edit"></span></a> --}}

                                    	<form action="{{route('sale-dues.destroy',$due->id)}}" method="post" style="display: none;" id="delete-form-{{$due->id}}">
                                            @csrf
                                            {{method_field('DELETE')}}
                                        </form>
                                        <a class="btn btn-sm bg-red" href="" onclick="if(confirm('Are You Sure To Delete?')){
                                            event.preventDefault();
                                            getElementById('delete-form-{{$due->id}}').submit();
                                            }else{
                                            event.preventDefault();
                                            }"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tr>
                                <td colspan="4" style="text-align: right; font-weight: bold;">Total=</td>
                                <td>{{$net_total}}</td>
                                <td colspan="2"></td>
                            </tr>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection