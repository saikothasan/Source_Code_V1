{{-- <div class="content-wrapper" id="sale-print"> --}}
{{--    <div class="text-center"> --}}
{{--        <div class="row text-center"> --}}
{{--            <img src="{{asset('images/sale_print.png')}}" alt="" --}}
{{--                 class="image"> --}}
{{--        </div> --}}
{{--        <div style="text-align: left;font-family: 'RobotoRegular';"> --}}
{{--            <div class="row"><h1><strong>Input</strong> CASH<strong> In</strong></h1></div> --}}
{{--            <div class="row" style="margin-top: 5px">{{$cashHistory->employee->name ?? ''}}</div> --}}
{{--            <div class="row">{{$cashHistory->amount}}</div> --}}
{{--            <div class="row">Received {{$cashHistory->receiver->name?? ''}}</div> --}}
{{--            <br/> --}}
{{--            <div class="row">{{$cashHistory->note}}</div> --}}
{{--            <br/> --}}
{{--            <div class="row"> --}}
{{--                <h4>{{ $cashHistory->created_at->format('d  F  Y') }} --}}
{{--                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --}}
{{--                    <span id="currentTime">{{ $cashHistory->created_at->format('h:i:s A') }}</span> --}}
{{--                </h4> --}}
{{--            </div> --}}
{{--            <br/> --}}
{{--        </div> --}}
{{--    </div> --}}
{{-- </div> --}}

<div class="content-wrapper" id="print" style="min-height: 282px;">
    <div class="ticket invoice invoice-font invoice-border" style="margin: auto;">
        <div class="text-center">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(asset(getSetting('print_logo', 'images/logoheader.png')))) }}"
                alt="" class="image">
        </div>
        <h3 class="centered">
            <strong>CASH</strong> In
        </h3>
        <p class="text-left"> {{ $cashHistory->employee->name ?? '' }} </p>
        <p class="text-left"> {{ $cashHistory->amount }} BDT </p>
        <p class="text-left"> Received {{ $cashHistory->receiver->name ?? '' }} </p>
        <p class="text-left"> {{ $cashHistory->note }} </p>
        <p class="text-left"> {{ $cashHistory->created_at->format('d  F  Y') }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $cashHistory->created_at->format('h:i:s A') }}</p>
    </div>
    <br class="hidden-print" />
    <div class="row">
        <button onclick='printDiv("print")' style="margin-right: 20px;border-color: #000000;background: white;"
            class="btn btn-default text-black download pointer hidden-print">Print</button>
        <a href="{{ route('cash-history.download', $cashHistory->id) }}" class="hidden-print">
            <button type="submit" style="margin-right: 20px;border-color: #000000;background: white;"
                class="btn btn-default text-black download pointer hidden-print">Download
            </button>
        </a>
    </div>

</div>
