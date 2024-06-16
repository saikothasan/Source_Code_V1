<style>
    .corner {
        border-radius: 7px;
        text-align: center;
    }

    .second-section {
        text-align: center;
    }

    .header-logo img {
        width: 40%;
    }

    .header tr {
        background: black !important;
        color: white;
        border: 1px solid black !important;

    }

    .header th {
        border-bottom: 2px solid #000000 !important;
    }

    td {
        border: 1px solid black !important;
    }

    .autority-section hr {
        margin-top: 20px;
        margin-bottom: 10px;
        border: 0;
        border-top: 2px solid #1d1c1c;
        width: 50%;
    }

    .signature-generator, .autority-section, .footer-section {
        text-align: center;
    }

    .confirm-section p {
        font-size: 16px;
    }

    .confirm-section {
        margin-top: 7%;
        margin-bottom: 5%;
        text-align: center;
    }

    .confirm-section hr {
        margin-top: 20px;
        margin-bottom: 5px;
        border: 0;
        border-top: 2px solid #000;
    }

    .signature-generator hr {
        margin-top: 20px;
        margin-bottom: 5px;
        border: 0;
        border-top: 2px solid #000;
    }

    .second-section h3 strong {
        text-decoration: underline;
    }

    .box-header {
        border: 1px solid #00c0ef;
        border-radius: 17px;
    }

    .groupedInput {
        border: 1px solid #e1cdcd;
        border-radius: 7px;
        /*border-radius: 10px;*/
    }

    footer {
        margin-top: 5%;
    }

    .spacer {
        margin-top: 20px;
    }

    .groupedLabel {
        margin-top: 7px;
        color: rgb(153, 153, 153);
    }


    .action {
        color: rgb(167, 169, 172);
        font-family: 'Roboto Light';
    }

    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #f9f9f9;
        color: black !important;
    }
    .table {
        margin-bottom: 0px !important;
    }

    .tbody td {
        color: black;
    }

    .image-size {
        width: 1.5em;
        height: 1.5em;
    }
    .individual {
        margin-bottom: 10%;
    }

    .card-sale {
        border: 2px solid #1cb24d;
    }

    .card-cost {
        border: 2px solid #F15A29;
    }

    .card-blance {
        margin-top: 5%;
        border: 2px solid gray;
    }

    .card-other-cost {
        margin-top: 4%;
        border: 2px solid #ED1E24;
        background: #ED1E24;
    }

    .card-profit {
        border: 2px solid rgb(0, 118, 150);
    }

    .card-header,
    .card-footer {
        padding: 10px;
        text-align: center;
        color: white;
    }

    .card-sale .card-header,
    .card-footer {
        background: #1cb24d;
    }

    .card-sale {
        background: #1cb24d;
    }

    .delivery {
        padding: 18px;
        border-bottom: 1px solid black;
    }

    .card-profit {
        background: rgb(0, 118, 150);
    }

    .card-blance {
        background: gray;
    }

    .card-cost {
        background: #F15A29;
    }

    .for-title-branch {
        font-size: 19px;
        text-decoration: underline;
    }

    .list-group-item {
        position: relative;
        display: block;
        padding: 10px 15px;
        margin-bottom: -1px;
        background-color: #fff;
        /*border-bottom: 3px solid #a59e9e;*/
    }

    .list-group-item p {
        font-family: 'Source Sans Pro', sans-serif;
    }

    .list-group {
        margin-bottom: 0;
        background: white;
    }

    .amount-margin {
        margin-top: 18%;
    }

    .total_pices {
        font-family: 'Source Sans Pro', sans-serif;
        font-size: 16px;
    }

    .cost-row {
        font-family: 'Source Sans Pro', sans-serif;
        font-size: 16px;
    }
    .col-md-8{
        width: 66.66666667%;
    }

    .paddin-dicress {
        padding-right: 0px;
        padding-left: 10px;
    }
</style>
<div class="">
    <div class="">
        <div class="">

            <div class="col-md-6 header-logo">
                <img class="logo"
                     src="data:image/png;base64,{{ base64_encode(file_get_contents('images/logo.png')) }}"
                     alt="">

            </div>
            <div class="col-md-6" style="text-align: right;">
                <div> {{translate('Report')}} {{translate('Generate')}}
                    @if(isset($report['details']['generator_name']))
                        {{$report['details']['generator_name']}}
                    @endif
                </div>
                <div>
                    {{date('l, F-y',strtotime($report['created_at']))}}
                </div>
                <div>  {{date('h : i : s A',strtotime($report['created_at']))}}</div>
                <div> {{translate('Report')}} {{translate('ID')}} : {{$report['report_id']}}</div>
            </div>
        </div>
        @if($report['report_name']=='Sales Report')
            <x-report.sale-report :report="$report"></x-report.sale-report>
        @endif
        @if($report['report_name']=='Stock Report')
            <x-report.stock-report :report="$report"></x-report.stock-report>
        @endif
        @if($report['report_name']=='C.R Master Report')
            <x-report.cr-master-report :report="$report"></x-report.cr-master-report>
        @endif

        <div class="signature-generator row">
            <div class="col-md-8" style="width: 60%;"></div>
            <div class="col-md-4" style="width: 40%; float: right;">
                <hr>
                <p>{{$report['details']['generator_name']}}</p>
                <p>{{translate('Generator')}} {{translate('Signature')}}</p>
            </div>
        </div>
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
                <p>{{translate('Authority')}}</p>
            </div>
            <div class="col-md-4" style="width: 50%;">
                <hr>
                <p>{{translate('Receiver')}}</p>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <footer>
        <div class="footer-section">
            <p>House-36, Road-05, Block-B, Banasree, Rampura.</p>
            <span>www.colourful.com.bd</span> <span>01785-992233</span> <span>collourfuloffice@gmail.com</span>
        </div>
    </footer>
</div>
