@extends('layouts.app')
@section('title', 'Cash In')
@section('content')
    <br>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row text-center">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">

                        <x-transferMoney.transfer :cashHistory="$cashHistory"></x-transferMoney.transfer>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection
