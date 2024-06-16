@extends('layouts.app')
@section('title', 'Department')
@section('content')
    <style>
        .corner {
            border-radius: 7px;
            text-align: center;
        }

        .spacer {
            margin-top: 20px;
        }

        .example-table tr:nth-child(2n+1) {
            background-color: #ddd;
        }

        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
        }

        .action {
            color: rgb(167, 169, 172);
            /* font-family: 'Roboto Light'; */
        }

        .button-size {
            padding: 2px 13px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .custom-btn {
            position: relative;
        }

        .custom-add {
            position: absolute;
            top: 0;
            border-radius: 5px;
            right: 35px;
            z-index: 9;
            border: none;
            top: 2px;
            height: 30px;
            cursor: pointer;
            color: #423030;
            background-color: transparent;
            transform: translateX(2px);
        }

        .font {
            font-family: 'Roboto Light';
        }

        .custom-home {
            padding: 8px 59px;
            font-size: 18px;
            line-height: 1.3333333;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h3>Department</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 spacer" style="overflow-x: auto" >
                    <table class="table table-striped table-responsive example-table">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Department Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $key => $value)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td class="action">
                                        <a href="{{ route('departments.edit', $value->id) }}">
                                            <button class="button-size font"> <i class="fa fa-edit"></i> </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $departments->links() }}
                </div>
                <div class="row spacer ">
                    <div class="col-md-12">
                        @if (isset($department))
                            <form method="POST" action="{{ route('departments.update', $department->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group custom-btn">
                                    <input type="text" class="form-control corner" name="name"
                                        value="{{ $department->name }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <button class="btn custom-add font" type="submit">Update</button>
                                </div>
                            </form>
                        @else
                            <form method="POST" action="{{ route('departments.store') }}">
                                @csrf
                                <div class="form-group custom-btn">
                                    <input type="text" class="form-control corner" name="name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <button class="btn custom-add font" type="submit">Add</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection
