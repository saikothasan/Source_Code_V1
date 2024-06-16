@extends('layouts.app')
@section('title', 'Cash In')
@section('content')
    <br>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row text-center">
                    <div class="col-md-4"></div>
                    <form method="POST" action="{{ route('cash-in.store') }}" class="col-md-4" onsubmit="newTab()">
                        @csrf
                        <div class="form-group">
                            <h1 style="color:black"><strong style="color:black">{{ translate('Cash In') }} </strong></h1>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="note" placeholder="source">
                            @error('note')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="employee">
                                <option value="" selected>Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->value }}">{{ $employee->text }}</option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" name="amount" placeholder="0.00">
                            @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="color: white;"><strong>CASH
                                    IN</strong></button>
                        </div>
                    </form>
                    <div class="col-md-4"></div>
                </div>
            </div>
    </div>
    </section>
    </div>
    <script>
        @if (Session::has('id'))
            window.open("{{ route('cash-drawer.show', Session::get('id')) }}", '_blank');
        @endif
    </script>
@endsection
