@extends('layouts.app')
@section('title', 'Admin Transfer')
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
                <div class="col-lg-4 col-md-3"></div>
                <div class="col-lg-4 col-md-6">
                    <h2><strong>{{translate('Admin')}} {{translate('Transfer')}}
                        </strong></h2>
                    <form class="form-horizontal" action="{{route('admin-transfer-store')}}" method="POST"
                          class="form-horizontal">
                        @csrf
                        <div class="box-body">
                            <input type="hidden" name="date" value="{{ date("Y-m-d") }}">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select class="form-control select2" name="sender_bank_id" id="sender_bank_id">
                                        <option value="">{{translate('Select')}} {{translate('Sender')}} {{translate('Account')}}</option>
                                        @foreach ($banks as $bank )

                                            <option value="{{ $bank->id }}">{{ $bank->name }} ({{ $bank->amount }}tk)
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('sender_bank_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select class="form-control select2" name="cash_drawer_id" id="user_id">
                                        <option value="">{{translate('Select')}} {{translate('Receiver')}} {{translate('Cash')}} {{translate('Drawer')}}</option>
                                        @foreach ($cashDrawer as $cash )
                                            <option value="{{ $cash->id }}">{{ $cash->name }}</option>
                                        @endforeach

                                    </select>
                                    @error('cash_drawer_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" id="payable_amount" name="paid" class="form-control"
                                           value="{{ old('payable_amount') }}"
                                           placeholder="Transfer Amount">
                                    @error('paid')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            @php
                                $cash_history = App\Model\CashHistory::count()+1;
                            @endphp
                            <input type="hidden" name="reference_id"
                                   value="CD-00-{{$cash_history ? $cash_history : 1}}">
                            <input type="hidden" name="type" value="cash_drawer">

                        </div>
                        <div class="row text-center form-group mt-5">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-success" style="width: 100%">{{translate('Transfer')}}</button>

                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>

                </div>
                </form>
            </div>
            <div class="col-lg-4 col-md-3"></div>

        </div>


    </div>

    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {


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
                        $.each(data.banks, function (index, bank) {
                            $('#bank_account_id').append('<option value="' + bank.id + '">' + bank.name + '</option>');
                            let account = bank.account_no;

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
