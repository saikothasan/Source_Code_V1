@extends('layouts.app')
@section('title', 'Sale List')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('sale.index')}}"><i class="fa fa-group"></i> Sales</a></li>
            <li class="active">List</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (user header) -->
                <div class="box box-6a8d9d box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sale list</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('sale.create')}}" class="btn btn-sm bg-purple"><i class="fa fa-plus"></i> New sale</a>
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
                                    <th style="width: 10%;">Customer</th>
                                    <th style="width: 15%;">User</th>
                                    <th style="width: 15%;">Subtotal</th>
                                    <th style="width: 10%;">Total</th>
                                    <th style="width: 20%;">Note</th>
                                    <th style="width: 10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $net_total = 0;
                                @endphp
                                @foreach ($sales as $key => $sale)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$sale->date}}</td>
                                    <td>{{$sale->customer}}</td>
                                    <td>{{$sale->user}}</td>
                                    <td>{{$sale->subtotal}}</td>
                                    <td>{{$sale->total}} <?php $net_total +=$sale->total; ?></td>
                                    <td>{{$sale->note}}</td>
                                    <td>
                                    	<a class="btn btn-sm btn-6a8d9d" href="{{route('sale.show',$sale->id)}}"><span class="fa fa-eye"></span></a>

                                    	<form action="{{route('sale.destroy',$sale->id)}}" method="post" style="display: none;" id="delete-form-{{$sale->id}}">
                                            @csrf
                                            {{method_field('DELETE')}}
                                        </form>
                                        <a class="btn btn-sm bg-red" href="" onclick="if(confirm('Are You Sure To Delete?')){
                                            event.preventDefault();
                                            getElementById('delete-form-{{$sale->id}}').submit();
                                            }else{
                                            event.preventDefault();
                                            }"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tr>
                                <td colspan="5" style="text-align: right; font-weight: bold;">Total=</td>
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