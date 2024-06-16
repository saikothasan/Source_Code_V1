@extends('layouts.app')
@section('title', 'User profile')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-12 row">
                    <div class="col-md-12 text-center">
                        <h1>{{ translate('Change') }} {{ translate('Password') }}</h1>
                    </div>
                </div>
            </div>
            <br />
            <div class="row text-center">
                <div class="col-md-4"></div>
                <div class="col-md-4 ">
                    <form action="{{ route('password.change') }}" method="POST" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="password" class="form-control"
                                    placeholder="{{ translate('Old') }} {{ translate('Password') }}" name="old_password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="password" class="form-control"
                                    placeholder="{{ translate('New') }} {{ translate('Password') }}" name="new_password">
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success">{{ translate('Update') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4"></div>
        </section>
    </div>
@endsection
