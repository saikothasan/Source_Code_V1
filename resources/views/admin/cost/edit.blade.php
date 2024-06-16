

@extends('layouts.app')
@section('title', 'New cost update')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('costs.index')}}"><i class="fa fa-group"></i> Costs</a></li>
            <li class="active">New cost</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Content Header (cost header) -->
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">New cost</h3>
                        <div class="box-tools pull-right">
                            <a href="{{route('costs.index')}}" class="btn btn-sm bg-orange"><i class="fa fa-list"></i> Cost list</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br>
                        @include('includes.errormessage')
                        <form action="{{route('costs.update',$cost->id)}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Date</label>
                                        <input name="date" placeholder="Date" class="form-control" required="" type="text" value="{{ date('d-m-Y', strtotime($cost->date)) }}" autocomplete="off" id="date">
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Payment Method</label>
                                        <select name="payment_method" class="form-control" id="">
                                            <option value="Cash" @if ($cost->payment_method == 'Cash') {{ 'selected' }}

                                            @endif>Cash</option>
                                            <option value="Bank" @if ($cost->payment_method == 'Bank') {{ 'selected' }}

                                            @endif>Bank</option>
                                            <option value="Bkash" @if ($cost->payment_method == 'Bkash') {{ 'selected' }}

                                            @endif>Bkash</option>
                                        </select>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Amount</label>
                                        <input name="amount" placeholder="Amount" class="form-control" required="" type="number" value="{{ $cost->amount }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Note</label>
                                        <textarea name="note" placeholder="Cost note" class="form-control" id="" rows="5">{{ $cost->note }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm bg-red">Cancel</button>
                                    <button type="submit" class="btn btn-sm bg-blue">Update</button>
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

