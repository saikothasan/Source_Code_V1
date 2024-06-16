@extends('layouts.app')
@section('title', 'New Payment Method')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Dashboard

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('payment-method.index') }}"><i class="fa fa-group"></i> Payment Method List</a></li>
                <li class="active">New Payment Method</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <!-- Content Header (employee header) -->
                    <div class="box box-danger box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">New Payment Method</h3>
                            <div class="box-tools pull-right">
                                <a href="{{ route('payment-method.index') }}" class="btn btn-sm bg-green"><i
                                        class="fa fa-list"></i> Payment Method list</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <br>
                            @include('includes.errormessage')
                            <form action="{{ route('payment-method.store') }}" method="POST" class="form-horizontal"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label col-md-2">Name</label>
                                    <div class="col-sm-9">
                                        <input name="name" placeholder="Name" class="form-control" required="" type="text"
                                               value="{{ old('name') }}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Reference Show</label>
                                    <div class="col-sm-9">
                                        <select name="reference_status" class="form-control" id="">
                                            <option value="1">Show</option>
                                            <option value="0">Off</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                        <button type="reset" class="btn btn-sm bg-red">Reset</button>
                                        <button type="submit" class="btn btn-sm bg-green">Save</button>
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
