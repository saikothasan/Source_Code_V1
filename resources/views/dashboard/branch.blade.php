<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="{{ asset('public/images/Icon.png') }}">
    <title>@yield('title', auth()->user()->branch?->name)</title>
    @include('layouts.head')
    @stack('css')
    <style>
        .top-radious {
            border-top-left-radius: 11px;
            border-top-right-radius: 11px;
        }

        .bottom-radious {
            border-bottom-left-radius: 11px;
            border-bottom-right-radius: 11px;
        }

        .font {
            font-family: RobotoLight;
        }

        .font-width {
            font-weight: 700;
        }

        .sell {
            background: rgb(58, 66, 154) !important;
            color: #ffff;
        }

        .sell-inner {
            background-color: rgb(0, 134, 219) !important;
            color: #ffff;
        }

        .product {
            background-color: rgb(37, 94, 4) !important;
            color: #ffff;
        }

        .product-inner {
            background-color: rgb(0, 174, 76) !important;
            color: #ffff;
        }

        .cost {
            background-color: rgb(156, 70, 13) !important;
            color: #ffff;
        }

        .cost-inner {
            background-color: rgb(255, 96, 0) !important;
            color: #ffff;
        }

        .box {
            position: relative;
            display: block;
            margin-bottom: 20px;
        }

        .card {
            position: relative;
            display: inline-block;
            /* margin: 50px; */
        }

        .card .img-top {
            display: none;
            position: absolute;
            top: 0;
            left: 90px;
            z-index: 99;
        }

        .card:hover .img-top {
            width: 40%;
            display: inline;
        }

        .card .text-top {
            display: none;
            position: absolute;
            top: 150px;
            left: 90px;
            z-index: 99;
        }

        .card:hover .text-top {
            width: 40%;
            display: inline;
        }

        .card .text-top2 {
            display: none;
            position: absolute;
            top: 150px;
            left: 90px;
            z-index: 99;
            font-size: 20px;
        }

        .card:hover .text-top2 {
            width: 40%;
            display: inline;
        }

        .card .text-top3 {
            display: none;
            position: absolute;
            top: 150px;
            left: 90px;
            z-index: 99;
        }

        .card:hover .text-top3 {
            width: 40%;
            display: inline;
            font-size: 20px;
        }

        .remove-box-shadow {
            box-shadow: 0 0px 1px rgb(0 0 0 / 10%);
            font-family: Roboto Regular;
            font-weight: 400;
        }

        .title-text {
            color: rgb(187, 189, 191);
            margin-top: 30px;
            font-size: 20px !important;
            margin-top: 30px;
            font-family: auto;
        }

        .sell-active {
            color: rgb(58, 66, 154);
        }

        .exchange-active {
            color: rgb(37, 94, 4);
        }

        .return-active {
            color: rgb(255, 0, 0)
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">

    @include('layouts.header')
    @include('layouts.sidebar')

    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-lg-4 col-xs-6">
                        <a href="{{ route('sales.create') }}">
                            <div class="card text-center" style="cursor: pointer;" onmouseover="sellHover()"
                                onmouseout="sellHoverOut()">
                                <div>
                                    <img id="sell-image" style="width:40%" src="{{ asset('images/sales/07.png') }}"
                                        alt="New Sell">
                                </div>
                                <div style="margin-top: 20px;">
                                    <span id="sellSpan" style="margin-left: 26px;" class="title-text">
                                        NEW
                                        SELL</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4 col-xs-6">
                        <a href="{{ route('sale-exchange.create') }}">
                            <div class="card text-center" style="cursor: pointer;" onmouseover="exchangeHover()"
                                onmouseout="exchangeHoverOut()">
                                <div>
                                    <img id="exchange-image" style="width:40%" src="{{ asset('images/sales/06.png') }}"
                                        alt="EXCHANGE">
                                </div>
                                <div style="margin-top: 20px;">
                                    <span id="exchangeSpan" class="title-text">EXCHANGE</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-xs-6">
                        <a href="{{ route('sale-return.create') }}">
                            <div class="card text-center" style="cursor: pointer;" onmouseover="returnHover()"
                                onmouseout="returnHoverOut()">
                                <div>
                                    <img id="return-image" style="width:40%" src="{{ asset('images/sales/05.png') }}"
                                        alt="Return">
                                </div>
                                <div style="margin-top: 20px;">
                                    <span id="returnSpan" style="margin-left: 26px;" class="title-text">RETURN</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row" style="margin-top: 40px">
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box">
                            <a href="{{ route('sales.index') }}" class="small-box-footer top-radious sell">SELL</a>
                            <div class="inner text-center sell-inner">
                                <p class="font">TOTAL <Span class="font-width">
                                        {{ number_format($totalSale) }} {{get_settings('currency_symbol')}}</Span></p>
                                <p class="font">TODAY <Span class="font-width">
                                        {{ number_format($today_sale) }} {{get_settings('currency_symbol')}}</Span></p>
                            </div>
                            <a href="{{ route('sales.index') }}" class="small-box-footer bottom-radious font sell">More
                                info</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box">
                            <a href="{{ route('products.index') }}"
                                class="small-box-footer top-radious product">PRODUCT</a>
                            <div class="inner text-center product-inner">
                                <p class="font">TOTAL <Span class="font-width">
                                        {{ number_format($total_product) }} pcs</Span>
                                </p>
                                <p class="font">AVAILABLE <Span class="font-width">
                                        {{ number_format($available_product) }} pcs</Span>
                                </p>
                            </div>
                            <a href="{{ route('products.index') }}"
                                class="small-box-footer bottom-radious font product">More info</a>

                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box">
                            <a href="{{ route('costs.index') }}" class="small-box-footer top-radious cost">COST</a>
                            <div class="inner text-center product-inner cost-inner">
                                <p class="font">TOTAL <Span class="font-width">
                                        {{ number_format($total_cost) }} {{get_settings('currency_symbol')}}</Span></p>
                                <p class="font">TODAY<Span class="font-width">
                                        {{ number_format($today_cost) }} {{get_settings('currency_symbol')}}</Span></p>
                            </div>
                            <a href="{{ route('costs.index') }}" class="small-box-footer bottom-radious font cost">More
                                info</a>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

</body>
@show
@include('layouts.footer')
</div>
@stack('js')
<script>
    function sellHover() {
        $("#sellSpan").addClass('sell-active');
        $("#sell-image").attr("src", 'images/sales/08.png')
    }

    function sellHoverOut() {
        $("#sellSpan").removeClass('sell-active');
        $("#sell-image").attr("src", 'images/sales/07.png')
    }

    function exchangeHover() {
        console.log("Hre")
        $("#exchangeSpan").addClass('exchange-active');
        $("#exchange-image").attr("src", 'images/sales/09.png')
    }

    function exchangeHoverOut() {
        $("#exchangeSpan").removeClass('exchange-active');
        $("#exchange-image").attr("src", 'images/sales/06.png')
    }

    function returnHover() {
        $("#returnSpan").addClass('return-active');
        $("#return-image").attr("src", 'images/sales/10.png')
    }

    function returnHoverOut() {
        $("#returnSpan").removeClass('return-active');
        $("#return-image").attr("src", 'images/sales/05.png')
    }
</script>
</body>

</html>
