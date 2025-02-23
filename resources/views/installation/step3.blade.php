@extends('installation.layouts.app')
@section('title', 'Setp 3')
@section('content')
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-12">
                <div class="mar-ver pad-btm text-center">
                    <h1 class="h3">Configure Database</h1>
                    <p>Provide database information correctly.</p>
                </div>

                @if (session()->has('error'))
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                <strong>Invalid Database Credentials!! </strong>Please check your database credentials
                                carefully
                            </div>
                        </div>
                    </div>
                @endif

                <div class="text-muted font-13">
                    <form method="POST" action="{{ route('install.db') }}">
                        @csrf
                        <div class="form-group">
                            <label for="db_host">Database Host</label>
                            <input type="text" class="form-control" id="db_host" name="DB_HOST" required
                                autocomplete="off">
                            <input type="hidden" name="types[]" value="DB_HOST">
                        </div>
                        <div class="form-group">
                            <label for="db_name">Database Name</label>
                            <input type="text" class="form-control" id="db_name" name="DB_DATABASE" required
                                autocomplete="off">
                            <input type="hidden" name="types[]" value="DB_DATABASE">
                        </div>
                        <div class="form-group">
                            <label for="db_user">Database Username</label>
                            <input type="text" class="form-control" id="db_user" name="DB_USERNAME" required
                                autocomplete="off">
                            <input type="hidden" name="types[]" value="DB_USERNAME">
                        </div>
                        <div class="form-group">
                            <label for="db_pass">Database Password</label>
                            <input type="password" class="form-control" id="db_pass" name="DB_PASSWORD"
                                autocomplete="off">
                            <input type="hidden" name="types[]" value="DB_PASSWORD">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-info">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
