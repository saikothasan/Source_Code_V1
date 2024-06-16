<div class="modal-dialog"
     style="width: 330px;
            font-size: 15px; border: 2px solid #fbd3ad;
            border-radius: 22px">
    <div class="modal-content modal-radious">
        <div class="modal-header custom-modal-header">
            <div class="text-center row">
                <div class="col-md-2">
                </div>
                <div class="col-md-8 text-center" style="color: white">
                    <h1>
                        <strong>{{translate('Cost')}}</strong>
                        <span style="font-size: 16px;">{{translate('Receipt')}}</span>
                    </h1>
                </div>
            </div>
        </div>
        <div class="modal-body custom-modal-footer" style="background-color: rgb(237,238,238);">
            <div class="row">
                <div class="col-md-12 text-center">{{date('d M Y',strtotime($cost->created_at))}}</div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 text-center">{{ucwords( str_replace("_", " ", $cost->cost_type) )}}
                    @if($cost->cost_category !== null)
                        - {{ucwords(str_replace("_", " ", $cost->cost_category))}}
                    @endif
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 text-center">{{$cost->creator->name ?? ''}}</div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">{{$cost->creator->phone ?? ''}}</div>
            </div>
            <br>

            @if($cost->cost_category == 'transport')
                <div class="row">
                    <div class="col-md-12 text-center">{{$cost->details->transport_form}} to {{$cost->details->transport_to}}</div>
                </div>
                <br>
            @endif

            @if($cost->cost_category == 'electric_bill' )
                <div class="row">
                    @php
                    $allMonth =collect(getMonths());
                    $selectedMonth = $allMonth->pull( $cost->details->selected_month);
                    @endphp
                    <div class="col-md-12 text-center">{{$selectedMonth}}-<span>{{$cost->paymentMethod->name}}</span>-<span>{{$cost->details->transaction_id}}</span></div>
                </div>
                <br>
            @endif

            @if($cost->cost_category == 'office_rent')
                <div class="row">
                    @php
                        $allMonth =collect(getMonths());
                        $selectedMonth = $allMonth->pull( $cost->details->selected_month);
                    @endphp
                    <div class="col-md-12 text-center">{{$selectedMonth}}</div>
                </div>
                <br>
            @endif

            @if($cost->cost_category == 'accessories'|| $cost->cost_category == 'office_rent')
                <div class="row">
                    <div class="col-md-12 text-center">{{$cost->details->note}}</div>
                </div>
                <br>
            @endif
            @if($cost->cost_category == 'asset' &&  $cost->assetBranch !== null)
                <div class="row">
                    <div class="col-md-12 text-center"> {{$cost->details->asset_name}} - {{$cost->details->purchase_shop}} - {{$cost->assetBranch->name}}</div>
                </div>
                <br>
            @endif

            <div class="row">
                <div class="col-md-12 text-center" style="font-size: 24px">{{$cost->amount}} {{get_settings('currency_symbol')}}</div>
            </div>
            <br>

            @if($cost->employee_id !== null)
                <div class="row">
                    <div class="col-md-12 text-center">{{$cost->employee->name ?? ''}}</div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">{{$cost->employee->phone ?? ''}}</div>
                </div>
                <br>
            @endif

            @if( $cost->employee_id == null && $cost->details->amount_receiver_name !== null && $cost->details->amount_receiver_phone !== null)
                <div class="row">
                    <div class="col-md-12 text-center">{{ $cost->details->amount_receiver_name}}</div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">{{$cost->details->amount_receiver_phone}}</div>
                </div>
                <br>
            @endif

            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-8 tablet" style="text-align: center;">
                    {{translate('Receipt')}} {{translate('No')}} : {{$cost->receipt_no}}
                </div>
                <div class="col-md-2">
                </div>
            </div>
            <div class="row text-center" style="margin-top: 10px">
                <div class="col-md-12">
                    <i class="fa fa-check-circle custom-circle"></i>
                    <br/>
                    <span style="    font-size: 8px;
                                color: #929292;">COST
                                    ADDED SUCCESSFULLY</span>
                </div>
            </div>
        </div>
    </div>
</div>
