@extends('layouts.app')
@section('title', 'Balance List')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{translate('Dashboard')}}

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('balances.index')}}"><i class="fa fa-group"></i> {{translate('Balance')}} {{translate('transfer')}}</a></li>
            <li class="active">List</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (user header) -->
                <div class="box box-teal box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{translate('Balance')}} {{translate('transfer')}} {{translate('list')}}</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('balances.create')}}" class="btn btn-sm bg-green"><i class="fa fa-plus"></i> {{translate('New')}} {{translate('balance')}} {{translate('transfer')}}</a>
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
                                            <th style="width: 10%;">{{translate('Date')}}</th>
                                            <th style="width: 10%;">{{translate('Medium')}}</th>
                                            <th style="width: 10%;">{{translate('Bank')}}</th>
                                            <th style="width: 35%;">{{translate('note')}}</th>
                                            <th style="width: 10%;">{{translate('Amount')}}</th>
                                            <th style="width: 15%;">{{translate('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $net_total = 0;
                                        @endphp
                                        @foreach ($balances as $key => $balance)
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>
                                            <td>{{date('d M, Y', strtotime($balance->date))}}</td>
                                            <td>{{$balance->type}}</td>
                                            <td>{{$balance->bank_name}}</td>
                                            <td>{{$balance->note}}</td>
                                            <td>{{$balance->amount}} <?php $net_total +=$balance->amount; ?></td>
                                            <td>
                                            	{{-- <a class="btn btn-sm bg-teal" href="{{route('balances.edit',$balance->id)}}"><span class="glyphicon glyphicon-edit"></span></a> --}}

                                            	<form action="{{route('balances.destroy',$balance->id)}}" method="post" style="display: none;" id="delete-form-{{$balance->id}}">
                                                    @csrf
                                                    {{method_field('DELETE')}}
                                                </form>
                                                <a class="btn btn-sm bg-red" href="" onclick="if(confirm('Are You Sure To Delete?')){
                                                    event.preventDefault();
                                                    getElementById('delete-form-{{$balance->id}}').submit();
                                                    }else{
                                                    event.preventDefault();
                                                    }"><span class="glyphicon glyphicon-trash"></span></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tr>
                                        <td colspan="4" style="text-align: right; font-weight: bold;">{{translate('Total')}}=</td>
                                        <td>{{$net_total}}</td>
                                        <td></td>
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
