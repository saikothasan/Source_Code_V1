@extends('layouts.app')
@section('title', 'Quotation List')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('quotations.index')}}"><i class="fa fa-group"></i> Quotations</a></li>
            <li class="active">List</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (user header) -->
                <div class="box box-purple box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Quotation list</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('quotations.create')}}" class="btn btn-sm bg-green"><i class="fa fa-plus"></i> New Quotation</a>
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    	@include('includes.errormessage')
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    
                                    <th style="width: 10%;">Date</th>
                                    <th style="width: 10%;">Company</th>
                                    <th style="width: 10%;">Subtotal</th>
                                    <th style="width: 10%;">Total</th>
                                    <th style="width: 15%;">Note</th>
                                    <th style="width: 10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $net_total = 0;
                                @endphp
                                @foreach ($quotations as $key => $quotation)
                                <tr>
                                    
                                    <td>{{date('d M, Y', strtotime($quotation->date))}}</td>
                                    <td>{{$quotation->company }}</td>
                                    <td>{{$quotation->total}} <?php $net_total +=$quotation->total ?></td>
                                    <td>{{$quotation->note}}</td>
                                    <td>
                                    	<a class="btn btn-sm bg-purple" href="{{route('quotations.show',$quotation->id)}}"><span class="fa fa-eye"></span></a>

                                    	<form action="{{route('quotations.destroy',$quotation->id)}}" method="post" style="display: none;" id="delete-form-{{$quotation->id}}">
                                            @csrf
                                            {{method_field('DELETE')}}
                                        </form>
                                        <a class="btn btn-sm bg-red" href="" onclick="if(confirm('Are You Sure To Delete?')){
                                            event.preventDefault();
                                            getElementById('delete-form-{{$quotation->id}}').submit();
                                            }else{
                                            event.preventDefault();
                                            }"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                            <tr>
                                <td colspan="3" style="text-align: right; font-weight: bold;">Total=</td>
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