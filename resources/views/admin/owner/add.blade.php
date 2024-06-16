@extends('layouts.app')
@section('title', 'New Owner add')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('owners.index')}}"><i class="fa fa-group"></i> Owners</a></li>
            <li class="active">New owner</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (owner header) -->
                <div class="box box-teal box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">New owner ||
                             <span style="background: #fff;color: black;padding: 5px;font-weight: bold;"> in counter:</span>  <span id="incash" style="background: #fff;color: black;padding: 5px;font-weight: bold;"> <?php

                                // today calculation

                                $all_plus = $today_sale_payment + $today_sale_due_collection;

                                $all_minus = $today_cost;

                                $in_cash = $all_plus - $all_minus;

                                $todays_in_cash = $yesterday_cash + $in_cash;

                                echo $todays_in_cash;

                                ?> 
                            </span>
                    </h3>
                        <div class="box-tools pull-right">
                        	<a href="{{route('owners.index')}}" class="btn btn-sm bg-green"><i class="fa fa-list"></i> Owner list</a>
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                    	@include('includes.errormessage')
                    	<form action="{{route('owners.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    		@csrf
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        
                                            <label>Date</label>
                                            <input name="date" placeholder="Date" class="form-control" required="" type="text" value="{{ old('date') }}" autocomplete="off" id="date">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        
                                            <label>Owner Take</label>
                                            <input name="amount" placeholder="Owner Take" class="form-control" required="" type="number" value="{{ old('amount') }}" autocomplete="off" onchange="calculateCashAmount()" id="owner_take">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        
                                            <label>Incash</label>
                                            <input name="daily_amount" placeholder="Incash" class="form-control" required="" type="number" value="{{ old('daily_amount') }}" autocomplete="off" id="cash">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        
                                            <label>Note</label>
                                            <textarea name="note" placeholder="owner note" class="form-control" id="" rows="5">{{ old('note') }}</textarea>
                                        
                                    </div>
                                </div>
                            </div>
                            
	                        <div class="col-md-12">
	                        	<center>
	                        		<button type="reset" class="btn btn-sm bg-red">Reset</button>
	                        		<button type="submit" class="btn btn-sm bg-teal">Save</button>
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

        function calculateCashAmount() {

           let cash          = $('#incash').text();
           let ownerTake     = $('#owner_take').val();
           let cashInCounter = parseInt(cash) - parseInt(ownerTake);
           $('#cash').val(cashInCounter);
           
        }

        
    </script>

    
@endsection

