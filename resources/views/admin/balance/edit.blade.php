@extends('layouts.app')
@section('title', 'Bank Update')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{translate('Dashboard')}}

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('banks.index')}}"><i class="fa fa-group"></i> {{translate('Banks')}}</a></li>
            <li class="active">{{translate('Bank')}} {{translate('Update')}}</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (bank header) -->
                <div class="box box-teal box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{translate('Bank')}} {{translate('Update')}}</h3>
                        <div class="box-tools pull-right">
                            <a href="{{route('banks.index')}}" class="btn btn-sm bg-green"><i class="fa fa-list"></i> {{translate('Bank')}} {{translate('list')}}</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                        @include('includes.errormessage')
                        <form action="{{route('banks.update',$bank->id)}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label col-md-2">{{translate('Date')}}</label>
                                        <div class="col-sm-10">
                                            <input name="date" placeholder="Date" class="form-control" required="" type="text" value="{{ $bank->date }}" autocomplete="off" id="date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label col-md-2">{{translate('Type')}}</label>
                                        <div class="col-sm-10">
                                            <select name="type" class="form-control" id="">
                                                <option value="Deposit" @if ($bank->type == 'Deposit')
                                                    {{'selected'}}
                                                @endif>{{translate('Deposit')}}</option>
                                                <option value="Withdraw" @if ($bank->type == 'Withdraw')
                                                    {{'selected'}}
                                                @endif>{{translate('Withdraw')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label col-md-2">{{translate('Amount')}}</label>
                                        <div class="col-sm-10">
                                            <input name="amount" placeholder="Amount" class="form-control" required="" type="number" value="{{ $bank->amount }}" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label col-md-1">{{translate('Description')}}</label>
                                        <div class="col-sm-11">
                                            <textarea name="description" placeholder="Bank description" class="form-control" id="" rows="5">{{ $bank->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm bg-red">{{translate('Cancel')}}</button>
                                    <button type="submit" class="btn btn-sm bg-teal">{{translate('Update')}}</button>
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

