@extends('layouts.app')
@section('title', 'Attendance list')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{translate('Dashboard')}}

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('attendance')}}"><i class="fa fa-group"></i> {{translate('Attendance')}}</a></li>
            <li class="active">list</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (attendance header) -->
                <div class="box box-teal box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{translate('View')}} {{translate('Employee')}} {{translate('Attendance')}}</h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                    	@include('includes.errormessage')
                    	<form action="{{route('attendance.employee-attendance')}}" method="GET" class="form-horizontal" enctype="multipart/form-data">
                    		@csrf
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label>{{translate('Months')}}</label>
                                        <select name="month" class="form-control select2" id="" required="">
                                            <option value="">{{translate('Select')}} {{translate('Months')}}</option>
                                            @foreach ($months as $month)
                                                <option value="{{$month->id}}" @if (old('month') == $month->id) {{'selected'}}

                                                @endif>{{$month->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>{{translate('Departments')}}</label>
                                        <select name="department_id" class="form-control select2" id="department" onchange="getDepartmentEmployees()">
                                            <option value="">{{translate('Select')}} {{translate('Departments')}}</option>
                                            @foreach ($departments as $department)
                                                <option value="{{$department->id}}">{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>{{translate('Employee')}}</label>
                                        <select name="employee_id" class="form-control select2" id="employee" required>
                                            <option value="">{{translate('Select')}} {{translate('Employee')}} {{translate('First')}}</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label for=""><br></label>
	                        	<button type="submit" class="btn btn-sm bg-teal form-control">{{translate('Search')}}</button>
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

        function getDepartmentEmployees() {

            var department_id = $('#department').val();
            var department = $('#department option:selected').text();

            var url = '{{route("find.employee")}}';

            $.ajaxSetup({

                headers: {'X-CSRF-Token' : '{{csrf_token()}}'}

            });

            $.ajax({

                url: url,
                method: 'POST',
                data: { 'department_id' : department_id, },

                success: function(data2){

                    var data = JSON.parse(data2);

                    $('#employee').find('option').remove().end().append("<option value=''>Select " + department + " Employee</option>");

                    $.each(data, function (i, item) {

                        $("#employee").append($('<option>', {
                            value: this.id,
                            text: this.name,
                        }));
                    });

                },

                error: function(error) {

                    console.log(error);
                }


            });
        }
    </script>
@endsection

