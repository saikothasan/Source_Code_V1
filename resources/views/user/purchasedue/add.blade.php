@extends('layouts.app')
@section('title', 'New purchase dues')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('purchase.index')}}"><i class="fa fa-shopping-cart"></i> Purchases</a></li>
            <li><a href="{{route('purchases-due.index')}}"><i class="fa fa-money"></i> Purchase dues Collection</a></li>
            <li class="active">Create</li>
        </ol>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (supplier header) -->
                <div class="box box-purple box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">New purchase due collection</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('purchases-due.index')}}" class="btn btn-sm bg-green"><i class="fa fa-list"></i> Purchase due collections list</a>
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                    	@include('includes.errormessage')
                    	<form action="{{route('purchases-due.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    		@csrf
                            <div class="form-group">
                                <label class="control-label col-md-2">Date</label>
                                <div class="col-sm-9">
                                    <input name="date" placeholder="date" class="form-control" required="" type="text" value="{{ old('date') }}" id="date" autocomplete="off">
                                    <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <label class="control-label col-md-2">User</label>
                                <div class="col-sm-9">
                                    <select name="user_id" class="form-control select2" style="width: 100%" id="user_id">
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{$user->id}}" @if (old('user_id') == $user->id) {{'selected'}}
                                            @endif>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <label class="control-label col-md-2">Supplier</label>
                                <div class="col-sm-9">
                                    <select name="supplier_id" class="form-control select2" style="width: 100%" id="supplier_id" required="">
                                        <option value="">Select supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{$supplier->id}}" @if (old('supplier_id') == $supplier->id) {{'selected'}}
                                            @endif data-total_due="{{$supplier->due}}">{{$supplier->name}}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Total Due</label>
                                <div class="col-sm-9">
                                    <input placeholder="Total Due" class="form-control" type="number" value="0" id="total_due">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Paid</label>
                                <div class="col-sm-9">
                                    <input name="paid" placeholder="paid" class="form-control" required="" type="number" value="{{ old('paid') }}" onkeyup="calculateDue()" id="paid" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Due</label>
                                <div class="col-sm-9">
                                    <input name="due" placeholder="due" class="form-control" required="" type="number" value="{{ old('due') }}" id="due" readonly="">
                                </div>
                            </div>
	                        <div class="col-md-12">
	                        	<center>
	                        		<button type="reset" class="btn btn-sm bg-red">Reset</button>
	                        		<button type="submit" class="btn btn-sm bg-purple">Save</button>
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

    <script>
        $('#supplier_id').change(function(){
            var total_due = $(this).find(':selected').attr('data-total_due');
            $('#total_due').val(total_due);

        });

        function calculateDue() {
            var total_due = $('#total_due').val();
            var paid      = $('#paid').val();
            var due = parseInt(total_due) - parseInt(paid);
            $('#due').val(due);
        }
    </script> 
@endsection