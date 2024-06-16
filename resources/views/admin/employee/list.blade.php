@extends('layouts.app')
@section('title', 'Employee List')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Dashboard
                
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('employees.index')}}"><i class="fa fa-group"></i> Employees</a></li>
                <li class="active">List</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <!-- Content Header (user header) -->
                    <div class="box box-danger box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Employee list</h3>
                            <div class="box-tools pull-right">

                                <a href="{{route('employees.create')}}" class="btn btn-sm bg-green"><i class="fa fa-plus"></i> New employee</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            @include('includes.errormessage')
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 5%;">Sl.</th>
                                    <th style="width: 15%;">Department</th>
                                    <th style="width: 10%;">Name</th>
                                    <th style="width: 10%;">Designation</th>
                                    <th style="width: 15%;">Email</th>
                                    <th style="width: 10%;">Phone</th>
                                    <th style="width: 15%;">Address</th>
                                    <th style="width: 10%;">Photo</th>
                                    <th style="width: 10%;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($employees as $key => $employee)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$employee->department}}</td>
                                        <td>{{$employee->name}}</td>
                                        <td>{{$employee->designation}}</td>
                                        <td>{{$employee->email}}</td>
                                        <td>{{$employee->phone}}</td>
                                        <td>{{$employee->address}}</td>
                                        <td><img src="{{asset($employee->photo)}}" alt="" style="width: 50px; height:50px;"></td>
                                        <td>
                                            <a class="btn btn-sm btn-success" href="{{route('employees.edit',$employee->id)}}"><span class="glyphicon glyphicon-edit"></span></a>

                                            <form action="{{route('employees.destroy',$employee->id)}}" method="post" style="display: none;" id="delete-form-{{$employee->id}}">
                                                @csrf
                                                {{method_field('DELETE')}}
                                            </form>
                                            <a class="btn btn-sm bg-red" href="" onclick="if(confirm('Are You Sure To Delete?')){
                                            event.preventDefault();
                                            getElementById('delete-form-{{$employee->id}}').submit();
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
        </div>
    </div>
@endsection
