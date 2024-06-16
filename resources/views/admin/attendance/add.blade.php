@extends('layouts.app')
@section('title', 'Attendance')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
           {{translate(' Dashboard')}}

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('attendance')}}"><i class="fa fa-group"></i> {{translate('Attendance')}}</a></li>
            <li class="active">{{translate('Attendance')}}</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (attendance header) -->
                <div class="box box-teal box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{translate('Attendance')}}</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('attendance')}}" class="btn btn-sm bg-green"><i class="fa fa-list"></i> Attendance list</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                        @include('includes.errormessage')
                        @if ($attendances->isEmpty())
                    	<form action="{{route('attendance.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    		@csrf
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%">{{translate('Employee')}}</th>
                                            <th style="width: 15%">{{translate('In')}} {{translate('time')}} </th>
                                            <th style="width: 15%">{{translate('Out')}} {{translate('time')}} </th>
                                            <th style="width: 15%">{{translate('Late')}}</th>
                                            <th style="width: 30%">{{translate('Remark')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $key => $employee)
                                        <tr>
                                            <td>
                                            <input type="text" class="form-control" id="name-{{$key}}" placeholder="Employee" autocomplete="off" value="{{$employee->name}} ({{$employee->employee_id}})">

                                            <input type="hidden" class="form-control" id="employee_id-{{$key}}" placeholder="product name" name="employee_id[]" value="{{$employee->id}}">
                                            </td>
                                            <td>
                                            <input type="text" class="form-control" id="intime-{{$key}}" placeholder="intime" autocomplete="off" name="in_time[]" value="{{old('in_time.' . $key)}}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="outtime-{{$key}}" placeholder="outtime" autocomplete="off" name="out_time[]" value="{{old('out_time.' . $key)}}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="late-{{$key}}" placeholder="late" autocomplete="off" name="late_time[]" value="{{old('late_time.' . $key)}}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="remark-{{$key}}" placeholder="remark" autocomplete="off" name="remarks[]" value="{{old('remarks.' . $key)}}">
                                            </td>
                                        </tr>
                                         @endforeach
                                    </tbody>
                                </table>
                            </div>

	                        <div class="col-md-12">
	                        	<center>
	                        		<button type="reset" class="btn btn-sm bg-red">{{translate('Reset')}}</button>
	                        		<button type="submit" class="btn btn-sm bg-teal">{{translate('Save')}}</button>
	                        	</center>
	                        </div>
                        </form>

                        @else
                            <form action="{{route('attendance.update')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf

                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%">{{translate('Employee')}}</th>
                                            <th style="width: 15%">{{translate('In')}} {{translate('time')}} </th>
                                            <th style="width: 15%">{{translate('Out')}} {{translate('time')}} </th>
                                            <th style="width: 15%">{{translate('Late')}}</th>
                                            <th style="width: 30%">{{translate('Remark')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attendances as $key => $atten)
                                        <tr>
                                            <td>
                                            <input type="text" class="form-control" id="name-{{$key}}" placeholder="Employee" autocomplete="off" value="{{$atten->name}} ({{$atten->em_id}})">

                                            <input type="hidden" class="form-control" id="employee_id-{{$key}}" placeholder="product name" name="employee_id[]" value="{{$atten->employee_id}}">
                                            </td>
                                            <td>
                                            <input type="text" class="form-control" id="intime-{{$key}}" placeholder="intime" autocomplete="off" name="in_time[]" value="{{$atten->in_time}}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="outtime-{{$key}}" placeholder="outtime" autocomplete="off" name="out_time[]" value="{{$atten->out_time}}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="late-{{$key}}" placeholder="late" autocomplete="off" name="late_time[]" value="{{$atten->late_time}}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="remark-{{$key}}" placeholder="remark" autocomplete="off" name="remarks[]" value="{{$atten->remarks}}">
                                            </td>
                                        </tr>
                                         @endforeach
                                    </tbody>
                                </table>
                            </div>

	                        <div class="col-md-12">
	                        	<center>
	                        		<button type="reset" class="btn btn-sm bg-red">{{translate('Cancel')}}</button>
	                        		<button type="submit" class="btn btn-sm bg-teal">{{translate('Update')}}</button>
	                        	</center>
	                        </div>
                        </form>
                         @endif
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

