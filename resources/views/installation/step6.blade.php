@extends('installation.layouts.app')
@section('title', 'Done')
@section('content')
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-12">
                <div class="pad-btm text-center">
                    <h1 class="h3">All Done, Great Job.</h1>
                    <p>Your software is ready to run.</p>
                    <div class="row">
                        <div class="col-sm-12 ">
                            <div class="panel bord-all mar-top panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        Configure the following setting from settings to run the system
                                        properly.
                                    </h3>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center pt-3">
                    <a href="{{ env('APP_URL') }}" target="_blank" class="btn btn-success">Login</a>
                </div>
            </div>
        </div>
    </div>
@endsection
