@extends('layouts.app')
@section('title', 'Owner List')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('owners.index')}}"><i class="fa fa-group"></i> Owners</a></li>
            <li class="active">List</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (user header) -->
                <div class="box box-teal box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Owner list</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('owners.create')}}" class="btn btn-sm bg-green"><i class="fa fa-plus"></i> New owner</a>
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
                                    <th style="width: 50%;">Note</th>
                                    <th style="width: 15%;">Amount</th>
                                    <th style="width: 15%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $net_total = 0;
                                @endphp
                                @foreach ($owners as $key => $owner)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{date('d M, Y', strtotime($owner->date))}}</td>
                                    <td>{{$owner->note}}</td>
                                    <td>{{$owner->amount}} <?php
                                                                                                                                                                                                                                                                                      $net_total +=$owner->amount; ?></td>
                                    <td>
                                    	<a class="btn btn-sm bg-teal" href="{{route('owners.edit',$owner->id)}}"><span class="glyphicon glyphicon-edit"></span></a>

                                    	<form action="{{route('owners.destroy',$owner->id)}}" method="post" style="display: none;" id="delete-form-{{$owner->id}}">
                                            @csrf
                                            {{method_field('DELETE')}}
                                        </form>
                                        <a class="btn btn-sm bg-red" href="" onclick="if(confirm('Are You Sure To Delete?')){
                                            event.preventDefault();
                                            getElementById('delete-form-{{$owner->id}}').submit();
                                            }else{
                                            event.preventDefault();
                                            }"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            

                            <tr>
                                <td colspan="3" style="text-align: right; font-weight: bold;">Total =</td>
                                <td>{{$net_total}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right; font-weight: bold;">Transfer =</td>
                                <td>{{$total_balance}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right; font-weight: bold;">Balance =</td>
                                <td>{{$net_total - $total_balance}}</td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (balance header) -->
                <div class="box box-teal box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">New balance transfer</h3>
                        <div class="box-tools pull-right">
                            <a href="{{route('balances.index')}}" class="btn btn-sm bg-green"><i class="fa fa-list"></i> Balance transfer list</a>
                        </div>      
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                        <form action="{{route('balances.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        
                                            <label>Date</label>
                                            <input name="date" placeholder="Date" class="form-control" required="" type="text" value="{{ old('date') }}" autocomplete="off" id="date">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        
                                            <label>Medium</label>
                                            <select name="type" class="form-control" id="">
                                                <option value="Bank">Bank</option>
                                                <option value="Owner Salary">Owner Salary</option>
                                            </select>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        
                                            <label>Bank Name</label>
                                            <input name="name" placeholder="Bank Name" class="form-control" type="text" value="{{ old('name') }}" autocomplete="off">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        
                                            <label>Amount</label>
                                            <input name="amount" placeholder="Amount" class="form-control" required="" type="number" value="{{ old('amount') }}" autocomplete="off">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        
                                            <label>Note</label>
                                            <textarea name="note" placeholder="balance note" class="form-control" id="" rows="5">{{ old('note') }}</textarea>
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm bg-red">Reset</button>
                                    <button type="submit" class="btn btn-sm bg-teal">Save</button>
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
            $('#date').datepicker({
                autoclose:   true,
                changeYear:  true,
                changeMonth: true,
                dateFormat:  "dd-mm-yy",
                yearRange:   "-10:+10"
            });
        });
    </script>
@endsection