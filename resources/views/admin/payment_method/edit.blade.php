@extends('layouts.app')
@section('title', 'Update Payment Method')
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
                            <form action="{{ route('payment-method.update', $paymentMethod->id) }}" method="POST"
                                class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label class="control-label col-md-2">Name</label>
                                    <div class="col-sm-9">
                                        <input name="name" placeholder="Name" class="form-control" required=""
                                            type="text" value="{{ old('name', $paymentMethod->name) }}"
                                            autocomplete="off">
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                    <label class="control-label col-md-2">Reference Show</label>
                                    <div class="col-sm-9">
                                        <select name="reference_status" class="form-control"  >
                                            <option value="1" {{$paymentMethod->reference_status==1 ? 'selected' : ''}}>Show</option>
                                            <option value="0" {{$paymentMethod->reference_status==0 ? 'selected' : ''}}>Off</option>
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="form-group">
                                    <label class="control-label col-md-2">Status</label>
                                    <div class="col-sm-9">
                                        <select name="status" class="form-control">
                                            <option value="1" {{ $paymentMethod->status == 1 ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="0" {{ $paymentMethod->status == 0 ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Icon</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" placeholder="Upload/url" name="photo"
                                            value="{{ $paymentMethod->photo }}">
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
