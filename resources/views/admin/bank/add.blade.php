@extends('layouts.app')
@section('title', 'New bank add')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('banks.index')}}"><i class="fa fa-group"></i> {{translate('Banks')}}</a></li>
            <li class="active">{{translate('New')}} {{translate('bank')}}</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (bank header) -->
                <div class="box box-teal box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{translate('New')}} {{translate('bank<')}}/h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('banks.index')}}" class="btn btn-sm bg-green"><i class="fa fa-list"></i> {{translate('Bank')}} {{translate('list')}}</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                    	@include('includes.errormessage')
                    	<form action="{{route('banks.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    		@csrf


                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label col-md-2">{{translate('Bank')}}</label>
                                        <div class="col-sm-10">
                                            <select name="bank_id" class="form-control" id="">
                                                <option value="Deposit">{{translate('Select')}} {{translate('Bank')}}</option>
                                                @foreach ($banks as $bank )
                                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>

                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                        <label class="control-label col-md-2">{{translate('Type')}}</label>
                                        <div class="col-sm-10">
                                            <select name="type" class="form-control" id="">
                                                <option value="Deposit">{{translate('Deposit')}}</option>
                                                <option value="sendCacsh">{{translate('Send')}} {{translate('Cacsh')}}</option>
                                                <option value="Withdraw">{{translate('Withdraw')}}</option>
                                            </select>
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
                                        <label class="control-label col-md-1">{{translate('Description')}}</label>
                                        <div class="col-sm-11">
                                            <textarea name="description" placeholder="Bank description" class="form-control" id="" rows="5">{{ old('description') }}</textarea>
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

