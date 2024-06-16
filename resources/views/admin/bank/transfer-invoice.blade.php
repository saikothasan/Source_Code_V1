@extends('layouts.app')
@section('title', 'Payment '.$bankTransfer->receipt_no)
@section('content')
    @push('css')
        <style>
            .image img {
                width: 102px;
                border-radius: 50px;
            }

            .image-sm {
                width: 56px;
                border-radius: 25px;
            }

            .image-size {
                width: 1.5em;
                height: 1.5em;
            }

            .image-div {
                text-align: right;
                padding: 100px;
                margin-top: -160px;
            }

            .right-image {
                height: 50%;
                width: 19%;
                border: 4px solid #FF7200;
                border-radius: 100%;
            }

            .heading {
                margin-top: -150px;
            }
            .fa-fw {
                width: 2.285714em;
                text-align: center;
                font-size: 24px;
                color: gray;
            }

            .hr {
                margin-top: 20px;
                margin-bottom: 20px;
                border: 0;
                border-top: 3px solid black;
            }

            .text-color {
                style = "color: gray";
            }

            .table-spacing {
                font-family: 'Roboto Light';
                padding-top: 10px;
            }

            .sidepanel {
                height: auto;
                width: 0;
                position: absolute;
                z-index: 1;
                background-color: rgb(75, 75, 113);
                overflow-x: hidden;
                transition: 0.5s;
                margin-top: -57px;
            }

            .white-text {
                color: #ffffff;
            }

            .modal-radious {
                border: 0px solid #ededed;
                border-radius: 25px;
            }

            .custom-modal-header {
                background-image: linear-gradient(to right, #EC1D24, #e6e691);
                border-top-right-radius: 20px;
                border-top-left-radius: 20px;
            }

            .custom-modal-footer {
                background-color: rgb(255, 226, 201);
                border-bottom-left-radius: 20px;
                border-bottom-right-radius: 20px;
            }

            .tablet {
                border: 2px solid #0a0606;
                border-radius: 8px;
                background-color: black;
                color: white;
            }

            .custom-circle {
                font-size: 50px;
                color: rgb(255, 77, 0);
            }
            .custom-footer{
                padding: 15px;
                text-align: right;
            }
            .d-flex{
                display: flex;
            }
        </style>
    @endpush
    <div class="content-wrapper">
       
     <div class="modal-dialog" role="document">
        <div class="modal-content modal-radious">
            <div class="modal-header custom-modal-header">
                <div class="text-center row">
                    <div class="col-md-2">
    
                        @if($bankTransfer->user->photo )
                            <img class="image-sm" src="{{ asset($bankTransfer->user->photo) }}" alt=""/>
                        @else
                            <img class="image-sm" src="{{ asset('images/blank.jpg') }}" alt=""/>
                        @endif
                    </div>
                    <div class="col-md-4 text-center" style="color: white">
                        <h2>
                            <strong>{{$bankTransfer->user->name}}</strong>
                        </h2>
                            <span>
                                Payment Receipt
                            </span>
                      
                     
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
            </div>
    
    
            <div class="modal-body custom-modal-footer" style="background-color: rgb(255,226,201);">
                <div class="row">
                    <div class="col-md-6 text-left">{{date('d F Y',strtotime($bankTransfer->date))}}</div>
                </div>
                <div class="text-center">
              
                    <div class="row text-center">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 row">
                         
                            <div class="row">
                                <div class="col-md-6 text-left">Sender Account</div>
                              
                                <div class="col-md-6">{{ $bankTransfer->senderBank->name }}</div>
                                <div class="col-md-6 "></div>
                                <div class="col-md-6">{{ $bankTransfer->senderBank->account_no }}</div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6 text-left">Receiver Account</div>
                              
                                <div class="col-md-6">{{ $bankTransfer->receiverBank->name }}</div>
                                <div class="col-md-6 "></div>
                                <div class="col-md-6">{{ $bankTransfer->receiverBank->account_no }}</div>
                            </div>
                               <br>
                         
                            <div class="row">
                                <div class="col-md-6 text-left">Paid Amount</div>
                                <div class="col-md-6">{{$bankTransfer->paid}}</div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="row text-center" style="margin-top: 10px">
                        <div class="col-md-3"></div>
                        <div class="col-md-6 tablet">
                            Receipt No : {{$bankTransfer->reference_id}}
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="row text-center" style="margin-top: 10px">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <i class="fa fa-check-circle custom-circle"></i>
                            <br/>
                            <span>PAYMENT SUCCESSFUL</span>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                </div>
            </div>
    
            <div class="custom-footer row" style="    display: flex;
        text-align: center;">
                <div class="col-md-6 row">
                    <a href="{{ route('bank-branch.transfer.download',$bankTransfer->id) }}">
                    <button type="button" class="btn btn-primary">Download</button>
                </a>
                </div>
                <div class="col-md-4 row">
                    <button type="button" class="btn btn-success">Screenshot</button>
                </div>
                <div class="col-md-4">
                    <a href="{{route('bank-transfer.index')}}">
                        <button type="button" class="btn btn-primary" style="width: 75%;">View
                            Payment
                        </button>
                    </a>
    
                </div>
            </div>
        </div>
    </div>
    </div>
    
@endsection















