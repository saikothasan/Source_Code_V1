@extends('layouts.app')
@section('title', 'Purchase return')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('purchases.index')}}"><i class="fa fa-shopping-cart"></i> Purchases</a></li>
            <li><a href="{{route('purchases.show',$purchase_detail->purchase_id)}}"><i class="fa fa-eye"></i> Purchase details</a></li>
            <li class="active">Return</li>
        </ol>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (supplier header) -->
                <div class="box box-purple box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Purchase return</h3>
                        <div class="box-tools pull-right">
                        	<a href="{{URL::to('admin/purchase-returns')}}" class="btn btn-sm bg-green"><i class="fa fa-list"></i> Purchase return list</a>
                        </div>		
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                    	@include('includes.errormessage')
                    	<form action="{{route('purchase-returns.store')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    		@csrf
                            <div class="form-group">
                                <label class="control-label col-md-2">Date</label>
                                <div class="col-sm-9">
                                    <input name="date" placeholder="date" class="form-control" required="" type="text" value="{{ old('date') }}" id="date" autocomplete="off">

                                    <input name="detail_id" type="hidden" value="{{$purchase_detail->id}}" >
                                    <input name="purchase_id" type="hidden" value="{{$purchase_detail->purchase_id}}" >
                                    <input name="supplier_id" type="hidden" value="{{$purchase_info->supplier_id}}" >
                                    <input name="invoice" type="hidden" value="{{$purchase_detail->invoice}}" >
                                    <input name="product_id" type="hidden" value="{{$purchase_detail->product_id}}">

                                    <input name="user_id" type="hidden" value="{{auth()->user()->id}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Quantity</label>
                                <div class="col-sm-9">
                                    <input name="quantity" placeholder="Quantity" class="form-control" required="" type="number" value="{{ old('quantity') }}" step="0.001">
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
@endsection