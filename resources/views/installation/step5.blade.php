@extends('installation.layouts.app')
@section('title', 'Setp 5')
@section('content')
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-12">
                <div class="mar-ver pad-btm text-center">
                    <h1 class="h3">Admin Account Settings <i class="fa fa-cogs"></i></h1>
                    <p>Provide your information.</p>
                </div>
                <div class="text-muted font-13">
                    <form method="POST" action="{{ route('system_settings') }}">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="site_name">Site Name</label>
                                    <input type="text" class="form-control" id="site_name" name="site_name" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="admin_name">Admin Name</label>
                                    <input type="text" class="form-control" id="admin_name" name="admin_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="admin_email">Admin Email</label>
                                    <input type="email" class="form-control" id="admin_email" name="admin_email" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="admin_phone">Admin Phone</label>
                                    <input type="text" class="form-control" id="admin_phone" name="admin_phone" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="admin_password">Admin Password (At least 8 characters)</label>
                                    <input type="text" class="form-control" id="admin_password" name="admin_password"
                                        required>
                                </div>
                            </div>
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
