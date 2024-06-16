@extends('layouts.app')
@section('title', 'New employee add')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Dashboard
                
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('employees.index') }}"><i class="fa fa-group"></i> Employees</a></li>
                <li class="active">New employee</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <!-- Content Header (employee header) -->
                    <div class="box box-danger box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">New employee</h3>
                            <div class="box-tools pull-right">
                                <a href="{{ route('employees.index') }}" class="btn btn-sm bg-green"><i
                                        class="fa fa-list"></i> Employee list</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <br>
                            @include('includes.errormessage')
                            <form action="{{ route('employees.update', $employee->id) }}" method="POST"
                                class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label class="control-label col-md-2">Department</label>
                                    <div class="col-sm-9">
                                        <select name="department_id" class="form-control select2" style="width: 100%" id=""
                                            required="">
                                            <option value="">Select Department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    @if ($department->id == $employee->department_id) {{ 'selected' }} @endif>
                                                    {{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Name</label>
                                    <div class="col-sm-9">
                                        <input name="name" placeholder="name" class="form-control" required="" type="text"
                                            value="{{ $employee->name }}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Designation</label>
                                    <div class="col-sm-9">
                                        <input name="designation" placeholder="Designation" class="form-control"
                                            required="" type="text" value="{{ $employee->designation }}"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">ID</label>
                                    <div class="col-sm-9">
                                        <input name="employee_id" placeholder="Employee ID" class="form-control"
                                            required="" type="text" value="{{ $employee->employee_id }}"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Join</label>
                                    <div class="col-sm-9">
                                        <input name="join_date" placeholder="Employee Join date" class="form-control"
                                            required="" type="text" value="{{ $employee->join_date }}" id="join_date"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">E-mail Address</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" placeholder="E-mail Address" name="email"
                                            value="{{ $employee->email }}" autocomplete="off">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Phone</label>
                                    <div class="col-sm-9">
                                        <input name="phone" placeholder="Phone" class="form-control" required=""
                                            type="text" value="{{ $employee->phone }}" required="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Salary</label>
                                    <div class="col-sm-9">
                                        <input name="salary" placeholder="Salary" class="form-control" type="text"
                                            value="{{ $employee->salary }}" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Reference</label>
                                    <div class="col-sm-9">
                                        <input name="reference" placeholder="Reference" class="form-control" type="text"
                                            value="{{ $employee->reference }}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Address</label>
                                    <div class="col-sm-9">
                                        <textarea name="address" rows="3" class="form-control" placeholder="Address" style="resize: vertical;">{{ $employee->address }}</textarea>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Photo</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="photo" onchange="readPicture(this)">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <center>
                                        <img src="{{ asset($employee->photo) }}" alt="employee Photo" id="employee_photo"
                                            style="width: 200px; height:200px;">
                                        <br> <br>
                                        <button type="reset" class="btn btn-sm bg-red">Cancel</button>
                                        <button type="submit" class="btn btn-sm bg-green">Update</button>
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
        // profile picture change
        function readPicture(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#employee_photo')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(function() {
            $('#join_date').datepicker({
                autoclose: true,
                changeYear: true,
                changeMonth: true,
                dateFormat: "dd-mm-yy",
                yearRange: "-10:+10"
            });
        });
    </script>
@endsection
