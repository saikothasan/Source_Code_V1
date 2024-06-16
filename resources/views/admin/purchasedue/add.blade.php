@extends('layouts.app')
@section('title', 'New purchase dues')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('purchases.index')}}"><i class="fa fa-shopping-cart"></i> Purchases</a></li>
            <li><a href="{{route('purchase-dues.index')}}"><i class="fa fa-money"></i> Purchase dues Collection</a></li>
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
                        	<a href="{{route('purchase-dues.index')}}" class="btn btn-sm bg-green"><i class="fa fa-list"></i> Purchase due collections list</a>
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                    	@include('includes.errormessage')
                        @include('flash-messages')

                    	<form action="{{route('purchase-dues.store')}}" method="POST" class="form-horizontal" id="sale-form" enctype="multipart/form-data">
                    		@csrf
                            <div class="form-group">
                                <label class="control-label col-md-2">Date</label>
                                <div class="col-sm-9">
                                    <input name="date" placeholder="date" class="form-control" required="" type="text" value="{{ old('date') }}" id="date" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">User</label>
                                <div class="col-sm-9">      
                                    <input type="hidden" hidden name="user_id" class="form-control" id="invoice" placeholder="sale invoice" value="{{auth()->user()->id}}"> 
                                    <input type="text" readonly hidden name="" class="form-control" id="invoice" placeholder="sale invoice" value="{{auth()->user()->name}}"> 

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Supplier</label>
                                <div class="col-sm-9">
                                    <select name="supplier_id" class="form-control select2" style="width: 100%" onchange="getSupplerTotalsale()" id="suplier_id" required="">
                                        <option value="">Select supplier</option>
                                        @foreach ($suppliers as $supplier)
                               
                                            <option value="{{$supplier->id}}" @if (old('supplier_id') == $supplier->id) {{'selected'}}
                                            @endif data-total_due="{{$supplier->due}}" data-total_paid ="{{ $supplier->total_paid }}" >{{$supplier->name}} </option>
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
                                <label class="control-label col-md-2">Total Sale (Buy Price)</label>
                                <div class="col-sm-9">
                                    <input placeholder="Total Sale" class="form-control" type="number" readonly value="0" name="total_sale" id="total_sale" step="0.001">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Total Paid</label>
                                <div class="col-sm-9">
                                    <input placeholder="Total Paid" class="form-control" type="number" readonly value="0" name="total_paid" id="total_paid_amount" step="0.001">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2">Total Sale Due</label>
                                <div class="col-sm-9">
                                    <input placeholder="Total Paid" class="form-control" type="number" readonly value="0" name="total_due_amount" id="total_due_amount" step="0.001">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Paid</label>
                                <div class="col-sm-9">
                                    <input name="paid" placeholder="paid" class="form-control" required="" type="number" value="{{ old('paid') }}" onkeyup="calculateDue()" id="paid" autocomplete="off" step="0.001">
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <label class="control-label col-md-2">Due</label>
                                <div class="col-sm-9">
                                    <input name="due" placeholder="due" class="form-control" required="" type="number" value="{{ old('due') }}" id="due" readonly="" step="0.001">
                                </div>
                            </div> --}}

                            <div class="form-group">
                                <label class="control-label col-md-2">Due</label>
                                <div class="col-sm-9">
                                    <input name="due" placeholder="due" class="form-control" required="" type="number" value="{{ old('due') }}" id="total_sale_due" readonly="" step="0.001">
                                </div>
                            </div>
	                        <div class="col-md-12">
	                        	<center>
	                        		<button type="reset" class="btn btn-sm bg-red">Reset</button>
	                        		<button type="submit" class="btn btn-sm bg-purple" onclick="saveConfidition()">Save</button>
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
    $('#suplier_id').change(function(){
        var total_due = $(this).find(':selected').attr('data-total_due');
        var total_paid = $(this).find(':selected').attr('data-total_paid');
        $('#total_due').val(total_due);
        $('#total_paid_amount').val(total_paid);

    });

    function calculateDue() {
        var total_due = $('#total_due').val();
        var paid      = $('#paid').val();
        var due = parseFloat(total_due) - parseFloat(paid);
        $('#due').val(due);


        let total_due_amount = $('#total_due_amount').val();
        let total_sale_due = parseFloat(total_due_amount) - parseFloat(paid);

        $('#total_sale_due').val(total_sale_due);

        
            //calculateSaleDue
    }


</script> 
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

        function getSupplerTotalsale() {
            var suplier_id = $('#suplier_id').val();
            var url = '{{route("get_supplier_total_sale")}}';

            $.ajaxSetup({

                headers: {'X-CSRF-Token' : '{{csrf_token()}}'}

            });

    $.ajax({

        url: url,
        method: 'POST',
        data: { 'suplier_id' : suplier_id, },

        success: function(data){
            let total_paid_amount =  $('#total_paid_amount').val();
            $('#total_sale').val(data);
            let total_sale = $('#total_sale').val();
            let total_sale_due = total_sale - total_paid_amount ;
            $('#total_due_amount').val(total_sale_due);
    


            
        },

        error: function(error) {

            console.log(error);
        }


    });
}

//  function saveConfidition(){
//      let paid = $('#paid').val();
//      let total_sale = $('#total_sale').val();
    
//      if( paid > total_sale  ){
         
//         alert('You Can Not be able to pay more than Sale Amount ');
//         event.preventDefault();
//      }
//      else{

// $('#sale-form').submit();
// }

//  }
    </script>  


@endsection