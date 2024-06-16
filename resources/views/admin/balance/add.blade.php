@extends('layouts.app')
@section('title', 'New balance add')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{translate('Dashboard')}}

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('balances.index')}}"><i class="fa fa-group"></i> {{translate('Balance')}} {{translate('transfer')}}</a></li>
            <li class="active">{{translate('New')}} {{translate('Balance')}} {{translate('transfer')}}</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (balance header) -->
                <div class="box box-teal box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{translate('New')}} {{translate('Balance')}} {{translate('transfer')}}</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('balances.index')}}" class="btn btn-sm bg-green"><i class="fa fa-list"></i> {{translate('Balance')}} {{translate('transfer')}} {{translate('list')}}</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                    	@include('includes.errormessage')
                    	<form action="{{route('balances.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    		@csrf
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label col-md-2">{{translate('Date')}}</label>
                                        <div class="col-sm-10">
                                            <input name="date" placeholder="Date" class="form-control" required="" type="text" value="{{ old('date') }}" autocomplete="off" id="date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label col-md-2">{{translate('Medium')}}</label>
                                        <div class="col-sm-10">
                                            <select name="type" class="form-control" id="">
                                                <option value="Bank">{{translate('Bank')}}</option>
                                                <option value="Owner Salary">{{translate('Owner')}} {{translate('Salary')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label col-md-2">{{translate('Bank')}} {{translate('Name')}}</label>
                                        <div class="col-md-10">
                                            <input name="name" placeholder="Bank Name" class="form-control" type="text" value="{{ old('name') }}" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label col-md-2">{{translate('Amount')}}</label>
                                        <div class="col-sm-10">
                                            <input name="amount" placeholder="Amount" class="form-control" required="" type="number" value="{{ old('amount') }}" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label col-md-1">{{translate('Note')}}</label>
                                        <div class="col-sm-11">
                                            <textarea name="note" placeholder="balance tranfercls note" class="form-control" id="" rows="5">{{ old('note') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

	                        <div class="col-md-12">
	                        	<center>
	                        		<button type="reset" class="btn btn-sm bg-red">{{translate('Reset')}}</button>
	                        		<button type="submit" class="btn btn-sm bg-teal">{{translate('Save')}}</button>
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

