@extends('layouts.app')
@section('title', 'Purchase details')

@section('content')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
            Dashboard
            
        </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('quotations.index')}}"><i class="fa fa-group"></i> Purchases</a></li>
        <li class="active">Purchase Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
        	@include('includes.errormessage')
          <h2 class="page-header">
            <i class="fa fa-globe"></i> POS
            <small class="pull-right">Date: {{date('d/m/Y')}}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          Company
          <address>
            <strong>{{$quotation->company}}</strong><br>
            <strong>Email:</strong> {{$quotation->email}} <br>
            <strong>Phone:</strong> {{$quotation->phone}} <br>
            <strong>Address:</strong> {{$quotation->address}}
          </address>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
	            <tr>
	              <th>Serial #</th>
	              <th>Product</th>
	              <th>Qty</th>
	              <th>Rate</th>
	              <th>Total</th>
	            </tr>
            </thead>
            <tbody>
            	@foreach ($quotation_details as $detail)
	            <tr>
	              <td>{{$loop->index + 1}}</td>
	              <td>{{$detail->product}} ({{$detail->value}}) </td>
	              <td>{{$detail->quantity}}</td>
	              <td>{{$detail->rate}}</td>
	              <td>{{$detail->total}}</td>
	            </tr>
	            @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-9">
          
        </div>
        <!-- /.col -->
        <div class="col-xs-3">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Subtotal:</th>
                <td>{{$quotation->subtotal}}</td>
              </tr>
              <tr>
                <th>Tax ({{$quotation->vat_percentage}}%)</th>
                <td>{{$quotation->vat}}</td>
              </tr>
              <tr>
                <th>Discount </th>
                <td>{{$quotation->discount}}</td>
              </tr>
              <tr>
                <th>Total:</th>
                <td>{{$quotation->total}}</td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-12">
            <a href="{{route('quotation',$quotation->id)}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('footerSection')

<script>
	 $(function () {
        $('#inputDate').datepicker({
            autoclose:   true,
            changeYear:  true,
            changeMonth: true,
            dateFormat:  "dd-mm-yy",
            yearRange:   "-10:+10"
        });
    });
</script>

@endsection