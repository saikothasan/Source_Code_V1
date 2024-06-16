<div class="">
    <div class="header-title text-center">
        <h2><strong>Product Report </strong></h2>
        <hr>
        <span>{{date('d-m-Y',strtotime($report['from_date']))}} to {{date('d-m-Y',strtotime($report['to_date']))}}</span>
    </div>
    @if(isset($report['details']['total_pieces']))
        @php
            $total_report =  $report['details']['total_pieces'];
        @endphp
        <div class="product-section">
            <h3><strong>{{$total_report['product']['name']}}</strong></h3>
            <span>Supplier : {{$total_report['product']['supplier_name']}} Adding Date : {{$total_report['product']['date']}} ({{$total_report['product']['added_by']}})</span>
        </div>
        <div class="generator-section">
            {!! $total_report['report_title'] !!}
        </div>
        <div class="product-table row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <table class="table table-bordered">

                    <tbody class="text-left">
                    <tr>
                        <td class="product-name" style="width: 50%">
                            Product Name
                        </td>
                        <td style="width: 50%"><strong>{{$total_report['product']['name']}}</strong></td>
                    </tr>
                    <tr>
                        <td class="product-name" style="width: 50%">
                            Suppliers
                        </td>
                        <td style="width: 50%"><strong>{{$total_report['product']['supplier_name']}}</strong></td>
                    </tr>
                    <tr>
                        <td class="product-name" style="width: 50%">
                            SKU
                        </td>
                        <td style="width: 50%"><strong>{{$total_report['product']['product_sku']}}</strong></td>
                    </tr>
                    <tr>
                        <td class="product-name" style="width: 50%">
                            Barcode
                        </td>
                        <td style="width: 50%"><strong>{{$total_report['product']['product_barcode']}}</strong></td>
                    </tr>
                    <tr>
                        <td class="product-name" style="width: 50%">
                            Buy Price
                        </td>
                        <td style="width: 50%"><strong>{{$total_report['product']['buy_price']}} {{get_settings('currency_symbol')}}</strong></td>
                    </tr>
                    <tr>
                        <td class="product-name" style="width: 50%">
                            Sell Price
                        </td>
                        <td style="width: 50%"><strong>{{$total_report['product']['sell_price']}} {{get_settings('currency_symbol')}}</strong></td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="col-md-3"></div>
        </div>

        <div class="purchase-history row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 purchase">
                        @if(isset($total_report['purchase_history']))
                            <h4><strong> Purchase History </strong></h4>
                            <hr>
                            @foreach($total_report['purchase_history'] as $value)
                                <div>{{$loop->iteration}}. {{date('d F Y',strtotime($value['date']))}}
                                    ({{$value['invoice']}})
                                </div>
                            @endforeach
                            <div class="strong"><strong>Total Bought {{count($total_report['purchase_history'])}}
                                    times </strong></div>
                        @endif
                    </div>
                    <div class="col-md-6 transfer">
                        @if(isset($total_report['transfer_history']))
                            <h4><strong> Transfer History </strong></h4>
                            <hr>
                            @foreach($total_report['transfer_history'] as $value)
                                <div>{{$loop->iteration}}. {{date('d F Y',strtotime($value['date']))}}
                                    ({{$value['invoice_code']}})
                                </div>
                            @endforeach
                            <div class="strong"><strong>Total Transferred {{count($total_report['transfer_history'])}}
                                    times </strong></div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>

        </div>
        @if(isset($total_report['selectPieces']))
            <div style="margin-top: 5%">
                @foreach($total_report['selectPieces'] as $value)
                    <div class="delivery_pce ">
                        <h4><strong style="border: 3px solid black;padding: 8px;"> {{$value['title']}}
                                : {{$value['total_pcs']}} PCS </strong></h4>
                        <div style="margin-top: 3%">
                            <strong>in words</strong>
                        </div>
                        <p style="margin-bottom: 2%">{{$value['in_word']}} </p>
                    </div>
                @endforeach
            </div>

        @endif

    @endif
    @if(isset($report['details']['individual_pieces']))
        @php
            $individual = $report['details']['individual_pieces'];
        @endphp

        @if(isset($individual['sale']))
            <div class="delivery">
                <div class="header-title text-center">
                    <h4><strong>SALE PIECES </strong></h4>
                    <hr>

                </div>
                <div class="branch-pec">
                    <div class="row col-md-12">
                        @foreach($report['details']['branch'] as $value)
                            <div style="padding-right: 5%">
                                <strong>{{$value['text']}}
                                    : {{collect($individual['sale'])->where('branch_id',$value['value'])->sum('quantity')}}
                                    pcs</strong>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="delivery-table">
                    <table class="table table-bordered">
                        <thead>
                        <tr style="font-weight: bold">
                            <td>S.N</td>
                            <td>Date & Time</td>
                            <td>Branch</td>
                            <td>Invoice</td>
                            <td>Seller</td>
                            <td>Quantity</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($individual['sale'] as $value)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <div>
                                        {{ date('d F y', strtotime($value['created_at'])) }}
                                    </div>
                                    <div>
                                        {{date('h : i : s A',strtotime($value['created_at']))}}
                                    </div>
                                <td>{{$value['branch']['name'] ?? ''}}</td>
                                <td>{{$value['sale']['invoice_code'] ?? ''}}</td>
                                <td>{{$value['sale']['seller']['name'] ?? ''}}</td>
                                <td>{{$value['quantity']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if(isset($individual['delivered_pieces']))
            <div class="delivery">
                <div class="header-title text-center">
                    <h4><strong>DELIVERED PIECES </strong></h4>
                    <hr>

                </div>
                <div class="branch-pec">
                    <div class="row col-md-12">
                        @foreach($report['details']['branch'] as $value)
                            <div style="padding-right: 5%">
                                <strong>{{$value['text']}}
                                    : {{collect($individual['delivered_pieces'])->where('branch_id',$value['value'])->sum('quantity')}}
                                    pcs</strong>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="delivery-table">
                    <table class="table table-bordered">
                        <thead>
                        <tr style="font-weight: bold">
                            <td>S.N</td>
                            <td>Date & Time</td>
                            <td>Branch</td>
                            <td>Invoice</td>
                            <td>Seller</td>
                            <td>Quantity</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($individual['delivered_pieces'] as $value)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <div>
                                        {{ date('d F y', strtotime($value['created_at'])) }}
                                    </div>
                                    <div>
                                        {{date('h : i : s A',strtotime($value['created_at']))}}
                                    </div>
                                <td>{{$value['branch']['name'] ?? ''}}</td>
                                <td>{{$value['sale']['invoice_code'] ?? ''}}</td>
                                <td>{{$value['sale']['seller']['name'] ?? ''}}</td>
                                <td>{{$value['quantity']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if(isset($individual['pending']))
            <div class="delivery">
                <div class="header-title text-center">
                    <h4><strong>PENDING PIECES </strong></h4>
                    <hr>

                </div>
                <div class="branch-pec">
                    <div class="row col-md-12">
                        @foreach($report['details']['branch'] as $value)
                            <div style="padding-right: 5%">
                                <strong>{{$value['text']}}
                                    : {{collect($individual['pending'])->where('branch_id',$value['value'])->sum('quantity')}}
                                    pcs</strong>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="delivery-table">
                    <table class="table table-bordered">
                        <thead>
                        <tr style="font-weight: bold">
                            <td>S.N</td>
                            <td>Date & Time</td>
                            <td>Branch</td>
                            <td>Invoice</td>
                            <td>Seller</td>
                            <td>Quantity</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($individual['pending'] as $value)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <div>
                                        {{ date('d F y', strtotime($value['created_at'])) }}
                                    </div>
                                    <div>
                                        {{date('h : i : s A',strtotime($value['created_at']))}}
                                    </div>
                                <td>{{$value['branch']['name'] ?? ''}}</td>
                                <td>{{$value['sale']['invoice_code'] ?? ''}}</td>
                                <td>{{$value['sale']['seller']['name'] ?? ''}}</td>
                                <td>{{$value['quantity']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if(isset($individual['returned']))
            <div class="delivery">
                <div class="header-title text-center">
                    <h4><strong>RETURNED PIECES </strong></h4>
                    <hr>

                </div>
                <div class="branch-pec">
                    <div class="row col-md-12">
                        @foreach($report['details']['branch'] as $value)
                            <div style="padding-right: 5%">
                                <strong>{{$value['text']}}
                                    : {{collect($individual['returned'])->where('branch_id',$value['value'])->sum('quantity')}}
                                    pcs</strong>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="delivery-table">
                    <table class="table table-bordered">
                        <thead>
                        <tr style="font-weight: bold">
                            <td>S.N</td>
                            <td>Date & Time</td>
                            <td>Branch</td>
                            <td>Invoice</td>
                            <td>Seller</td>
                            <td>Quantity</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($individual['returned'] as $value)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <div>
                                        {{ date('d F y', strtotime($value['created_at'])) }}
                                    </div>
                                    <div>
                                        {{date('h : i : s A',strtotime($value['created_at']))}}
                                    </div>
                                <td>{{$value['branch']['name'] ?? ''}}</td>
                                <td>{{$value['sale']['invoice_code'] ?? ''}}</td>
                                <td>{{$value['sale']['seller']['name'] ?? ''}}</td>
                                <td>{{$value['quantity']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        @if(isset($individual['available']))
            <div class="delivery" style="margin-top: 5%;">
                <div class="header-title text-center">
                    <h4><strong>AVAILABLE PIECES </strong></h4>
                    <hr>

                </div>
                <div class="branch-pec">
                    <div class="row col-md-12">
                        @foreach($report['details']['branch'] as $value)
                            <div style="padding-right: 5%">
                                <strong>{{$value['text']}}
                                    : {{collect($individual['available'])->where('id',$value['value'])->sum('available_quantity')}}
                                    pcs</strong>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="delivery-table">
                    <table class="table table-bordered">
                        <thead>
                        <tr style="font-weight: bold">
                            <td>SL</td>
                            <td>Branch</td>
                            <td>Transferred</td>
                            <td>Available</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($individual['available'] as $value)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$value['name']}}</td>
                                <td>{{number_format($value['transfer_quantity'])}}</td>
                                <td>{{number_format($value['available_quantity'])}}</td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @endif


    <div class="">
        <div class="confirm-section row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <p>C O N F I R M E D</p>
                <hr>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="autority-section row" style="display: flex;">
            <div class="col-md-2"></div>
            <div class="col-md-4" style="width: 50%;">
                <hr>
                <p>Authority</p>
            </div>
            <div class="col-md-4" style="width: 50%;">
                <hr>
                <p>Receiver</p>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <footer>
        <div class="footer-section">
            <p>House-36, Road-05, Block-B, Banasree, Rampura.</p>
            <span>www.colourful.com.bd</span> <span>01785-992233</span>
            <span>collourfuloffice@gmail.com</span>
        </div>
    </footer>
    <br>
    <br>
</div>
