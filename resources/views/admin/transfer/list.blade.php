@extends('layouts.app')
@section('title', 'Transfer List')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('transfers.index')}}"><i class="fa fa-group"></i> {{translate('Product')}} {{translate('Transfers')}}</a></li>
            <li class="active">List</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (user header) -->
                <div class="box box-purple box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{translate('Product')}} {{translate('Transfer')}} {{translate('list')}}</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('transfers.create')}}" class="btn btn-sm bg-green"><i class="fa fa-plus"></i> {{translate('New')}} {{translate('Product')}} {{translate('Transfer')}}</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    	@include('includes.errormessage')
                        <div class="col-md-12">
                            <div class="">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">{{translate('Sl')}}.</th>
                                            <th style="width: 15%;">{{translate('Date')}}</th>
                                            <th style="width: 35%;">{{translate('Product')}}</th>
                                            <th style="width: 15%;">{{translate('User')}}</th>
                                            <th style="width: 15%;">{{translate('Quantity')}}</th>
                                            <th style="width: 15%;">{{translate('action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transfers as $key => $transfer)
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>
                                            <td>{{date('d M, Y', strtotime($transfer->date))}}</td>
                                            <td>{{$transfer->product}}</td>
                                            <td>{{$transfer->user}}</td>
                                            <td>{{$transfer->quantity}}</td>
                                            <td>
                                            	<a class="btn btn-sm bg-purple" href="{{route('transfers.edit',$transfer->id)}}"><span class="glyphicon glyphicon-edit"></span></a>

                                            	<form action="{{route('transfers.destroy',$transfer->id)}}" method="post" style="display: none;" id="delete-form-{{$transfer->id}}">
                                                    @csrf
                                                    {{method_field('DELETE')}}
                                                </form>
                                                <a class="btn btn-sm bg-red" href="" onclick="if(confirm('Are You Sure To Delete?')){
                                                    event.preventDefault();
                                                    getElementById('delete-form-{{$transfer->id}}').submit();
                                                    }else{
                                                    event.preventDefault();
                                                    }"><span class="glyphicon glyphicon-trash"></span></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
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
