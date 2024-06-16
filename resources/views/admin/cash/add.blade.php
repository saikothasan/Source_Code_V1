@extends('layouts.app')
@section('title', 'New Cash')
@section('content')
    <div class="content-wrapper">
        {{-- <section class="content-header">
            <h1>
                Dashboard

            </h1>
        </section> --}}
        <div class="content">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <h2> <strong> CASH DRAWER </strong></h2>
                    <form class="form-horizontal" action="{{ route('suppliers.store') }}" method="POST"
                        class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select name="category_id" class="form-control select2" style="width: 100%;"
                                        id="category_id" required="">
                                        <option value="">Select Category</option>
                                        <option value="">Daily</option>
                                        <option value="">Weekly</option>
                                        <option value="">Monthly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="" class="form-control" value="" id=""
                                        placeholder="Transport">
                                    @error('company')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="example">Form</label>
                                    <input placeholder="Select date" type="date" id="example" class="form-control">
                                    @error('user_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label for="example">To</label>
                                    <input placeholder="Select date" type="date" id="example" class="form-control">
                                    @error('')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="name" class="form-control" value="{{ old('phone') }}"
                                        id="" placeholder="Amount receiver name">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="number" class="form-control" value="{{ old('email') }}"
                                        id="" placeholder="Receiver phone number">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="number" value="{{ old('address') }}" class="form-control"
                                        id="" placeholder="00.00">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="note" value="{{ old('address') }}"
                                        class="form-control" id="" placeholder="Note">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="name" value="{{ old('address') }}"
                                        class="form-control" id="" placeholder="User auto">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row text-center form-group mt-5">
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-6">

                                <button type="submit" class="b_confirm" data-toggle="modal"
                                    data-target="#exampleModal">CONFIRM</button>
                            </div>
                            <div class="col-md-3">

                            </div>
                        </div>
                    </form>
                </div>




            </div>


            {{-- <div class="row">
                <div class="col-md-12">
                    <!-- Content Header (cash header) -->
                    <div class="box box-success box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">New Cash</h3>
                            <div class="box-tools pull-right">
                                <a href="{{ route('cashes') }}" class="btn btn-sm bg-red"><i
                                        class="fa fa-list"></i> Cash List</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <br>
                            @include('includes.errormessage')
                            <form action="{{ route('cashes.store') }}" method="POST" class="form-horizontal"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Date</label>
                                            <input name="date" placeholder="Date" class="form-control" required=""
                                                type="text" value="{{ old('date') }}" autocomplete="off" id="date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>In Cash</label>
                                            <input name="in_cash" placeholder="In Cash" class="form-control" required=""
                                                type="numeric" readonly value="{{ $todays_in_cash }}" autocomplete="off"
                                                id="in_cash">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Type</label>
                                            <select name="type" class="form-control" id="type">
                                                <option value="">Select One</option>
                                                <option value="bank">Bank</option>
                                                <option value="user">User</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3" id="bankSelect">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Select Bank</label>
                                            <select name="bank_id" class="form-control" id="type">
                                                <option value="">Select bank</option>
                                                @php
                                                    $bank = App\Model\Bank::get();

                                                @endphp
                                                @foreach ($bank as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3" id="userName" style="display:none ">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>User Name</label>
                                            <input name="user_name" placeholder="user Name" class="form-control"
                                                type="numeric" value="" autocomplete="off"
                                                id="">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Transfer</label>
                                            <input name="transfer" placeholder="Transfer" class="form-control" required=""
                                                type="numeric" value="{{ old('transfer') }}" autocomplete="off"
                                                id="transfer" onkeyup="calculateAmount(this.value)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Amount</label>
                                            <input name="amount" placeholder="Amount" class="form-control" required=""
                                                type="number" value="{{ old('amount') }}" autocomplete="off" id="amount">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4" style="">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Description</label>
                                            <input name="description" placeholder="user Name" class="form-control" required=""
                                                type="text" value="" autocomplete="off"
                                                id="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <center>
                                        <button type="reset" class="btn btn-sm bg-red">Reset</button>
                                        <button type="submit" class="btn btn-sm bg-green">Save</button>
                                    </center>
                                </div>
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection

@section('footerSection')
    <script>
        $(function() {
            $('#date').datepicker({
                autoclose: true,
                changeYear: true,
                changeMonth: true,
                dateFormat: "dd-mm-yy",
                yearRange: "-10:+10"
            });
        });

        function calculateAmount(transfer) {
            let in_cash = $('#in_cash').val();
            let amount = in_cash - transfer;

            $('#amount').val(amount);

        }


        $('#type').change(function() {
            let type = $('#type').val();

            if (type == 'user') {
                $("#userName").show();
                $("#bankSelect").hide();

            } else {
                $("#userName").hide();
                $("#bankSelect").show();
            }

        });
    </script>
@endsection
