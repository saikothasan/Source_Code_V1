@extends('layouts.app')
@section('title', 'View Purchase')
@section('content')
    <style>
        .header {
            color: rgb(255, 150, 0);
        }

        .corner {
            border-radius: 7px;
            text-align: center;
        }

        .spacer {
            margin-top: 20px;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h3 class="header">View Product Purchase</h3>
                        </div>
                    </div>
                    <div class="col-md-12 row text-center spacer">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <input class="form-control corner" placeholder="Invoice No">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    <input class="form-control corner" placeholder="Invoice No">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>
                                    <input class="form-control corner" placeholder="Invoice No">
                                </label>
                                <label>
                                    <input class="form-control corner" placeholder="Invoice No">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>

@endsection
