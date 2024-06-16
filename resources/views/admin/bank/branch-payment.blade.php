@extends('layouts.app')
@section('title', 'Make Payment')
@section('content')

    @push('css')
        <style>
            .supplier_content {
                text-align: center;
            }

            .form-control {
                border-radius: 7px;
                box-shadow: none;
                border-color: #06cdffd6 !important;
                height: 50px;
            }


            ::-webkit-input-placeholder {
                text-align: center;
            }

            :-moz-placeholder { /* Firefox 18- */
                text-align: center;
            }

            ::-moz-placeholder { /* Firefox 19+ */
                text-align: center;
            }

            :-ms-input-placeholder {
                text-align: center;
            }

            .image img {
                width: 102px;
                border-radius: 50px;
            }

            .image input {
                margin-left: 37%;
                margin-top: 23px;
            }


        </style>
    @endpush
    <div class="content-wrapper">
        <div class="content supplier_content">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    @if(auth()->user()->is_main_branch == 1)
                        <div class="button-div">
                            <div class="row">
{{--                                <div class="col-md-6">--}}
{{--                                    <a href="{{ route('bank-transfer.create') }}" class="btn btn-success btn-sm">--}}
{{--                                        Supplier/Employee</a>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <a href="{{ route('bank-send-money.create') }}" class="btn btn-success btn-sm">--}}
{{--                                        Branch</a>--}}

{{--                                </div>--}}

                            </div>
                        </div>
                    @endif
                    <h2><strong> {{translate('Branch')}} {{translate('Payment')}}
                        </strong></h2>

                    <form class="form-horizontal" id="branch-form" action="{{route('bank-send-money.store')}}"
                          method="POST"
                          class="form-horizontal">
                        @csrf
                        <div class="box-body">
                            <input type="hidden" name="date" value="{{ date("Y-m-d") }}">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select class="form-control select2" name="sender_bank_id" id="">
                                        <option value="">{{translate('Select')}} {{translate('Sender ')}}{{translate('Account')}}</option>
                                        @foreach ($senderAccount as $account )
                                            <option value="{{ $account->id }}">{{ $account->name }} ({{number_format($account->amount)}} {{get_settings('currency_symbol')}})</option>
                                        @endforeach

                                    </select>
                                    @error('sender_bank_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select class="form-control select2" name="user_id" id="user_id">
                                        <option value="">{{translate('Select')}} {{translate('User')}}</option>
                                        @foreach ($users as $user )
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select class="form-control" name="receiver_bank_id" id="bank_account_id">
                                    </select>
                                    @error('receiver_bank_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="paid" class="form-control" value="{{ old('paid') }}"
                                           id="paid" placeholder=" amount">
                                    @error('paid')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            @php
                                $referance_id = App\Model\BankTransfer::orderBy('id','desc')->get()->count()+1;
                            @endphp
                            <input type="hidden" name="reference_id" value=" CP-00-{{$referance_id}}">
                            <input type="hidden" name="type" value="branch">


                        </div>
                        <div class="row text-center form-group mt-5">
                            <div class="col-md-4">
                                <a href="{{ route('banks.index') }}">
                                    <button type="button" class="btn btn-orange">{{translate('View')}} {{translate('Bank')}}</button>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" style="width: 100%" class="btn btn-success">{{translate('Pay')}}</button>

                            </div>
                            <div class="col-md-4">
                                <a href="{{route('bank-transfer.index')}}">
                                    <button type="button" class="btn btn-orange">{{translate('View')}} {{translate('Transaction')}}</button>
                                </a>
                            </div>


                        </div>

                </div>


                </form>


            </div>
            <div class="col-md-4"></div>

        </div>


    </div>

    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {

            $('#paid').on('keyup', function (e) {

                var payable_amount = $('#payable_amount').val();
                var paid = $('#paid').val();
                var due = parseFloat(payable_amount) - parseFloat(paid);

                $('#due').val(due);
            })

            $('#user_id').on('change', function (e) {
                var user_id = e.target.value;
                //alert(user_id);
                $.ajax({
                    url: "{{ route('get-user.bank') }}",
                    type: "POST",
                    data: {
                        user_id: user_id
                    },
                    success: function (data) {
                        $('#bank_account_id').empty();
                        $.each(data.result, function (index, bank) {
                            $('#bank_account_id').append('<option value="' + bank.value + '">' + bank.text + ' (' +bank.account_no + ')' + '</option>');
                            let account = bank.account_no;
                            $('#account_no').val(account);
                        })
                        $('#payable_amount').val(data.payable_amount);
                    }
                })
            });


            $('#designation').on('change', function (e) {
                var designation = e.target.value;
                //alert(user_id);
                $.ajax({
                    url: "{{ route('get-designation-user') }}",
                    type: "POST",
                    data: {
                        designation: designation
                    },
                    success: function (data) {
                        $('#user_id').empty();
                        $('#user_id').append('<option value="">' + ' Select Reciver' + '</option>');
                        $.each(data.users, function (index, user) {
                            $('#user_id').append('<option value="' + user.id + '">' + user.name + '</option>');
                            let account = user.account_no;
                            $('#account_no').val(account);
                            $('#bank_account_id').on('change', function (e) {
                                let account = bank.account_no;
                                $('#account_no').val(account);
                            })
                        })
                    }
                })
            });
        });
    </script>

@endpush


