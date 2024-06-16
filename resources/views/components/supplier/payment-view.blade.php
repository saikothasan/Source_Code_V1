<div class="content-wrapper">
<div class="modal-dialog" role="document">
    <div class="modal-content modal-radious">
        <div class="modal-header custom-modal-header">
            <div class="text-center row">
                <div class="col-md-2">

                    @if($purchasePayment->supplier->photo )
                        <img class="image-sm" src="{{ asset($purchasePayment->supplier->photo) }}" alt=""/>
                    @else
                        <img class="image-sm" src="{{ asset('images/blank.jpg') }}" alt=""/>
                    @endif
                </div>
                <div class="col-md-4 text-center" style="color: white">
                    <h2>
                        <strong>{{$purchasePayment->supplier->name}}</strong>
                    </h2>
                    <h4>
                        Payment Receipt
                    </h4>
                </div>
                <div class="col-md-6">
                </div>
            </div>
        </div>


        <div class="modal-body custom-modal-footer" style="background-color: rgb(255,226,201);">
            <div class="row text-center">

                <div class="">{{date('d F Y - h : i  A',strtotime($purchasePayment->created_at))}}</div>
                @if($purchasePayment->from_date != '0000-00-00')
                    <div class="">{{date('d F',strtotime($purchasePayment->from_date))}} to {{date('d F y',strtotime($purchasePayment->to_date))}}</div>
                @endif

            </div>
            <div class="text-center">
                <div class="row text-center" style="margin-top: 15px">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 row">
                        <div class="row">
                            <div class="col-md-6 text-left">Invoice</div>
                            @php
                            $invoices = collect(json_decode($purchasePayment->purchase_invoice));
                            @endphp
                            <div class="col-md-6 text-right">
                                <div>
                                    {!! $invoices->implode("<br>") !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row text-center">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 row">
                        <div class="row">
                            <div class="col-md-6 text-left">Total Amount</div>
                            <div class="col-md-6 text-right">{{formatWithComma($purchasePayment->total_pay + $purchasePayment->total_due + $purchasePayment->total_advance) }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-left">Advance</div>
                            <div class="col-md-6 text-right">{{formatWithComma($purchasePayment->total_advance)}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-left">Paid</div>
                            <div class="col-md-6 text-right">{{formatWithComma($purchasePayment->total_pay)}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-left">Due</div>
                            <div class="col-md-6 text-right">{{formatWithComma($purchasePayment->total_due)}}</div>
                        </div>
                        @if(isset($purchasePayment->supplierBank))
                            <div class="row">
                                <div class="col-md-6 text-left">Bank Account</div>
                                <div class="col-md-6 text-right">
                                    <p>{{$purchasePayment->supplierBank->name}}</p>
                                    <p>{{$purchasePayment->supplierBank->account_no}}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row text-center" style="margin-top: 10px">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 tablet">
                        Receipt No : {{$purchasePayment->receipt_no}}
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
                <a href="{{ route('supplier.transfer.download',$purchasePayment->id) }}">
                <button type="button" class="btn btn-primary">Download</button>
            </a>
            </div>
            <div class="col-md-4 row">
                <button type="button" class="btn btn-success">Screenshot</button>
            </div>
            <div class="col-md-4">
                <a href="{{route('supplier.view-payment', $purchasePayment->supplier_id)}}">
                    <button type="button" class="btn btn-primary" style="width: 75%;">View
                        Payment
                    </button>
                </a>

            </div>
        </div>
    </div>
</div>
</div>
