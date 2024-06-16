@extends('layouts.app')
@section('title', 'Cash List')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Dashboard
                
            </h1>
        </section>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <!-- Content Header (user header) -->
                    <div class="box box-success box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cash list</h3>
                            <div class="box-tools pull-right">
                                <a href="{{ route('cashes.create') }}" class="btn btn-sm bg-red"><i
                                        class="fa fa-plus"></i> New Cash</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            @include('includes.errormessage')
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl.</th>
                                        <th>Date</th>
                                        <th>Transfer</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>User/Bank</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $net_total = 0;
                                        $transfer = 0;
                                    @endphp
                                    @foreach ($cashes as $key => $cash)
                                     
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ date('d M, Y', strtotime($cash->date)) }}</td>
                                            <td>{{ $cash->transfer }} <?php $transfer += $cash->transfer; ?></td>
                                            <td>{{ $cash->amount }} <?php $net_total = $cash->amount; ?></td>
                                            <td>{{ $cash->type }} </td>
                                            <td>{{ $cash->user_name ? $cash->user_name : $cash->bank->name ?? "" }} </td>

                                            <td>

                                                <form action="{{ route('cashes.destroy', $cash->id) }}"
                                                    method="post" style="display: none;"
                                                    id="delete-form-{{ $cash->id }}">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                </form>
                                                <a class="btn btn-sm bg-red" href="" onclick="if(confirm('Are You Sure To Delete?')){
                                                    event.preventDefault();
                                                    getElementById('delete-form-{{ $cash->id }}').submit();
                                                    }else{
                                                    event.preventDefault();
                                                    }"><span class="glyphicon glyphicon-trash"></span></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                <tr>
                                    <td colspan="2" style="text-align: right; font-weight: bold;">Total=</td>
                                    <td>{{ $transfer }}</td>
                                    <td>{{ $net_total }}</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
