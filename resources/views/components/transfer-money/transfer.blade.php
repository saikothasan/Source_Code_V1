<div class="content-wrapper" id="print" style="min-height: 282px;">
    <div class="ticket invoice invoice-font invoice-border" style="margin: auto;">
        <div class="text-center">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(asset(getSetting('print_logo', 'images/logoheader.png')))) }}"
                alt="" class="image">
        </div>
        <h3 class="centered">
            <strong>TRANSFER</strong> CASH
        </h3>
        <p class="text-left"> Receiver: {{ $cashHistory->branch->name ?? '' }}
            {{ $cashHistory->receiverBranch->name ?? '' }}</p>
        <p class="text-left"> {{ $cashHistory->bank->name ?? '' }}
            {{ $cashHistory->payment_reference ?? 'Cash Drawer' }} </p>
        <p class="text-left"> BDT {{ $cashHistory->amount }}  {{get_settings('currency_symbol')}} </p>
        <p class="text-left"> Sender( {{ $cashHistory->sender->name ?? '' }})</p>
        <p class="text-left"> {{ $cashHistory->note }} </p>
        <p class="text-left"> {{ $cashHistory->created_at->format('d  F  Y') }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $cashHistory->created_at->format('h:i:s A') }}</p>
    </div>
    <br class="hidden-print" />
    <div class="row">
        <button onclick='printDiv("print")' style="margin-right: 20px;border-color: #000000;background: white;"
            class="hidden-print btn btn-default text-black download pointer hidden-print">Print</button>
        <a href="{{ route('cash-history.download', $cashHistory->id) }}" class="hidden-print">
            <button type="submit" style="margin-right: 20px;border-color: #000000;background: white;"
                class="btn btn-default text-black download pointer hidden-print">Download
            </button>
        </a>
    </div>
</div>
