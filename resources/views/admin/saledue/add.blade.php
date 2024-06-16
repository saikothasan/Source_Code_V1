@extends('layouts.app')
@section('title', 'New sale dues')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('sales.index')}}"><i class="fa fa-shopping-cart"></i> Sales</a></li>
            <li><a href="{{route('sale-dues.index')}}"><i class="fa fa-money"></i> Sale dues Collection</a></li>
            <li class="active">Create</li>
        </ol>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (customer header) -->
                <div class="box box-6a8d9d box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">New sale due collection</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('sale-dues.index')}}" class="btn btn-sm bg-purple"><i class="fa fa-list"></i> Sale due collections list</a>
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                    	@include('includes.errormessage')
                    	<form action="{{route('sale-dues.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    		@csrf
                            <div class="form-group">
                                <label class="control-label col-md-2">Date</label>
                                <div class="col-sm-9">
                                    <input name="date" placeholder="date" class="form-control" required="" type="text" value="{{date('Y-m-d')}}" id="date" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">User</label>
                                <div class="col-sm-9">
                                    <input type="hidden"  name="user_id" class="form-control" id="invoice" placeholder="sale invoice" value="{{auth()->user()->id}}"> 
                                    <input type="text" readonly  name="" class="form-control" id="invoice" placeholder="sale invoice" value="{{auth()->user()->name}}"> 

                            
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Customer</label>
                                <div class="col-sm-9">
                                    <select name="customer_id" class="form-control select2" style="width: 100%" id="customer_id" required="">
                                        <option value="">Select customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{$customer->id}}" @if (old('customer_id') == $customer->id) {{'selected'}}
                                            @endif data-total_due="{{$customer->due}}">{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Total Due</label>
                                <div class="col-sm-9">
                                    <input placeholder="Total Due" class="form-control" type="number" value="0" id="total_due" step="0.001">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2" for="">Payment Method</label>
                                <div class="col-md-9">
                                    <select name="payment_method" class="form-control" id="">
                                        <option value="">Select Payment Method</option>
                                        <option value="2">Bank</option>
                                        <option value="3">Bkash</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Bank Name</label>
                                <div class="col-sm-9">
                                    <input placeholder="Bank Name" class="form-control" type="text" value="{{old('name')}}" name="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Paid</label>
                                <div class="col-sm-9">
                                    <input name="paid" placeholder="paid" class="form-control" required="" type="number" onkeyup="calculateDue()" id="paid" autocomplete="off" value="0" step="0.001">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Cash</label>
                                <div class="col-sm-9">
                                    <input name="cash" placeholder="Cash" class="form-control" required="" type="number" onkeyup="calculateDue()" id="cash" autocomplete="off" value="0" step="0.001">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Due</label>
                                <div class="col-sm-9">
                                    <input name="due" placeholder="due" class="form-control" required="" type="number" value="{{ old('due') }}" id="due" readonly="" step="0.001">
                                </div>
                            </div>
	                        <div class="col-md-12">
	                        	<center>
	                        		<button type="reset" class="btn btn-sm bg-red">Reset</button>
	                        		<button type="submit" class="btn btn-sm btn-6a8d9d">Save</button>
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
        $('#customer_id').change(function(){
            var total_due = $(this).find(':selected').attr('data-total_due');
            $('#total_due').val(total_due);

        });

        function calculateDue() {

            var total_due = $('#total_due').val();
            var paid      = $('#paid').val();
            var cash      = $('#cash').val();

            var due = parseFloat(total_due) - parseFloat(paid) - parseFloat(cash);
            $('#due').val(due);

        }
    </script> 
@endsection