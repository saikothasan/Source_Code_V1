<div class="content-wrapper" id="print" style="min-height: 282px;">
    <div class="ticket invoice invoice-font invoice-border" style="margin: auto;">
        <div class="text-center">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(asset(getSetting('print_logo', 'images/logoheader.png')))) }}"
                alt="" class="image">
        </div>
        <h3 class="centered">
            <strong>Payment</strong>
        </h3>
        <p class="text-left"> {{ $cashHistory->note }}</p>
        <p class="text-left"> Reference {{ $cashHistory->employee->name ?? '' }}</p>
        <p class="text-left"> Received {{ $cashHistory->employee->name ?? '' }} </p>
        <p class="text-left"> {{ $cashHistory->amount }} BDT</p>
        <p class="text-left"> Paid ({{ $cashHistory->sender->name ?? '' }})</p>
        <p class="text-left"> {{ $cashHistory->created_at->format('d  F  Y') }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $cashHistory->created_at->format('h:i:s A') }}</p>
    </div>
    <br class="hidden-print" />
    <div class="row">
        <button onclick='printDiv("print")' class="btn btn-default text-black download pointer hidden-print"
            style="margin-right: 20px;border-color: #000000;background: white;">Print</button>
        <a href="{{ route('cash-history.download', $cashHistory->id) }}" class="hidden-print">
            <button type="submit" style="margin-right: 20px;border-color: #000000;background: white;"
                class="btn btn-default text-black download pointer hidden-print">Download
            </button>
        </a>
    </div>
</div>
