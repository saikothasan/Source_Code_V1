@extends('installation.layouts.app')
@section('title', 'Installation')
@section('content')
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-12">
                <div class="mar-ver pad-btm text-center">
                    <h1 class="h3">Multi Branch Software Installation</h1>
                    <p class="text-red">Provide information which is required.</p>
                </div>
                <ol class="list-group">
                    <li class="list-group-item text-semibold"><i class="fa fa-check"></i> Database Name</li>
                    <li class="list-group-item text-semibold"><i class="fa fa-check"></i> Database Username</li>
                    <li class="list-group-item text-semibold"><i class="fa fa-check"></i> Database Password</li>
                    <li class="list-group-item text-semibold"><i class="fa fa-check"></i> Database Hostname</li>
                </ol>
                <p style="font-size: 14px;" class="pt-5">
                    We will check permission to write several files,proceed..
                </p>
                <br>
                <div class="text-center">
                    <a href="{{ route('step1') }}" class="btn btn-info text-light">
                        Start Now <i class="fa fa-forward"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
